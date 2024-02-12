<?php

namespace  App\Repository;

use App\Interface\VeiculoInterface;
use App\Models\Veiculo;

class VeiculoRepository extends BaseRepository  /* implements VeiculoInterface */ {

    protected $veiculo;

    public function __construct(Veiculo $veiculo)
    {
        parent::__construct($veiculo);
    }


}