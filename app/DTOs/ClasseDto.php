<?php

namespace App\DTOs;

use App\Models\Classe;
use App\Models\ContentType;
use Illuminate\Http\Request;

readonly class ClasseDto
{

    public function __construct(
        public string $module_id,
        public int $content_type_id,
        public string $title,
        public int $order,
        public string $url_content,
        public string $text_content,
        public string $file_path,
        public string $original_file_name,
    ){}

    public static function createDto(Request $request): self
    {
        return new self(
            module_id: $request->input('module_id'),
            content_type_id: $request->input('content_type_id'),
            title: $request->input('title'),
            order: $request->input('order'),
            url_content: $request->input('url_content'),
            text_content: $request->input('text_content'),
            file_path: $request->input('file_path'),
            original_file_name: $request->input('original_file_name'),
        );
    }

    public static function createResponse(Classe $model)
    {
        return response()->json([
            'message' => 'Aula criada com sucesso!',
            'data' => [
                'public_id' => $model->public_id,
                'title' => $model->title,
                'order' => $model->order,
            ]
        ], 201);
    }

    public static function updateResponse(Classe $model)
    {
        return response()->json([
            'Aula atualizada.' => [
                'public_id' => $model->public_id,
                'title' => $model->title,
                'order' => $model->order,
            ]
        ]);
    }
}
