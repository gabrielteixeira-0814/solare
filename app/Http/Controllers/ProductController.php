<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function store(){
        //* Variáveis globais
        $board_id = 3189733335; //? Id do board
        $tokenSystem = "ACUarqUqpZbP6307f0d8910c2"; //? Token usado no gatilho do sistema da SolarMarket

        //* Conexão com api monday
        $tokenMonday = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';
        $apiUrl = 'https://api.monday.com/v2';
        $headers = ['Content-Type: application/json', 'Authorization: ' . $tokenMonday];
    
        //* Recebe webhook
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);
        $token = $jsonData['token']; 

        //* Buscar grupo 
       $query = ' { boards (limit:1, ids: [3189733335]) {groups {title id} } }';

       $data = @file_get_contents($apiUrl, false, stream_context_create([
          'http' => [
              'method' => 'POST',
              'header' => $headers,
              'content' => json_encode(['query' => $query]),
          ]
       ]));
       
       $groups = json_decode($data, true);
       
       //* Tratamento do dado recebido para se obter uma lista de nomes de grupo
       $listGroup = []; //? Lista com id e nome para uso futuro do id
       $groups = $groups['data']['boards']; 

       foreach ($groups[0]['groups'] as $data) {
            $group = [
                'id' => $data['id'],
                'name' => $data['title'],
            ];

            $listGroup[] =  $group;
       }
       
        $listNameGroup = []; //? Lista só com os nomes de grupo para usar no in_array()

        foreach ($listGroup as $data) {
            $listNameGroup[] = $data['name'];
        }

        //* Token validation
        if($token == $tokenSystem) {

            //* Verifica se o grupo já existe no monday
            //* Se já existir ele apenas adicionar o item no grupo
            if(in_array(ucfirst($jsonData['nomesFunisProjeto']), $listNameGroup)){

                //* Encontrando id do grupo ao qual o item pertence
                foreach ($listGroup as $data) {
                    if(ucfirst($jsonData['nomesFunisProjeto']) == $data['name']){
                        $idGroup = $data['id'];
                    }
                }

                $query = 'mutation($borderId: Int!, $groupId: String!, $itemName: String!, $columnValues: JSON!) { create_item (board_id:$borderId, group_id:$groupId, item_name:$itemName, column_values:$columnValues){id}}';

                $vars = [
                    'borderId' => $board_id,
                    'groupId' =>  $idGroup,
                    'itemName' => $jsonData['nome'],
                    'columnValues' => json_encode([
                        'person' => [
                            'personsAndTeams' => array([
                                'id' => 33125431,
                                'kind' => 'person'
                            ])
                        ],
                        'status' => ['index' => 0],
                        'data' => ['date' => '2022-12-01'],
                        'texto' => 'Empadão de frango'
                    ])

                    //"{\"changed_at\":\"2022-09-07T14:56:04.551Z\",\"personsAndTeams\":[{\"id\":33125431,\"kind\":\"person\"}]}"
                ];
        
                $data = @file_get_contents($apiUrl, false, stream_context_create([
                   'http' => [
                       'method' => 'POST',
                       'header' => $headers,
                       'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                   ]
                ]));
                
                $json = json_decode($data, true);

                return $json;

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
    }

    public function delete()
    {
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);

        /** Conexão com api monday**/
        $tokenMonday = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';

        $board_id = 3189733335;
        $tokenSystem = "ACUarqUqpZbP6307f0d8910c2";
        $token = $jsonData['token']; 

        // Buscar grupo inicio

        //     /** Conexão com api monday**/
        //    $token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';

        $apiUrl = 'https://api.monday.com/v2';
        $headers = ['Content-Type: application/json', 'Authorization: ' . $tokenMonday];

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

            $listGroup[] =  $group;
        }

      
        // Buscar grupo fim

        $listNameGroup = [];
        foreach ($listGroup as $data) {
            $listNameGroup[] = $data['name'];
        }

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
                foreach ($listGroup as $data) {
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

    public function getRead()
    {

        return 'ola, mundo!';
       // $json = file('inputs.json');

    //    if(file_exists("inputs.json")) {
    //         $json = file_get_contents("inputs.json");
    //         $data = json_decode($json);

    //         return $data;
    //     }else {
    //         return "Não existe dados";
    //     }
    }
}
