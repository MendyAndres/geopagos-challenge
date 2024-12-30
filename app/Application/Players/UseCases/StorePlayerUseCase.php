<?php
declare(strict_types=1);

namespace App\Application\Players\UseCases;

use App\Domain\Players\Entities\Player;
use App\Domain\Players\Repositories\PlayerRepositoryInterface;

class StorePlayerUseCase
{
    public function __construct(private PlayerRepositoryInterface $playerRepository){}

    public function create(array $request): array
    {
        $player = new Player(
            isset($request['id']) ? (int)$request['id'] : null,
            $request['name'],
            (int)$request['skill_level'],
            $request['gender'],
            isset($request['strength_level']) ? (int)$request['strength_level'] : null,
            isset($request['speed_level']) ? (int)$request['speed_level'] : null,
            isset($request['reaction_time']) ? (int)$request['reaction_time'] : null,
            $request['tournament_id'],
        );

        return $this->playerRepository->create($player);
    }
}
