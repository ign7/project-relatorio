<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'numero_pedido',
        'cidade',
        'numero_nota',
        'valor_frete',
        'status',
        'total_valor_frete',
        'valor_descarga',
        'data_pagamento',
        'data_solicitacao',
        'cliente_id',
        'carga_id',
        'cidade_id'
    ];

    public function carga()
    {
        return $this->belongsTo(Carga::class);
    }
    
    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
