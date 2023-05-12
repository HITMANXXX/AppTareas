<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UsuariosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'email' => $this->faker->email,
            'telefono' => $this->faker->e164PhoneNumber,
            'tarea_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
