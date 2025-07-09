<?php

namespace App\DTOs;

use App\Models\Module;
use Illuminate\Http\Request;

readonly class ModuleDto
{
    public function __construct
    (
        public string $course_id,
        public string $title,
        public string $description,
        public int $order,
    ) {}

    public static function createDto(Request $request): self
    {
        return new self(
            course_id: $request->input('course_id'),
            title: $request->input('title'),
            description: $request->input('description'),
            order: $request->input('order'),
        );
    }

    public static function createResponse(Module $model)
    {
        return response()->json([
            'public_id' => $model->public_id,
            'course_id' => $model->course->public_id,
            'title' => $model->title,
            'description' => $model->description,
            'order' => $model->order,
        ], 201);
    }
}
