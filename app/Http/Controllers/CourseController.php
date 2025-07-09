<?php

namespace App\Http\Controllers;

use App\DTOs\CourseDto;
use App\Services\CourseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private CourseService $courseService;

    public function __construct()
    {
        $this->courseService = new CourseService();
    }

    public function index()
    {
        return $this->courseService->getAll();
    }

    public function store(Request $request)
    {
        $this->validateRequest($request, "CREATE");
        try {
            $courseDto = new CourseDto(
                $request->input('title'),
                $request->input('description')
            );
            return CourseDto::createResponse($this->courseService->create($courseDto, auth()->id()));
        }catch (Exception $e) {
            return response()->json(['Erro interno durante criação de curso.' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $this->validateRequest($request, "UPDATE");
        try {
            $courseDto = new CourseDto(
                $request->input('title'),
                $request->input('description'),
            );
            $return = $this->courseService->update($courseDto, $id, auth()->id());
            return ($return)
                ? response()->json(['Curso atualizado.'], 200)
                : response()->json("Erro durante atualização de curso", 500);
        }catch (Exception $e){
            return response()->json(['Erro durante atualização de curso.' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try{
            $this->courseService->delete($id, auth()->id());
            return response()->json(['Sucesso' => 'Curso deletado.']);
        }catch (Exception $e){
            return  response()->json(['Erro' => $e->getMessage()], 500);
        }
    }

    private function validateRequest(Request $request, string $typeValidate): JsonResponse|array
    {
        try {
            if($typeValidate === 'CREATE'){
                return $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                    'creator_id' => 'required|string'
                ]);
            }
            return $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status'  => 'required|string|max:255',
            ]);
        }catch (Exception $e){
            return response()->json(["Erro na requisição, verifique os dados." => $e->getMessage()], 500);
        }
    }
}
