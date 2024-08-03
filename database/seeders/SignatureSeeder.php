<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\{Item, Signature};
use DB;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SignatureSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(fn () => Signature::factory(30)
            ->sequence(fn (Sequence $sequence) => [
                'item_id'    => Item::factory()->create(['name' => "Signature: " . $sequence->index]),
                'created_at' => now()->format('Y-m-d H:i:s'),
            ])
            ->create());
    }
}
