<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inscription>
 */
class InscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "approval" => $this->faker->randomElement([true, false]),
            "certificate_code" => $this->faker->randomElement(),
            "student_id" => Student::factory(),
            "course_id" => Course::factory(),
        ];
    }
}
