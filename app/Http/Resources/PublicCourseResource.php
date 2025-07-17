<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::where('id', $this->creator_id)->first();
        return [
            'public_id' => $this->public_id,
            'creator_name' => $user->name,
            'title' => $this->title,
            'description' => $this->description,
            'is_enrolled' => $this->is_enrolled,
            'modules' => $this->modules->map(function ($module) {
                return [
                    'title' => $module->title,
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
        ];
    }
}
