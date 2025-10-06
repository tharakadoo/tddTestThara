<?php

namespace App\WebsitePost\UseCases;

use App\Mail\PostPublishedMail;
use App\WebsitePost\Entities\Post;
use App\WebsitePost\Entities\Website;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PostSubmitUseCase
{
    /**
     * Handle post submission.
     */
    public function execute(array $data): Post
    {
        if (empty($data['title'])) {
            throw ValidationException::withMessages([
                'title' => ['Title is required'],
            ]);
        }

        if (empty($data['content'])) {
            throw ValidationException::withMessages([
                'content' => ['Content is required'],
            ]);
        }

        $website = Website::findOrFail($data['website_id']);

        $post = isset($data['id'])
            ? Post::findOrFail($data['id'])
            : $website->posts()->create([
                'title'   => $data['title'],
                'content' => $data['content'],
            ]);

        foreach ($website->users as $user) {
            if (!$post->emailedUsers()->where('user_id', $user->id)->exists()) {
                Mail::to($user->email)->queue(new PostPublishedMail($post));
                $post->emailedUsers()->attach($user->id);
            }
        }

        return $post;

    }
}
