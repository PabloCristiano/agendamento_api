<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->id();
            $table->string('pais', 50);
            $table->string('sigla', 6);
            $table->string('ddi', 6);
            $table->timestamps();
        });

        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->string('estado', 50);
            $table->string('uf', 6);
            $table->foreignId('id_pais')->constrained('paises');
            $table->timestamps();
        });

        Schema::create('cidades', function (Blueprint $table) {
            $table->id();
            $table->string('cidade', 50);
            $table->string('ddd', 6);
            $table->foreignId('id_estado')->constrained('estados');
            $table->timestamps();
        });

        Schema::create('condicao_pg', function (Blueprint $table) {
            $table->id();
            $table->string('condicao_pagamento', 50);
            $table->double('juros');
            $table->double('multa');
            $table->double('desconto');
            $table->timestamps();
        });

        Schema::create('forma_pg', function (Blueprint $table) {
            $table->id();
            $table->string('forma_pg', 50);
            $table->timestamps();
        });

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('cliente', 50);
            $table->string('apelido', 50)->nullable();
            $table->string('cpf', 14);
            $table->string('rg', 8)->nullable();
            $table->date('dataNasc')->nullable();
            $table->string('logradouro', 50)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('whatsapp', 14)->nullable();
            $table->string('telefone', 14);
            $table->string('email', 50);
            $table->string('senha', 50);
            $table->string('confSenha', 50);
            $table->string('observacao', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('servico', 50);
            $table->integer('tempo');
            $table->float('valor');
            $table->float('comissao');
            $table->timestamps();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('categoria', 50);
            $table->timestamps();
        });

        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_pessoa', 50)->nullable();
            $table->string('razaoSocial', 50);
            $table->string('nomeFantasia', 50)->nullable();
            $table->string('apelido', 50)->nullable();
            $table->string('logradouro', 50);
            $table->string('numero', 10);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 50);
            $table->string('cep', 9);
            $table->foreignId('id_cidade')->constrained('cidades');
            $table->string('whatsapp', 14)->nullable();
            $table->string('telefone', 14)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('pagSite', 50)->nullable();
            $table->string('contato', 50)->nullable();
            $table->string('cnpj', 18);
            $table->string('ie', 14)->nullable();
            $table->string('cpf', 14);
            $table->string('rg', 10)->nullable();
            $table->foreignId('id_condicaopg')->constrained('condicao_pg');
            $table->float('limeteCredito')->nullable();
            $table->string('obs', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('produto', 50);
            $table->integer('unidade');
            $table->foreignId('id_categoria')->constrained('categorias');
            $table->integer('qtdEstoque')->nullable();
            $table->float('precoCusto')->nullable();
            $table->float('precoVenda');
            $table->float('custoUltCompra')->nullable();
            $table->date('dataUltCompra')->nullable();
            $table->date('dataUltVenda')->nullable();
            $table->timestamps();
        });

        Schema::create('profissionais', function (Blueprint $table) {
            $table->id();
            $table->string('profissional', 50);
            $table->string('apelido', 50)->nullable();
            $table->string('cpf', 18);
            $table->string('rg', 18)->nullable();
            $table->date('dataNasc');
            $table->string('logradouro', 50);
            $table->string('numero', 10);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 50);
            $table->string('cep', 12);
            $table->string('whatsapp', 20)->nullable();
            $table->string('telefone', 20);
            $table->string('email', 50);
            $table->string('senha', 50);
            $table->string('confSenha', 50);
            $table->integer('qtd_servico');
            $table->foreignId('id_servico')->constrained('servicos');
            $table->float('comissao');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profissionais');
        Schema::dropIfExists('produtos');
        Schema::dropIfExists('fornecedores');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('servicos');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('forma_pg');
        Schema::dropIfExists('condicao_pg');
        Schema::dropIfExists('cidades');
        Schema::dropIfExists('estados');
        Schema::dropIfExists('paises');
    }
};
