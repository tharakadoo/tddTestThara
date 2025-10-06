<?php

namespace App\WebsitePost\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostUserEmail extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
