<?php

namespace  App\Interface;

use App\Models\Carga;
use App\Repository\CargaRepository;

interface BaseRepositoryInterface extends ServiceInterface {

    public function all();
    
    public function find(int $id);
   
    public function findByColumn(string $column, $value);
    
    public function save(array $attributes);
    
    public function update(int $id, array $attributes);
    
}

