<?php

namespace App\Livewire;

use App\Interface\CargaInterface;
use App\Models\Carga;
use League\Csv\Reader;
use League\Csv\Writer;
use SplTempFileObject;
use App\Models\Cliente;
use App\Repository\BaseRepository;
use App\Repository\CargaRepository;
use App\Services\CargaService;
use Livewire\Component;
use Illuminate\Http\Response;
use Ramsey\Uuid\Type\Integer;


class FormCarga extends Component
{

    public $numero_carga, $carga, $mode, $showAlert = false, $result = array(), $cargas = [], $selectcarga, $show;

    protected  $service;
    protected  $rep;

    
    

     public function mount(CargaService $cargaService, CargaRepository $repository)
    {
        $this->service = $cargaService;
        $this->rep = $repository;
        $this->cargas = $this->service->all();
    }

    public function hydrate()
    {
        $this->service = app(CargaService::class);
        $this->rep = app(CargaRepository::class);
    } 


    public function save()
    {
        if ($this->service->findByColumn('numero_carga', $this->numero_carga)->first() == null) {
            $carga = [
                'numero_carga' => $this->numero_carga,
                'user_id' => auth()->id(),
            ];
            $this->service->register($carga, $this->rep);
            return $this->succsessAlert();
        }
        $this->FailAlert();
    }


    public function succsessAlert()
    {
        $this->show();
        $this->showAlert = true;
        return session()->flash('sucesso', 'Número de carga cadastrado!');
    }

    public function FailAlert()
    {
        $this->showAlert = true;
        return session()->flash('erro', 'Já existe uma carga com este número.');
    }

    public function rules()
    {
        $rule = [
            'selectcarga' => 'required',
        ];

        return $rule;
    }


    public function delete()
    {
        $cargaachada = Carga::find($this->selectcarga);
        $pedidoscarga = $cargaachada->pedidos()->get();

        foreach ($pedidoscarga as $pedido)
            $pedido->delete();

        $cargaachada->delete();
        return redirect()->route('cargas');
    }

    public function show()
    {
        $this->show = true;
    }


    public function showtable()
    {
        $this->query();
        $this->show = true;
    }

    public function pesquisar()
    {
        $this->validate();
        $this->showtable();
    }


    public function limpar()
    {
        $this->show = false;
        $this->result = [];
    }

    public function closealert()
    {
        $this->showAlert = false;
    }





    public function query()
    {
        $this->mode = 'carga';
        $cargaselecionada = Carga::find($this->selectcarga);

        $pedidos = $cargaselecionada->pedidos;

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

            $totalfrete = $cargaselecionada->valor_total_frete += $pedido->valor_frete;


            $this->result[] = [

                'id' => $pedido->id,
                'id_carga' => $cargaselecionada->id,
                'numero_pedido' => $num_pedido,
                'cidade' => $cidade,
                'numero_nota' => $num_nota_fiscal,
                'valor_frete' => $valor_frete,
                'valor_descarga' => $descarga,
                'data_solicitacao' => date('d/m/Y', strtotime($data_solicitacao)),
                'numero_carga' => $numero_carga,
                'nome_cliente' => $nome_cliente,
                'valor_total_frete_carga' => $totalfrete,
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
        return view('livewire.form-carga');
    }
}
