<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "dni" => $this->faker->randomNumber(8),
            "name" => $this->faker->name(),
            "lastname" => $this->faker->lastName(),
            "sex" => $this->faker->randomElement(Student::$_SEXS),
            "instruction" => $this->faker->randomElement(Student::$_INSTRUCTIONS),
            "address" => $this->faker->address(),
            "email" => $this->faker->safeEmail(),
            "cellphone" => $this->faker->phoneNumber(),
            "phone" => $this->faker->phoneNumber(),
            "description" => $this->faker->sentence(),
            "entity_name" => $this->faker->name(),
            "entity_post" => $this->faker->postcode(),
            "entity_address" => $this->faker->address(),
            "entity_phone" => $this->faker->phoneNumber()
        ];
    }
}
