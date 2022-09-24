@extends('layouts.layout')

<div class="container mt-5">
  <div class="h2 pt-5" style="font-weight: bold; color: #0099B2">Usuários</div>
    <div class="row bg-white rounded px-3">
      <div class="col-6 py-4">
        <div>
          <span class="p-2" >Pesquisar:</span> 
          <input type="text" class="rounded" id="search" name="search" placeholder="John Doe...">
        </div>
      </div>
      <div class="col-6 py-3 text-end">
        <button type="button" class="btn btn-success">Usuário <i class='bx bx-user nav_icon' style="font-size: 15px"></i></button>
      </div>
        {{-- Insere a pagina listSale.blade.php --}}
        <div class="users_data"></div>
    </div>
</div>

