<?php

declare(strict_types=1);

namespace App\Application\Players\UseCases;

use App\Application\Players\DTOs\PlayerDTO;
use App\Domain\Players\Entities\Player;
use App\Domain\Players\Repositories\PlayerRepositoryInterface;

final readonly class GetPlayerByIdUseCase
{
    public function __construct(private PlayerRepositoryInterface $playerRepository){}

    public function execute(int $id): PlayerDTO
    {
        $response = $this->playerRepository->findOneById($id);

        $player = new Player(
            $response['id'],
            $response['name'],
            $response['skill_level'],
            $response['gender'],
            $response['strength_level'],
            $response['speed_level'],
            $response['reaction_time'],
            $response['tournament_id']
        );

        return PlayerDTO::fromPlayer($player);
    }
}
