<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::factory(10)->create();

        for ($i = 1; $i < 3; $i++) {
            User::factory()->create([
                'name' => 'User Test : ' . $i,
                'email' => 'test' . $i . '@example.com',
                'password' => bcrypt('password' . $i),
            ]);
        }
    }
}
