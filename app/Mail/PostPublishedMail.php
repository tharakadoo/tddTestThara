<?php

namespace App\Mail;

use App\WebsitePost\Entities\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostPublishedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->subject('New Post Published!')
            ->view('emails.post_published')
            ->with([
                'title'   => $this->post->title,
                'content' => $this->post->content,
            ]);
    }
}
