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
      </div>
        <div class="project_data"></div>
    </div>
</div>

<!-- Modal Project -->
<div class="modal fade" id="viewProject" tabindex="-1" aria-labelledby="viewProjectLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewProjectLabel" style="font-weight: bold; color: #0099B2">Projetoaa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
        {{-- Gif --}}
        <div class="row justify-content-center mt-5" id="gif">
          <div class="col-1 text-center">
            <div class="loading">Loading&#8230;</div>
          </div>
        </div>
        
        <div class="modal-body modalGif">
            <form action="" class="form" id="form">
                <input type="hidden" class="" id="id" name="id">
                <div class="mb-3">
                  <label for="name" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="name" name="name" aria-describedby="name">
                </div>
                <div class="mb-3">
                  <label for="descricao" class="form-label">Descrição</label>
                  <input type="text" class="form-control" id="descricao" name="descricao">
                </div>
                <div class="mb-3">
                    <label for="responsavel" class="form-label">Responsável</label>
                    <input type="text" class="form-control" id="responsavel" name="responsavel">
                </div>
                <div class="mb-3">
                  <label for="cliente" class="form-label">Cliente</label>
                  <input type="text" class="form-control" id="cliente" name="cliente">
                </div>
                <div class="mb-3">
                  <label for="etapaProjeto" class="form-label">Etapa do Projeto</label>
                  <input type="text" class="form-control" id="etapaProjeto" name="etapaProjeto">
                </div>
                <div class="mb-3">
                  <label for="data" class="form-label">Data</label>
                  <input type="text" class="form-control" id="data" name="data">
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

@section('script')
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="{{ asset('js/project.js') }}" defer></script>
@endsection