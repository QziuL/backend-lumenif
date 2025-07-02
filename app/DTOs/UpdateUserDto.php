<?php

namespace App\DTOs;

use App\Models\User;
use Illuminate\Http\Request;

class UpdateUserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public int $role_id,
    ) {}

    public static function createDto(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            role_id: $request->input('role_id'),
        );
    }

    public static function updateResponse(User $user)
    {
        return response()->json([
            'user' => [
                'public_id' => $user->public_id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles
            ]
        ], 200);
    }
}
