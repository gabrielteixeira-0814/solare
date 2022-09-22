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
                    {{-- <i class='bx bxs-show'></i> --}}
                    <a href="" class='edit' value="1" data-toggle="modal" data-target="#user" style="color: #0099B2; font-size: 16px;"><i class='bx bxs-edit-alt'></i></a>
                    <a href="" class='' style="color: #0099B2; font-size: 16px;" ><i class='bx bxs-trash'></i></a>
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

  <!-- Modal -->
  <div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold; color: #0099B2">Usuário</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
                    <label for="function" class="form-label">Função</label>
                    <input type="text" class="form-control" id="function" name="function">
                  </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary save">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  