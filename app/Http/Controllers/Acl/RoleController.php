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

    public function show($id)
    {
        return $role = Role::find($id);
    }

    // public function update($id)
    // {
    //     $role = Role::find($id);
    //     $permission = Permission::get();
    //     $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
    //         ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
    //         ->all();
    
    //     return view('roles.edit',compact('role','permission','rolePermissions'));
    // }

    public function update(Request $request)
    {
        // if($request->ajax()){
            
        //     $role = Role::find($request['id']);

        //     return  $role;
        //     if($role) {
        //         $role->update($request);
        //         return $role;
        //     }
        // }
    }
}
