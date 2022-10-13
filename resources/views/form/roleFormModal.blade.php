
{{-- Form role --}}
  <div class="form-permission">
      <form action="" class="form_permission" id="form_permission">
          <input type="hidden" class="" id="id" name="id">
          <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="name">
          </div>

          <div class="mb-3">
            <label for="checkbox" class="form-label">Permissões</label>
          </div>
        @foreach ( $listPermissionSelect as $permission)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" checked="true"  value="{{$permission->name}}" id="{{$permission->name}}">
            <label class="form-check-label" for="{{$permission->name}}">
            {{ $permission->name }}
            </label>
          </div>
        @endforeach
      </form>
  </div>
        

  