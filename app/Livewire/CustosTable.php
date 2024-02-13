<?php

namespace App\Livewire;

use App\Models\Custo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class CustosTable extends PowerGridComponent
{

    protected $listeners = [
        'opentableCustos' => 'datasource'
    ];

    public function datasource(): ?Collection
    {
        return Custo::all();
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('titulo')
            ->add('valor_litro')
            ->add('litro')
            ->add('combustivel')
            ->add('pedagio')
            ->add('despesas')
            ->add('descarga')
            ->add('manutencao')
            ->add('carga_id')
            ->add('veiculo_id')
            ->add('daata_manutencao', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('titulo', 'titulo')
                ->searchable()
                ->sortable(),

            Column::make('descricao', 'descricao')
                ->searchable()
                ->sortable(),

            Column::make('valor_litro', 'valor_litro')
                ->sortable(),

            Column::make('litro', 'litro')
                ->sortable(),
            Column::make('combustivel', 'combustivel')
                ->sortable(),
            Column::make('pedagio', 'pedagio')
                ->sortable(),
            Column::make('despesas', 'despesas')
                ->sortable(),
            Column::make('manutencao', 'manutencao')
                ->sortable(),
            Column::make('carga_id', 'carga_id')
                ->sortable(),

            Column::make('veiculo_id', 'veiculo_id')
                ->sortable(),



            Column::action('Action')
        ];
    }
}
