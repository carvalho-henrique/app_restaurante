<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login (Request $request) {
        $credentials = $request->all(['email', 'password']);

        $token = auth('api')->attempt($credentials);

        if($token){
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Usuário ou senha inválido!'], 403);
        }
    }

    public function logout () {
        auth('api')->logout();
        return response()->json(['msg' => 'Logout foi realizado com sucesso!']);
    }

    public function refresh () {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function me () {
        return response()->json(auth()->user());
    }

    public function register (Request $request) {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'password_confirmation' => 'required|same:password',
        ];

        $request->validate($rules);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
