<?php

namespace App\Application\Tournaments\UseCases;

use App\Application\Players\UseCases\GetPlayerByIdUseCase;
use App\Application\Tournaments\DTOs\PlayedTournamentDTO;
use App\Domain\Players\Repositories\PlayerRepositoryInterface;
use App\Domain\Tournaments\Entities\Tournament;
use App\Domain\Tournaments\Repositories\TournamentRepositoryInterface;

final readonly class GetTournamentByIdUseCase
{
    public function __construct(private TournamentRepositoryInterface $tournamentRepository, private GetPlayerByIdUseCase $getPlayerByIdUseCase){}

    /**
     * Executes the process of retrieving a tournament by its ID, transforming it into a Tournament entity,
     * and fetching data of the winning player, then returning a PlayedTournamentDTO.
     *
     * @param int $tournamentId
     * @return PlayedTournamentDTO
     */
    public function execute(int $tournamentId): PlayedTournamentDTO
    {
        $responseTournament = $this->tournamentRepository->findOneById($tournamentId);

        $tournament = new Tournament(
            $responseTournament['id'],
            $responseTournament['name'],
            $responseTournament['type'],
            $responseTournament['winner_id'],
        );

        $playerDTO = $this->getPlayerByIdUseCase->execute($tournament->getWinner());

        return PlayedTournamentDTO::fromArray($tournament, $playerDTO);
    }
}
