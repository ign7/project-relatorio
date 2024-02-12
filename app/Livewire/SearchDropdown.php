<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Collection;

class SearchDropdown extends Component
{

    public $query;
    public $modelClassName;
    public $contacts;
    public $highlightIndex, $atributte, $searchFilter,$column;

    public function mount($modelClassName)
    {
        $this->modelClassName = $modelClassName;
        $this->resetar();
    }

    public function resetar()
    {
        $this->query = '';
        $this->contacts = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->contacts) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->contacts) - 1;
            return;
        }
        $this->highlightIndex--;
    }

 public function selectContact()
{
    $contact = $this->contacts[$this->highlightIndex] ?? null;
    if ($contact) {
        $this->atributte = $contact[$this->column] ?? null;
        $this->searchFilter = $contact['id'];
    }
}


    public function selectClickContact($contactId)
    {
        $contactCollection = new Collection($this->contacts);
        $contact = $contactCollection->firstWhere('id', $contactId);
        if ($contact) {
            $this->atributte = $contact[$this->column];
            $this->searchFilter = $contact['id'];
            $this->clear();
        }
        $this->dispatch('search_id',$this->searchFilter);
    }

    public function clear()
    {
        $this->query = '';
        $this->contacts = [];
        $this->highlightIndex = 0;
    }

    public function search()
    {
        $modelClass = App::make($this->modelClassName);
        $this->contacts = $modelClass::where($this->column, 'like', '%' . $this->query . '%')
            ->get()
            ->toArray();
    }


    public function render()
    {
        return view('livewire.search-dropdown');
    }
}