<?php

namespace App\Services;

use App\Enums\CourseStatusEnum;
use App\Models\Course;

class AdminCourseService
{
    public function getAllCourses()
    {
        return Course::all();
    }

    public function getAllApproved() {
        return Course::where('status', CourseStatusEnum::Approved)->get();
    }

    public function getAllPending() {
        return Course::where('status', CourseStatusEnum::Pending)->get();
    }

    public function approve(Course $course) {
        return $course->update(['status' => CourseStatusEnum::Approved]);
    }

    public function reject(Course $course) {
        return $course->update(['status' => CourseStatusEnum::Rejected]);
    }
}
