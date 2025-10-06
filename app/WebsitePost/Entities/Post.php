<?php

namespace App\WebsitePost\Entities;

use Database\Factories\WebsitePost\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function emailedUsers()
    {
        return $this->belongsToMany(User::class, 'post_user_emails', 'post_id', 'user_id');
    }
}
