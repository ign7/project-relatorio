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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_pedido');
            $table->string('cidade')->nullable();
            $table->string('numero_nota');
            $table->decimal('valor_frete');
            $table->string('data_solicitacao')->nullable();
            $table->enum('status', ['pago', 'nao_pago', 'pendente'])->default('pendente');
            $table->decimal('pedagio')->nullable();
            $table->string('data_pagamento')->nullable();
            $table->decimal('valor_descarga')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
