<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
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
            "description" => $this->faker->sentence()
        ];
    }
}
