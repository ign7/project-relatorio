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




final class PedidoTable extends PowerGridComponent
{

    use WithExport;

    public $result = array(), $frete, $mode, $idcarga,$id_cliente;

    /* public function datasource(): array
    {
        if ($this->mode == 'carga') {
            foreach ($this->result as $valor) {
                $this->frete = $valor['valor_total_frete_carga'];
            }
            $this->getTotalFreteCarga();
        }
        return $this->result;
    } */


    public function datasource(): ?Collection
    {
        if ($this->mode == 'carga') {
            foreach ($this->result as $valor) {
                $this->frete = $valor['valor_total_frete_carga'];
                $this->idcarga=$valor['id_carga'];
            }
            $this->getTotalFreteCarga();

            return Pedido::select(
                'pedidos.id',
                'pedidos.numero_pedido',
                'pedidos.cidade',
                'pedidos.numero_nota',
                'pedidos.valor_frete',
                'pedidos.valor_descarga',
                'pedidos.data_solicitacao',
                'cargas.numero_carga',  // Adicione o campo desejado da tabela "carga"
                'clientes.nome' // Adicione o campo desejado da tabela "cliente"
            )
            ->join('cargas', 'pedidos.carga_id', '=', 'cargas.id') // Join com a tabela "carga"
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id') // Join com a tabela "cliente"
            ->where('pedidos.carga_id', $this->idcarga)
            ->get();
        }

        if ($this->mode == 'cliente') {
            
            foreach ($this->result as $valor) {
                $this->id_cliente = $valor['id_cliente'];
            }
            return Pedido::select(
                'pedidos.id',
                'pedidos.numero_pedido',
                'pedidos.cidade',
                'pedidos.numero_nota',
                'pedidos.valor_frete',
                'pedidos.valor_descarga',
                'pedidos.data_solicitacao',
                'cargas.numero_carga',  // Adicione o campo desejado da tabela "carga"
                'clientes.nome' // Adicione o campo desejado da tabela "cliente"
            )
            ->join('cargas', 'pedidos.carga_id', '=', 'cargas.id') // Join com a tabela "carga"
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id') // Join com a tabela "cliente"
            ->where('pedidos.cliente_id', $this->id_cliente)
            ->get();
        }


        if ($this->mode == 'pedido') {  

            return Pedido::select(
                'pedidos.id',
                'pedidos.numero_pedido',
                'pedidos.cidade',
                'pedidos.numero_nota',
                'pedidos.valor_frete',
                'pedidos.valor_descarga',
                'pedidos.data_solicitacao',
                'cargas.numero_carga',  // Adicione o campo desejado da tabela "carga"
                'clientes.nome' // Adicione o campo desejado da tabela "cliente"
            )
            ->join('cargas', 'pedidos.carga_id', '=', 'cargas.id') // Join com a tabela "carga"
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id') // Join com a tabela "cliente"
            ->get();
        }
        else{
            return collect();
        }
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
            ->addColumn('nome')
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

            Column::make('Cliente', 'nome')
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

    protected $listners = ['excluir', 'excluir'];

    public function excluir($id)
    {
        dump($id);
    }


    public function actions(Pedido $valor)
    {
        return [
            Button::add('fill-os')
                ->slot('Editar')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->openModal('form-pedido-modal', ['id' => $valor->id]),

            Button::add('fill-os')
                ->slot('Excluir')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('excluir', ['id' => $valor->id]),
        ];
    }
}
