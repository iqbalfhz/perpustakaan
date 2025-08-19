<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
    // Generate 5 random categories using the factory
    Category::factory()->count(5)->create();
    }
}
