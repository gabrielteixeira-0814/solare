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
       $tokenMonday = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';
       $headers = ['Content-Type: application/json', 'Authorization: ' . $tokenMonday];

       return $headers;
    }

    public function getList()
    {
        return $this->model;
    }

    public function store(array $data)
    {
        return $this->model->create($data);
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
        return $this->model->findOrFail($id);
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