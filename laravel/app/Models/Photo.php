<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'photos';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $perPage = 9;

    protected $fillable = [
        'id',
        'user_id',
        'filename',
    ];

    protected $appends = [
        'url',
    ];

    protected $visible = [
        'id',
        'owner',
        'url',
        'comments',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)
            ->orderBy('id', 'desc');
    }

    public function getUrlAttribute(): string
    {
        return Storage::cloud()->url($this->attributes['filename']);
    }
}
