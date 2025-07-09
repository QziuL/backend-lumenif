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

    public function classes(): HasMany {
        return $this->hasMany(Classe::class);
    }
}
