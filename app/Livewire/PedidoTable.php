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
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;




final class PedidoTable extends PowerGridComponent
{

    use WithExport;

    public $result = array(), $frete, $mode;

    public function datasource(): array
    {
        if ($this->mode == 'carga') {
            foreach ($this->result as $valor) {
                $this->frete = $valor['valor_total_frete_carga'];
            }
            $this->getTotalFreteCarga();
        }
        return $this->result;
    }

    public function getTotalFreteCarga()
    {
        $this->frete;
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()->showSearchInput(),
            Header::make()
                ->includeViewOnTop('components.datatable.header-top'),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('numero_pedido')
            ->addColumn('numero_nota')
            ->addColumn('data_solicitacao')
            ->addColumn('cidade')
            ->addColumn('valor_frete')
            ->addColumn('valor_descarga')
            ->addColumn('nome_cliente')
            ->addColumn('numero_carga');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('pedido', 'numero_pedido')
                ->sortable(),

            Column::make('numero_nota', 'numero_nota')
                ->sortable(),

            Column::make('carga', 'numero_carga')
                ->sortable(),

            Column::make('Cliente', 'nome_cliente')
                ->sortable(),

            Column::make('data solicitacao', 'data_solicitacao')
                ->searchable()
                ->sortable(),


            Column::make('cidade', 'cidade')
                ->sortable(),

            Column::make('valor_frete', 'valor_frete')
                ->sortable(),

            Column::make('valor_descarga', 'valor_descarga')
                ->sortable(),

            Column::action('Action')
        ];
    }
}
