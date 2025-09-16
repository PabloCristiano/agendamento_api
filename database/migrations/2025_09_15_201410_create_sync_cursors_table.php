<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sync_cursors', function (Blueprint $table) {
            $table->string('name')->primary(); // ex: 'transfer_vendas'
            $table->date('last_data')->nullable();
            $table->time('last_hora')->nullable();
            $table->string('last_num_doc', 50)->nullable();
            $table->string('last_cod_item', 50)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sync_cursors');
    }
};
