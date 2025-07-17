<?php

namespace App\Services;

use App\DTOs\CourseDto;
use App\Enums\CourseStatusEnum;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Registration;
use App\Models\User;
use Exception;

class CourseService
{
    public function getAll() {
        return CourseResource::collection(
            Course::with('modules')
                ->orderBy('created_at', 'desc')
                ->paginate(15)
        );
    }

    public function create(CourseDto $courseDto, int $authUserId)
    {
        return Course::create([
            'public_id' => uuid_create(),
            'title' => $courseDto->title,
            'description' => $courseDto->description,
            'status' => CourseStatusEnum::Pending,
            'creator_id' => $authUserId,
        ]);
    }

    public function getOneForCreateOrUpdate(string $public_id)
    {
        return Course::where('public_id', $public_id)->firstOrFail();
    }

    public function getOneForShow(string $public_id)
    {
        $course = Course::with('modules')->where('public_id',$public_id)->firstOrFail();
        $user = User::where('id', $course->creator_id)->first();
        $registrations = Registration::where('course_id', $course->id)->get();
        return [
            'public_id' => $course->public_id,
            'creator_id' => $user->public_id,
            'title' => $course->title,
            'description' => $course->description,
            'status' => $course->status->label(),  // chamando metodo 'label()' do enum para apresentação dos dados
            'modules' => $course->modules->map(function ($module) {
                return [
                    'title' => $module->title,
                    'public_id' => $module->public_id,
                    'description' => $module->description,
                    'order' => $module->order,
                    'lessons' => $module->classes->map(function ($class) {
                        return [
                            'id' => $class->public_id,
                            'title' => $class->title,
                        ];
                    })->values()
                ];
            })->values(),
            'students' => $registrations->map(function ($registration) {
                return [
                    'name' => $registration->user->name,
                    'email' => $registration->user->email,
                    'enrolled_at' =>  $registration->created_at->format('d/m/Y'),
                ];
            })->values()
        ];
    }

    public function update(CourseDto $courseDto, string $id, int $authUserId): bool
    {
        $course = $this->getOneForCreateOrUpdate($id);
        if($course &&  $course->creator_id === $authUserId)
        {
            $course->update([
                'title' => $courseDto->title,
                'description' => $courseDto->description,
            ]);
            return true;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function delete(string $public_id, int $authUserId): void
    {
        $course = $this->getOneForCreateOrUpdate($public_id);
        if(!$course || $course->creator_id !== $authUserId)
            throw new Exception("Acesso negado.");
        $course->delete();
    }


}
