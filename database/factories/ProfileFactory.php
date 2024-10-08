<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'status' => $this->faker->sentence,
            'bio' => $this->faker->sentence,
            'pronouns' => $this->faker->randomElement(['he/him', 'she/her', 'they/them']),
        ];
    }
}
