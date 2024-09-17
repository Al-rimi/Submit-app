<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = \App\Models\Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_id' => $this->faker->unique()->numerify('##########'),
            'student_name' => $this->faker->name(),
            'submit_count' => 0, // Initially, students haven't submitted anything
        ];
    }
}
