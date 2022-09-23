<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class UserRepositoryEloquent implements UserRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function getList()
    {
        return $this->model;
    }

    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data)
    {
        return $this->model->find($data['id'])->update($data);
    }

    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }
}

?>