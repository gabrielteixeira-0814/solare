<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
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
