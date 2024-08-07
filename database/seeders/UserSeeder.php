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
            'login' => 'admin',
            'role'  => UserRole::Admin,
        ] + $default);

        User::factory()->asRole(UserRole::User)->create([
            'login' => 'user',
            'role'  => UserRole::User,
        ] + $default);

        User::factory()->asRole(UserRole::Guest)->create([
            'login' => 'guest',
            'role'  => UserRole::Guest,
        ] + $default);
    }
}
