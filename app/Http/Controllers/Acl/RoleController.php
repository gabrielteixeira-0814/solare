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
        // Remove todas as permissões
        $listPermission = [];
        $role = Role::find($request['id']);

        $rolePermission = $role->permissions;

        foreach ($rolePermission as $item ) {
            if($request[$item->name]){
                $role->revokePermissionTo($item->pivot->permission_id);
            }
        }


        // list permission
        $list = [];
        $listPermission = Permission::all();

        foreach ($listPermission as $permission) {

            if($request[$permission->name]){
                $list[] = $request[$permission->name];
            }
        }

        $role->update(['name' => $request['name']]);

        // Acrescentar as permissões para a função criada acima
        $role->syncPermissions($list); // EX: $request[1,2]
    }

    public function delete(Request $request) 
    {
        $role = Role::find($request['id']);
        return   $role->delete(['name' => $request['name']]);
    }

    // Verifica quais Permissões são daquela função
    public function rolePermission($id) 
    {
        $list = [];
        $role = Role::find($id);

        foreach ($role->permissions as $item ) {
            $list[] = $item->pivot->permission_id;
        }

        return $list;
    }
}
