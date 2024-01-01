<?php

namespace Database\Factories;

use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "image" => $this->faker->randomElement(["1.png", "2.png", "3.png", "4.png", "5.png"]),
            "name" => $this->faker->word(3),
            "duration" => $this->faker->numberBetween(20, 50),
            "date_start" => $this->faker->date(),
            "date_end" => $this->faker->date(),
            "quota" => $this->faker->numberBetween(10, 50),
            "whatsapp" => "https://api.whatsapp.com/send?phone=" . $this->faker->phoneNumber() . "&text=Hola,%20bienvenido",
            "teacher_id" => User::factory(),
            "responsible_id" => User::factory(),
            "template_id" => Template::factory(),
        ];
    }
}
