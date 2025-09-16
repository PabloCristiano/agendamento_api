<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('vendas_voucher', function (Blueprint $table) {
            $table->string('EMPRESA',20);
            $table->string('NUM_DOC', 50);
            $table->string('ESP_DOC', 20)->nullable();
            $table->string('SERIE', 20)->nullable();
            $table->date('DATA')->nullable();
            $table->time('HORA')->nullable();

            $table->string('COD_ITEM', 50);
            $table->string('DESCRICAO_ITEM', 255)->nullable();
            $table->string('UNIDADE', 20)->nullable();
            $table->decimal('QTD', 15, 4)->nullable();
            $table->decimal('PRECO_UNIT', 15, 4)->nullable();
            $table->decimal('TOTAL_BRUTO', 15, 2)->nullable();
            $table->decimal('VALOR_LIQUIDO', 15, 2)->nullable();

            $table->string('CLIENTE', 255)->nullable();
            $table->string('CPF_CNPJ', 20)->nullable();
            $table->string('CPF_CNPJ_FORMATADO', 25)->nullable();

            $table->string('COD_FORNECEDOR', 50)->nullable();
            $table->string('FORNECEDOR', 255)->nullable();
            $table->string('FORNECEDOR_FANTASIA', 255)->nullable();

            // evita duplicar:
            $table->primary(['EMPRESA', 'NUM_DOC', 'COD_ITEM']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas_voucher');
    }
};
