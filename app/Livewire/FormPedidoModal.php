<?php

namespace App\Livewire;

use App\Models\Pedido;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class FormPedidoModal extends ModalComponent
{
    public $id, $valor_frete, $dataPagamento, $mode, $num_nota_fiscal, $num_pedido, $cidade, $cliente_id, $nome_cliente, $pedido, $showAlert, $data_solicitacao, $descarga, $carga_id;
    public $pedido_id,$pedido_update_id;

    

    public function rules()
    {
        $rule = [
            'num_pedido' => 'required',
            'cidade' => 'required',
            'num_nota_fiscal' => 'required',
            'valor_frete' => 'required',
            'data_solicitacao' => 'required',
        ];

        return $rule;
    }

    public function delete(){
        
       $this->pedido= Pedido::find($this->id);
       $this->pedido->delete();
       return redirect()->route('cargas');
    }

    public function move_pago()
    {
        if ($this->pedido_id){
            $this->pedido = Pedido::find($this->pedido_id);          
            if ($this->pedido) {
                $this->pedido->update([
                    'status' => 'pago',
                    'data_pagamento' => $this->dataPagamento
                ]);
              
                if ($this->pedido != null) {
                    $this->closeModal();
                    return redirect()->route('cargas');
                }
            }            
        }
    }

    public function move_pendente()
    {
        if ($this->pedido_update_id){
            $this->pedido = Pedido::find($this->pedido_update_id);          
            if ($this->pedido) {
                $this->pedido->update([
                    'status' => 'pendente',
                    'data_pagamento' => ''
                ]);
              
                if ($this->pedido != null) {
                    $this->closeModal();
                    return redirect()->route('cargas');
                }
            }            
        }
    }

    public function move_nao_pago()
    {
        if ($this->pedido_id){
            $this->pedido = Pedido::find($this->pedido_id);          
            if ($this->pedido) {
                $this->pedido->update([
                    'status' => 'nao_pago',
                    'data_pagamento' => ''
                ]);
              
                if ($this->pedido != null) {
                    $this->closeModal();
                    return redirect()->route('cargas');
                }
            }            
        }
    }

    public function mount()
    {
        $this->id;
        $this->mode;

        if ($this->mode == 'update_pedido') {
            $this->pedido = Pedido::find($this->id);
            $this->num_pedido = $this->pedido->numero_pedido;
            $this->cidade = $this->pedido->cidade;
            $this->num_nota_fiscal = $this->pedido->numero_nota;
            $this->valor_frete = $this->pedido->valor_frete;
            $this->data_solicitacao = $this->pedido->data_solicitacao;
            $this->descarga = $this->pedido->valor_descarga;
        }
    }
    public function render()
    {
        return view('livewire.form-pedido-modal');
    }

    public function editarpedido()
    {
        $this->validate();
        $this->pedido->update([
            'numero_pedido' => $this->num_pedido,
            'cidade' => $this->cidade,
            'numero_nota' => $this->num_nota_fiscal,
            'valor_frete' => $this->valor_frete,
            'data_solicitacao' => $this->data_solicitacao,
            'valor_descarga' => $this->descarga
        ]);

        if ($this->pedido != null) {
            $this->closeModal();
            return redirect()->route('cargas');
        }
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
