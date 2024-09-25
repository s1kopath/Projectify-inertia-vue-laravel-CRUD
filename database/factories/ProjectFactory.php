<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company,
            'description' => $this->faker->paragraph,
            'staff_id' => function () {
                return User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['active', 'inactive', 'hold']),
            'file_path' => $this->faker->optional()->filePath,
        ];
    }
}
