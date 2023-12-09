<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pedidos')->insert([
            'numero_pedido' => 1234545,
            'cidade' => 'Belo Horizonte',
            'cliente_id'=>1,
            'numero_nota' => 'ABC123',
            'valor_frete' => 50.00,
            'total_valor_frete' => 55.00,
            'valor_descarga' => 10.00,
            'user_id' => 1, // Associando ao usuário com id 1
        ]);

    }
}
