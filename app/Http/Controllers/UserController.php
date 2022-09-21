<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('users');
    }
    
    public function getList(Request $request)
    {
        if($request->ajax()){

            $listUser = $this->service->getList($request);

            return $listUser;

            // Ele retornar toda uma pagina
            return view('list.listUser', compact('listUser'))->render();
        }
    }
    
    public function get($id)
    {
        return $this->service->get($id);
    }

    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function delete($id)
    {
        return $this->service->destroy($id);
    }
}
