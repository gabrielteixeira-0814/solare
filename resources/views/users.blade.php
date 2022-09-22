@extends('layouts.layout')

<div class="container mt-5">
  <div class="h2">Usuários</div>
    <div class="row bg-white rounded">
      <div class="col-12 justify-content-end text-right py-3">
        <span class="pr-2" >Pesquisar:</span> 
          <input type="text" class="rounded" id="search" name="search" placeholder="John Doe...">
      </div>
        {{-- Insere a pagina listSale.blade.php --}}
        <div class="users_data"></div>
    </div>
</div>

