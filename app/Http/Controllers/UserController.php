<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(string $id)
    {
        try{
            $user = User::where('public_id', $id)->firstOrFail();

            return response()->json([
                "public_id" => $user->public_id,
                "name" => $user->name,
                "email" => $user->email
            ], 200);
        }catch (Exception $error){
            return response()->json(["error" => "User not found"], 401);
        }
    }
}
