<?php
declare(strict_types=1);

namespace App\Application\Tournaments\DTOs;

use App\Application\Players\DTOs\PlayerDTO;
use App\Domain\Tournaments\Entities\Tournament;

final readonly class PlayedTournamentDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public PlayerDTO $winner,
    ){}

    public static function fromArray(Tournament $tournament, PlayerDTO $winner): self
    {
        return new self(
            $tournament->getId(),
            $tournament->getName(),
            $winner,
        );
    }
}
