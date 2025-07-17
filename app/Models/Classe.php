<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classe extends Model
{
    use SoftDeletes;

    protected $table = 'classes';
    protected $fillable = [
        'public_id',
        'module_id',
        'title',
        'order'
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
    public function contents(): HasMany
    {
        return $this->hasMany(ClasseContent::class);
    }
}
