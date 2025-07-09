<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classe extends Model
{
    use SoftDeletes;

    protected $table = 'classes';
    protected $fillable = [
        'public_id',
        'module_id',
        'content_type_id',
        'title',
        'description',
        'duration_seconds',
        'url_content',
        'text_content',
        'order'
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
    public function contentType(): BelongsTo
    {
        return $this->belongsTo(ContentType::class);
    }
}
