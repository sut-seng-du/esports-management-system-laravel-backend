<?php

namespace Database\Factories;

use App\Models\Record;
use App\Models\Seat;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecordFactory extends Factory
{
    protected $model = Record::class;

    public function definition(): array
    {
        $memberAmount = fake()->numberBetween(1000, 50000);
        $orderAmount = fake()->numberBetween(0, 20000);
        $total = $memberAmount + $orderAmount;
        $paid = fake()->boolean(80);
        $debt = $paid ? 0 : $total;

        return [
            'seat' => Seat::inRandomOrder()->first()?->code ?? fake()->bothify('??##'),
            'member_ID' => fake()->randomElement(['MEM' . fake()->numberBetween(100, 999), 'Guest']),
            'member_amount' => $memberAmount,
            'order' => fake()->sentence(),
            'order_amount' => $orderAmount,
            'total' => $total,
            'paid' => $paid,
            'online' => false,
            'debt' => $debt,
            'created_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'modified_date' => now(),
        ];
    }
}
