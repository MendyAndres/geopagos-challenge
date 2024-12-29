<?php

namespace Tests\Feature\Infrastructure\Framework\Controllers\Tournaments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExecuteTournamentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testExecuteTournamentSuccess(): void
    {
        $payload = [
            'tournament' => [
                'name' => 'Championship',
                'type' => 'male',
            ],
            'players' => [
                [
                    'name' => 'Player One',
                    'skill_level' => 80,
                    'gender' => 'male',
                    'strength_level' => 70,
                    'speed_level' => 60,
                ],
                [
                    'name' => 'Player Two',
                    'skill_level' => 75,
                    'gender' => 'male',
                    'strength_level' => 65,
                    'speed_level' => 55,
                ],
                [
                    'name' => 'Player Three',
                    'skill_level' => 85,
                    'gender' => 'male',
                    'strength_level' => 80,
                    'speed_level' => 70,
                ],
                [
                    'name' => 'Player Four',
                    'skill_level' => 78,
                    'gender' => 'male',
                    'strength_level' => 68,
                    'speed_level' => 60,
                ],
            ],
        ];

        $response = $this->postJson('/api/v1/tournaments/execute', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'winner' => [
                        'id',
                        'name',
                        'skill_level',
                        'gender',
                        'strength_level',
                        'speed_level',
                        'reaction_time',
                        'tournament_id',
                    ],
                ]
            ]);

        $this->assertDatabaseHas('tournaments', [
            'name' => 'Championship',
            'type' => 'male',
        ]);
    }

    public function testExecuteTournamentInvalidNumberOfPlayers(): void
    {
        $payload = [
            'tournament' => [
                'name' => 'Invalid Championship',
                'type' => 'female',
            ],
            'players' => [
                [
                    'name' => 'Player 1',
                    'skill_level' => 80,
                    'gender' => 'female',
                    'reaction_time' => 50,
                ],
            ],
        ];

        $response = $this->postJson('/api/v1/tournaments/execute', $payload);

        $response->assertStatus(400)
            ->assertJson([
                'error' => 'The number should be a power of two',
            ]);
    }
}
