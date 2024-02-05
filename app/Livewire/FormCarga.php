<?php

namespace App\Livewire;

use App\Models\Carga;
use League\Csv\Reader;
use League\Csv\Writer;
use SplTempFileObject;
use App\Models\Cliente;
use Livewire\Component;
use Illuminate\Http\Response;
use Ramsey\Uuid\Type\Integer;
use App\Services\CargaService;
use App\Interface\CargaInterface;
use App\Repository\BaseRepository;
use App\Repository\CargaRepository;
use App\Repository\PedidoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class FormCarga extends Component
{

    use LivewireAlert;
    
    public $numero_carga, $carga, $mode, $showAlert = false, $result = array(), $cargas = [], $selectcarga, $show;

    protected  $service;
    protected  $rep;
    protected  $repositoryPedido;




    public function mount(CargaService $cargaService, CargaRepository $repository, PedidoRepository $repositoryPedido)
    {
        $this->service = $cargaService;
        $this->rep = $repository;
        $this->repositoryPedido = $repositoryPedido;
        $this->cargas = $this->service->all();
    }

    public function hydrate()
    {
        $this->service = app(CargaService::class);
        $this->rep = app(CargaRepository::class);
        $this->repositoryPedido = app(PedidoRepository::class);
    }


    public function query()
    {
        $this->mode = 'carga';
        return $this->result = $this->repositoryPedido->getPedidosByCarga($this->selectcarga);
    }


    public function save()
    {
        if ($this->service->findByColumn('numero_carga', $this->numero_carga)->first() == null) {
            $carga = [
                'numero_carga' => $this->numero_carga,
                'user_id' => auth()->id(),
            ];
            $this->service->register($carga);
            $this->show();
           return $this->alert('success', 'Número de carga cadastrado!');
        }
        return $this->alert('error', 'Já existe uma carga com este número.');
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
