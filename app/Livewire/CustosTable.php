<?php

namespace App\Livewire;

use App\Models\Custo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        DB::statement('SET sql_mode=(SELECT REPLACE(@@sql_mode,"ONLY_FULL_GROUP_BY",""))');
        return Custo::select([
            'custos.id as id_custo',
            'custos.descricao as descricao',
            'custos.titulo as titulo',
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
            ->add('daata_manutencao', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id_custo')
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

            Column::make('litros', 'litros')
                ->sortable(),
            Column::make('combustivel', 'combustivel')
                ->sortable(),
            Column::make('pedagio', 'pedagio')
                ->sortable(),
            Column::make('despesas', 'despesas')
                ->sortable(),
            Column::make('name_veiculo', 'name_veiculo')
                ->sortable(),
            Column::make('numero_carga', 'numero_carga')
                ->sortable(),

            Column::make('veiculo_id', 'veiculo_id')
                ->sortable(),



            Column::action('Action')
        ];
    }
}
