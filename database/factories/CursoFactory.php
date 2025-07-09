<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $palavras = ['Aprovado', 'Pendente', 'Rejeitado'];
        $sorteada = $palavras[array_rand($palavras)];
        return [
            'public_id' => Str::uuid(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'title'  => fake()->title(),
            'description' => fake()->text(),
            'status' => $sorteada,
        ];
    }
}
