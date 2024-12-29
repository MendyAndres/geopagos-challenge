<?php

namespace Database\Factories;

use App\Infrastructure\Framework\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Framework\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    protected $model = Tournament::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Torneo de Prueba',
            'type' => 'female',
        ];
    }
}
