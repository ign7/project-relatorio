<?php

namespace  App\Repository;

use App\Interface\CustoInterface;
use App\Models\Custo;

class CustoRepository extends BaseRepository  /* implements CargaInterface */ {

    protected $custo;

    public function __construct(Custo $custo)
    {
        parent::__construct($custo);
    }


}