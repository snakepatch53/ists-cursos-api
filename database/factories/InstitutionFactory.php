<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institution>
 */
class InstitutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "initials" => $this->faker->randomElement(["UFRN", "IFRN", "UERN"]),
            "logo" => $this->faker->randomElement(["1.png", "2.png", "3.png", "4.png", "5.png"])
        ];
    }
}
