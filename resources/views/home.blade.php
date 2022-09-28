@extends('layouts.layout')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-10 mt-5" id="successDelete">
      <div class="alert alert-success text-center" role="alert">
        Projeto deletado com sucesso!
      </div>
    </div>
  </div>
  <div class="h2 pt-5" style="font-weight: bold; color: #0099B2">Projetos</div>
    <div class="row bg-white rounded px-3">
      <div class="col-6 py-4">
        <div>
          <span class="p-2" >Pesquisar:</span> 
          <input type="text" class="rounded" id="search" name="search" placeholder="John Doe...">
        </div>
      </div>
      <div class="col-6 py-3 text-end">
        <button type="button" class="btn btn-success createProject" data-toggle="modal" data-target="#projectForm" >Projeto <i class='bx bx-detail nav_icon' style="font-size: 15px"></i></button>
      </div>
        {{-- Insere a pagina listSale.blade.php --}}
        <div class="project_data"></div>
    </div>
</div>


@section('script')
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="{{ asset('js/project.js') }}" defer></script>
@endsection