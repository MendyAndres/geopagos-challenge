<?php

namespace Tests\Feature\Infrastructure\Player\Repositories;

use App\Domain\Players\Entities\Player;
use App\Infrastructure\Framework\Models\Player as PlayerDb;
use App\Infrastructure\Framework\Models\Tournament;
use App\Infrastructure\Players\Repositories\EloquentPlayerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentPlayerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatePlayer()
    {
        $repository = new EloquentPlayerRepository();
        $tournament = Tournament::factory()->create();

        $player = new Player(
            null,
            'Test Player',
            85,
            'female',
            null,
            null,
            45,
            $tournament->id,
        );

        $result = $repository->create($player);

        $this->assertDatabaseHas('players', [
            'name' => 'Test Player',
            'skill_level' => 85,
            'gender' => 'female',
            'reaction_time' => 45,
        ]);
        $this->assertNotNull($result['id']);
    }

    public function testFindPlayerById()
    {
        $repository = new EloquentPlayerRepository();
        $player = PlayerDb::factory()->create();

        $result = $repository->findOneById($player->id);

        $this->assertEquals($player->name, $result['name']);
        $this->assertEquals($player->skill_level, $result['skill_level']);
    }
}
