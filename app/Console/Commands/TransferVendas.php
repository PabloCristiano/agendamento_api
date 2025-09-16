<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransferVendas extends Command
{
    protected $signature = 'transfer:vendas
        {--since=today : Data inicial (YYYY-MM-DD) ou "today"}
        {--until= : Data final exclusiva; se vazio: since + 1 dia}
        {--batch=2000 : Tamanho do lote}
        {--incremental : Usa cursor (DATA,HORA,NUM_DOC,COD_ITEM) para buscar só novos}';

    protected $description = 'Transfere vendas do banco remoto para vendas_voucher sem duplicar, com suporte a incremental.';

    public function handle(): int
    {
        $sinceArg = $this->option('since') === 'today'
            ? Carbon::today()->toDateString()
            : ($this->option('since') ?: Carbon::today()->toDateString());

        $untilArg = $this->option('until')
            ? $this->option('until')
            : Carbon::parse($sinceArg)->addDay()->toDateString();

        $batch = (int)($this->option('batch') ?: 2000);
        $incremental = (bool)$this->option('incremental');

        $this->info("Intervalo base: [{$sinceArg} .. {$untilArg}) | batch={$batch} | incremental=".($incremental?'on':'off'));

        // Lê cursor
        $cursor = DB::table('sync_cursors')->where('name', 'transfer_vendas')->first();
        $cursorTuple = null;
        if ($incremental && $cursor && $cursor->last_data && $cursor->last_hora) {
            $cursorTuple = [
                $cursor->last_data,
                $cursor->last_hora,
                $cursor->last_num_doc ?? '',
                $cursor->last_cod_item ?? '',
            ];
            // Mantém o intervalo do dia atual para segurança
            $sinceArg = max($sinceArg, $cursor->last_data);
        }

        // SQL incremental com comparação de linha
        $sqlBase = <<<SQL
SELECT
  MOVDET.DET_CODEMP   AS EMPRESA,
  MOVDET.DET_NUMDOC   AS NUM_DOC,
  MOVDET.DET_ESPDOC   AS ESP_DOC,
  MOVDET.DET_SERIE_   AS SERIE,
  MOVDET.DET_DTAENT   AS DATA,
  MOVDET.DET_HORENT   AS HORA,
  MOVDET.DET_CODITE   AS COD_ITEM,
  CADITE.ITE_DESITE   AS DESCRICAO_ITEM,
  MOVDET.DET_UNIDAD   AS UNIDADE,
  MOVDET.DET_QTDITE   AS QTD,
  MOVDET.DET_UNITAR   AS PRECO_UNIT,
  MOVDET.DET_TOTITE   AS TOTAL_BRUTO,
  CADCLI.CLI_NOMCLI   AS CLIENTE,
  CADCLI.CLI_CGCCPF   AS CPF_CNPJ,
  CADCLI.CLI_C_G_C_   AS CPF_CNPJ_FORMATADO,
  CADFOR.FOR_CODFOR   AS COD_FORNECEDOR,
  CADFOR.FOR_NOMFOR   AS FORNECEDOR,
  CADFOR.FOR_NOMFAN   AS FORNECEDOR_FANTASIA,
  CASE
    WHEN MOVDET.DET_ESPDOC = 'BR' OR MOVDET.DET_CLAFIS IN ('5910','6910') THEN 0.00
    WHEN CAST(LEFT(MOVDET.DET_CLAFIS, 1) AS UNSIGNED) < 5
      THEN - ( (MOVDET.DET_TOTITE - MOVDET.DET_DESESP) - MOVDET.DET_DESCFF )
    ELSE ( (MOVDET.DET_TOTITE - MOVDET.DET_DESESP) - MOVDET.DET_DESCFF )
  END AS VALOR_LIQUIDO
FROM MOVDET
LEFT JOIN CADITE ON MOVDET.DET_CODITE = CADITE.ITE_CODITE
LEFT JOIN CADCLI ON MOVDET.DET_CODCLI = CADCLI.CLI_CODCLI
LEFT JOIN CADFOR ON CADITE.ITE_CODFOR = CADFOR.FOR_CODFOR
WHERE
  MOVDET.DET_DTAENT >= ?
  AND MOVDET.DET_DTAENT <  ?
  AND MOVDET.DET_PROEMB <> 'S'
  AND MOVDET.DET_TIP_FC = 'C'
  AND MOVDET.DET_CODCLI NOT IN ('00000062','00000245','00039679','00039680',
                                '20005026','20005027','30010199','20035180')
  AND MOVDET.DET_CLAFIS IN ('5101','5102','5108','5403','5405','6102','6108',
                            '6404','6405','6403','6101','1202','2202','1411',
                            '2411','5922','6922','5110','7102','7501','1201',
                            '2201','7202','1204')
  AND MOVDET.DET_ESPDOC NOT IN ('FF','TR','DV')
SQL;

        $order = " ORDER BY MOVDET.DET_DTAENT ASC, MOVDET.DET_HORENT ASC, MOVDET.DET_NUMDOC ASC, MOVDET.DET_CODITE ASC";

        $params = [$sinceArg, $untilArg];

        if ($incremental && $cursorTuple) {
            // pega só maiores que o último cursor
            $sql = $sqlBase . "
  AND (MOVDET.DET_DTAENT, MOVDET.DET_HORENT, MOVDET.DET_NUMDOC, MOVDET.DET_CODITE) > (?, ?, ?, ?)
" . $order;
            $params = array_merge($params, $cursorTuple);
        } else {
            $sql = $sqlBase . $order;
        }

        $rows = DB::connection('mysql_remote')->select($sql, $params);
        $this->info('Lidos (remoto): '.count($rows));

        if (!$rows) {
            $this->info('Nada novo.');
            return self::SUCCESS;
        }

        // prepara payload
        $payload = array_map(function($r){
            $a = (array)$r;
            // coerções leves para decimais (evita “Array to string conversion”)
            foreach (['QTD','PRECO_UNIT','TOTAL_BRUTO','VALOR_LIQUIDO'] as $k) {
                if (array_key_exists($k,$a) && $a[$k] !== null) $a[$k] = (string)$a[$k];
            }
            return $a;
        }, $rows);

        $uniqueBy = ['EMPRESA','NUM_DOC','COD_ITEM'];
        $updateCols = [
            'ESP_DOC','SERIE','DATA','HORA',
            'DESCRICAO_ITEM','UNIDADE','QTD','PRECO_UNIT','TOTAL_BRUTO','VALOR_LIQUIDO',
            'CLIENTE','CPF_CNPJ','CPF_CNPJ_FORMATADO',
            'COD_FORNECEDOR','FORNECEDOR','FORNECEDOR_FANTASIA',
        ];

        DB::connection('mysql')->beginTransaction();
        try {
            foreach (array_chunk($payload, max(1,$batch)) as $i => $chunk) {
                DB::table('vendas_voucher')->upsert($chunk, $uniqueBy, $updateCols);
                $this->info("Lote ".($i+1)." processado (+".count($chunk).")");
            }
            DB::connection('mysql')->commit();
        } catch (\Throwable $e) {
            DB::connection('mysql')->rollBack();
            $this->error('Falha ao gravar local: '.$e->getMessage());
            return self::FAILURE;
        }

        // Atualiza cursor com o último registro do lote (já ordenado ASC)
        $last = end($rows);
        DB::table('sync_cursors')->updateOrInsert(
            ['name' => 'transfer_vendas'],
            [
                'last_data' => $last->DATA,
                'last_hora' => $last->HORA,
                'last_num_doc' => $last->NUM_DOC,
                'last_cod_item' => $last->COD_ITEM,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $this->info('Cursor atualizado.');
        return self::SUCCESS;
    }
}