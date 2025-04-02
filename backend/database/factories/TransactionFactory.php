<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'currency' => fake()->randomElement(['USD', 'EUR', 'GBP']),
            'amount' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}
