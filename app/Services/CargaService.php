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

    public function register(array $attributes){
      return $this->cargaRepository->save($attributes);
    }

    public function findByColumn(string $column, $value)
    {
        return $this->cargaRepository->findByColumn($column, $value);
    }

    public function all()
    {
        return $this->cargaRepository->all();
    }
}