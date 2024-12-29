<?php

namespace Tests\Unit\Application\Tournaments\UseCases;

use App\Application\Tournaments\DTOs\PlayedTournamentDTO;
use App\Application\Tournaments\UseCases\ExecuteTournamentUseCase;
use App\Domain\Players\Entities\Player;
use App\Domain\Tournaments\Entities\Tournament;
use App\Domain\Tournaments\Repositories\TournamentRepositoryInterface;
use App\Domain\Tournaments\Services\ExecuteTournamentService;
use Mockery;
use PHPUnit\Framework\TestCase;

class ExecuteTournamentCaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testExecuteCallsDependenciesCorrectly()
    {
        $players = [
            new Player(1, 'Player 1', 70, 'male', 50, 60, null, 1),
            new Player(2, 'Player 2', 75, 'male', 45, 55, null, 1),
        ];

        $tournament = new Tournament(1, 'Argentina Open', 'male');

        $tournamentRepositoryMock = Mockery::mock(TournamentRepositoryInterface::class);
        $executeTournamentServiceMock = Mockery::mock(ExecuteTournamentService::class);

        $executeTournamentServiceMock->shouldReceive('execute')
            ->once()
            ->with($players, $tournament)
            ->andReturn($players[1]); // Jugador 2 gana

        $tournamentRepositoryMock->shouldReceive('saveWinner')
            ->once()
            ->with($tournament->getId(), $players[1]->getId());

        $useCase = new ExecuteTournamentUseCase($tournamentRepositoryMock, $executeTournamentServiceMock);

        $result = $useCase->execute($players, $tournament);

        $this->assertInstanceOf(PlayedTournamentDTO::class, $result);
        $this->assertEquals($players[1]->getName(), $result->winner->name);
    }
}
