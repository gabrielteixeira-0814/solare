<table class='table'>
        <tr>
            <th scope="col">
                Nome
            </th>
            <th scope="col">
                E-mail
            </th>
            <th scope="col">
                Função
            </th>
            <th scope="col">
                Data
            </th>
            <th scope="col">
                Ações
            </th>
        </tr>
    
        @foreach ($listUser as $user)
            <tr>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ date("d/m/Y", strtotime($user->created_at)) }} 
                </td>
                <td>
                    <button class='edit userButton' id='editUser' value="{{ $user->id }}" name="{{ $user->id }}" data-toggle="modal" data-target="#user" style="color: #0099B2; font-size: 16px;"><i class='bx bxs-edit-alt'></i></button>
                    <button class='delete userButton' id='deleteUser' value="{{ $user->id }}" name="{{ $user->id }}" style="color: #0099B2; font-size: 16px;" ><i class='bx bxs-trash'></i></button>
                </td>
            </tr>
        @endforeach
        </tr>
    </table>
    @if ($search)
        <div class="paginationUser">
            <p>{{ $listUser->links() }}</p>
        </div>
    @endif

    {{-- Inserir no modal o formulario criado em um arquivo novo --}}

  <!-- Modal Edit -->
  <div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold; color: #0099B2">Usuário</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row justify-content-center">
          <div class="col-10 mt-2">
            <div class="alert alert-success text-center" id="success" role="alert">
              Usuário editado com sucesso!
            </div>
          </div>
        </div>

        {{-- Gif --}}
        <div class="row justify-content-center mt-5" id="gif">
          <div class="col-1 text-center">
            <div class="loading">Loading&#8230;</div>
          </div>
        </div>
        
        <div class="modal-body modalGif">
            <form action="" class="form_user" id="form_user">
                <input type="hidden" class="" id="id" name="id">
                <div class="mb-3">
                  <label for="name" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="name" name="name" aria-describedby="name">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="function" class="form-label">Função</label>
                    <input type="text" class="form-control" id="function" name="function">
                  </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary save">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  