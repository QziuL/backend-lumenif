<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicCourseResource;
use App\Models\Course;
use App\Services\RegistrationCourseService;
use Exception;

class RegistrationCourseController extends Controller
{
    private RegistrationCourseService $service;

    public function __construct()
    {
        $this->service = new RegistrationCourseService();
    }


    public function index() {
        return response()->json($this->service->getAll());
    }

    public function store(Course $course) {
//        try{
//            $request->validate([
//                'course_id'=>'required|exists:courses,public_id',
//            ]);
//        }catch (Exception $e) {
//            return response()->json(["Requisição inválida."=>$e->getMessage()],500);
//        }

        try{
            return response()->json($this->service->create($course, auth()->id()), 201);
        }catch (Exception $e){
            return response()->json(["Erro ao se inscrever" => $e->getMessage()],500);
        }

    }
    public function show(Course $course){
        return response()->json(new PublicCourseResource($course), 200);
    }
    public function update(){}
    public function destroy(){}
}
