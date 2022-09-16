@extends('layouts.layout')
<div class="row h-100">
    <div class="col-12 col-md-4">
        <div class="row h-100 justify-content-center">
            <div class="col-10 align-self-center p-4 mb-5">
                <div class="h3 text-center pb-3 text-black">Loginaa</div>
                <div class="mb-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row mb-2">
                            <label for="email" class="col-md-12 mb-2">E-mail</label>
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="password" class="col-md-12">Senha</label>
                            <div class="col-md-12 mb-2">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn text-white" style="background-color: #0099B2">
                                        Entrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
      <div class="col-12 col-md-8 d-none d-sm-block" style="background-color: #52575A">
        <div class="row h-100 justify-content-center text-center">
          <div class="col-12 align-self-center mb-5">
            <img src="{{ asset('img/logo.png') }}" class="img-fluid mb-5"/>
          </div>
        </div>
      </div>
  </div>