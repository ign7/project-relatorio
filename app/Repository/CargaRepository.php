<?php

namespace  App\Repository;

use App\Interface\CargaInterface;
use App\Models\Carga;

class CargaRepository extends BaseRepository  /* implements CargaInterface */ {

    protected $carga;

    public function __construct(Carga $carga)
    {
        parent::__construct($carga);
    }


}