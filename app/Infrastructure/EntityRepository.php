<?php
namespace App\Infrastructure;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class EntityRepository
{
    /**
     * Main repo Entity.
     *
     * @var string
     */
    protected $entity;

    /**
     * Creates new model instance.
     *
     * @param  array $with Allows to eager load relations
     * @return mixed
     * @throws \Exception
     */
    public function make($with = [])
    {
        if ($this->entity) {
            $entity = app()->make($this->entity);
            if (!empty($with)) {
                $entity->with($with);
            }

            return $entity;
        } else {
            throw new Exception('No entity set.');
        }
    }

    /**
     * Finds model by id.
     *
     * @param  int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->make()->find($id);
    }

    /**
     * Finds model by token.
     *
     * @param  string $token
     * @return mixed
     */
    public function findByToken($token)
    {
        return $this->make()->where('token', $token)->first();
    }

    /**
     * Find model by id or throw an exception.
     *
     * @param  int $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $model = $this->make()->find($id);
        if (!$model) {
            throw new NotFoundHttpException('Resource not found.');
        }
        return $model;
    }

    /**
     * Fetch all rows from DB for current model
     *
     * @param  array $with Allows to eager load relations
     * @return mixed
     */
    public function all($with = [])
    {
        return $this->make($with)->get();
    }

    /**
     * Sets new entity for repository.
     *
     * @param string $entity
     * @return void
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Returns repository entity.
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Return empty model - new one or existing.
     *
     * @param $id
     * @return Model
     * @throws \Exception
     */
    public function getOrCreate($id): Model
    {
        if ($id != null) {
            return $this->findOrFail($id);
        }

        return $this->make()->newInstance();
    }

    /**
     * Create new model or update existing.
     *
     * @param mixed $id
     * @param array $data
     * @return Model
     */
    public function createOrUpdate($id = null, array $data = []): Model
    {
        $model = null;

        if ($id != null) {
            $model = $this->find($id);
        }

        if (!$model) {
            $model = $this->make();
        }

        $model->fill($data);
        $model->save();

        return $model;
    }

    public function getSelectArray(): array
    {
        return $this->make()->orderBy('name')->pluck('name', 'id')->toArray();
    }
}
