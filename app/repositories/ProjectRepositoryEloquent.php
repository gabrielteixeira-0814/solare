<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class ProjectRepositoryEloquent implements ProjectRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function connectionApiMonday()
    {
       // Conexão com api monday
       $tokenMonday = '';

       $headers = ['Content-Type: application/json', 'Authorization: ' . $tokenMonday];

       return $headers;
    }

    public function store(array $data)
    {
       //
    }

    public function getListGroup()
    {
      //
    }

    public function getListColumns()
    {
       //
    }

    public function get($id)
    {
        //
    }

    public function update(array $data, $id)
    {
        //
    }

    public function delete()
    {
        //
    }
}

?>