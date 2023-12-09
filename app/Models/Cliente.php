<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'pedido_id'
    ];

    // Adicione a relação com o modelo Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}