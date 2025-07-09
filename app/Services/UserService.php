<?php

namespace App\Services;

use App\DTOs\UpdateUserDto;
use App\DTOs\UserDto;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll()
    {
        return UserResource::collection(
            User::with('roles')
                ->orderBy('created_at', 'desc')
                ->paginate(15)
        );
    }

    public function getOne(string $id)
    {
        return User::with('roles')->where('public_id', $id)->firstOrFail();
    }

    public function create(UserDto $userDto)
    {
        return User::create([
            'public_id' => uuid_create(),
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => Hash::make($userDto->password),
        ]);
    }

    public function update(UpdateUserDto $userDto, string $public_id)
    {
        $user = User::where('public_id', $public_id)->first();

        $roleUser = $user->roles()->first();

        if($user->email != $userDto->email)
            $user->email = $userDto->email;
        if($user->name != $userDto->name)
            $user->name = $userDto->name;
        if($roleUser->id != $userDto->role_id)
        {
            $user->roles()->detach();
            $user->roles()->attach($userDto->role_id);
        }
        $user->save();

        return $user;
    }

    public function delete(string $public_id)
    {
        $user = User::where('public_id', $public_id)->first();
        $user->delete();
        return $user;
    }
}
