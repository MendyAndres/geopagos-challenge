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

    public function testSimulateTournamentWithValidPlayers(): void
    {
        // Crear un torneo de tipo 'male'
        $tournament = new Tournament(null, 'Torneo Maradona', 'male');

        // Crear jugadores
        $players = [
            new Player(1, 'Jugador 1', 80, 'male', 70, 60, null, null),
            new Player(2, 'Jugador 2', 75, 'male', 65, 55, null, null),
            new Player(3, 'Jugador 3', 85, 'male', 75, 65, null, null),
            new Player(4, 'Jugador 4', 90, 'male', 80, 70, null, null),
        ];

        // Crear un mock de ExecuteMatchService
        $matchServiceMock = Mockery::mock(ExecuteMatchService::class);

        // Definir expectativas para la primera ronda
        $matchServiceMock->shouldReceive('execute')
            ->with($players[0], $players[1], 'male')
            ->once()
            ->andReturn($players[0]); // Jugador 1 gana

        $matchServiceMock->shouldReceive('execute')
            ->with($players[2], $players[3], 'male')
            ->once()
            ->andReturn($players[3]); // Jugador 4 gana

        // Definir expectativas para la final
        $matchServiceMock->shouldReceive('execute')
            ->with($players[0], $players[3], 'male')
            ->once()
            ->andReturn($players[3]); // Jugador 4 gana la final

        // Instanciar ExecuteTournamentService con el mock
        $executeTournamentService = new ExecuteTournamentService($matchServiceMock);

        // Ejecutar la simulación
        $winner = $executeTournamentService->execute($players, $tournament);

        // Verificar que el campeón es Jugador 4
        $this->assertInstanceOf(Player::class, $winner);
        $this->assertEquals('Jugador 4', $winner->getName());
    }

    public function testSimulateTournamentWithInvalidNumberOfPlayers(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The number should be a power of two');

        // Crear un torneo de tipo 'female'
        $tournament = new Tournament(null, 'Torneo Invierno', 'female');

        // Crear 3 jugadores (no es potencia de 2)
        $players = [
            new Player(1, 'Jugador 1', 80, 'female', null, null, 60, null),
            new Player(2, 'Jugador 2', 75, 'female', null, null, 55, null),
            new Player(3, 'Jugador 3', 85, 'female', null, null, 65, null),
        ];

        // Crear un mock de ExecuteMatchService (no será usado)
        $matchServiceMock = Mockery::mock(ExecuteMatchService::class);

        // Instanciar ExecuteTournamentService con el mock
        $executeTournamentService = new ExecuteTournamentService($matchServiceMock);

        // Ejecutar la simulación, lo que debería lanzar una excepción
        $executeTournamentService->execute($players, $tournament);
    }

}
