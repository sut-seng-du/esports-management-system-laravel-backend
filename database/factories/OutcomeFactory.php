<?php

namespace Database\Factories;

use App\Models\Outcome;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutcomeFactory extends Factory
{
    protected $model = Outcome::class;

    public function definition(): array
    {
        return [
            'description' => fake()->randomElement(['Electric bill', 'Internet subscription', 'Cleaning supplies', 'Repair work', 'Refreshments stock', 'Marketing']),
            'price' => fake()->numberBetween(5000, 200000),
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
