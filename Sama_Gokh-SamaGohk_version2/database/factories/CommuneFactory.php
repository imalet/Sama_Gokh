<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commune>
 */
class CommuneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'nom'=>fake()->name(),
        'nombreCitoyen' => fake()->numberBetween(1, 5000),
        'image'=>'imagepath',
        'ville_id'=>rand(1,5), 
        ];
    }
}

