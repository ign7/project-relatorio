<?php

namespace App\Livewire;

use App\Models\Pedido;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class PedidoTable extends PowerGridComponent
{
    public function datasource(): ?Collection
    {
        return Pedido::select(
            'id',
            'numero_pedido',
            'cidade',
            'numero_nota',
            'valor_frete',
            'valor_descarga',
            'data_solicitacao',
            'cliente_id',
            'carga_id'

        )->get();
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

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('data_solicitacao')
            ->addColumn('numero_pedido')
            ->addColumn('cidade')
            ->addColumn('numero_nota')
            ->addColumn('valor_frete')
            ->addColumn('valor_descarga')
            ->addColumn('cliente_id')
            ->addColumn('carga_id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('data solicitacao', 'data_solicitacao')
                ->searchable()
                ->sortable(),

            Column::make('pedido', 'numero_pedido')
                ->sortable(),

            Column::make('cidade', 'cidade')
                ->sortable(),

            Column::make('numero_nota', 'numero_nota')
                ->sortable(),

            Column::make('valor_frete', 'valor_frete')
                ->sortable(),

            Column::make('valor_descarga', 'valor_descarga')
                ->sortable(),
            Column::make('cliente_id', 'cliente_id')
                ->sortable(),

            Column::make('carga_id', 'carga_id')
                ->sortable(),

            Column::action('Action')
        ];
    }
}
