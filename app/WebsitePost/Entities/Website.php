<?php

namespace App\WebsitePost\Entities;

use Database\Factories\WebsitePost\WebsiteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_websites', 'website_id', 'user_id');
    }

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }
}
