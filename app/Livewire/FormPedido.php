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

class FormPedido extends Component
{

    public $valor_frete, $mode, $num_nota_fiscal, $num_pedido, $cidade, $cliente_id, $nome_cliente, $pedido, $showAlert, $data_solicitacao, $descarga, $carga_id, $cidade_id;

    public $cargas, $cidades, $clientes, $result = array(), $show;


    public function mount()
    {
        $this->cargas = Carga::All();
        $this->cidades = Cidade::All();
        $this->clientes = Cliente::All();

        $this->showtable();
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

            $this->showAlert = true;
            session()->flash('sucesso', 'Pedido  cadastrado !!');
            return redirect()->route('pedidos');
        } else {
            $this->showAlert = true;
            session()->flash('erro', 'numero de Pedido  ja existente !!');
        }
    }


    public function closealert()
    {
        $this->showAlert = false;
    }


    public function query()
    {
        $pedidos = Pedido::all();
        $this->mode = 'pedido';
        foreach ($pedidos as $pedido) {
            $num_pedido = $pedido->numero_pedido;
            /* $cidade = $pedido->cidade; */
            $num_nota_fiscal = $pedido->numero_nota;
            $valor_frete = $pedido->valor_frete;
            $data_solicitacao = $pedido->data_solicitacao;

            $cliente_id = $pedido->cliente_id;
            $carga_id = $pedido->carga_id;
            $descarga = $pedido->valor_descarga;
            $cidade_id = $pedido->cidade_id;

            $cidadeOBJ = Cidade::find($cidade_id);
            
                $cidade = $cidadeOBJ->cidade;
        
           
            $selectcarga = Carga::find($carga_id);

            $numero_carga = $selectcarga ? $selectcarga->numero_carga : null;

            $selectcliente = Cliente::find($cliente_id);

            $nome_cliente = $selectcliente ? $selectcliente->nome : null;


            $this->result[] = [
                'id' => $pedido->id,
                'numero_pedido' => $num_pedido,
                'cidade' => $cidade,
                'numero_nota' => $num_nota_fiscal,
                'valor_frete' => $valor_frete,
                'valor_descarga' => $descarga,
                'data_solicitacao' => date('d/m/Y', strtotime($data_solicitacao)),
                'numero_carga' => $numero_carga,
                'nome_cliente' => $nome_cliente,
            ];
        }

        return $this->result;
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
