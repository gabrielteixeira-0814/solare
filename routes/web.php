<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;  
use App\Http\Controllers\ProductController; 
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
    return view('welcome');
});


// Route::get('/user', [UserController::class, 'getList'])->name('getListUser');
// Route::get('/user/{id}', [UserController::class, 'get'])->name('getUser');
// Route::post('/user', [UserController::class, 'store'])->name('postUser');
// Route::post('/user/{id}', [UserController::class, 'update'])->name('putUser');
//Route::delete('/{id}', [UserController::class, 'delete'])->name('deleteUser');

// Project
Route::post('create', [ProjectController::class, 'store'])->name('create');
Route::get('listGroup', [ProjectController::class, 'getListGroup'])->name('getListGroup');
Route::get('/', [ProjectController::class, 'getRead'])->name('getRead');
Route::post('deleteTeste', [ProjectController::class, 'delete'])->name('delete');



// Teste
//Route::get('/ler', [ProductController::class, 'getRead'])->name('getRead');
//Route::post('/create', [ProductController::class, 'store'])->name('create');
//Route::post('delete', [ProductController::class, 'delete'])->name('delete');