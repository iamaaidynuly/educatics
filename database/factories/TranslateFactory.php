<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Translate>
 */
class TranslateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ru'    =>  $this->faker->text(15),
            'kz'    =>  $this->faker->text(15),
            'en'    =>  $this->faker->text(15),
        ];
    }
}
