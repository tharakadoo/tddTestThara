<?php

namespace App\WebsitePost\Entities;

use Database\Factories\WebsitePost\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'email'
    ];

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
