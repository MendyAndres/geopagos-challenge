<?php

namespace Database\Factories;

use App\Infrastructure\Framework\Models\Player;
use App\Infrastructure\Framework\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Framework\Models\Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'gender' => 'female',
            'skill_level' => $this->faker->numberBetween(1, 100),
            'strength_level' => null,
            'speed_level' => null,
            'reaction_time' => $this->faker->numberBetween(1, 100),
            'tournament_id' => Tournament::factory()->create()->id,
        ];
    }
}
