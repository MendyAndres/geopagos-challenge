<?php
declare(strict_types=1);

namespace  App\Application\Tournaments\UseCases;

use App\Application\Tournaments\DTOs\TournamentDTO;
use App\Domain\Tournaments\Entities\Tournament;
use App\Domain\Tournaments\Repositories\TournamentRepositoryInterface;

final readonly class GetTournamentsUseCase
{
    public function __construct(private TournamentRepositoryInterface $tournamentRepository){}

    /**
     * Executes a query to find tournaments based on the provided filters.
     *
     * @param array $filters
     * @return array
     */
    public function execute(array $filters): array
    {
        $response = $this->tournamentRepository->findWithFilters($filters);

        $tournaments = array_map(function($tournament) {
            return new Tournament(
                $tournament['id'],
                $tournament['name'],
                $tournament['type'],
            );
        }, $response);

        return array_map(fn($tournament) => TournamentDTO::fromTournament($tournament), $tournaments);
    }
}
