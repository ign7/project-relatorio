<?php

namespace  App\Repository;
use App\Models\Carga;

class CargaRepository extends BaseRepository {

    protected $carga;

    public function __construct(Carga $carga)
    {
        parent::__construct($carga);
    }


}