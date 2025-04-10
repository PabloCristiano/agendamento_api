<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelasSistema extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('tipo_pessoa')->nullable();
            $table->string('cnpj');
            $table->string('nome_responsavel');
            $table->string('telefone');
            $table->string('email');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cep');
            $table->boolean('status')->default(true);
            $table->text('observacao')->nullable();
            $table->timestamps();
        });

        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->string('cargo');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->timestamps();
        });

        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cpf')->unique();
            $table->string('telefone');
            $table->string('password');
            $table->foreignId('cargo_id')->constrained('cargos');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->timestamps();
        });

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf')->unique();
            $table->date('data_nascimento');
            $table->string('whatsapp');
            $table->string('telefone');
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->timestamps();
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('servico');
            $table->integer('tempo');
            $table->decimal('valor', 10, 2);
            $table->decimal('comissao', 10, 2);
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->timestamps();
        });

        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->date('data_atendimento');
            $table->time('hora_atendimento');
            $table->timestamps();
        });

        Schema::create('servico_agendamento', function (Blueprint $table) {
            $table->foreignId('agendamento_id')->constrained('agendamentos')->onDelete('cascade');
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->primary(['agendamento_id', 'servico_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servico_agendamento');
        Schema::dropIfExists('agendamentos');
        Schema::dropIfExists('servicos');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('cargos');
        Schema::dropIfExists('empresas');
    }
}
