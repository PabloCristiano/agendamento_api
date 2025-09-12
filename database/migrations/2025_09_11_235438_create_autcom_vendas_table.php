<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autcom_vendas', function (Blueprint $table) {
            $table->id();

            // Campos MOVDET
            $table->string('det_codemp', 10)->nullable()->comment('Código da empresa');
            $table->string('det_codven', 20)->nullable()->comment('Código do vendedor');
            $table->string('det_codite', 50)->nullable()->comment('Código do item');
            $table->string('det_codmar', 20)->nullable()->comment('Código da marca');
            $table->string('det_codcli', 20)->nullable()->comment('Código do cliente');
            $table->string('det_numdoc', 20)->nullable()->comment('Número do documento');
            $table->string('det_espdoc', 10)->nullable()->comment('Espécie do documento');
            $table->string('det_serie_', 10)->nullable()->comment('Série do documento');
            $table->date('det_dtaent')->nullable()->comment('Data de entrada');
            $table->time('det_horent')->nullable()->comment('Hora de entrada');
            $table->date('det_dtadoc')->nullable()->comment('Data do documento');
            $table->string('det_conpag', 20)->nullable()->comment('Condição de pagamento');
            $table->string('det_tip_fc', 10)->nullable()->comment('Tipo FC');
            $table->string('det_estado', 5)->nullable()->comment('Estado');
            $table->text('det_descri')->nullable()->comment('Descrição');
            $table->decimal('det_qtdite', 15, 4)->nullable()->comment('Quantidade do item');
            $table->decimal('det_totite', 15, 2)->nullable()->comment('Total do item');

            // Campos CADCLI
            $table->string('cli_codcli', 20)->nullable()->comment('Código do cliente');
            $table->string('cli_codati', 20)->nullable()->comment('Código de atividade');
            $table->string('cli_nomcli', 100)->nullable()->comment('Nome do cliente');
            $table->string('cli_cgccpf', 20)->nullable()->comment('CNPJ/CPF');
            $table->string('cli_c_g_c_', 20)->nullable()->comment('CGC');
            $table->string('cli_i_e_s_', 20)->nullable()->comment('Inscrição estadual');
            $table->string('cli_iesuni', 20)->nullable()->comment('IE única');
            $table->string('cli_fone01', 20)->nullable()->comment('Telefone 01');
            $table->string('cli_status', 10)->nullable()->comment('Status do cliente');
            $table->string('cli_consum', 10)->nullable()->comment('Consumidor');
            $table->decimal('cli_limcre', 15, 2)->nullable()->comment('Limite de crédito');
            $table->date('cli_ultalt')->nullable()->comment('Última alteração');
            $table->decimal('cli_vrucom', 15, 2)->nullable()->comment('Valor última compra');
            $table->date('cli_ultcom')->nullable()->comment('Data última compra');
            $table->string('cli_celula', 20)->nullable()->comment('Célula');
            $table->integer('cli_qtdeti')->nullable()->comment('Quantidade etiquetas');
            $table->date('cli_dtmcom')->nullable()->comment('Data maior compra');
            $table->decimal('cli_vrmcom', 15, 2)->nullable()->comment('Valor maior compra');
            $table->integer('cli_domcom')->nullable()->comment('Dia do mês compra');
            $table->integer('cli_doucom')->nullable()->comment('Dia útil compra');
            $table->string('cli_sufram', 20)->nullable()->comment('Suframa');
            $table->decimal('cli_permmi', 5, 2)->nullable()->comment('Percentual mínimo');
            $table->decimal('cli_permff', 5, 2)->nullable()->comment('Percentual FF');
            $table->integer('cli_atrmax')->nullable()->comment('Atraso máximo');
            $table->decimal('cli_crdfis', 15, 2)->nullable()->comment('Crédito fiscal');
            $table->string('cli_eminfe', 10)->nullable()->comment('Emite NF-e');
            $table->decimal('cli_capsoc', 15, 2)->nullable()->comment('Capital social');

            // Campos CADITE
            $table->date('ite_ultalt')->nullable()->comment('Última alteração do item');

            // Campos CADFOR
            $table->string('fornecedor', 100)->nullable()->comment('Nome do fornecedor');
            $table->string('for_nomfan', 100)->nullable()->comment('Nome fantasia fornecedor');
            $table->string('for_codfor', 20)->nullable()->comment('Código do fornecedor');

            // Campo calculado
            $table->decimal('valor_total', 15, 2)->nullable()->comment('Valor total calculado');

            $table->timestamps();

            // Índices
            $table->index(['det_codemp', 'det_codcli'], 'idx_empresa_cliente');
            $table->index(['det_dtadoc'], 'idx_data_documento');
            $table->index(['det_codven'], 'idx_vendedor');
            $table->index(['det_codite'], 'idx_item');
            $table->index(['cli_codcli'], 'idx_cliente');
            $table->index(['for_codfor'], 'idx_fornecedor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autcom_vendas');
    }
};
