<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Fine;
use App\Models\Loan;

class FineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fine::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'loan_id' => Loan::factory(),
            'type' => fake()->randomElement(["late","lost","damaged"]),
            'amount' => fake()->randomFloat(2, 0, 99999999.99),
            'paid_at' => fake()->dateTime(),
            'notes' => fake()->text(),
        ];
    }
}
