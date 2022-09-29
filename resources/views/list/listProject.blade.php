<table class='table'>
    <tr>
        <th scope="col">
            Nome
        </th>
        <th scope="col">
            Descrição
        </th>
        <th scope="col">
            Responsável
        </th>
        <th scope="col">
            Cliente
        </th>
        <th scope="col">
            Etapa do Projeto
        </th>
        <th scope="col">
            Data
        </th>
        <th scope="col">
            Ações
        </th>
    </tr>

    @foreach ($listProject as $project)
        <tr style="font-size: 13px">
            <td>
                {{ $project->name }}
            </td>
            <td>
                {{ $project->description }}
            </td>
            <td>
                {{ $project->responsibleProject }}
            </td>
            <td>
                {{ $project->nameClient }}
            </td>
            <td>
                {{ $project->nameStepsProject }}
            </td>
            <td>
                {{ date("d/m/Y", strtotime($project->created_at)) }} 
            </td>
            <td>
                <button class='view userButton' id='view' value="{{ $project->id }}" name="{{ $project->id }}" data-bs-toggle="modal" data-bs-target="#viewProject" style="color: #0099B2; font-size: 20px;"><i class='bx bx-show'></i></button>
            </td>
        </tr>
    @endforeach
    </tr>
</table>
@if ($search)
    <div class="paginationProject">
        <p>{{ $listProject->links() }}</p>
    </div>
@endif
