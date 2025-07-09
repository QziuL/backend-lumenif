<?php

namespace App\DTOs;

use App\Models\Classe;
use Illuminate\Http\Request;

readonly class ClasseDto
{

    public function __construct(
        public string $module_id,
        public string $content_type_id,
        public string $title,
        public ?int $duration_seconds = null,
        public ?string $url_content = null,
        public ?string $text_content = null,
        public int $order
    ){}

    public static function createDto(Request $request): self
    {
        return new self(
            module_id: $request->input('module_id'),
            content_type_id: $request->input('content_type_id'),
            title: $request->input('title'),
            duration_seconds: $request->input('duration_seconds'),
            url_content: $request->input('url_content'),
            text_content: $request->input('text_content'),
            order: $request->input('order'),
        );
    }

    public static function createResponse(Classe $model)
    {
        return response()->json([
            'public_id' => $model->public_id,
            'module_id' => $model->module->public_id,
            'content_type_id' => $model->content_type_id,
            'title' => $model->title,
            'order' => $model->order,
        ], 201);
    }

    public static function updateResponse(Classe $model)
    {
        return response()->json([
            'Registro atualizado.' => [
                'public_id' => $model->public_id,
                'module_id' => $model->module->public_id,
                'content_type_id' => $model->content_type_id,
                'title' => $model->title,
                'url_content' => $model->url_content,
                'duration_seconds' => $model->duration_seconds,
                'text_content' => $model->text_content,
                'order' => $model->order,
            ]
        ], 200);
    }
}
