<?php

namespace App\WebsitePost\Entities;

use Illuminate\Database\Eloquent\Model;

class UserWebsite extends Model
{
    protected $fillable = [
        'user_id',
        'website_id'
    ];
}
