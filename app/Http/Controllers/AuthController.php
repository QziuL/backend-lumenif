<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $roleAluno = Role::where('name', 'ALUNO')->first();

        if(!$roleAluno)
            return response()->json(['error' => 'Internal server error'], 500);

        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed',
            ]);
        } catch(Exception $error){
            return response()->json('Credentials invalid', 401);
        }

        $user = User::create([
            'public_id' => uuid_create(),
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->roles()->attach($roleAluno);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User created successfully!',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'public_id' => $user->public_id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        }catch (Exception $error){
            return response()->json("Invalid credentials.", 401);
        }

        // Verifica credenciais,
        // Se as credenciais baterem, realiza autenticação na sessão,
        // Se não, retorna 401
//        if(!Auth::attempt($request->only(['email'], ['password'])))
//            return response()->json(['error' => 'Invalid credentials!'], 401);

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'public_id' => $user->public_id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logout successful!'], 200);
    }
}
