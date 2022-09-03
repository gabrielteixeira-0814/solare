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
        /** Conexão com api monday**/
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3ODk0MjkyMywidWlkIjozMzY4NDY4MywiaWFkIjoiMjAyMi0wOS0wMlQyMTo0MTo1My4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMyMzU3ODQsInJnbiI6InVzZTEifQ.sQSfb09nAo5DmaWjaS2VMTgZrRcpEDZkxGcfMFtAo0U';


        $apiUrl = 'https://api.monday.com/v2';
        $headers = ['Content-Type: application/json', 'Authorization: ' . $token];

        $query = ' { mutation($itemName: String! ) { create_item (board_id: , item_name:$itemName){id} }';
        $vars = [
            'itemName' => 'Hello, world!'
        ];

        $data = @file_get_contents($apiUrl, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $headers,
                'content' => json_encode(['query' => $query, 'variables' => $vars]),
            ]
        ]));
        
        $group = json_decode($data, true);


        return $vars;

        return $this->model->create($data);
    }

    public function getListGroup()
    {
       /** Conexão com api monday**/
       $token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3ODk0MjkyMywidWlkIjozMzY4NDY4MywiaWFkIjoiMjAyMi0wOS0wMlQyMTo0MTo1My4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMyMzU3ODQsInJnbiI6InVzZTEifQ.sQSfb09nAo5DmaWjaS2VMTgZrRcpEDZkxGcfMFtAo0U';


       $apiUrl = 'https://api.monday.com/v2';
       $headers = ['Content-Type: application/json', 'Authorization: ' . $token];

       $query = ' { boards (limit:1) {groups {title id} } }';

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
            $list[] = $data['id'];
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

    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }

    public function create_group($board_id, $group_name)
    {

        return $board_id;
        /** Conexão com api monday**/
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3ODk0MjkyMywidWlkIjozMzY4NDY4MywiaWFkIjoiMjAyMi0wOS0wMlQyMTo0MTo1My4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMyMzU3ODQsInJnbiI6InVzZTEifQ.sQSfb09nAo5DmaWjaS2VMTgZrRcpEDZkxGcfMFtAo0U';

        $apiUrl = 'https://api.monday.com/v2';
        $headers = ['Content-Type: application/json', 'Authorization: ' . $token];

        $query = ' { mutation($boardId: Int!, $groupName: String! ) { create_group (board_id: $boardId, group_name: $groupName){id} }';
        $vars = [
            'boardId' => $board_id,
            'groupName' => $group_name
        ];

        $data = @file_get_contents($apiUrl, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $headers,
                'content' => json_encode(['query' => $query, 'variables' => $vars]),
            ]
        ]));
        
        $groups = json_decode($data, true);

        return $groups;
    }
}

?>