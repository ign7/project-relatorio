<?php

namespace App\Livewire;

use App\Models\Custo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class CustosTable extends PowerGridComponent
{

    protected $listeners = [
        'opentableCustos' => 'datasource'
    ];

    public function datasource(): ?Collection
    {
        DB::statement('SET sql_mode=(SELECT REPLACE(@@sql_mode,"ONLY_FULL_GROUP_BY",""))');
        return Custo::select([
            'custos.id as id_custo',
            'custos.descricao as descricao',
            'custos.titulo as titulo',
            'custos.despesas as despesas',
            'custos.valor_litro as valor_litro',
            'custos.data_manutencao as data_manutencao',
            'custos.litros as litros',
            'custos.combustivel as combustivel',
            'custos.kimometros as kimometros',
            'custos.pedagio as pedagio',

            'veiculos.name as name_veiculo',
            'cargas.numero_carga as numero_carga',
            'cargas.id as id_carga',
        ])
            //->selectRaw('SUM(pedidos.valor_frete) as valor_total_frete_carga')
            ->leftJoin('cargas', function ($table) {
                $table->on('custos.carga_id', '=', 'cargas.id');
            })->join('veiculos', function ($table) {
                $table->on('custos.veiculo_id', '=', 'veiculos.id');
            })
            ->groupBy('custos.id')
            ->get();
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
            ->add('litros')
            ->add('combustivel')
            ->add('pedagio')
            ->add('despesas')
            ->add('descarga')
            ->add('manutencao')
            ->add('name_veiculo')
            ->add('numero_carga')
            ->add('data_manutencao', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [

            Column::action('Action')
                ->sortable(),

            Column::make('ID', 'id_custo')
                ->searchable()
                ->sortable(),

            Column::make('titulo', 'titulo')
                ->searchable()
                ->sortable(),

            Column::make('descricao', 'descricao')
                ->searchable()
                ->sortable(),

            Column::make('R$ Litro', 'valor_litro')
            ->searchable()
                ->sortable(),
            Column::make('data_manutencao', 'data_manutencao')
            ->searchable()
                ->sortable(),

            Column::make('litros', 'litros')
            ->searchable()
                ->sortable(),
            Column::make('combustivel', 'combustivel')
            ->searchable()
                ->sortable(),
            Column::make('pedagio', 'pedagio')
            ->searchable()
                ->sortable(),
            Column::make('despesas', 'despesas')
            ->searchable()
                ->sortable(),
            Column::make('veiculo', 'name_veiculo')
            ->searchable()
                ->sortable(),
            Column::make('carga', 'numero_carga')
            ->searchable()
                ->sortable(),
        ];
    }


    public function actions(Custo $valor)
    {
        return [
            Button::add('fill-os')
                ->slot('Editar')
                ->class('bg-orange-500 text-white font-bold px-3 rounded'),
                //->openModal('form-veiculo-modal', ['id' => $valor->id, 'mode' => 'update_veiculo']),

            Button::add('fill-os')
                ->slot('Excluir')
                ->class('bg-red-500 text-white font-bold px-3 rounded'),
                //->openModal('form-veiculo-modal', ['id' => $valor->id, 'mode' => 'excluir']),

            Button::add('fill-os')
                ->slot('vizualizar')
                ->class('bg-blue-500 text-white font-bold px-3 rounded'),
                //->openModal('form-veiculo-modal', ['veiculo_id' => $valor->id, 'mode' => 'vizualizar']),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('data_manutencao'),

            /* Filter::select('status', 'status')
                ->dataSource(Custo::select('status')->distinct()->get())
                ->optionValue('status')
                ->optionLabel('status'), */


        ];
    }

    /*  public function actionRules(): array
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
                    return $row->status == 'pago';
                })
                ->setAttribute('class', 'bg-gray-200'), 

            Rule::rows()
                ->when(function ($row) {
                    return $row->status == 'pendente';
                })
                ->setAttribute('class', 'hover:bg-blue-500 hover:text-white'),

            Rule::rows()
                ->when(function ($row) {
                    return $row->status == 'nao_pago';
                })
                ->setAttribute('class', 'hover:bg-red-500'),

             
        ];
    } */
}
