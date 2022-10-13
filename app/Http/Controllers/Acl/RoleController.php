<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::get();
        return view('roles');
    }
    
    public function getList(Request $request)
    {
        if($request->ajax()){
            $search = !$request['search'] ? true : false;
           
            if($request['search']){

                $roles = new Role();
                $listRole = $roles->where('name', 'LIKE', '%'.$request['search'].'%')->get();
            }else {
                $listRole = Role::paginate(2);
            }

            return view('list.listRole', compact('listRole', 'search'));
        }
    }

    public function formRole()
    {
        $listPermissionSelect = Permission::all();
        return view('form.roleFormModal', compact('listPermissionSelect'))->render();
    }

    public function store(Request $request)
    {
        $list = [];

        // list permission
        $listPermission = Permission::all();

        foreach ($listPermission as $permission) {

            if($request[$permission->name]){
                $list[] = $request[$permission->name];
            }
        }

        $role = Role::create(['name' => $request['role']]);

        // Acrescentar as permissões para a função criada acima
        $role->syncPermissions($list); // EX: $request[1,2]

        return $role;
    }

    public function show($id)
    {
        return $role = Role::find($id);
    }

    public function update(Request $request)
    {
        $role = Role::find($request['id']);
        return   $role->update(['name' => $request['name']]);
    }
}
