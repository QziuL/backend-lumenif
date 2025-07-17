<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminCourseResource;
use App\Models\Course;
use App\Services\AdminCourseService;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    private AdminCourseService $service;

    public function __construct()
    {
        $this->service = new AdminCourseService();
    }


    public function index()
    {
        return response()->json(AdminCourseResource::collection($this->service->getAllCourses()));
    }

    public function getAllApproved()
    {
        return response()->json($this->service->getAllApproved());
    }

    public function getAllPending()
    {
        return response()->json($this->service->getAllPending());
    }

    public function approve(Course $course)
    {
        return ($this->service->approve($course))
            ? response()->json(['message' => 'Course approved successfully'])
            : response()->json(['message' => 'Something went wrong'], 500);
    }

    public function reject(Course $course)
    {
        return ($this->service->reject($course))
            ? response()->json(['message' => 'Course reject successfully'])
            : response()->json(['message' => 'Something went wrong'], 500);
    }
}
