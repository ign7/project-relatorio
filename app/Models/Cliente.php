<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'pedido_id'
        
    ];

    // Adicione a relação com o modelo Pedido
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}