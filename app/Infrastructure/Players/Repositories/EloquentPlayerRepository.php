<?php
declare(strict_types=1);

namespace App\Infrastructure\Players\Repositories;

use App\Domain\Players\Entities\Player as PlayerEntity;
use App\Domain\Players\Repositories\PlayerRepositoryInterface;
use App\Infrastructure\Framework\Models\Player;

class EloquentPlayerRepository implements PlayerRepositoryInterface
{
    public function findAll(): array
    {
        return Player::all()->toArray();
    }

    public function findOneById(int $id): array
    {
        return Player::findOrFail($id)->toArray();
    }

    public function create(PlayerEntity $player): array
    {
        $eloPlayer = new Player();
        $eloPlayer->name = $player->getName();
        $eloPlayer->skill_level = $player->getSkillLevel();
        $eloPlayer->gender = $player->getGender();
        $eloPlayer->strength_level = $player->getStrengthLevel();
        $eloPlayer->speed_level = $player->getSpeedLevel();
        $eloPlayer->reaction_time = $player->getReactionTime();
        $eloPlayer->tournament_id = $player->getTournamentId();
        $eloPlayer->save();

        return $eloPlayer->toArray();
    }

    public function update(int $id, array $player): array
    {
        $player = Player::findOrFail($id);
        $player->update($player);
        return $player->toArray();
    }

    public function delete(int $id): void
    {
        $player = Player::findOrFail($id);
        $player->delete();
        return;
    }
}
