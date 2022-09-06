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
        $board_id = 3189733335;
        $tokenSystem = "ACUarqUqpZbP6307f0d8910c2";
        $token = $jsonData['token']; 

        $groups = $this->repo->getListGroup();
        $listNameGroup = [];
        foreach ($groups as $data) {
            $listNameGroup[] = $data['name'];
        }

        //return $listNameGroup;

        /** Conexão com api monday**/
        $tokenMonday = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';


        $apiUrl = 'https://api.monday.com/v2';
        $headers = ['Content-Type: application/json', 'Authorization: ' . $tokenMonday];

        // Token validation
        if($token == $tokenSystem) {

            // Verifica se o grupo já existe no monday
            // Se já existir ele apenas adicionar o item no group
            if(in_array(ucfirst($jsonData['nomesFunisProjeto']), $listNameGroup)){

                // Encontrar grupo
                foreach ($groups as $data) {
                    if(ucfirst($jsonData['nomesFunisProjeto']) == $data['name']){
                        $idGroup = $data['id'];
                    }
                }

                $query = 'mutation($borderId: Int!, $groupId: String!, $itemName: String!) { create_item (board_id:$borderId, group_id:$groupId, item_name:$itemName){id}}';

                $vars = [
                    'borderId' => $board_id,
                    'groupId' =>  $idGroup,
                    'itemName' => $jsonData['nome']
                ];
        
                $data = @file_get_contents($apiUrl, false, stream_context_create([
                   'http' => [
                       'method' => 'POST',
                       'header' => $headers,
                       'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                   ]
                ]));
                
                $json = json_decode($data, true);

            }else {

                // Ele cria o group junto com o item para quando não existir
                $query = ' mutation($boardId: Int!, $groupName: String! ) { create_group (board_id: $boardId, group_name: $groupName){id}} ';
                $vars = [
                    'boardId' => $board_id,
                    'groupName' => ucfirst($jsonData['nomesFunisProjeto'])
                ];

        
                $data = @file_get_contents($apiUrl, false, stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'header' => $headers,
                        'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                    ]
                ]));

                $groupData = json_decode($data, true);
                $groupId = $groupData['data']['create_group']['id'];


                // Criar o projeto dentro do group depois de 10 segundos
                sleep(10);

                $query = 'mutation($borderId: Int!, $groupId: String!, $itemName: String!) { create_item (board_id:$borderId, group_id:$groupId, item_name:$itemName){id}}';

                $vars = [
                    'borderId' => $board_id,
                    'groupId' => $groupId,
                    'itemName' => $jsonData['nome']
                ];
        
                $data = @file_get_contents($apiUrl, false, stream_context_create([
                   'http' => [
                       'method' => 'POST',
                       'header' => $headers,
                       'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                   ]
                ]));
                
                $json = json_decode($data, true);

                return 'Criou grupo com item!';
            }

        }else {
            return 'Token invalido!';
        }
        
        //return $this->repo->store($data);
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

    public function delete($jsonData)
    {
        $board_id = 3189733335;
        $tokenSystem = "ACUarqUqpZbP6307f0d8910c2";
        $token = $jsonData['token']; 

        $groups = $this->repo->getListGroup();
        $listNameGroup = [];
        foreach ($groups as $data) {
            $listNameGroup[] = $data['name'];
        }

        /** Conexão com api monday**/
        $tokenMonday = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';

        $apiUrl = 'https://api.monday.com/v2';
        $headers = ['Content-Type: application/json', 'Authorization: ' . $tokenMonday];

        // Lista de item do quadro
        $query = ' { boards (limit:1, ids: [3189733335]) {items {id, name, group {title id} } }}';

        $data = @file_get_contents($apiUrl, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $headers,
                'content' => json_encode(['query' => $query]),
            ]
        ]));
        
        $itemDoGroup = json_decode($data, true);
        $itemDoGroup = $itemDoGroup['data']['boards'][0]['items'];
        $idItem = '';
      
        // Token validation
        if($token == $tokenSystem) {

            // Verifica se o grupo já existe no monday
            // Se já existir ele apenas adicionar o item no group
            if(in_array(ucfirst($jsonData['nomesFunisProjeto']), $listNameGroup)){

                // Encontrar grupo
                foreach ($groups as $data) {
                    if(ucfirst($jsonData['nomesFunisProjeto']) == $data['name']){
                        $idGroup = $data['id'];
                    }
                }

                // Encontrar item do grupo
                foreach ($itemDoGroup as $data) {
                    if($idGroup == $data['group']['id']){

                        if($jsonData['nome'] == $data['name']) {
                            $idItem = $data['id'];
                        }
                    }
                }

                // Converte o idItem de string para int
                $idItem = intVal($idItem);

                // Deletando um item do grupo
                $query = 'mutation($itemId: Int!) { delete_item(item_id: $itemId){id}}';

                $vars = [
                    'itemId' => $idItem
                ];
        
                $data = @file_get_contents($apiUrl, false, stream_context_create([
                   'http' => [
                       'method' => 'POST',
                       'header' => $headers,
                       'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                   ]
                ]));
                
                $json = json_decode($data, true);

                if($json == ''){
                    return "Não foi encontrado o projeto requerido!";
                }else {
                    return $json;
                }
           

            }else {
                return "Não foi encontrado o projeto requerido!";
            }

        }else {
            return 'Token invalido!';
        }

        //return $this->repo->delete();
    }
}

?>