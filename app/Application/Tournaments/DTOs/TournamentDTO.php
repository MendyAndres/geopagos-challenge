<?php
declare(strict_types=1);

namespace App\Application\Tournaments\DTOs;


use App\Domain\Tournaments\Entities\Tournament;

final readonly class TournamentDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $type,
    ){}

    public static function fromTournament(Tournament $tournament): self
    {
        return new self(
            $tournament->getId(),
            $tournament->getName(),
            $tournament->getType(),
        );
    }
}
