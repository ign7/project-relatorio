<?php

namespace App\Livewire;

use app;
use Livewire\Component;
use App\Services\CustoService;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FormCustos extends Component
{

    use LivewireAlert;

    public $search_id, $search_id_carga, $search_id_veiculo, $mode;

    public $id,
        $litros,
        $titulo,
        $descricao,
        $valor_litro,
        $combustivel,
        $kimometros,
        $pedagio,
        $despesas,
        $descarga,
        $manutencao,
        $data_manutencao;

    protected  $service;

    public function mount(CustoService $service)
    {
        $this->service = $service;
    }

    public function hydrate()
    {
        $this->service = app(CustoService::class);
    }

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

    public function save()
    {
        $atributos = [
            'litros' => $this->litros,
            'titulo'=>$this->titulo,
            'descricao'=>$this->descricao,
            'valor_litro' => $this->valor_litro,
            'combustivel' => $this->combustivel,
            'kimometros' => $this->kimometros,
            'pedagio' => $this->pedagio,
            'despesas' => $this->despesas,
            'descarga' => $this->descarga,
            'manutencao' => $this->manutencao,
            'data_manutencao' => $this->data_manutencao,
            'carga_id' => $this->search_id_carga,
            'veiculo_id' => $this->search_id_veiculo
        ];

        if ($this->service) {
            $result = $this->service->register($atributos);
            if ($result) {
                $this->alert('success', 'Fromulario cadastrado');
               return $this->dispatch('opentableCustos');
            }

            return $this->alert('error', 'not register found !!');
        }

        return $this->alert('error', 'serviço indisponivel !!');
    }

    public function render()
    {
        return view('livewire.form-custos');
    }
}
