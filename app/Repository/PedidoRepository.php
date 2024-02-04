<?php

namespace  App\Repository;

use App\Models\Pedido;
use App\Interface\PedidoInterface;
use Illuminate\Support\Facades\DB;

class PedidoRepository extends BaseRepository  /* implements PedidoInterface */
{

    protected $pedido;

    public function __construct(Pedido $pedido)
    {
        parent::__construct($pedido);
    }



    public function getPedidosByCarga($carga_id) 
    {
        DB::statement('SET sql_mode=(SELECT REPLACE(@@sql_mode,"ONLY_FULL_GROUP_BY",""))');
       return Pedido::where('carga_id', $carga_id)
        ->select([
            'pedidos.id as id_pedido',
            'pedidos.numero_pedido as numero_pedido',
            'pedidos.valor_frete as valor_frete',
            'pedidos.valor_descarga as valor_descarga',
            'pedidos.data_solicitacao as data_solicitacao',
            'pedidos.numero_nota as numero_nota',
            'cidades.cidade as cidade',
            'clientes.nome as nome_cliente',
            'cargas.numero_carga as numero_carga',
            'cargas.id as id_carga',
        ])
        ->selectRaw('SUM(pedidos.valor_frete) as valor_total_frete_carga')
        ->join('cargas', function ($table) {
            $table->on('pedidos.carga_id', '=', 'cargas.id');
        })->join('clientes', function ($table) {
            $table->on('pedidos.cliente_id', '=', 'clientes.id');
        })->join('cidades', function ($table) {
            $table->on('pedidos.cidade_id', '=', 'cidades.id');
        })
        ->groupBy('pedidos.id')
        ->get();

    }
}
