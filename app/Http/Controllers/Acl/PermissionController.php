<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        //
    }


    public function getList()
    {
        //
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'permission' => 'required',
        ]);
        return $request;
        // // Criar uma função
        // $role = Role::create(['guard_name' => 'web', 'name' => $request->input('name')]);

        //  // Acrescentar as permissões para a função criada acima
        // $role->syncPermissions($request["permission"]); // EX: $request[1,2]
        
        return 'Função criada com sucesso!';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return ('Função deletada com sucesso!');
    }
}
