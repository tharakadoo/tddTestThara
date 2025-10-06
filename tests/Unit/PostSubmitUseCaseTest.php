<?php

namespace Tests\Unit;

use App\Mail\PostPublishedMail;
use App\WebsitePost\Entities\User;
use Tests\TestCase;
use App\WebsitePost\Entities\Post;
use App\WebsitePost\Entities\Website;
use App\WebsitePost\UseCases\PostSubmitUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PostSubmitUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_post_using_factory_data(): void
    {
        Mail::fake();

        $useCase = new PostSubmitUseCase();

        $website = Website::factory()->create();

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();
        $user_3 = User::factory()->create();
        $user_4 = User::factory()->create();

        $website->users()->attach([
            $user_2->id,
            $user_3->id
        ]);

        $post = $website->posts()->create(
            Post::factory()->make()->toArray()
        );

        $created = $useCase->execute($post->toArray());

        $this->assertInstanceOf(Post::class, $created);
        $this->assertEquals($website->id, $created->website_id);

        $emailService = app(\WebsitePost\Contracts\EmailServiceContract::class);

        $users = Cache::remember("website_{$website->id}_users", 60, function () use ($website) {
            return $website->users()->get();
        });

        foreach ($users as $user) {
            $emailService->send([
                'to' => $user->email,
                'post' => $post,
            ]);
        }

        if ($user_2 && $user_2->email) {
            Mail::assertQueued(PostPublishedMail::class, function ($mail) use ($user_2) {
                return $mail->hasTo($user_2->email);
            });
        }

        if ($user_3 && $user_3->email) {
            Mail::assertQueued(PostPublishedMail::class, function ($mail) use ($user_3) {
                return $mail->hasTo($user_3->email);
            });
        }

        if ($user_4 && $user_4->email) {
            Mail::assertNotQueued(PostPublishedMail::class, function ($mail) use ($user_4) {
                return $mail->hasTo($user_4->email);
            });
        }


    }

    public function test_post_cannot_be_submitted_without_title(): void
    {
        $useCase = new PostSubmitUseCase();

        $postData = [
            'title' => '',
            'content' => 'Some content'
        ];

        $this->expectException(ValidationException ::class);

        $useCase->execute($postData);
    }

    public function test_post_cannot_be_submitted_without_content(): void
    {
        $useCase = new PostSubmitUseCase();

        $postData = [
            'title' => 'Some Title',
            'content' => ''
        ];

        $this->expectException(ValidationException::class);

        $useCase->execute($postData);
    }

    public function test_email_is_not_sent_twice_to_same_user_for_same_post(): void
    {
        Mail::fake();

        $website = Website::factory()->create();
        $user = User::factory()->create();
        $website->users()->attach($user->id);

        $post = Post::factory()->create(['website_id' => $website->id]);
        $useCase = new PostSubmitUseCase();

        // First send
        $useCase->execute($post->toArray());

        // Simulate trying to send again
        $useCase->execute(array_merge($post->toArray(), ['id' => $post->id]));

        // Assert only one email queued for the user
        Mail::assertQueued(PostPublishedMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $this->assertCount(1, Mail::queued(PostPublishedMail::class));
    }
}
