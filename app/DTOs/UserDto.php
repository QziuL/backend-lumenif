<?php

namespace App\DTOs;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class UserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    // Retorna o próprio DTO com base nos dados da request recebida
    public static function createDto(Request $request): self
    {
        return new self(
            name:  $request->input('name'),
            email:  $request->input('email'),
            password:  $request->input('password'),
        );
    }

    // Retorna um response json contendo os dados de usuario e token
    public static function createResponse(User $user)
    {
        return response()->json([
            'user' => [
                'public_id' => $user->public_id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'roles' => $user->roles
        ], 201);
    }
}
