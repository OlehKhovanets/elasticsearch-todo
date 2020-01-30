<?php

namespace App\Repositories;

use App\Contracts\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Model | Builder $model
 */

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model | Builder
     */
    public $model;

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function allActive(): Collection
    {
        return $this->model->where('active', true)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function updateOrCreate(array $attributes, array $data)
    {
        return $this->model->updateOrCreate($attributes, $data);
    }

    public function update(int $id, array $data)
    {
        $item = $this->findById($id);

        return $item->update($data);
    }

    /**
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $item = $this->findById($id);

        return $item->delete();
    }

    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyConditions($where);
        return $this;
    }

    public function applyConditions($where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    public function first()
    {
        return $this->model->first();
    }

    public function get()
    {
        return $this->model->get();
    }

    public function sync($id, $relation, $attributes, $detaching = true)
    {
        return $this->find($id)->{$relation}()->sync($attributes, $detaching);
    }

    public function find($id, $columns = ['*'])
    {
        $model = $this->model->findOrFail($id, $columns);
        return $model;
    }

    public function insert($data)
    {
        return $this->model->insert($data);
    }
}
