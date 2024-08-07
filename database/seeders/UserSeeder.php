<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $default = [
            'name'     => 'Bruno Costa',
            'password' => '$2y$12$.Kzvtisda9P7qO/E7OX1/ebQPESPjYw9omBcmsjWlE7Oa63PeVJJS',
        ];

        User::factory()->asRole(UserRole::Admin)->create([
            'email' => 'bhcosta90@gmail.com',
            'role'  => UserRole::Admin,
        ] + $default);

        User::factory()->asRole(UserRole::User)->create([
            'email' => 'bhcosta90-user@gmail.com',
            'role'  => UserRole::User,
        ] + $default);

        User::factory()->asRole(UserRole::Guest)->create([
            'email' => 'bhcosta90-guest@gmail.com',
            'role'  => UserRole::Guest,
        ] + $default);
    }
}
