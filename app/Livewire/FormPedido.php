<?php

namespace App\Livewire;

use App\Models\Carga;
use App\Models\Cidade;


use App\Models\Pedido;
use League\Csv\Reader;
use League\Csv\Writer;


use SplTempFileObject;
use App\Models\Cliente;
use Livewire\Component;
use Illuminate\Http\Response;
use App\Repository\PedidoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FormPedido extends Component
{

    use LivewireAlert;
    public $valor_frete, $mode, $num_nota_fiscal, $num_pedido, $cidade, $cliente_id, $nome_cliente, $pedido, $showAlert, $data_solicitacao, $descarga, $carga_id, $cidade_id;

    public $cargas, $cidades, $clientes, $result = array(), $show;


    protected PedidoRepository $repository;


    public function mount(PedidoRepository $repository)
    {
        $this->cargas = Carga::All();
        $this->cidades = Cidade::All();
        $this->clientes = Cliente::All();
        $this->repository = $repository;

        $this->showtable();
    }


    public function hydrate()
    {
        $this->repository = app(PedidoRepository::class);
    }


    public function rules()
    {
        $rule = [
            'num_pedido' => 'required',
            'num_nota_fiscal' => 'required',
            'valor_frete' => 'required',
            'data_solicitacao' => 'required',
            'cliente_id' => 'required',
            'carga_id' => 'required',
            'cidade_id' => 'required'
        ];

        return $rule;
    }

    public function showtable()
    {
        $this->show = true;
        $this->query();
    }

    public function save()
    {

        $this->validate();
        $pedidoExistente = Pedido::where('numero_pedido', $this->num_pedido)->first();

        if (!$pedidoExistente) {
            $this->pedido = Pedido::create([
                'numero_pedido' => $this->num_pedido,
                'numero_nota' => $this->num_nota_fiscal,
                'valor_frete' => $this->valor_frete,
                'data_solicitacao' => $this->data_solicitacao = date('d/m/Y', strtotime($this->data_solicitacao)),
                'valor_descarga' => $this->descarga,
                'cliente_id' => $this->cliente_id,
                'carga_id' => $this->carga_id,
                'cidade_id' => $this->cidade_id,
            ]);
            $this->alert('success', 'Pedido  cadastrado !!');
            return redirect()->route('pedidos');
        }
        return $this->alert('error', 'numero de Pedido  ja existente !!');
    }


    public function closealert()
    {
        $this->showAlert = false;
    }


    public function query()
    {
        $this->mode = 'pedido';
        return $this->result = $this->repository->getPedidosQuery();
    }

    public function exportar()
    {
        $header  = [
            'numero_pedido',
            'cidade',
            'numero_nota',
            'valor_frete',
            'valor_descarga',
            'data_solicitacao',
            'numero_carga',
            'nome_cliente',
        ];


        $records = $this->query();



        $csv = Writer::createFromFileObject(new SplTempFileObject());


        $csv->insertOne($header);


        $csv->insertAll($records);


        $csvContent = $csv->toString();


        $csvFilePath = storage_path('app/relatorio.csv');


        file_put_contents($csvFilePath, $csvContent);


        return response()->download($csvFilePath)->deleteFileAfterSend(true);
    }



    public function render()
    {
        return view('livewire.form-pedido');
    }
}
