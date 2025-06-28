<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($users, 200);
    }

    public function show(string $id): JsonResponse
    {
        $user = $user = User::with('roles')->where('public_id', $id)->firstOrFail();
        return ($user)
            ?  response()->json($user, 200)
            :  response()->json(["error" => "User not found."], 404);
    }
}
