<?php 

namespace App\Services;
use App\Repositories\ProjectRepositoryInterface;
use Validator;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    private $repo;

    public function __construct(ProjectRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store($jsonData)
    {
        $board_id = 3151173296;
        // Teste
        $quadroExiste = true; 

        $tokenSystem = "ACUarqUqpZbP6307f0d8910c2";
        $token = $jsonData['token']; 

        $groups = $this->repo->getListGroup();

        /** Conexão com api monday**/
        $tokenMonday = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3ODk0MjkyMywidWlkIjozMzY4NDY4MywiaWFkIjoiMjAyMi0wOS0wMlQyMTo0MTo1My4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMyMzU3ODQsInJnbiI6InVzZTEifQ.sQSfb09nAo5DmaWjaS2VMTgZrRcpEDZkxGcfMFtAo0U';


        $apiUrl = 'https://api.monday.com/v2';
        $headers = ['Content-Type: application/json', 'Authorization: ' . $tokenMonday];

       
        // Token validation
        if($token == $tokenSystem) {

            // Verifica se o grupo já existe no monday
            // Se já existir ele apenas adicionar o item no group
            if(in_array($jsonData['nomesFunisProjeto'], $groups)){

                $query = 'mutation($borderId: Int!, $groupId: String!, $itemName: String!) { create_item (board_id:$borderId, group_id:$groupId, item_name:$itemName){id}}';

                $vars = [
                    'borderId' => $board_id,
                    'groupId' => $jsonData['nomesFunisProjeto'],
                    'itemName' => 'Teste'
                ];
        
                $data = @file_get_contents($apiUrl, false, stream_context_create([
                   'http' => [
                       'method' => 'POST',
                       'header' => $headers,
                       'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                   ]
                ]));
                
                $json = json_decode($data, true);

                return 'Mondayaaa';

            }else {

                // Ele cria o group junto com o item para quando não existir

                $this->repo->create_group($board_id,$jsonData['nomesFunisProjeto']);

                sleep(2);

                $query = 'mutation($borderId: Int!, $groupId: String!, $itemName: String!) { create_item (board_id:$borderId, group_id:$groupId, item_name:$itemName){id}}';

                $vars = [
                    'borderId' => $board_id,
                    'groupId' => $jsonData['nomesFunisProjeto'],
                    'itemName' => 'Teste pedro'
                ];
        
                $data = @file_get_contents($apiUrl, false, stream_context_create([
                   'http' => [
                       'method' => 'POST',
                       'header' => $headers,
                       'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                   ]
                ]));
                
                $json = json_decode($data, true);

                return 'Criou nessa parada';
            }

        }else {
            return 'Token invalido!';
        }
        
        return $this->repo->store($data);
    }

    public function getListGroup()
    {
        return $this->repo->getListGroup();
    }

    public function update($request, $id)
    {
        //$findEmail = $this->repo->get($id); // encontrar dados do usuário
        //return $this->repo->update($data, $id);
    }

    public function destroy($id)
    {
        // Teste
        $quadroExiste = true;

        $tokenSystem = "ACUarqUqpZbP6307f0d8910c2";
        
        $token = $jsonData['token']; 

        // Token validation
        if($token == $tokenSystem) {

            // Verifica se o grupo já existe no monday
            // Se já existir ele apenas adicionar o item no group
            if(in_array($jsonData['nomesFunisProjeto'], $group)){

                return 'Mondayaaa';

            }else {

                // Ele cria o group junto com o item para quando não existir
                return 'Funnil';
            }

        }else {
            return 'Token invalido!';
        }

        return $this->repo->destroy($id);
    }

    //! TESTE
    //^ TESTE
    //? TESTE
    //* TESTE
    //// TESTE
    //& TESTE
}

?>