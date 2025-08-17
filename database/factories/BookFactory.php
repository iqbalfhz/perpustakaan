<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Category;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'isbn' => $this->faker->unique()->regexify('[A-Za-z0-9]{13}'),
            'code' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'title' => $this->faker->sentence(4),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'year' => $this->faker->year(),
            'stock' => $this->faker->numberBetween(0, 100),
            'replacement_cost' => $this->faker->randomFloat(2, 10000, 99999999.99),
        ];
    }
}
