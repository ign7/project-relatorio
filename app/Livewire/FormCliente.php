<?php

namespace App\Livewire;

use App\Models\Cliente;
use Livewire\Component;

class FormCliente extends Component
{

    public $nome,$cliente,$showAlert;



    public function rules(){
        $rule=[
            'nome'=>'required',
        ];

        return $rule;
    }
    public function save(){
        
        $this->validate();

        $this->cliente=Cliente::create([
          'nome'=> $this->nome,
        ]);
        $this->showAlert = true;
        session()->flash('sucesso', 'Cliente cadastrado !!');
    }


    public function closealert()
    {
        $this->showAlert = false;
    }


    public function render()
    {
        return view('livewire.form-cliente');
    }
}
