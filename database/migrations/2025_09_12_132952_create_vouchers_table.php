<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('numero_nota', 30)->unique();     
            $table->string('nome_completo', 150);
            $table->string('cpf_cnpj', 20)->unique();                  
            $table->string('loja', 50);                     
            $table->string('voucher_code', 60)->unique();    
            $table->timestamp('gerado_em')->nullable();      
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
