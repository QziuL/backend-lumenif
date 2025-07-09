<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'creator_id' => $user->public_id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->label(),  // chamando metodo 'label()' do enum para apresentação dos dados
            'modules' => $this->modules->map(function ($module) {
                return [
                    'title' => $module->title,
                    'description' => $module->description,
                    'order' => $module->order,
                ];
            })->values()
        ];
    }
}
