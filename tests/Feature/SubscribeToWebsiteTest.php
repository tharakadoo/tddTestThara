<?php

namespace Tests\Feature;

use App\WebsitePost\Entities\User;
use App\WebsitePost\Entities\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeToWebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_be_attached_to_website(): void
    {
        $website = Website::factory()->create();

        // Create users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Call endpoint
        $response = $this->postJson("/api/websites/users", [
            'user_ids' => [$user1->id, $user2->id],
            'website'  => $website->id
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Users subscribed successfully',
            ]);

        // Assert users are attached
        $this->assertTrue($website->users()->where('user_id', $user1->id)->exists());
        $this->assertTrue($website->users()->where('user_id', $user2->id)->exists());
    }

    public function test_it_returns_a_list_of_websites(): void
    {
        Website::factory()->create(['url' => 'example.com']);
        Website::factory()->create(['url' => 'another-site.org']);

        $response = $this->getJson('/api/websites');

        // Assert: Status and structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'url'],
            ])
            ->assertJsonFragment(['url' => 'example.com']);
    }

    public function test_it_returns_empty_array_when_no_websites_exist(): void
    {
        Website::query()->delete();

        $response = $this->getJson('/api/websites');

        $response->assertStatus(200)
            ->assertExactJson([]);
    }

    public function test_it_returns_a_list_of_users(): void
    {
        User::query()->delete();

        User::factory()->create();
        User::factory()->create();

        $response = $this->getJson('/api/users');

        // Assert: Status and structure
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonStructure([
                '*' => ['id', 'email'],
            ]);
    }


}
