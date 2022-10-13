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

    @foreach ($listPermission as $permission)
        <tr>
            <td>
                {{ $permission->name }}
            </td>
            <td>
                {{ date("d/m/Y", strtotime($permission->created_at)) }} 
            </td>
            <td>
                <button class='edit permissionButton' id='editPermission' value="{{ $permission->id }}" name="{{ $permission->id }}" data-toggle="modal" data-target="#permission" style="color: #0099B2; font-size: 16px;"><i class='bx bxs-edit-alt'></i></button>
                <button class='delete permissionButton' id='deletePermission' value="{{ $permission->id }}" name="{{ $permission->id }}" style="color: #e93535; font-size: 16px;" ><i class='bx bxs-trash'></i></button>
            </td>
        </tr>
    @endforeach
    </tr>
</table>
@if ($search)
    <div class="paginationPermission">
        <p>{{ $listPermission->links() }}</p>
    </div>
@endif

