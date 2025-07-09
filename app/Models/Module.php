<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $table = 'modules';

    protected $fillable = [
        'public_id',
        'course_id',
        'title',
        'description',
        'order'
    ];

    public function course(): BelongsTo {
        return $this->belongsTo(Course::class);
    }

    public function classes(): HasMany {
        return $this->hasMany(Classe::class);
    }
}
