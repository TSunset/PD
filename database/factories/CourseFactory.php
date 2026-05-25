<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(3),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(20000, 60000),
            'duration' => fake()->numberBetween(8, 32).' академических часов',
            'is_active' => true,
        ];
    }
}
