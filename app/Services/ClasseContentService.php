<?php

namespace App\Services;

use App\Models\ClasseContent;
use Illuminate\Database\Eloquent\Collection;

class ClasseContentService
{
    public function getAll(): Collection
    {
        return ClasseContent::all();
    }
}
