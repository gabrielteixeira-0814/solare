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

    public function getList($request)
    { 
        if($request['search']){

            $projects = $this->repo->getList();
            $listProject = $projects->where('name', 'LIKE', '%'.$request['search'].'%')->get();
            return $listProject;

        }else {
            $projects = $this->repo->getList();
            $listProject = $projects->paginate(2);
            return $listProject;
        }
    }

    public function store($jsonData)
    {
        // Array para salvar as informações no banco de dados
        $createProjectData = [];
        
       // Variáveis globais
       $board_id = 3189733335; 
       $tokenSystem = "ACUarqUqpZbP6307f0d8910c2"; 
       $headers = $this->repo->connectionApiMonday();
       $groups = $this->getListGroup();
        
       $listNameGroup = []; 

       foreach ($groups as $data) {
           $listNameGroup[] = $data['name'];
       }

        // Buscar colunas
        // Tratamento do dado recebido para se obter uma lista de nomes de colunas
      $columns = $this->getListColumns();
     
      $listColumn = []; 
      $columns = $columns['data']['boards']; 

      foreach ($columns[0]['columns'] as $data) {
           $column = [
               'id' => $data['id'],
               'name' => $data['title']
           ];

           $listColumn[] =  $column;
      }

      $listNameColumn = []; 

       foreach ($listColumn as $data) {
           $listNameColumn[] = $data['name'];
       }

       // Tratando tipo de dados
       $dataColumn =  array(
            ['Nome', $jsonData['nome'], 'text'],
            ['Descricão', $jsonData['descricao'], 'text'],
            ['Projeto', $jsonData['projeto'], 'text'],
            ['Identificador', $jsonData['identificador'], 'text'],
            ['Quantidade de Proposta', $jsonData['quantidadePropostaProjeto'], 'numbers'],
            ['Funil', $jsonData['nomesFunisProjeto'], 'text'],
            ['Etapa', $jsonData['nomeEtapasProjeto'], 'text'],
            ['Responsável do Projeto', $jsonData['nomeResponsavelProjeto'], 'text'],
            ['E-mail do Responsável', $jsonData['emailResponsavelProjeto'], 'email'],
            ['Telefone do Responsável', $jsonData['telefoneResponsavelProjeto'], 'phone'],
            ['status', '', 'status'],
        );

       // Token validation
       if($jsonData['token'] == $tokenSystem) {
           
           // Correndo tipo de dados
           foreach ($dataColumn as $data) {

               if(!in_array($data[0], $listNameColumn)){

                   // Ele cria as colunas
                   $query = 'mutation($boardId: Int!, $titulo: String!, $descricao: String!, $texto: ColumnType!) { create_column (board_id: $boardId, title: $titulo, description: $descricao, column_type: $texto ){id}} ';
                   
                   $vars = [
                       'boardId' => $board_id,
                       'titulo' => $data[0],
                       'descricao' => '',
                       'texto' => $data[2]
                   ];
                   $apiUrl = 'https://api.monday.com/v2';
                   $data = @file_get_contents($apiUrl, false, stream_context_create([
                       'http' => [
                           'method' => 'POST',
                           'header' => $headers,
                           'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                       ]
                   ]));

                   $columnData = json_decode($data, true);
               }
           }

          // Criar o projeto dentro do group depois de 10 segundos
          sleep(10);

           // Verifica se o grupo já existe no monday
           // Se já existir ele apenas adicionar o item no grupo
           if(in_array(ucfirst($jsonData['nomesFunisProjeto']), $listNameGroup)){

               // Encontrando id do grupo ao qual o item pertence
               foreach ($groups as $data) {
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
                       $this->findFieldId('Nome',$listColumn) => $jsonData['nome'],
                       $this->findFieldId('Descricão',$listColumn) => $jsonData['descricao'],
                       $this->findFieldId('Projeto',$listColumn) => $jsonData['projeto'],
                       $this->findFieldId('Responsável do Projeto',$listColumn) => $jsonData['nomeResponsavelProjeto'],
                       $this->findFieldId('Identificador',$listColumn) => $jsonData['identificador'],
                       $this->findFieldId('Quantidade de Proposta',$listColumn) => $jsonData['quantidadePropostaProjeto'],
                       $this->findFieldId('Funil',$listColumn) => $jsonData['nomesFunisProjeto'],
                       $this->findFieldId('Etapa',$listColumn) => $jsonData['nomeEtapasProjeto'],
                       $this->findFieldId('E-mail do Responsável',$listColumn) => ['text' => $jsonData['emailResponsavelProjeto'],'email' => $jsonData['emailResponsavelProjeto']],
                       $this->findFieldId('Telefone do Responsável',$listColumn) => ['phone' => $jsonData['telefoneResponsavelProjeto'],'countryShortName'=>'BR'],
                       $this->findFieldId('status',$listColumn) => ['index' => 1]
                   ])
               ];
               $apiUrl = 'https://api.monday.com/v2';
               $data = @file_get_contents($apiUrl, false, stream_context_create([
                  'http' => [
                      'method' => 'POST',
                      'header' => $headers,
                      'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                  ]
               ]));
               
               $json = json_decode($data, true);

               if($json['data']['create_item']['id']) {
                    $createProjectData = [
                        'project' => $jsonData['projeto'],
                        'identifier' => $jsonData['identificador'],
                        'name' => $jsonData['nome'],
                        'description' => $jsonData['descricao'],
                        'FunnelsProjectnames' => $jsonData['nomesFunisProjeto'],
                        'nameStepsProject' => $jsonData['nomeEtapasProjeto'],
                        'responsibleProject' => $jsonData['nomeResponsavelProjeto'],
                        'nameRepresentativeProject' => $jsonData['nomeRepresentanteProjeto'],
                        'nameClient' => $jsonData['nomeCliente'],
                    ];

                    return $this->repo->store($createProjectData);
               }
           }else {

                // Corre tipo de dados a ser inserido na coluna
               foreach ($dataColumn as $data) {

                   if(!in_array($data[0], $listNameColumn)){

                       // Ele cria as colunas ================
                       $query = 'mutation($boardId: Int!, $titulo: String!, $descricao: String!, $texto: ColumnType!) { create_column (board_id: $boardId, title: $titulo, description: $descricao, column_type: $texto ){id}} ';
                       
                       $vars = [
                           'boardId' => $board_id,
                           'titulo' => $data[0],
                           'descricao' => '',
                           'texto' => $data[2]
                       ];
                       $apiUrl = 'https://api.monday.com/v2';
                       $data = @file_get_contents($apiUrl, false, stream_context_create([
                           'http' => [
                               'method' => 'POST',
                               'header' => $headers,
                               'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                           ]
                       ]));

                       $columnData = json_decode($data, true);
                   }
               }
               // Criar o projeto dentro do group depois de 10 segundos
               sleep(10);
               // Ele cria as colunas =================
             
               // Ele cria o group junto com o item para quando não existir
               $query = ' mutation($boardId: Int!, $groupName: String! ) { create_group (board_id: $boardId, group_name: $groupName){id}} ';
               $vars = [
                   'boardId' => $board_id,
                   'groupName' => ucfirst($jsonData['nomesFunisProjeto'])
               ];
               $apiUrl = 'https://api.monday.com/v2';
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

               $query = 'mutation($borderId: Int!, $groupId: String!, $itemName: String!, $columnValues: JSON!) { create_item (board_id:$borderId, group_id:$groupId, item_name:$itemName, column_values:$columnValues){id}}';

               $vars = [
                   'borderId' => $board_id,
                   'groupId' =>  $groupId,
                   'itemName' => $jsonData['nome'],
                   'columnValues' => json_encode([
                       $this->findFieldId('Nome',$listColumn) => $jsonData['nome'],
                       $this->findFieldId('Descricão',$listColumn) => $jsonData['descricao'],
                       $this->findFieldId('Projeto',$listColumn) => $jsonData['projeto'],
                       $this->findFieldId('Responsável do Projeto',$listColumn) => $jsonData['nomeResponsavelProjeto'],
                       $this->findFieldId('Identificador',$listColumn) => $jsonData['identificador'],
                       $this->findFieldId('Quantidade de Proposta',$listColumn) => $jsonData['quantidadePropostaProjeto'],
                       $this->findFieldId('Funil',$listColumn) => $jsonData['nomesFunisProjeto'],
                       $this->findFieldId('Etapa',$listColumn) => $jsonData['nomeEtapasProjeto'],
                       $this->findFieldId('E-mail do Responsável',$listColumn) => ['text' => $jsonData['emailResponsavelProjeto'],'email' => $jsonData['emailResponsavelProjeto']],
                       $this->findFieldId('Telefone do Responsável',$listColumn) => ['phone' => $jsonData['telefoneResponsavelProjeto'],'countryShortName'=>'BR'],
                       $this->findFieldId('status',$listColumn) => ['index' => 1]
                   ])
               ];
               $apiUrl = 'https://api.monday.com/v2';
               $data = @file_get_contents($apiUrl, false, stream_context_create([
                  'http' => [
                      'method' => 'POST',
                      'header' => $headers,
                      'content' => json_encode(['query' => $query, 'variables' => json_encode($vars)]),
                  ]
               ]));
               
               $json = json_decode($data, true);
               
               if($json['data']['create_item']['id']) {
                    $createProjectData = [
                        'project' => $jsonData['projeto'],
                        'identifier' => $jsonData['identificador'],
                        'name' => $jsonData['nome'],
                        'description' => $jsonData['descricao'],
                        'FunnelsProjectnames' => $jsonData['nomesFunisProjeto'],
                        'nameStepsProject' => $jsonData['nomeEtapasProjeto'],
                        'responsibleProject' => $jsonData['nomeResponsavelProjeto'],
                        'nameRepresentativeProject' => $jsonData['nomeRepresentanteProjeto'],
                        'nameClient' => $jsonData['nomeCliente'],
                    ];

                    return $this->repo->store($createProjectData);
                }
           
           }

       }else {
           return 'Token invalido!';
       }
    }

    public function update($request, $id)
    {
        //$findEmail = $this->repo->get($id); // encontrar dados do usuário
        //return $this->repo->update($data, $id);
    }

    public function delete($jsonData)
    {
        
        // Variáveis globais
        $board_id = 3189733335; 
        $tokenSystem = ""; 
        $headers = $this->repo->connectionApiMonday();

        // Buscar grupo
        $groups = $this->getListGroup();
        $listNameGroup = []; 
 
        foreach ($groups as $data) {
            $listNameGroup[] = $data['name'];
        }
        
        // Lista de item do quadro
        $apiUrl = 'https://api.monday.com/v2';
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
        if($jsonData['token'] == $tokenSystem) {

            // Verifica se o grupo já existe no monday
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
                    return "Não foi encontrado o projeto!";
                }else {
                    return "Projeto deletado com sucesso!";
                }
           
            }else {
                return "Não foi encontrado o projeto!";
            }

        }else {
            return 'Token invalido!';
        }
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

    public function getListColumns()
    {
        // Variáveis globais
       $board_id = 3189733335; 

       /** Conexão com api monday**/
       $token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE3NzcyOTQ2NCwidWlkIjozMzEyNTQzMSwiaWFkIjoiMjAyMi0wOC0yNlQxOTo1NTo0NC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTMwNTk3MDksInJnbiI6InVzZTEifQ.ePujvhvPa6V0wlcsQ7w_FbB4KyBZxlsNRuF-Nmq90Z0';


       $apiUrl = 'https://api.monday.com/v2';
       $headers = ['Content-Type: application/json', 'Authorization: ' . $token];

        // Buscar colunas
        $query = '{ boards (limit:1, ids: [3189733335]){columns {title id}}}';
        $apiUrl = 'https://api.monday.com/v2';
        $data = @file_get_contents($apiUrl, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $headers,
                'content' => json_encode(['query' => $query]),
            ]
        ]));
      
        $columns = json_decode($data, true);
        return $columns;        
    }

    public function findFieldId($fieldName,$array){
        foreach($array as $item){
            if($fieldName == $item['name']){
                return $item['id'];
            }
        }
    }
}

?>