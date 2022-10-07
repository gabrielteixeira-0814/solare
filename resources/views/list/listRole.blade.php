<table class='table'>
        <tr>
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
    
        @foreach ($listRole as $role)
            <tr>
                <td>
                    {{ $role->name }}
                </td>
                <td>
                    {{ date("d/m/Y", strtotime($role->created_at)) }} 
                </td>
                <td>
                    <button class='edit roleButton' id='editRole' value="{{ $role->id }}" name="{{ $role->id }}" data-toggle="modal" data-target="#role" style="color: #0099B2; font-size: 16px;"><i class='bx bxs-edit-alt'></i></button>
                    <button class='delete roleButton' id='deleteRole' value="{{ $role->id }}" name="{{ $role->id }}" style="color: #e93535; font-size: 16px;" ><i class='bx bxs-trash'></i></button>
                </td>
            </tr>
        @endforeach
        </tr>
    </table>
    @if ($search)
        <div class="paginationRole">
            <p>{{ $listRole->links() }}</p>
        </div>
    @endif
  