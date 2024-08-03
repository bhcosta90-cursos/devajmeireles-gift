<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = Category::factory(5)->make();
        Category::insert($categories->toArray());
    }
}
