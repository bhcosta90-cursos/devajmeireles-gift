<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\{User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Bruno Costa',
            'email'    => 'bhcosta90@gmail.com',
            'password' => '$2y$12$.Kzvtisda9P7qO/E7OX1/ebQPESPjYw9omBcmsjWlE7Oa63PeVJJS',
        ]);

        $this->call([
            CategorySeeder::class,
            ItemSeeder::class,
        ]);
    }
}
