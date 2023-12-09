<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\Carga;
use App\Models\Cliente;

class FormPedido extends Component
{

   public $valor_frete,$num_nota_fiscal,$num_pedido,$cidade,$cliente_id,$nome_cliente,$pedido,$showAlert,$data_solicitacao,$descarga,$carga_id;

  public $cargas,$clientes;


   public function mount(){
     $this->cargas=Carga::All();
     $this->clientes=Cliente::All();
   }

    public function rules(){
        $rule=[
            'num_pedido'=>'required',
            'cidade'=>'required',
            'num_nota_fiscal'=>'required',
            'valor_frete'=>'required',
            'data_solicitacao'=>'required',
            'cliente_id'=>'required',
            'carga_id'=>'required',
        ];

        return $rule;
    }

    public function save(){

        
        $this->validate();

        $this->pedido=Pedido::create([
            'numero_pedido'=>$this->num_pedido,
            'cidade'=>$this->cidade,
            'numero_nota'=>$this->num_nota_fiscal,
            'valor_frete'=>$this->valor_frete,
            'data_solicitacao'=>$this->data_solicitacao,
            'cliente_id'=>$this->cliente_id,
            'carga_id'=>$this->carga_id,
        ]);

        $this->showAlert = true;

        session()->flash('sucesso', 'Pedido  cadastrado !!');
    }


    public function closealert()
    {
        $this->showAlert = false;
    }


    public function render()
    {
        return view('livewire.form-pedido');
    }
}
