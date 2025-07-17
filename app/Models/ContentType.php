<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentType extends Model
{
    use SoftDeletes;

    protected $table = 'content_types';
    protected $fillable = ['name'];

    public function contents(): HasMany {
        return $this->hasMany(ClasseContent::class, 'content_type_id');
    }
}
