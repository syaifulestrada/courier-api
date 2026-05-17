<?php

namespace Database\Factories;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Courier>
 */
class CourierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'level' => random_int(1, 5),
            'address' => fake()->address(),
            'is_active' => (bool) random_int(0, 1),
            'registered_at' => fake()->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
