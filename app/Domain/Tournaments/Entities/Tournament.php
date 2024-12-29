<?php
declare(strict_types=1);

namespace App\Domain\Tournaments\Entities;

final class Tournament
{
    public function __construct(
        private readonly ?int $id,
        private readonly string $name,
        private readonly string $type,
        private ?int $winner = null
    ){}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getWinner(): ?int
    {
        return $this->winner;
    }

    public function setWinner(int $winner): void
    {
        $this->winner = $winner;
    }
}
