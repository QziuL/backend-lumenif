<?php

namespace App\Services;

use App\DTOs\CourseDto;
use App\Enums\CursoStatusEnum;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\User;
use Exception;

class CourseService
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

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
            'status' => CursoStatusEnum::Pending,
            'creator_id' => $authUserId,
        ]);
    }

    public function getOne(string $public_id)
    {
        return Course::where('public_id', $public_id)->first();
    }

    public function update(CourseDto $courseDto, string $id, int $authUserId): bool
    {
        $course = $this->getOne($id);
        if($course &&  $course->creator_id === $authUserId)
        {
            $course->update([
                'title' => $courseDto->title,
                'description' => $courseDto->description,
                'status' => CursoStatusEnum::from($courseDto->status),
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
        $course = $this->getOne($public_id);
        if(!$course || $course->creator_id !== $authUserId)
            throw new Exception("Acesso negado.");
        $course->delete();
    }


}
