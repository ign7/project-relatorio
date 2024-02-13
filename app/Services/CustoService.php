<?php

namespace  App\Services;

use App\Models\Custo;
use App\Interface\CustoInterface;
use App\Repository\CustoRepository;

class CustoService implements CustoInterface{
 

    protected CustoRepository $custoRepository; 

    public function __construct(CustoRepository $custoRepository)
    {
        $this->custoRepository = $custoRepository;
    }

    public function register(array $attributes){
      return $this->custoRepository->save($attributes);
    }

    public function findByColumn(string $column, $value)
    {
        return $this->custoRepository->findByColumn($column, $value);
    }

    public function all()
    {
        return $this->custoRepository->all();
    }
}