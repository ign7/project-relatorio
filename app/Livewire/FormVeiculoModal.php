<?php

namespace App\Livewire;

use App\Services\VeiculoService;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FormVeiculoModal extends ModalComponent
{

    public $name, $placa, $marca, $user_id;

    use LivewireAlert;

    protected VeiculoService $service;

    protected $listeners = [
        'search_id' => 'setIdUser',
    ];


    public function mount(VeiculoService $service)
    {
        $this->service = $service;
    }

    public function setIdUser($search_id)
    {
        $this->user_id = $search_id;
    }

    public function saveVeiculo()
    {
        
        $atributos = [
            'name' => $this->name,
            'placa' => $this->placa,
            'marca' => $this->marca,
            'user_id' => $this->user_id
        ];

        $this->service->register($atributos);
        $this->alert('success', 'veiculo cadastrado com sucesso');
        $this->closeModal();
    }

    public function hydrate()
    {
        $this->service = app(VeiculoService::class);
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }


    public function render()
    {
        return view('livewire.form-veiculo-modal');
    }
}
