<?php 

namespace App\Services;
use App\Repositories\UserRepositoryInterface;
use Validator;
use Illuminate\Support\Facades\Storage;

class UserService
{
    private $repo;

    public function __construct(UserRepositoryInterface $repo)
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
            'avatar' => 'image',
        ], $message);

         
        if($request['avatar']) {
            $file = $data['avatar'];

            $nameFile = $file->getClientOriginalName();
            $file = $file->storeAs('users', $nameFile);
            $data['avatar'] = $file;
        }
        return $this->repo->store($data);
    }

    public function getList()
    {
        return $this->repo->getList();
    }

    public function get($id)
    {
        return $this->repo->get($id);
    }

    public function update($request, $id)
    {
        $findEmail = $this->repo->get($id); // encontrar dados do usuário

        if($findEmail['email'] == $request['email']) {
            $message = [
                'name.required' => 'O nome do usuário é obrigatório!',
                'name.min' => 'É necessário no mínimo 5 caracteres no nome do usuário!',
                'name.max' => 'É necessário no Máximo 255 caracteres no nome do usuário!',

                'password.required' => 'A senha é obrigatório!',
                'password.min' => 'É necessário no mínimo 5 caracteres na senha usuário!',
                'password.max' => 'É necessário no Máximo 10 caracteres na senha do usuário!',
                'password.confirmed' => 'É necessário confirmar a senha!',
            ];
    
            $data = $request->validate([
                'name' => 'required|string|min:5|max:255',
                'password' => 'required|string|min:5|max:10|confirmed',
                'password_confirmation' => 'required|string|min:5|max:10',
                'avatar' => 'image',
            ], $message);
        }else {
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
                'email' => 'required|email',
                'password' => 'required|string|min:5|max:10|confirmed',
                'password_confirmation' => 'required|string|min:5|max:10',
                'avatar' => 'image',
            ], $message);
        }
        
        if($request['avatar']) {
            $file = $data['avatar'];

            $nameFile = $file->getClientOriginalName();

            // Encontrar arquivo antigo para deletar
            $oldFile = $this->repo->get($id); // encontrar dados do usuário
            Storage::disk('public')->delete("$oldFile->avatar");

            $file = $file->storeAs('users', $nameFile);
            $data['avatar'] = $file;
        }

        return $this->repo->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }
}

?>