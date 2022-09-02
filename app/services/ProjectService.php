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
        // Teste
        $quadroExiste = true; 

        $tokenSystem = "ACUarqUqpZbP6307f0d8910c2";
        $token = $jsonData['token']; 

        $group = $this->repo->getListGroup();

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
        
        return $this->repo->store($data);
    }

    public function getListGroup()
    {
        return $this->repo->getListGroup();
    }

    public function getGroup($id)
    {
        //return $this->repo->get($id);
    }

    public function update($request, $id)
    {
        //$findEmail = $this->repo->get($id); // encontrar dados do usuário
        //return $this->repo->update($data, $id);
    }

    public function destroy($id)
    {
        //return $this->repo->destroy($id);
    }
}

?>