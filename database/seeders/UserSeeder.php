<?php

namespace Database\Seeders;

use App\WebsitePost\Entities\User;
use App\WebsitePost\Entities\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    foreach (range(1, 5) as $id) {
        User::factory()->create(['id' => $id]);
    }
}
}
