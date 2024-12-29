<?php
namespace Tests\Feature\Infrastructure\Framework\Controllers\Tournaments;

use App\Infrastructure\Framework\Models\Tournament as TournamentDb;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListTournamentsControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createTournaments(array $data): void
    {
        foreach ($data as $attributes) {
            TournamentDb::factory()->create($attributes);
        }
    }

    private function getJsonStructure(): array
    {
        return [
            'status',
            'data' => [
                '*' => ['id', 'name', 'type'],
            ]
        ];
    }

    public function testListTournamentsWithoutFilters(): void
    {
        $tournaments = [
            ['name' => 'Tournament 1', 'type' => 'male', 'created_at' => '2024-01-01 10:00:00'],
            ['name' => 'Tournament 2', 'type' => 'female', 'created_at' => '2024-02-15 12:00:00'],
            ['name' => 'Tournament 3', 'type' => 'male', 'created_at' => '2024-03-20 14:00:00'],
        ];
        $this->createTournaments($tournaments);

        $expectedArray = array_map(function($tournament) {
            unset($tournament['created_at']);
            return $tournament;
        }, $tournaments);

        $expectedData = [
            'data' => $expectedArray,
        ];

        $response = $this->getJson('/api/v1/tournaments');

        $response->assertStatus(200)
            ->assertJson($expectedData)
            ->assertJsonCount(count($tournaments), 'data')
            ->assertJsonStructure($this->getJsonStructure());
    }

    public function testListTournamentsWithGenderFilter(): void
    {
        $tournaments = [
            ['name' => 'Tournament 1', 'type' => 'male', 'created_at' => '2024-01-01 10:00:00'],
            ['name' => 'Tournament 2', 'type' => 'female', 'created_at' => '2024-02-15 12:00:00'],
            ['name' => 'Tournament 3', 'type' => 'female', 'created_at' => '2024-03-20 14:00:00'],
        ];
        $this->createTournaments($tournaments);

        $response = $this->getJson('/api/v1/tournaments?gender=female');

        $expectedData = [
            'status' => 'success',
            'data' => [
                ['id' => 2, 'name' => 'Tournament 2', 'type' => 'female'],
                ['id' => 3, 'name' => 'Tournament 3', 'type' => 'female'],
            ],
        ];

        $response->assertStatus(200)
            ->assertJson($expectedData)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure($this->getJsonStructure());
    }

    public function testListTournamentsWithDateFilters(): void
    {
        $tournaments = [
            ['name' => 'Tournament 1', 'type' => 'male', 'created_at' => '2023-12-25 10:00:00'],
            ['name' => 'Tournament 2', 'type' => 'female', 'created_at' => '2024-02-15 12:00:00'],
            ['name' => 'Tournament 3', 'type' => 'male', 'created_at' => '2024-06-20 14:00:00'],
            ['name' => 'Tournament 4', 'type' => 'female', 'created_at' => '2024-09-10 16:00:00'],
        ];
        $this->createTournaments($tournaments);

        $filters = [
            'from_date' => '2024-01-01',
            'to_date' => '2024-06-30',
        ];

        $response = $this->getJson('/api/v1/tournaments?' . http_build_query($filters));

        $expectedData = [
            'status' => 'success',
            'data' => [
                ['id' => 2, 'name' => 'Tournament 2', 'type' => 'female'],
                ['id' => 3, 'name' => 'Tournament 3', 'type' => 'male'],
            ],
        ];

        $response->assertStatus(200)
            ->assertJson($expectedData)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure($this->getJsonStructure());
    }
}
