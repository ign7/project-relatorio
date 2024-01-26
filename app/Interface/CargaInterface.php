<?php

namespace  App\Interface;

use App\Models\Carga;
use App\Repository\CargaRepository;

interface CargaInterface extends ServiceInterface {

    public function register(array $attributes, CargaRepository $cargaRepository);
    
}

