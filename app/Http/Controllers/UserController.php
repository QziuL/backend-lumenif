<?php

namespace App\Http\Controllers;

use App\DTOs\UpdateUserDto;
use App\DTOs\UserDto;
use App\Models\Role;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    // Retorna todos os usuários do banco com paginação para frontend
    public function index()
    {
        try {
            return $this->userService->getAll();
        }catch (Exception $e){
            return response()->json(['Erro interno do servidor.' => $e->getMessage()], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            return response()->json($this->userService->getOne($id), 200);
        }catch(Exception $e){
            return response()->json(["error" => "Usuário não encontrado."], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $this->createUserValidateRequest($request);
        }catch (Exception $exception){
            return response()->json(["error" => "Credenciais inválidas."], 401);
        }

        try{
            $user = $this->userService->createUser(UserDto::createDto($request));
            $role = Role::where('id', $validated['role_id'])->first();
            $user->roles()->attach($role);

            return UserDto::createResponse($user);
        }catch (Exception $exception){
            return response()->json(["Erro interno." =>  $exception->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $validated = $this->editUserValidateRequest($request);
        }catch (Exception $e){
            return response()->json(["error" => "Credenciais inválidas."], 401);
        }

        try{
            return UpdateUserDto::updateResponse(
                $this->userService->updateUser(
                    UpdateUserDto::createDto($request),
                    $id
                )
            );
        }catch (Exception $e){
            return response()->json(["Erro interno." =>  $e->getMessage()], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try{
            return response()->json($this->userService->deleteUser($id), 200);
        }catch (Exception $e){
            return response()->json(["error" => "Erro interno ao deletar dados."], 500);
        }
    }

    // Métodos para validar request
    private function createUserValidateRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|integer|exists:roles,id',
        ]);
    }

    private function editUserValidateRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role_id' => 'required|integer|exists:roles,id',
        ]);
    }
}
