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

    public function formUser()
    {
        return view('form.userFormModal')->render();
    }
    
    public function getList(Request $request)
    {
        if($request->ajax()){

            $search = !$request['search'] ? true : false;
            $listUser = $this->service->getList($request);
            return view('list.listUser', compact('listUser', 'search'))->render();
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

    public function update(Request $request)
    {
        if($request->ajax()){
            return $this->service->update($request);
        }
    }

    public function delete($id)
    {
        return $this->service->destroy($id);
    }
}
