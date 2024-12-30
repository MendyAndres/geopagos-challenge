<?php

namespace Tests\Unit\Domain\Tournaments\Services;

use App\Domain\Players\Entities\Player;
use App\Domain\Tournaments\Entities\Tournament;
use App\Domain\Tournaments\Services\ExecuteTournamentService;
use App\Domain\Tournaments\Services\ExecuteMatchService;
use Mockery;
use PHPUnit\Framework\TestCase;

class ExecuteTournamentServicesTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Tests the simulation of a tournament with valid players and ensures
     * the correct winner is determined in multiple match rounds.
     *
     * - Creates a tournament of type 'male'.
     * - Mocks the ExecuteMatchService to define expected match results.
     * - Simulates matches between players in two rounds (including final).
     * - Validates the winner of the tournament is correct.
     */
    public function testSimulateTournamentWithValidPlayers(): void
    {
        $tournament = new Tournament(null, 'Torneo Maradona', 'male');

        $players = [
            new Player(1, 'Jugador 1', 80, 'male', 70, 60, null, null),
            new Player(2, 'Jugador 2', 75, 'male', 65, 55, null, null),
            new Player(3, 'Jugador 3', 85, 'male', 75, 65, null, null),
            new Player(4, 'Jugador 4', 90, 'male', 80, 70, null, null),
        ];

        $matchServiceMock = Mockery::mock(ExecuteMatchService::class);

        $matchServiceMock->shouldReceive('execute')
            ->with($players[0], $players[1], 'male')
            ->once()
            ->andReturn($players[0]); // Jugador 1 gana

        $matchServiceMock->shouldReceive('execute')
            ->with($players[2], $players[3], 'male')
            ->once()
            ->andReturn($players[3]); // Jugador 4 gana

        $matchServiceMock->shouldReceive('execute')
            ->with($players[0], $players[3], 'male')
            ->once()
            ->andReturn($players[3]); // Jugador 4 gana la final

        $executeTournamentService = new ExecuteTournamentService($matchServiceMock);

        $winner = $executeTournamentService->execute($players, $tournament);

        $this->assertInstanceOf(Player::class, $winner);
        $this->assertEquals('Jugador 4', $winner->getName());
    }

    /**
     * Tests the simulation of a tournament with an invalid number of players.
     *
     * This test ensures that when the number of players is not a power of two,
     * an InvalidArgumentException is thrown. It creates a 'female' tournament
     * with an invalid set of players and uses a mocked ExecuteMatchService for
     * the simulation. Execution should trigger the exception.
     *
     * @throws \InvalidArgumentException if the number of players is invalid.
     */
    public function testSimulateTournamentWithInvalidNumberOfPlayers(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The number should be a power of two');

        $tournament = new Tournament(null, 'Torneo Invierno', 'female');

        $players = [
            new Player(1, 'Jugador 1', 80, 'female', null, null, 60, null),
            new Player(2, 'Jugador 2', 75, 'female', null, null, 55, null),
            new Player(3, 'Jugador 3', 85, 'female', null, null, 65, null),
        ];

        $matchServiceMock = Mockery::mock(ExecuteMatchService::class);

        $executeTournamentService = new ExecuteTournamentService($matchServiceMock);

        $executeTournamentService->execute($players, $tournament);
    }

}
