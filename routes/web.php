<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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


Route::get('/user', [UserController::class, 'getList'])->name('getListUser');
Route::get('/user/{id}', [UserController::class, 'get'])->name('getUser');
Route::post('/user', [UserController::class, 'store'])->name('postUser');
Route::post('/user/{id}', [UserController::class, 'update'])->name('putUser');
//Route::delete('/{id}', [UserController::class, 'delete'])->name('deleteUser');