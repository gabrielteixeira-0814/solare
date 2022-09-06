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

    public function store(array $data)
    {
       
        
        return $this->model->create($data);
    }

    public function getListGroup()
    {
       /** Conexão com api monday**/
       $token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';


       $apiUrl = 'https://api.monday.com/v2';
       $headers = ['Content-Type: application/json', 'Authorization: ' . $token];

       $query = ' { boards (limit:1, ids: [3189733335]) {groups {title id} } }';

       $data = @file_get_contents($apiUrl, false, stream_context_create([
          'http' => [
              'method' => 'POST',
              'header' => $headers,
              'content' => json_encode(['query' => $query]),
          ]
       ]));
       
       $groups = json_decode($data, true);

       $list = [];
       $groups = $groups['data']['boards'];

       foreach ($groups[0]['groups'] as $data) {

        $group = [
            'id' => $data['id'],
            'name' => $data['title'],
        ];

            $list[] =  $group;
       }

       return $list;
    }

    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete()
    {
        /** Conexão com api monday**/
       $token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';


       $apiUrl = 'https://api.monday.com/v2';
       $headers = ['Content-Type: application/json', 'Authorization: ' . $token];

        $query = 'mutation($itemId: Int!) { delete_item(item_id: $itemId){id}}';

                $vars = [
                    'itemId' => 3189917469
                ];
        
                $data = @file_get_contents($apiUrl, false, stream_context_create([
                   'http' => [
                       'method' => 'POST',
                       'header' => $headers,
                       'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                   ]
                ]));
                
                $json = json_decode($data, true);

                return 'Criando com o grupo existente!';
    }
}

?>