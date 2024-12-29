<?php

declare(strict_types=1);

namespace App\Domain\Tournaments\Repositories;

use App\Domain\Tournaments\Entities\Tournament;
use http\Exception;

interface TournamentRepositoryInterface
{
    public function findWithFilters(array $filters): array;
    public function findOneById(int $id): array;
    public function create(Tournament $tournament): array;
    public function update(int $id, array $tournament): array;
    public function delete(int $id): void;
    public function saveWinner(int $tournamentId, int $winnerId): void;
}
