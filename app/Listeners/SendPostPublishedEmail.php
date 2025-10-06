<?php

namespace App\Listeners;

use App\Events\PostPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use WebsitePost\Contracts\EmailServiceContract;
use Illuminate\Support\Facades\Cache;

class SendPostPublishedEmail implements ShouldQueue
{
    protected EmailServiceContract $emailService;

    public function __construct(EmailServiceContract $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        $post = $event->post;
        $post->loadMissing('website');

        $website = $event->post->website;

        if (!$website) {
            return;
        }

        // Cache the users for 60 seconds to avoid repeated DB queries
        $users = Cache::remember(
            "website_{$website->id}_users",
            60,
            fn() => $website->users()->get()
        );

        foreach ($users as $user) {
            // Only send email if user hasn't been emailed for this post
            if (!$post->emailedUsers()->where('user_id', $user->id)->exists()) {
                $this->emailService->send([
                    'to'   => $user->email,
                    'post' => $post,
                ]);

                // Track that the user has been emailed
                $post->emailedUsers()->attach($user->id);
            }
        }
    }
}
