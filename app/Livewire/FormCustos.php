<?php

namespace App\Livewire;

use Livewire\Component;

class FormCustos extends Component
{

    public $search_id, $mode;

    protected $listeners = [
        'search_id' => 'setIdModel',
    ];


    public function setIdModel($search_id, $mode)
    {
        $this->mode = $mode;
        if ($this->mode == 'veiculo')
            dump('entrouaki' . $this->mode);
        else
            dump('entrouaki no else' . $this->mode);

        $this->search_id = $search_id;
    }


    public function render()
    {
        return view('livewire.form-custos');
    }
}
