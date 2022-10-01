<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SettingService;

class SettingController extends Controller
{
    private $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('setting');
    }

    public function getList()
    {
        return $this->service->getList();  
    }

    public function formSetting()
    {
        return view('form.settingForm');
    }

    public function editBoard(Request $request)
    {
        if($request->ajax()){
            return $this->service->editBoard($request);
        }
        
       
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

    public function update(Request $request)
    {
        if($request->ajax()){
            return $this->service->update($request);
        }
    }

    public function delete()
    {
        // Recebe webhook
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);

        return $this->service->delete($jsonData);
    }
}
