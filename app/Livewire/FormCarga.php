<?php

namespace App\Livewire;

use App\Models\Carga;
use Livewire\Component;

class FormCarga extends Component
{

    public $nome,$carga,$showAlert;



    public function rules(){
        $rule=[
            'nome'=>'required',
        ];

        return $rule;
    }
    public function save(){
        
        $this->validate();

        $this->carga=Carga::create([
          'numero_carga'=> $this->nome,
          'user_id'=>auth()->id(),
        ]);
        $this->showAlert = true;
        session()->flash('sucesso', 'Numero de carga cadastrado !!');
    }


    public function closealert()
    {
        $this->showAlert = false;
    }



    public function render()
    {
        return view('livewire.form-carga');
    }
}
