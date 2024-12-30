<?php

namespace Tests\Feature\Infrastructure\Framework\Controllers\Tournaments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExecuteTournamentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests the successful execution of a tournament with provided data.
     * Verifies that the response status is 200 and matches the expected JSON structure.
     * Asserts that the created tournament data is correctly stored in the database.
     */
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

    /**
     * Tests the execution of a tournament with an invalid number of players.
     * Confirms that the system returns a 400 status code with the appropriate error message.
     */
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
