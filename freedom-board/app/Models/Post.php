<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'parent_id',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Loads direct replies; each reply lazy-loads its own replies recursively in the Blade template
    public function replies(): HasMany
    {
        return $this->hasMany(Post::class, 'parent_id')->with('user', 'replies');
    }
}
