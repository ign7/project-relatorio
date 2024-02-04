<?php

namespace App\Livewire;

use App\Models\Carga;
use League\Csv\Reader;
use League\Csv\Writer;
use SplTempFileObject;
use App\Models\Cliente;
use Livewire\Component;
use App\Repository\PedidoRepository;

class FormCliente extends Component
{

    public $nome,$id_cliente,$cliente,$mode,$showAlert,$result=array(),$clientes=[],$selectcliente,$show;
    

    protected PedidoRepository $pedido_repository;

    public function mount(PedidoRepository $pedido_repository){
        $this->clientes = Cliente::all();
        $this->pedido_repository=$pedido_repository;
    }

    public function hydrate()
    { 
        $this->pedido_repository=app(PedidoRepository::class);
    }

    public function rules(){
        $rule=[
            'selectcliente'=>'required',
        ];

        return $rule;
    }
    public function save(){
        
        $clienteExistente = Cliente::where('nome', $this->nome)->first();

        if(!$clienteExistente){
            $this->cliente=Cliente::create([
                'nome'=> $this->nome,
              ]);
              $this->showAlert = true;
              session()->flash('sucesso', 'Cliente cadastrado !!');
              return redirect()->route('clientes');
        }else{
            $this->showAlert = true;
              session()->flash('erro', 'Cliente ja existente!!');
        }
    }

    public function delete()
    {
        $clienteachada = Cliente::find($this->selectcliente);
        $pedidoscliente=$clienteachada->pedidos()->get();
        foreach($pedidoscliente as $pedidos){
            $pedidos->delete();
        }
        $clienteachada->delete();
        return redirect()->route('clientes');
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
        $this->validate();     
         $this->showtable();        
    }
    

    public function limpar(){       
        $this->show=false;   
        $this->result=[];     
}




public function query()
{
    $this->mode='cliente';
    return $this->result=$this->pedido_repository->getPedidosByCliente($this->selectcliente);
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
