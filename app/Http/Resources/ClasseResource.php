<?php

namespace App\Http\Resources;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClasseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        $module = Module::where('id', $request->module_id)->first();
        return [
            'public_id' => $this->public_id,
            'module_id' => $this->module->public_id,
            'content_type' => $this->content_type_id,
            'title' => $this->title,
            'duration_seconds' => $this->duration_seconds,
            'url_content' => $this->url_content,
            'text_content' => $this->text_content,
            'order' => $this->order
        ];
    }
}
