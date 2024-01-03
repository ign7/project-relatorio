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

class FormCarga extends Component
{

    public $numero_carga, $carga, $mode, $showAlert = false, $result = array(), $cargas = [], $selectcarga, $show;



    public function rules()
    {
        $rule = [
            'selectcarga' => 'required',
        ];

        return $rule;
    }
    public function save()
    {

        // Verifica se já existe uma carga com o mesmo número
        $cargaExistente = Carga::where('numero_carga', $this->numero_carga)->first();

        if (!$cargaExistente) {
            $this->carga = Carga::create([
                'numero_carga' => $this->numero_carga,
                'user_id' => auth()->id(),
            ]);

            $this->show();
            $this->showAlert = true;
            session()->flash('sucesso', 'Número de carga cadastrado!');
            return redirect()->route('pedidos');
        } else {
            $this->showAlert = true;
            session()->flash('erro', 'Já existe uma carga com este número.');
        }
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

    
   public $vt=[1,2,3,4];
   public $vt2=[1,2,3];

    public function mount()
    {
        $this->cargas = Carga::all();
        //$this->logica(20,50);
        $this->logica1(20,50);
        $this->logica2($this->vt,$this->vt2);
    }

    public function logica( int $v1,int $v2)
    {
        dump($v1 + $v2 > 20 ? 'resultado se maior que 20 => '. $v1+$v2+8 : 'resultado se menor que 20 => '.$v1+$v2-5); 
    }

    public function logica1( int $v1)
    {
    
        dump($v1%2==0 && $v1%5==0 && $v1%10==0 ?  $v1.' E divisivivel por 10 5 e 2 ao memso tempo' : 'Nao e divisivel por nenhum destes');
    }

    public function logica2($v1,$v2)
    {
    $return=array();
    $return=array_diff($v1,$v2);
     dump($return);
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
