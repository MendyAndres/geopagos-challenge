<?php
declare(strict_types=1);

namespace App\Application\Players\DTOs;

use App\Domain\Players\Entities\Player;

final readonly class PlayerDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public int $skill_level,
        public string $gender,
        public ?int $strength_level,
        public ?int $speed_level,
        public ?int $reaction_time,
        public int $tournament_id
    ){}

    public static function fromPlayer(Player $player): self
    {
        return new self(
            $player->getId(),
            $player->getName(),
            $player->getSkillLevel(),
            $player->getGender(),
            $player->getStrengthLevel(),
            $player->getSpeedLevel(),
            $player->getReactionTime(),
            $player->getTournamentId(),
        );
    }
}
