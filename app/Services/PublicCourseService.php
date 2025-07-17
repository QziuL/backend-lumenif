<?php

namespace App\Services;

use App\Enums\CourseStatusEnum;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class PublicCourseService
{
    public function getAllApproved() {
        return Course::with('modules')
            ->where('status', CourseStatusEnum::Approved)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function getOneApproved(string $public_id) {
        $course = Course::with('modules')
            ->where('public_id', $public_id)
            ->where('status', CourseStatusEnum::Approved)
            ->first();

        $course->load(['modules.classes' => function ($query) {
            $query->orderBy('order'); // Ordena as aulas
        }, 'modules' => function ($query) {
            $query->orderBy('order'); // Ordena os módulos
        }]);

        // == Lógica para verificar se usuário já se inscreveu no curso ==
        $isEnrolled = false;
        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
            $isEnrolled = $user->registrations()->where('course_id', $course->id)->exists();
        }

        $course->setAttribute('is_enrolled', $isEnrolled);

        return $course;
    }
}
