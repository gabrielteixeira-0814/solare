@extends('layouts.layout')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-10 mt-5" id="successDelete">
      <div class="alert alert-success text-center" role="alert">
        Usuário deletado com sucesso!
      </div>
    </div>
  </div>
  <div class="h2 pt-5" style="font-weight: bold; color: #0099B2">Configurações</div>
    <div class="row bg-white rounded px-3">
        {{-- Insere a formulario --}}
        <div class="setting_data"></div>
    </div>
</div>


@section('script')
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="{{ asset('js/setting.js') }}" defer></script>
@endsection