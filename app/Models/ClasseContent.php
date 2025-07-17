<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasseContent extends Model
{
    use SoftDeletes;

    protected $table = 'classe_contents';
    protected $fillable = [
        'public_id',
        'classe_id',
        'content_type_id',
        'content',
        'order',
    ];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function contentType(): BelongsTo
    {
        return $this->belongsTo(ContentType::class);
    }
}
