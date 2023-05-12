<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TareasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->text(30),
            'descripcion' => $this->faker->text(200),
        ];
    }
}
