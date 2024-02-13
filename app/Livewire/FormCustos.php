<?php

namespace App\Livewire;

use Livewire\Component;

class FormCustos extends Component
{

    public $search_id, $search_id_carga, $search_id_veiculo, $mode;


    public $id,
        $litros,
        $valor_litro,
        $combustivel,
        $kimometros,
        $pedagio,
        $despesas,
        $descarga,
        $manutencao,
        $data_manutencao,
        $carga_id,
        $veiculo_id;

    protected $listeners = [
        'search_id' => 'setIdModel',
    ];


    public function setIdModel($search_id, $mode)
    {
        $this->mode = $mode;
        if ($this->mode == 'veiculo')
            $this->search_id_veiculo = $search_id;
        if ($this->mode == 'carga')
            $this->search_id_carga = $search_id;
    }


    public function render()
    {
        return view('livewire.form-custos');
    }
}
