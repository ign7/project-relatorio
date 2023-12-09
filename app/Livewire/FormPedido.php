<?php

namespace App\Livewire;

use Livewire\Component;

class FormPedido extends Component
{

   public $valor_fatura,$num_nota_fiscal,$num_pedido,$cidade,$cliente_id,$nome_cliente;


    public function render()
    {
        return view('livewire.form-pedido');
    }
}
