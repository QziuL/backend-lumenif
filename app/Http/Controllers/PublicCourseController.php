<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicCourseResource;
use App\Models\Course;
use App\Services\PublicCourseService;
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{
    private PublicCourseService $service;

    public function __construct()
    {
        $this->service = new PublicCourseService();
    }


    public function index()
    {
        return response()->json(PublicCourseResource::collection($this->service->getAllApproved()));
    }

    public function show(string $public_id)
    {
//        if ($course->status !== 'Aprovado')
//            abort(404);
        return response()->json(new PublicCourseResource($this->service->getOneApproved($public_id)));
    }

}
