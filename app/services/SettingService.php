<?php 

namespace App\Services;
use App\Repositories\SettingRepositoryInterface;
use Validator;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    private $repo;

    public function __construct(SettingRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store($request)
    {
        $message = [
            'name.required' => 'O nome do usuário é obrigatório!',
            'name.min' => 'É necessário no mínimo 5 caracteres no nome do usuário!',
            'name.max' => 'É necessário no Máximo 255 caracteres no nome do usuário!',

            'email.required' => 'O email do usuário é obrigatório!',
            'email.email' => 'O e-mail é inválido',
            'email.unique' => 'O e-mail já existe',
           
            'password.required' => 'A senha é obrigatório!',
            'password.min' => 'É necessário no mínimo 5 caracteres na senha usuário!',
            'password.max' => 'É necessário no Máximo 10 caracteres na senha do usuário!',
            'password.confirmed' => 'É necessário confirmar a senha!',
        ];

        $data = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5|max:10|confirmed',
            'password_confirmation' => 'required|string|min:5|max:10',
            //'avatar' => 'image',
        ], $message);

        $data['password'] = Hash::make($request->password);
      
        // if($request['avatar']) {
        //     $file = $data['avatar'];

        //     $nameFile = $file->getClientOriginalName();
        //     $file = $file->storeAs('users', $nameFile);
        //     $data['avatar'] = $file;
        // }
        return $this->repo->store($data);
    }

    public function getList()
    {
        $data = $this->repo->getList();

        foreach ($data as $item) {
            if($item->type == "boards"){
                $boards = ['id' => $item->id, 'token' => $item->token];
            }

            if($item->type == "monday"){
                $monday = ['id' => $item->id, 'token' => $item->token];
            }

            if($item->type == "company"){
                $company = ['id' => $item->id, 'token' => $item->token];
            }
        }
        $list = ["boards" => $boards, 'monday' => $monday, 'company' => $company];
        return $list;
    }

    public function get($id)
    {
        return $this->repo->get($id);
    }

    public function update($request)
    {
        switch ($request['id']) {
            case 1:
                $tokenMin = '10';
                $tokenMax = '20';
                $type = 'numeric';
                break;
            case 2:
                $tokenMin = '2';
                $tokenMax = '200';
                $type = 'string';
                break;
            case 3:
                $tokenMin = '2';
                $tokenMax = '200';
                $type = 'string';
                break;
        }
        $typeWriting = $type != 'numeric' ? 'Letra' : 'Número';

        $message = [
            'id.required' => 'O id é obrigatório!',

            'token.min' => "É necessário no mínimo $tokenMin caracteres no token da configuração!",
            'token.max' => "Apenas no Máximo $tokenMax caracteres no token da configuração!",
            "token.$type" => "O token deve ser um $typeWriting.",
        ];

        $data = $request->validate([
            // 'id' => 'required|numeric|min:5|max:255',
            'id' => 'required',
            'token' => "required|$type|min:10|max:50",
        ], $message);

        $data = [
            "id" => $data['id'],
            "token" => $data['token']
        ];
        
        return $this->repo->update($data);
    }

    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }
}

?>