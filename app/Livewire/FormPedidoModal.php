<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class FormPedidoModal extends ModalComponent
{
   public $id;

    public function mount(){
       dump($this->id);
    }
    public function render()
    {
        return view('livewire.form-pedido-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
