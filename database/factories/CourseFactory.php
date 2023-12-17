<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Programme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the course model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'programme_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
