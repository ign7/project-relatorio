<?php

namespace  App\Services;

use App\Models\Veiculo;
use App\Interface\VeiculoInterface;
use App\Repository\VeiculoRepository;

class VeiculoService implements VeiculoInterface{
 

    protected VeiculoRepository $veiculoRepository; 

    public function __construct(VeiculoRepository $veiculoRepository)
    {
        $this->veiculoRepository = $veiculoRepository;
    }

    public function register(array $attributes){
      return $this->veiculoRepository->save($attributes);
    }

    public function findByColumn(string $column, $value)
    {
        return $this->veiculoRepository->findByColumn($column, $value);
    }

    public function all()
    {
        return $this->veiculoRepository->all();
    }
}