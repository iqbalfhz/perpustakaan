<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil 5 kategori pertama
        $categoryIds = \App\Models\Category::inRandomOrder()->limit(5)->pluck('id')->toArray();
        if (empty($categoryIds)) {
            throw new \Exception('Tidak ada kategori yang tersedia. Jalankan CategorySeeder terlebih dahulu.');
        }
        // Buat 30 buku, assign kategori random dari 5 kategori
        Book::factory()->count(30)->make()->each(function ($book) use ($categoryIds) {
            $book->category_id = $categoryIds[array_rand($categoryIds)];
            $book->save();
        });
    }
}
