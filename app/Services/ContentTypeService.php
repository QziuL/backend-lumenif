<?php

namespace App\Services;

use App\Models\ContentType;
use Illuminate\Http\JsonResponse;

class ContentTypeService
{
    public function getAll(): JsonResponse
    {
        return response()->json(ContentType::all());
    }

}
