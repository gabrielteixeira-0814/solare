<?php 

namespace App\Services;
use App\Repositories\UserRepositoryInterface;
use Validator;
use Illuminate\Support\Facades\Storage;


class UserService
{
    private $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store($request)
    {
        return $this->repo->store($request); 
    }

    public function getList()
    {
        return $this->repo->getList();
    }

    public function get($id)
    {
        return $this->repo->get($id);
    }

    public function update($request, $id)
    {
        return $this->repo->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }
}

?>