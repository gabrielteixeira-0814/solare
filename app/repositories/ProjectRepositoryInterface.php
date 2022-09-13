<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface ProjectRepositoryInterface 
{
    public function __construct(Model $model);
    public function connectionApiMonday();
    public function store(array $data);
    public function getListGroup();
    public function get($id);
    public function update(array $data, $id);
    public function delete();
}

?>