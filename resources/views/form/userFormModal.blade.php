
{{-- Form User --}}
  <div class="form-user">
      <form action="" class="form_user" id="form_user">
          <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="name">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirme a senha</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
          </div>
          <div class="mb-3">
            <label for="checkbox" class="form-label">Permissões</label>
          </div>
        @foreach ( $listRoleSelect as $role)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="{{$role->name}}"  value="{{$role->id}}" id="{{$role->name}}">
            <label class="form-check-label" for="{{$role->name}}">
            {{ $role->name }}
            </label>
          </div>
        @endforeach
      </form>
  </div>
        

  