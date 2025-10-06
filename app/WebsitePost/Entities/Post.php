<?php

namespace App\WebsitePost\Entities;

use Database\Factories\WebsitePost\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'title',
        'content'
    ];

    protected static function newFactory()
    {
        return PostFactory ::new();
    }

    public function emailedUsers() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_user_emails', 'post_id', 'user_id');
    }

    public function website() : BelongsTo
    {
        return $this->belongsTo(Website::class);
    }


}
