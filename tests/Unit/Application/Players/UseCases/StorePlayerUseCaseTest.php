<?php

namespace Tests\Unit\Application\Players\UseCases;

use App\Application\Players\UseCases\StorePlayerUseCase;
use App\Domain\Players\Entities\Player;
use App\Domain\Players\Repositories\PlayerRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class StorePlayerUseCaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testStorePlayerUseCase(): void
    {
        $playerEntitie = new Player(
            null,
            'Player 1',
            70,
            'male',
            50,
            60,
            null,
            1
        );

        $player = [
            "id" => null,
            "name" => 'Player 1',
            "skill_level" => 70,
            "gender" => 'male',
            "strength_level" => 50,
            "speed_level" => 60,
            "reaction_time" => null,
            "tournament_id" => 1
        ];

        $playerRepositoryMock = Mockery::mock(PlayerRepositoryInterface::class);
        $playerRepositoryMock->shouldReceive('create')
            ->once()
            ->with(Mockery::type(Player::class))
            ->andReturn([
                $player
            ]);

        $useCase = new StorePlayerUseCase($playerRepositoryMock);
        $result = $useCase->create($player);

        $this->assertIsArray($result);
        $this->assertEquals($player['name'], $result[0]['name']);
    }
}
