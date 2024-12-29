<?php

namespace Tests\Feature\Infrastructure\Tournaments\Repositories;

use App\Domain\Tournaments\Entities\Tournament;
use App\Infrastructure\Framework\Models\Tournament as TournamentDb;
use App\Infrastructure\Tournaments\Repositories\EloquentTournamentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentTournamentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTournament()
    {
        $repository = new EloquentTournamentRepository();

        $tournament = new Tournament(
            null,
            'Australia Open',
            'male'
        );

        $result = $repository->create($tournament);

        $this->assertDatabaseHas('tournaments', [
            'name' => $tournament->getName(),
            'type' => $tournament->getType(),
        ]);
    }

    public function testFindAllTournaments()
    {
        $repository = new EloquentTournamentRepository();

        TournamentDb::factory()->count(5)->create();

        $result = $repository->findWithFilters([]);

        $this->assertCount(5, $result);
    }
}
