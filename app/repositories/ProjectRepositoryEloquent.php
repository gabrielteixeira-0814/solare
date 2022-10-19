<?php 

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setting;

class ProjectRepositoryEloquent implements ProjectRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function connectionApiMonday()
    {

        $data = Setting::all();

        foreach ($data as $item) {
            if($item->type == "boards"){
                $boards = ['id' => $item->id, 'token' => $item->token];
            }

            if($item->type == "monday"){
                $monday = ['id' => $item->id, 'token' => $item->token];
            }

            if($item->type == "company"){
                $company = ['id' => $item->id, 'token' => $item->token];
            }
        }
        $list = ["boards" => $boards, 'monday' => $monday, 'company' => $company];

       // Conexão com api monday
       $tokenMonday = $list['monday']['token'];
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