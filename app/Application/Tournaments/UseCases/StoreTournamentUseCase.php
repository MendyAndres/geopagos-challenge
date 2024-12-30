<?php
declare(strict_types=1);

namespace App\Application\Tournaments\UseCases;

use App\Domain\Tournaments\Entities\Tournament;
use App\Domain\Tournaments\Repositories\TournamentRepositoryInterface;
use App\Infrastructure\Http\Requests\StoreTournamentRequest;

readonly class StoreTournamentUseCase
{
    public function __construct(private TournamentRepositoryInterface $tournamentRepository){}


    /**
     * Executes the creation process of a tournament based on the provided request data.
     *
     * @param array $request
     * @return array
     */
    public function execute(array $request): array
    {
        $tournamentEntity = new Tournament(
            (isset($request['id'])) ? (int)$request['id'] : null,
            $request['name'],
            $request['type'],
            (isset($request['winner'])) ? (int)$request['winner'] : null,
        );

        return $this->tournamentRepository->create($tournamentEntity);

    }
}
