<?php

namespace App\Http\Controllers;

use App\Models\VendasVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;

class VendasVoucherController extends Controller
{
    /**
     * GET /vendas-voucher
     * Filtros: empresa, num_doc, data_ini, data_fim, cliente, cpf_cnpj, fornecedor
     * Ordenação: sort (campo) e dir (asc|desc) — default DATA DESC, HORA DESC
     * Paginação: per_page (default 50, máx 500)
     */
    public function index(Request $req)
    {
        $q = VendasVoucher::query();

        if ($req->filled('empresa'))    $q->empresa($req->integer('empresa'));
        if ($req->filled('num_doc'))    $q->numDoc($req->get('num_doc'));
        if ($req->filled('data_ini') || $req->filled('data_fim'))
            $q->periodo($req->get('data_ini'), $req->get('data_fim'));
        if ($req->filled('cliente'))    $q->clienteContem($req->get('cliente'));
        if ($req->filled('cpf_cnpj'))   $q->cpfCnpj($req->get('cpf_cnpj'));
        if ($req->filled('fornecedor')) $q->fornecedorContem($req->get('fornecedor'));

        // Ordenação segura
        $allowedSorts = [
            'DATA','HORA','EMPRESA','NUM_DOC','COD_ITEM',
            'CLIENTE','FORNECEDOR','TOTAL_BRUTO','VALOR_LIQUIDO'
        ];
        $sort = $req->get('sort', 'DATA');
        $dir  = strtolower($req->get('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        if (!in_array($sort, $allowedSorts, true)) $sort = 'DATA';

        // Ordenação multi-chave quando DATA/HORA
        if ($sort === 'DATA') {
            $q->orderBy('DATA', $dir)->orderBy('HORA', $dir)->orderBy('NUM_DOC', $dir);
        } else {
            $q->orderBy($sort, $dir);
        }

        $perPage = (int) $req->get('per_page', 50);
        $perPage = max(1, min(500, $perPage));

        return response()->json($q->paginate($perPage));
    }

    /**
     * GET /vendas-voucher/{empresa}/{num_doc}/{cod_item}
     */
    public function show($empresa, $num_doc, $cod_item)
    {
        $row = VendasVoucher::query()
            ->where('EMPRESA', $empresa)
            ->where('NUM_DOC', $num_doc)
            ->where('COD_ITEM', $cod_item)
            ->firstOrFail();

        return response()->json($row);
    }

    /**
     * POST /vendas-voucher
     * Upsert (não duplica): EMPRESA + NUM_DOC + COD_ITEM
     */
    public function store(Request $req)
    {
        $data = $this->validatePayload($req);

        // Se preferir Eloquent:
        // VendasVoucher::updateOrCreate(
        //     ['EMPRESA'=>$data['EMPRESA'], 'NUM_DOC'=>$data['NUM_DOC'], 'COD_ITEM'=>$data['COD_ITEM']],
        //     collect($data)->except(['EMPRESA','NUM_DOC','COD_ITEM'])->all()
        // );

        // Builder (mais performático para lotes):
        DB::table('vendas_voucher')->upsert(
            [$data],
            ['EMPRESA','NUM_DOC','COD_ITEM'],
            [
                'ESP_DOC','SERIE','DATA','HORA',
                'DESCRICAO_ITEM','UNIDADE','QTD','PRECO_UNIT','TOTAL_BRUTO','VALOR_LIQUIDO',
                'CLIENTE','CPF_CNPJ','CPF_CNPJ_FORMATADO',
                'COD_FORNECEDOR','FORNECEDOR','FORNECEDOR_FANTASIA',
            ]
        );

        return response()->json(['ok' => true], 201);
    }

    /**
     * PUT /vendas-voucher/{empresa}/{num_doc}/{cod_item}
     */
    public function update(Request $req, $empresa, $num_doc, $cod_item)
    {
        $data = $this->validatePayload($req, updating: true, routeKeys: compact('empresa','num_doc','cod_item'));

        DB::table('vendas_voucher')
            ->where('EMPRESA', $empresa)
            ->where('NUM_DOC', $num_doc)
            ->where('COD_ITEM', $cod_item)
            ->update(collect($data)->except(['EMPRESA','NUM_DOC','COD_ITEM'])->all());

        return response()->json(['ok' => true]);
    }

    /**
     * DELETE /vendas-voucher/{empresa}/{num_doc}/{cod_item}
     */
    public function destroy($empresa, $num_doc, $cod_item)
    {
        DB::table('vendas_voucher')
            ->where('EMPRESA', $empresa)
            ->where('NUM_DOC', $num_doc)
            ->where('COD_ITEM', $cod_item)
            ->delete();

        return response()->json(['ok' => true]);
    }

    /* -------------------- helpers -------------------- */

    private function validatePayload(Request $req, bool $updating = false, array $routeKeys = [])
    {
        // Se vierem pelas rotas, preenche no array para validação
        if ($updating && $routeKeys) {
            $req->merge([
                'EMPRESA'  => $routeKeys['empresa'],
                'NUM_DOC'  => $routeKeys['num_doc'],
                'COD_ITEM' => $routeKeys['cod_item'],
            ]);
        }

        return $req->validate([
            'EMPRESA'              => ['required','integer'],
            'NUM_DOC'              => ['required','string','max:50'],
            'COD_ITEM'             => ['required','string','max:50'],

            'ESP_DOC'              => ['nullable','string','max:20'],
            'SERIE'                => ['nullable','string','max:20'],
            'DATA'                 => ['nullable','date'],
            'HORA'                 => ['nullable','date_format:H:i:s'],

            'DESCRICAO_ITEM'       => ['nullable','string','max:255'],
            'UNIDADE'              => ['nullable','string','max:20'],
            'QTD'                  => ['nullable','numeric'],
            'PRECO_UNIT'           => ['nullable','numeric'],
            'TOTAL_BRUTO'          => ['nullable','numeric'],
            'VALOR_LIQUIDO'        => ['nullable','numeric'],

            'CLIENTE'              => ['nullable','string','max:255'],
            'CPF_CNPJ'             => ['nullable','string','max:20'],
            'CPF_CNPJ_FORMATADO'   => ['nullable','string','max:25'],

            'COD_FORNECEDOR'       => ['nullable','string','max:50'],
            'FORNECEDOR'           => ['nullable','string','max:255'],
            'FORNECEDOR_FANTASIA'  => ['nullable','string','max:255'],
        ]);
    }

    /**
     * Retorna vendas apenas das empresas 007 e 001.
     * GET /vendas-voucher/empresas-007-001
     */
    public function vendasEmpresas_007_011()
    {
        $vendas = VendasVoucher::whereIn('EMPRESA', ['007', '011'])->get();
        return $vendas;
        // return response()->json($vendas);
    }

    /**
     * Retorna os vouchers de venda pelo número da nota (NUM_DOC).
     * GET /vendas-voucher/por-numero/{num_doc}
     */
    public function porNumero($num_doc)
    {
        $doc = $this->valida_NF($num_doc);    
        return $doc;
        // return response()->json($vouchers);
    }

    public function valida_NF(string $numDoc)
    {
       // Normaliza o parâmetro
        $docSemZeros = ltrim($numDoc, '0');
        if ($docSemZeros === '') {
            $docSemZeros = '0';
        }
        $docPad12 = str_pad($docSemZeros, 12, '0', STR_PAD_LEFT); // ajuste o 12 se sua coluna tiver outro tamanho

        $q = VendasVoucher::query()
            ->select([
                'NUM_DOC',
                'EMPRESA',
                DB::raw("MIN(CLIENTE) AS CLIENTE"),
                DB::raw("MIN(CPF_CNPJ_FORMATADO) AS CPF_CNPJ_FORMATADO"),
                DB::raw("MIN(ESP_DOC) AS ESP_DOC"),
                DB::raw("GROUP_CONCAT(DISTINCT FORNECEDOR_FANTASIA ORDER BY FORNECEDOR_FANTASIA SEPARATOR ', ') AS FORNECEDORES"),

                DB::raw("
                    SUM(CASE WHEN COD_FORNECEDOR='00000017'
                            THEN CAST(VALOR_LIQUIDO AS DECIMAL(18,2))
                            ELSE 0.0 END) AS total_00000017
                "),
                DB::raw("
                    SUM(CASE WHEN COD_FORNECEDOR='50001023'
                            THEN CAST(VALOR_LIQUIDO AS DECIMAL(18,2))
                            ELSE 0.0 END) AS total_50001023
                "),

                DB::raw("MAX(CASE WHEN COD_FORNECEDOR='00000017'  THEN 1 ELSE 0 END) AS has_00000017"),
                DB::raw("MAX(CASE WHEN COD_FORNECEDOR='50001023'  THEN 1 ELSE 0 END) AS has_50001023"),
            ])
            // NUM_DOC tolerante a zeros à esquerda
            ->where(function($w) use ($docPad12, $docSemZeros) {
                $w->where(DB::raw("LPAD(NUM_DOC, 12, '0')"), '=', $docPad12)
                ->orWhere(DB::raw("TRIM(LEADING '0' FROM NUM_DOC)"), '=', $docSemZeros);
            })
            // EMPRESA tolerante a zeros à esquerda
            ->whereIn(DB::raw("LPAD(EMPRESA, 3, '0')"), ['007','011'])

            // **Novo filtro**: somente documentos cujo ESP_DOC é exatamente 'NF'
            ->whereRaw("TRIM(ESP_DOC) = 'NF'")

            ->groupBy('NUM_DOC','EMPRESA')
            // pisos — só exigimos se o fornecedor aparecer na nota
            ->havingRaw('(has_00000017 = 0 OR total_00000017 >= 500)')
            ->havingRaw('(has_50001023 = 0 OR total_50001023 >= 300)');

        $res = $q->first(); // null se não atender às regras

        if (!$res) {
            return null;
        }

        // Garante retorno apenas se pelo menos um dos campos for > 0
        if (
            (isset($res->has_00000017) && $res->has_00000017 > 0) ||
            (isset($res->has_50001023) && $res->has_50001023 > 0)
        ) {
            return $res;
        }

    }
}
