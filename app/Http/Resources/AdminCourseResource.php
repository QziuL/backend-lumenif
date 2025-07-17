<?php

namespace App\Http\Resources;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminCourseResource extends JsonResource
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
            'creator' => $user->name,
            'title' => $this->title,
            'status' => $this->status->label(),
        ];
    }
}
