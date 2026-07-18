<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->optional()->paragraph(),
            'due_at' => fake()->dateTimeBetween('+1 day', '+1 month'),
            'is_completed' => false,
            'user_id' => User::factory(),
        ];
    }
}
