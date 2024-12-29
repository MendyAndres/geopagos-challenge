<?php
declare(strict_types=1);

namespace App\Application\Players\UseCases;

use App\Application\Players\DTOs\PlayerDTO;
use App\Domain\Players\Entities\Player;
use App\Domain\Players\Repositories\PlayerRepositoryInterface;

final readonly class GetPlayersUseCase
{
    public function __construct(private PlayerRepositoryInterface $playerRepository){}

    public function execute()
    {
        $response = $this->playerRepository->findAll();

        $players = array_map(function($player) {
            return new Player(
                $player['id'],
                $player['name'],
                $player['skill_level'],
                $player['gender'],
                $player['strength_level'],
                $player['speed_level'],
                $player['reaction_time'],
                $player['tournament_id'],
            );
        }, $response);

        return array_map(fn($player) => PlayerDTO::fromPlayer($player), $players);
    }
}
