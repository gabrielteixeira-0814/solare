@extends('layouts.layout')

<div class="container mt-5">
  <div class="h2 pt-5" style="font-weight: bold; color: #0099B2">Usuários</div>
    <div class="row bg-white rounded px-3">
      <div class="col-12 justify-content-center text-end py-3">
        <span class="p-2" >Pesquisar:</span> 
          <input type="text" class="rounded" id="search" name="search" placeholder="John Doe...">
      </div>
        {{-- Insere a pagina listSale.blade.php --}}
        <div class="users_data"></div>
    </div>
</div>

