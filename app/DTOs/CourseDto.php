<?php

namespace App\DTOs;

use App\Models\Course;
use Illuminate\Http\Request;
readonly class CourseDto
{

    public function __construct
    (
        public string $title,
        public string $description,
    )
    {}

    public static function createResponse(Course $model)
    {
        return response()->json([
            'public_id' => $model->public_id,
            'creator_id' => $model->public_id,
            'title' => $model->title,
            'description' => $model->description,
            'status' => $model->status->label(),  // chamando metodo 'label()' do enum para apresentação dos dados
            'modules' => $model->modules->map(function ($module) {
                return [
                    'title' => $module->title,
                    'description' => $module->description,
                    'order' => $module->order,
                ];
            })->values()
        ]);
    }
}
