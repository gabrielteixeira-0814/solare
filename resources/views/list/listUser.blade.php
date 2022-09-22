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
                    <a href="" class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</a>

                    <a href="" class='btn btn-danger'>Deletar</a>
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

  