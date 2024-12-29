<?php
declare(strict_types=1);

namespace App\Infrastructure\Tournaments\Repositories;

use App\Domain\Tournaments\Entities\Tournament as TournamentEntity;
use App\Domain\Tournaments\Repositories\TournamentRepositoryInterface;
use App\Infrastructure\Framework\Models\Tournament;
use http\Exception;

final class EloquentTournamentRepository implements TournamentRepositoryInterface
{
    public function __construct()
    {
    }

    public function findWithFilters(array $filters): array
    {
        $query = Tournament::query();
        if (isset($filters['gender'])){
            $query->where('type', $filters['gender']);
        }

        if (isset($filters['from_date'])){
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }

        if (isset($filters['to_date'])){
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }
        return $query->get()->toArray();
    }

    public function findOneById(int $id): array
    {
        return Tournament::findOrFail($id)->toArray();
    }

    public function create(TournamentEntity $tournament): array
    {
        $eloTournament = new Tournament();
        $eloTournament->name = $tournament->getName();
        $eloTournament->type = $tournament->getType();
        $eloTournament->save();
        return $eloTournament->toArray();
    }

    public function update(int $id, array $tournament): array
    {
        return [];
    }

    public function delete(int $id): void
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->delete();
    }

    public function saveWinner(int $tournamentId, int $winnerId): void
    {
        $tournament = Tournament::findOrFail($tournamentId);
        $tournament->winner_id = $winnerId;
        $tournament->save();

    }
}
