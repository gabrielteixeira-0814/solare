<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController; 
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\ProjectController;  
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\Acl\RoleController; 
use App\Http\Controllers\Acl\PermissionController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

require __DIR__.'/auth.php';

// User
Route::group(['middleware' => ['auth']], function(){ 
    Route::get('/users', [UserController::class, 'index'])->name('pageUsers');
    Route::get('/users/form', [UserController::class, 'formUser'])->name('formUser');
    Route::get('/user/list', [UserController::class, 'getList'])->name('getListUser');
    Route::get('/user/{id}', [UserController::class, 'get'])->name('getUser');
    Route::post('/user', [UserController::class, 'store'])->name('postUser');
    Route::post('/user/edit', [UserController::class, 'update'])->name('putUser');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('deleteUser');
    Route::get('/userRole/{id}', [UserController::class, 'userRole'])->name('userRole');
});

// Project

Route::post('create', [ProjectController::class, 'store'])->name('create');
Route::post('delete', [ProjectController::class, 'delete'])->name('delete');

Route::group(['middleware' => ['auth']], function(){ 
    Route::get('/project/teste', [ProjectController::class, 'teste'])->name('teste');
    Route::get('/project/list', [ProjectController::class, 'getList'])->name('getListProject');
    Route::get('/project/{id}', [ProjectController::class, 'get'])->name('getProject');
    Route::get('listGroup', [ProjectController::class, 'getListGroup'])->name('getListGroup');
});


// Setting
Route::group(['middleware' => ['auth']], function(){ 
    Route::get('/setting', [SettingController::class, 'index'])->name('pageSetting');
    Route::get('/settingForm', [SettingController::class, 'formSetting'])->name('settingForm');
    Route::get('/setting/list', [SettingController::class, 'getList'])->name('getListSetting');
    Route::post('/setting/edit/board', [SettingController::class, 'update'])->name('editBoard');
});

// Roles 
Route::group(['middleware' => ['auth']], function(){
    Route::get('/role', [RoleController::class, 'index'])->name('pageRole');
    Route::get('/role/list', [RoleController::class, 'getList'])->name('getListRole');
    Route::get('/user/role/list', [RoleController::class, 'getListRole'])->name('getListRole');
    Route::get('/role/{id}', [RoleController::class, 'show'])->name('showRole');  
    Route::post('/role/edit', [RoleController::class, 'update'])->name('editRole');
    Route::get('/roleForm', [RoleController::class, 'formRole'])->name('formRoles');
    Route::post('/role/create', [RoleController::class, 'store'])->name('createRole');
    Route::get('/role/delete/{id}', [RoleController::class, 'delete'])->name('deleteRole');
    Route::get('/rolePermission/{id}', [RoleController::class, 'rolePermission'])->name('rolePermission');
});

// Permissions
Route::group(['middleware' => ['auth']], function(){
    Route::get('/permission', [PermissionController::class, 'index'])->name('pagePermission');
    Route::post('/permission/create', [PermissionController::class, 'store'])->name('createPermission');
    Route::get('/permission/list', [PermissionController::class, 'getList'])->name('getPermission');
    Route::get('/role/permission/list', [PermissionController::class, 'getListPermission'])->name('getListPermission');
    Route::get('/permission/form', [PermissionController::class, 'formPermission'])->name('formPermission');
    Route::post('/permission/edit', [PermissionController::class, 'update'])->name('editPermission');
    Route::get('/permission/{id}', [PermissionController::class, 'show'])->name('showPermission');  
    Route::get('/permission/delete/{id}', [PermissionController::class, 'delete'])->name('deletePermission');
});
