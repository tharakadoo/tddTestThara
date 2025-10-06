<?php

namespace Database\Factories\WebsitePost;

use App\WebsitePost\Entities\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteFactory extends Factory
{
    protected $model = Website::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->url
        ];
    }
}
