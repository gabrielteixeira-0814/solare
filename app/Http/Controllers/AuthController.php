<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5|max:10|confirmed',
            'password_confirmation' => 'required|string|min:5|max:10',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Criação do token do usuário
        $token = $user->createToken('primeirotoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return view('home');
        //return response($response, 201);
    } 

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // ckecka email do usuário 
        $user = User::where('email', $request->email)->first();

        // validade usuario e checa o password
        if(!$user || !Hash::check($request->password, $user->password)){

            return view('login');
            return response([
                'message' => 'Credenciais invalidas'
            ], 401);
        }

        // Criação do token do usuário
        $token = $user->createToken('primeirotoken')->plainTextToken;

        $response = [
            'user' => $user,
            'tokenn' => $token
        ];

        return view('home', compact('response'));
    }

    public function logout() 
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logout efetuado com sucesso e exclusão dos tokens.'
        ];

        return view('login');
    }
}
