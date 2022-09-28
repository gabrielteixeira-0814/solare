<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    private $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function getList()
    {
        return $this->service->getList();    
    }
    
    public function getListGroup()
    {
        return $this->service->getListGroup();
    }
    
    public function get($id)
    {
        return $this->service->get($id);
    }

    public function store()
    {
       // Recebe webhook
       $json = file_get_contents('php://input');
       $jsonData = json_decode($json, true);
       
       return $this->service->store($jsonData);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function delete()
    {
        // Recebe webhook
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);

        return $this->service->delete($jsonData);
    }
}
