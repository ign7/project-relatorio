<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class FormVeiculoModal extends ModalComponent
{

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    
    public function render()
    {
        return view('livewire.form-veiculo-modal');
    }
}
