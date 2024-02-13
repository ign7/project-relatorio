<?php

namespace App\Livewire;

use Livewire\Component;

class FormControle extends Component
{
    public $flagcargas, $flagpedidos, $flagclientes;

    public function activecarga()
    {
        if (!$this->flagcargas)
            return $this->flagcargas = true;

        return $this->flagcargas = false;
    }

    public function activepedido()
    {
        if (!$this->flagpedidos)
            return  $this->flagpedidos = true;

        return $this->flagpedidos = false;
    }


    public function activecliente()
    {
        if (!$this->flagclientes)
            return  $this->flagclientes = true;

        return $this->flagclientes = false;
    }
    public function render()
    {
        return view('livewire.form-controle');
    }
}
