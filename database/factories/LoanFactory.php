<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Member;

// Ensure the Loan model exists and is imported
use App\Models\Loan;

class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $loaned = $this->faker->dateTimeBetween('-30 days', 'now');
        $due = (clone $loaned)->modify('+7 days');
        $status = $this->faker->randomElement(["requested","borrowed","returned","lost","damaged"]);
        return [
            'member_id' => Member::inRandomOrder()->first()?->id ?? Member::factory(),
            'book_id' => Book::inRandomOrder()->first()?->id ?? Book::factory(),
            'loaned_at' => $loaned->format('Y-m-d H:i:s'),
            'due_at' => $due->format('Y-m-d H:i:s'),
            'returned_at' => in_array($status, ['returned','lost','damaged']) ? $this->faker->dateTimeBetween($loaned, 'now')->format('Y-m-d H:i:s') : null,
            'status' => $status,
        ];
    }
}
