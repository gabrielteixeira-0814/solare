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
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);

        $arquivo = 'inputs.json';
        $json = json_encode($jsonData);

        return $this->service->store($jsonData);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function delete()
    {
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);

        return $this->service->delete($jsonData);
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
