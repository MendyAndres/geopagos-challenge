<?php
declare(strict_types=1);

namespace App\Application\Tournaments\UseCases;

use App\Application\Players\DTOs\PlayerDTO;
use App\Application\Tournaments\DTOs\PlayedTournamentDTO;
use App\Domain\Tournaments\Entities\Tournament;
use App\Domain\Tournaments\Repositories\TournamentRepositoryInterface;
use App\Domain\Tournaments\Services\ExecuteTournamentService;

final readonly class ExecuteTournamentUseCase
{
    public function __construct(private TournamentRepositoryInterface $tournamentRepository, private ExecuteTournamentService $executeTournamentService){}


    /**
     * Executes the tournament logic for the given players and tournament.
     *
     * @param array $players
     * @param Tournament $tournament
     * @return PlayedTournamentDTO
     */
    public function execute(array $players, Tournament $tournament): PlayedTournamentDTO
    {
        $winner = $this->executeTournamentService->execute($players, $tournament);

        $this->tournamentRepository->saveWinner($tournament->getId(), $winner->getId());
        return PlayedTournamentDTO::fromArray($tournament, PlayerDTO::fromPlayer($winner));
    }
}
