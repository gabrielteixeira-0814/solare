<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('login');
    }
    
    public function get($id)
    {
       // return $this->service->get($id);
    }

}
