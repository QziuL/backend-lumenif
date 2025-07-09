<?php

namespace App\Http\Controllers;

use App\DTOs\ModuleDto;
use App\Services\ModuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ModuleController extends Controller
{
    private ModuleService $moduleService;

    public function __construct()
    {
        $this->moduleService = new ModuleService();
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->moduleService->getAll();
    }

    public function store(Request $request): JsonResponse
    {
        try{
            $this->validateRequestCreate($request);
        }catch (Exception $e){
            return response()->json(['Erro de validação.' => $e->getMessage()], 400);
        }

        try {
            return ModuleDto::createResponse($this->moduleService->create(ModuleDto::createDto($request), auth()->id()));
        }catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse|Exception
    {
        try{
            $this->validateRequestUpdate($request);
        }catch (Exception $e){
            return response()->json(['Erro de validação.' => $e->getMessage()], 400);
        }

        try{
            $return = $this->moduleService->update($request, $id);

            return ($return)
                ? response()->json($return)
                : response()->json(['Error' => 'Verifique o ID e tente novamente.'], 500);
        }catch(Exception $e){
            return response()->json(['Erro interno durante a atualização de Módulo.' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->moduleService->delete($id);
            return response()->json("Módulo deletado com sucesso");
        } catch (Exception $e) {
            return response()->json(['error' => 'Verifique o ID.'], 500);
        }
    }

    private function validateRequestCreate(Request $request): void
    {
        $request->validate([
            'course_id' => 'required|exists:courses,public_id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer|unique:modules,order',
        ]);
    }

    private function validateRequestUpdate(Request $request): void
    {
        $request->validate([
            'public_id' => 'required|exists:modules,public_id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer',
        ]);
    }
}
