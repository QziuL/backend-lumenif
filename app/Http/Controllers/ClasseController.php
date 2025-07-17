<?php

namespace App\Http\Controllers;

use App\DTOs\ClasseDto;
use App\Services\ClasseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClasseController extends Controller
{
    private ClasseService $classeService;

    public function __construct()
    {
        $this->classeService = new ClasseService();
    }


    public function index(): AnonymousResourceCollection
    {
        return $this->classeService->getAll();
    }

    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request, "CREATE");

        try{
            $result = $this->classeService->create($request);
            return response()->json([
                'message' => 'Sucesso ao criar Aula!',
                'data' => $result
            ], 201);
        }catch (Exception $e){
            return response()->json(['Erro interno durante criação de Aula.' => $e->getMessage()], 500);
        }

//        try {
//            return ClasseDto::createResponse(
//                $this->classeService->create(ClasseDto::createDto($request), auth()->id())
//            );
//        }catch (Exception $e) {
//            return response()->json(['Erro interno durante criação de Aula.' => $e->getMessage()], 500);
//        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            return response()->json(ClasseDto::createResponse($this->classeService->getOne($id)));
        }catch (Exception $e) {
            return response()->json(['Error ao buscar registro.' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $this->validateRequest($request, "UPDATE");
        try{
            $return  = $this->classeService->update($request, $id);
            return ($return)
                ? ClasseDto::updateResponse($return)
                : response()->json(['Error' => 'Verifique o ID e tente novamente.'], 500);
        }catch (Exception $e) {
            return response()->json(['Erro interno durante a atualização de Aula.' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->classeService->delete($id);
            return response()->json("Registro deletado com sucesso.");
        } catch (Exception $e) {
            return response()->json(['Error' => 'Verifique o ID.'], 500);
        }
    }

    private function validateRequest(Request $request, string $type): void
    {
        try {
            if($type === "CREATE")
            {
                $request->validate([
                    'module_id' => 'required|exists:modules,public_id',
                    'content_type_id' => 'required|exists:content_types,id',
                    'title' => 'required|string|max:255',
                    'order' => 'required|integer',
                    'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:10240',
                    'url_content' => 'nullable|string',
                    'text_content' => 'nullable|string',
                    'original_file_name'  => 'nullable|string',
                ]);
            }else{
                $request->validate([
                    'content_type_id' => 'required|exists:content_types,id',
                    'title' => 'required|string|max:255',
                    'order' => 'required|integer',
                ]);
            }
        }catch (Exception $e) {
            response()->json(['Validation Error.' => $e->getMessage()], 500);
            return;
        }

    }
}
