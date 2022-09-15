<!doctype html>
<html class="h-100"lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Site de Vendas</title>
    <!-- Styles -->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
  </head>
  <body class="h-100">
      <div class="row h-100">
        <div class="col-12 col-md-4">
            <div class="row h-100 justify-content-center">
                <div class="col-10 align-self-center p-4 mb-5">
                    <div class="h3 text-center pb-3 text-black">Login</div>
                    <div class="mb-5">
                        <form method="POST" action="">
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
        @yield('content')
      <footer class="fixed-bottom mt-5">
        <div style="background-color: #f5f4f4">
          <div class="container p-3">
            <div class="row text-center">
              <div class="col-12">
                &copy; {{date("Y")}} Solare
              </div>
            </div>
          </div>
        </div>
      </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>