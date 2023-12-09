<?php

namespace App\Livewire;

use App\Models\Carga;
use App\Models\Pedido;


use App\Models\Cliente;
use Livewire\Component;
use League\Csv\Reader;


use Illuminate\Http\Response;
use League\Csv\Writer;
use SplTempFileObject;

class FormPedido extends Component
{

    public $valor_frete, $num_nota_fiscal, $num_pedido, $cidade, $cliente_id, $nome_cliente, $pedido, $showAlert, $data_solicitacao, $descarga, $carga_id;

    public $cargas, $clientes, $result = array();


    public function mount()
    {
        $this->cargas = Carga::All();
        $this->clientes = Cliente::All();
        $this->query();
    }

    public function rules()
    {
        $rule = [
            'num_pedido' => 'required',
            'cidade' => 'required',
            'num_nota_fiscal' => 'required',
            'valor_frete' => 'required',
            'data_solicitacao' => 'required',
            'cliente_id' => 'required',
            'carga_id' => 'required',
        ];

        return $rule;
    }

    public function save()
    {


        $this->validate();

        $this->pedido = Pedido::create([
            'numero_pedido' => $this->num_pedido,
            'cidade' => $this->cidade,
            'numero_nota' => $this->num_nota_fiscal,
            'valor_frete' => $this->valor_frete,
            'data_solicitacao' => $this->data_solicitacao,
            'cliente_id' => $this->cliente_id,
            'carga_id' => $this->carga_id,
        ]);

        $this->showAlert = true;

        session()->flash('sucesso', 'Pedido  cadastrado !!');
    }


    public function closealert()
    {
        $this->showAlert = false;
    }


    public function query()
    {


        $pedidos = Pedido::all();
        /*  $this->result= Pedido::all(); */

        foreach ($pedidos as $pedido) {
            $num_pedido = $pedido->numero_pedido;
            $cidade = $pedido->cidade;
            $num_nota_fiscal = $pedido->numero_nota;
            $valor_frete = $pedido->valor_frete;
            $data_solicitacao = $pedido->data_solicitacao;

            $cliente_id = $pedido->cliente_id;
            $carga_id = $pedido->carga_id;
            $descarga = $pedido->valor_descarga;

            $selectcarga = Carga::find($carga_id);

            $numero_carga = $selectcarga ? $selectcarga->numero_carga : null;

            $selectcliente = Cliente::find($cliente_id);

            $nome_cliente = $selectcliente ? $selectcliente->nome : null;


            $this->result[] = [
                'numero_pedido' => $num_pedido,
                'cidade' => $cidade,
                'numero_nota' => $num_nota_fiscal,
                'valor_frete' => $valor_frete,
                'valor_descarga' => $descarga,
                'data_solicitacao' => $data_solicitacao,
                'numero_carga' => $numero_carga,
                'nome_cliente' => $nome_cliente,
            ];
        }

        return $this->result;
    }

    public function exportar()
    {
        $header  = [
            'pedido',
            'cidade',
            'notafiscais',
            'valor_frete',
            'valor_descarga',
            'data',
            'numero_carga',
            'nome_cliente',
        ];


        $records = $this->query();


        // Crie um escritor CSV
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        // Insira o cabeçalho
        $csv->insertOne($header);

        // Insira todos os registros
        $csv->insertAll($records);

        // Obtenha o conteúdo do CSV como uma string
        $csvContent = $csv->toString();

        // Especifique o caminho do arquivo CSV
        $csvFilePath = storage_path('app/relatorio.csv'); // ou qualquer caminho desejado

        // Salve o conteúdo do CSV no arquivo
        file_put_contents($csvFilePath, $csvContent);

        // Agora, você pode retornar o caminho do arquivo ou fazer qualquer outra coisa com ele
        return response()->download($csvFilePath)->deleteFileAfterSend(true);
    }



    public function render()
    {
        return view('livewire.form-pedido');
    }
}
