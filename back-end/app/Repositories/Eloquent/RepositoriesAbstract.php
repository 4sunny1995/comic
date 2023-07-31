<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

abstract class RepositoriesAbstract implements BaseInterface
{
    /**
     * @var Eloquent | Model
     */
    protected $model;

    /**
     * @var Eloquent | Model
     */
    protected $originalModel;

    /**
     * RepositoriesAbstract constructor.
     *
     * @param Eloquent|Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * {@inheritdoc}
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTable()
    {
        return $this->model->getTable();
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id, array $with = [])
    {
        $data = $this->make($with)->where('id', $id);
        $data = $data->first();

        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function make(array $with = [])
    {
        if (!empty($with)) {
            $this->model = $this->model->with($with);
        }

        return $this->model;
    }

    /**
     * {@inheritdoc}
     */
    public function resetModel()
    {
        $this->model = new $this->originalModel();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function findOrFail($id, array $with = [], array $select = [])
    {
        $data = $this->make($with)->where('id', $id);
        if ($select) {
            $data = $data->select($select);
        }
        $result = $data->first();
        $this->resetModel();

        if (!empty($result)) {
            return $result;
        }

        throw (new ModelNotFoundException())->setModel(
            \get_class($this->originalModel),
            $id
        );
    }

    /**
     * {@inheritdoc}
     */
    public function all(array $with = [])
    {
        $data = $this->make($with);

        return $data->get();
    }

    /**
     * {@inheritdoc}
     */
    public function pluck($column, $key = null)
    {
        $select = [$column];
        if (!empty($key)) {
            $select = [$column, $key];
        }

        $data = $this->model->select($select);

        return $data->pluck($column, $key)->all();
    }

    /**
     * {@inheritdoc}
     */
    public function allBy(array $condition, array $with = [], array $select = ['*'])
    {
        if (!empty($condition)) {
            $this->applyConditions($condition);
        }

        $data = $this->make($with)->select($select);
        $this->resetModel();

        return $data->get();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $data = $this->model->create($data);

        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function createOrUpdate($data, $condition = [])
    {
        // @var Model $item
        if (\is_array($data)) {
            if (empty($condition)) {
                $item = new $this->model();
            } else {
                $item = $this->getFirstBy($condition);
            }
            if (empty($item)) {
                $item = new $this->model();
            }

            $item = $item->fill($data);
        } elseif ($data instanceof Model) {
            $item = $data;
        } else {
            return false;
        }

        if ($item->save()) {
            $this->resetModel();

            return $item;
        }

        $this->resetModel();

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstBy(array $condition = [], array $select = ['*'], array $with = [])
    {
        $this->make($with);

        $this->applyConditions($condition);
        if (!empty($select)) {
            $data = $this->model->select($select);
        } else {
            $data = $this->model;
        }
        $this->resetModel();

        return $data->first();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrCreate(array $data, array $with = [])
    {
        $data = $this->model->firstOrCreate($data, $with);

        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $condition, array $data)
    {
        $data = $this->model->where($condition)->update($data);

        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function select(array $select = ['*'], array $condition = [])
    {
        return $this->model->where($condition)->select($select);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteBy(array $condition = [])
    {
        $this->applyConditions($condition);

        $data = $this->model->get();

        if (empty($data)) {
            return false;
        }
        foreach ($data as $item) {
            $item->delete();
        }

        $this->resetModel();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function count(array $condition = [])
    {
        $this->applyConditions($condition);
        $data = $this->model->count();

        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getByWhereIn($column, array $value = [], array $args = [])
    {
        $data = $this->model->whereIn($column, $value);

        if (!empty(Arr::get($args, 'where'))) {
            $this->applyConditions($args['where']);
        }

        if (!empty(Arr::get($args, 'paginate'))) {
            return $data->paginate($args['paginate']);
        }
        if (!empty(Arr::get($args, 'limit'))) {
            return $data->limit($args['limit']);
        }

        return $data->get();
    }

    /**
     * {@inheritdoc}
     */
    public function advancedGet(array $params = [])
    {
        $params = array_merge([
            'condition' => [],
            'order_by' => [],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1,
            ],
            'select' => ['*'],
            'with' => [],
        ], $params);

        $this->applyConditions($params['condition']);

        $data = $this->model;

        if ($params['select']) {
            $data = $data->select($params['select']);
        }

        foreach ($params['order_by'] as $column => $direction) {
            if (null !== $direction) {
                $data = $data->orderBy($column, $direction);
            }
        }

        foreach ($params['with'] as $with) {
            $data = $data->with($with);
        }

        if (1 === $params['take']) {
            $result = $data->first();
        } elseif ($params['take']) {
            $result = $data->take($params['take'])->get();
        } elseif ($params['paginate']['per_page']) {
            $paginate_type = 'paginate';
            if (Arr::get($params, 'paginate.type') && method_exists($data, Arr::get($params, 'paginate.type'))) {
                $paginate_type = Arr::get($params, 'paginate.type');
            }
            $result = $data
                ->{$paginate_type}(
                    Arr::get($params, 'paginate.per_page', 10),
                    [$this->originalModel->getTable().'.'.$this->originalModel->getKeyName()],
                    'page',
                    Arr::get($params, 'paginate.current_paged', 1)
                );
        } else {
            $result = $data->get();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function forceDelete(array $condition = [])
    {
        $item = $this->model->where($condition)->withTrashed()->first();
        if (!empty($item)) {
            $item->forceDelete();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function restoreBy(array $condition = [])
    {
        $item = $this->model->where($condition)->withTrashed()->first();
        if (!empty($item)) {
            $item->restore();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstByWithTrash(array $condition = [], array $select = [])
    {
        $query = $this->model->where($condition)->withTrashed();

        if (!empty($select)) {
            return $query->select($select)->first();
        }

        return $query->first();
    }

    /**
     * {@inheritdoc}
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrNew(array $condition)
    {
        $this->applyConditions($condition);

        $result = $this->model->first() ?: new $this->originalModel();

        $this->resetModel();

        return $result;
    }

    /**
     * @param null|Builder|Eloquent $model
     */
    protected function applyConditions(array $where, &$model = null)
    {
        if (!$model) {
            $newModel = $this->model;
        } else {
            $newModel = $model;
        }

        foreach ($where as $field => $value) {
            if (\is_array($value)) {
                [$field, $condition, $val] = $value;
                switch (strtoupper($condition)) {
                    case 'IN':
                        $newModel = $newModel->whereIn($field, $val);

                        break;
                    case 'NOT_IN':
                        $newModel = $newModel->whereNotIn($field, $val);

                        break;
                    case 'NULL':
                        $newModel = $newModel->whereNull($field);

                        break;
                    case 'NOT_NULL':
                        $newModel = $newModel->whereNotNull($field);

                        break;
                    default:
                        $newModel = $newModel->where($field, $condition, $val);

                        break;
                }
            } else {
                $newModel = $newModel->where($field, '=', $value);
            }
        }
        if (!$model) {
            $this->model = $newModel;
        } else {
            $model = $newModel;
        }
    }

    /**
     * Load relations
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations) : BaseInterface
    {
        $this->model = $this->model->with($relations);

        return $this;
    }
}
