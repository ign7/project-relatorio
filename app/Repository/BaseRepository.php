<?php

namespace  App\Repository;

use App\Interface\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $obj;

    protected function __construct(object $obj)
    {
        $this->obj = $obj;
    }

    public function all(): object
    {
        return $this->obj->all();
    }

    public function find(int $id): object
    {
        return $this->obj->find($id);
    }

    public function findByColumn(string $column, $value): object
    {
        return $this->obj->where($column, $value)->get();
    }

    public function save(array $attributes): bool
    {
        return $this->obj->insert($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->obj->find($id)->update($attributes);
    }
}

