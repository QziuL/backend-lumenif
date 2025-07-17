<?php

namespace App\Http\Resources;

use App\Models\Registration;
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
        $registrations = Registration::where('course_id', $this->id)->get();
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
}
