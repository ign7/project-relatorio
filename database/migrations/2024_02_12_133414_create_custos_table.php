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
        Schema::create('custos', function (Blueprint $table) {
            $table->id();
            $table->float('litros')->nullable();
            $table->float('valor_litro')->nullable();
            $table->float('combustivel')->nullable();
            $table->float('kimometros')->nullable();
            $table->float('pedagio')->nullable();
            $table->float('despesas')->nullable();
            $table->float('descarga')->nullable();
            $table->float('manutencao')->nullable();
            $table->string('data_manutencao')->nullable();
            $table->foreignId('carga_id')->constrained('cargas')->nullable();
            $table->foreignId('veiculo_id')->constrained('veiculos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custos');
    }
};
