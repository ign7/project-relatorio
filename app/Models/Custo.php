<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custo extends Model
{
    use HasFactory;

    protected $table = 'custos';

    protected $fillable = [
        'id',
        'titulo',
        'descricao',
        'litros',
        'valor_litro',
        'combustivel',
        'kimometros',
        'pedagio',
        'despesas',
        'descarga',
        'manutencao',
        'data_manutencao',
        'carga_id',
        'veiculo_id'
    ];
}
