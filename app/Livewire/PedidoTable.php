<?php

namespace App\Livewire;

use App\Models\Pedido;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use OpenSpout\Writer\CSV\Options;





final class PedidoTable extends PowerGridComponent
{

    use WithExport;

    public $result = array(), $frete, $mode, $idcarga, $id_cliente;

    protected $listeners = ['opentable', 'datasource'];


    public function datasource(): ?Collection
    {
        if ($this->mode == 'carga') {
            foreach ($this->result as $valor) {
                $this->frete = $valor['valor_total_frete_carga'];
                $this->idcarga = $valor['id_carga'];
            }
            $this->getTotalFreteCarga();

            return Pedido::select(
                'pedidos.id',
                'pedidos.numero_pedido',
                'pedidos.status',
                'pedidos.numero_nota',
                'pedidos.valor_frete',
                'pedidos.valor_descarga',
                'pedidos.data_solicitacao',
                'pedidos.data_pagamento',
                'cargas.numero_carga',
                'cidades.cidade',
                'clientes.nome'
            )
                ->join('cargas', 'pedidos.carga_id', '=', 'cargas.id')
                ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
                ->join('cidades', 'pedidos.cidade_id', '=', 'cidades.id')
                ->where('pedidos.carga_id', $this->idcarga)
                ->get();
        }

        if ($this->mode == 'cliente') {

            foreach ($this->result as $valor) {
                $this->frete += $valor['valor_frete'];
                $this->id_cliente = $valor['id_cliente'];
            }

            $this->getTotalFreteCarga();

            return Pedido::select(
                'pedidos.id',
                'pedidos.numero_pedido',
                'pedidos.status',
                'pedidos.numero_nota',
                'pedidos.valor_frete',
                'pedidos.valor_descarga',
                'pedidos.data_solicitacao',
                'pedidos.data_pagamento',
                'cargas.numero_carga',
                'cidades.cidade',
                'clientes.nome'
            )
                ->join('cargas', 'pedidos.carga_id', '=', 'cargas.id')
                ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
                ->join('cidades', 'pedidos.cidade_id', '=', 'cidades.id')
                ->where('pedidos.cliente_id', $this->id_cliente)
                ->get();
        }


        if ($this->mode == 'pedido') {


            foreach ($this->result as $valor) {
                $this->frete += $valor['valor_frete'];
            }
            $this->getTotalFretepedido();

            return Pedido::select(
                'pedidos.id',
                'pedidos.numero_pedido',
                'pedidos.status',
                'pedidos.numero_nota',
                'pedidos.valor_frete',
                'pedidos.valor_descarga',
                'pedidos.data_solicitacao',
                'pedidos.data_pagamento',
                'cargas.numero_carga',
                'cidades.cidade',
                'clientes.nome'
            )
                ->join('cargas', 'pedidos.carga_id', '=', 'cargas.id')
                ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
                ->join('cidades', 'pedidos.cidade_id', '=', 'cidades.id')
                ->get();
        } else {
            return collect();
        }
    }

    public function getTotalFreteCarga()
    {
        $this->frete;
    }

    public function getTotalFretepedido()
    {
        $this->frete;
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [

            Exportable::make('export')
                ->striped('#A6ACCD')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()->showSearchInput()
                ->includeViewOnTop('components.datatable.header-top')
                ->showToggleColumns(),


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
            ->addColumn('data_pagamento')
            ->addColumn('valor_descarga')
            ->addColumn('nome')
            ->addColumn('numero_carga')
            ->addColumn('status', function (Pedido $model) {
                if ($model->status == 'pendente') {
                    return '<span class=" rounded rounded hover:text-white border-2 px-2 py-1 rounded-2xl inline-block">PENDENTE</span>';
                }
                if ($model->status == 'pago') {
                    return '<p class=" rounded rounded hover:text-white border-2 px-2 py-1 rounded-2xl inline-block">PAGAMENTO EFETIVADO</p>';
                }
                if ($model->status == 'nao_pago') {
                    return '<p class="rounded rounded hover:text-white border-2 px-2 py-1 rounded-2xl inline-block">NÃO EFETIVADO</p>';
                }
            });
    }

    public function columns(): array
    {
        return [

            Column::action('Action')
                ->sortable(),

            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('PEDIDO', 'numero_pedido')
                ->sortable(),

            Column::make('NUMERO NOTA', 'numero_nota')
                ->sortable(),

            Column::make('CARGA', 'numero_carga')
                ->sortable(),

            Column::make('CLIENTE', 'nome')
                ->sortable(),

            Column::make('DATA SOLICITACAO', 'data_solicitacao')
                ->searchable()
                ->sortable(),

            Column::make('DATA PAGAMENTO', 'data_pagamento')
                ->searchable()
                ->sortable(),


            Column::make('CIDADE', 'cidade')
                ->sortable(),

            Column::make('VALOR FRETE', 'valor_frete')
                ->sortable(),

            Column::make('DESCARGA', 'valor_descarga')
                ->sortable(),

            Column::make('STATUS', 'status')
                ->sortable(),
        ];
    }

    public function actions(Pedido $valor)
    {
        return [
            Button::add('fill-os')
                ->slot('Editar')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->openModal('form-pedido-modal', ['id' => $valor->id, 'mode' => 'update_pedido']),

            Button::add('fill-os')
                ->slot('Excluir')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->openModal('form-pedido-modal', ['id' => $valor->id, 'mode' => 'excluir']),

            Button::add('fill-os')
                ->slot('Pagar')
                ->class('bg-green-500 text-white font-bold px-3 rounded')
                ->openModal('form-pedido-modal', ['pedido_id' => $valor->id, 'mode' => 'pagar']),

            Button::add('fill-os')
                ->slot('pendente')
                ->class('bg-orange-500 text-white font-bold px-3 rounded')
                ->openModal('form-pedido-modal', ['pedido_update_id' => $valor->id, 'mode' => 'pendente']),

            Button::add('fill-os')
                ->slot('nao_pago')
                ->class('bg-red-500 text-white font-bold px-3 rounded')
                ->openModal('form-pedido-modal', ['pedido_id' => $valor->id, 'mode' => 'nao_pago']),


        ];
    }

    public function actionRules(): array
    {
        return [

            Rule::button('pendente')
                ->when(fn ($row) => $row->status == 'pago')
                ->hide(),

            Rule::button('pago')
                ->when(fn ($row) => $row->status == 'pendente')
                ->hide(),

            Rule::button('nao_pago')
                ->when(fn ($row) => $row->status == 'pago')
                ->hide(),

            Rule::rows()
                ->when(function ($row) {
                    return $row->status == 'pendente';
                })
                ->setAttribute('class', 'hover:bg-orange-500 hover:text-white'),

            Rule::rows()
                ->when(function ($row) {
                    return $row->status == 'nao_pago';
                })
                ->setAttribute('class', 'hover:bg-red-500'),

            Rule::rows()
                ->when(function ($row) {
                    return $row->status == 'pago';
                })
                ->setAttribute('class', 'hover:bg-blue-500 hover:text-white'),
        ];
    }
}
