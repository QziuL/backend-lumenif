<?php

namespace App\Models;

use App\Enums\CourseStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = "courses";

    protected $casts = [
        'status' => CourseStatusEnum::class,
    ];

    protected $fillable = [
        'public_id',
        'creator_id',
        'title',
        'description',
        'status',
    ];

    // relação com usuário criador
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function modules(): HasMany {
        return $this->hasMany(Module::class);
    }

    public function registrations(): HasMany {
        return $this->hasMany(Registration::class);
    }
}
