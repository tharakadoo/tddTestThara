<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\WebsitePost\Entities\Post as EntitiesPost;

class PostPublished
{
    use Dispatchable, SerializesModels;

    public EntitiesPost $post;

    /**
     * Create a new event instance.
     */
    public function __construct(EntitiesPost $post)
    {
        $this->post = $post;
    }
}
