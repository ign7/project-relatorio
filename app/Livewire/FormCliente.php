<?php

namespace App\Livewire;

use App\Models\Carga;
use League\Csv\Reader;
use League\Csv\Writer;
use SplTempFileObject;
use App\Models\Cliente;
use Livewire\Component;

class FormCliente extends Component
{

    public $nome,$id_cliente,$cliente,$mode,$showAlert,$result=array(),$clientes=[],$selectcliente,$show;
    



    public function rules(){
        $rule=[
            'nome'=>'required',
        ];

        return $rule;
    }
    public function save(){
        
        $this->validate();

        $this->cliente=Cliente::create([
          'nome'=> $this->nome,
        ]);
        $this->showAlert = true;
        session()->flash('sucesso', 'Cliente cadastrado !!');
    }


    public function closealert()
    {
        $this->showAlert = false;
    }


    public function showtable(){
        $this->show=true;
        $this->query();
    }

    public function pesquisar(){       
            $this->showtable();        
    }
    

    public function limpar(){       
        $this->show=false;   
        $this->result=[];     
}


public function mount(){
    $this->clientes = Cliente::all();
}

public function query()
{
    $clienteselecionado =Cliente::find($this->selectcliente);

    $this->mode='cliente';

    $pedidos=$clienteselecionado->pedidos;
    
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
        $this->id_cliente=$selectcliente->id;

        $this->result[] = [
            'id'=>$pedido->id,
            'id_cliente'=>$this->id_cliente,
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
        'id',
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
        return view('livewire.form-cliente');
    }
}
