<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'public_id' => $this->public_id,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
            'course' => [
                'public_id' => $this->course->public_id,
                'title' => $this->course->title,
            ],
        ];
    }
}
