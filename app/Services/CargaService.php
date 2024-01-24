<?php

namespace  App\Services;

use App\Models\Carga;
use App\Interface\CargaInterface;
use App\Repository\CargaRepository;

class CargaService implements CargaInterface{
 

    protected CargaRepository $cargaRepository; 

    public function __construct(CargaRepository $cargaRepository)
    {
        $this->cargaRepository = $cargaRepository;
    }

    public function register(array $attributes, CargaRepository $cargaRepository){
      return $cargaRepository->save($attributes);
    }

    public function all()
    {
        return $this->cargaRepository->all();
    }
        
}