<?php

namespace App\WebsitePost\Entities;

use Illuminate\Database\Eloquent\Model;

class PostUserEmail extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
