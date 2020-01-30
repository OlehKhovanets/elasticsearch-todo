<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface
{
    public function findById(int $id);

    public function all(): Collection;

    public function create(array $data);

    public function updateOrCreate(array $attributes, array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function findWhere(array $where, $columns = ['*']);

    public function first();

    public function get();

    public function sync($id, $relation, $attributes, $detaching = true);

    public function find($id, $columns = ['*']);

    public function insert($data);
}
