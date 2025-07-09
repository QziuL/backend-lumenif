<?php

namespace App\Services;

use App\Enums\CourseStatusEnum;
use App\Http\Resources\RegistrationResource;
use App\Models\Course;
use App\Models\Registration;
use Exception;
use Illuminate\Http\Request;

class RegistrationCourseService
{
    public function getAll() {
        return RegistrationResource::collection(
            Registration::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(15)
        );
    }

    /**
     * @throws Exception
     */
    public function create(Request $request, $authUserId){
        $course = Course::where('public_id', $request->input('course_id'))->first();

        if(!$course || $course->status != CourseStatusEnum::Approved)
            throw new Exception("Curso inexistente ou não aprovado.");
        return Registration::create([
            'public_id' => uuid_create(),
            'course_id' => $course->id,
            'user_id' => $authUserId,
        ]);
    }
}
