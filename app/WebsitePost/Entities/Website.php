<?php

namespace App\WebsitePost\Entities;

use Database\Factories\WebsitePost\WebsiteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'url'
    ];

    protected static function newFactory()
    {
        return WebsiteFactory::new();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_websites', 'website_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
