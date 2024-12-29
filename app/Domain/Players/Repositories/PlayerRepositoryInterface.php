<?php

declare(strict_types=1);

namespace App\Domain\Players\Repositories;

use App\Domain\Players\Entities\Player;

interface PlayerRepositoryInterface
{
    public function findAll(): array;
    public function findOneById(int $id): array;
    public function create(Player $player): array;
    public function update(int $id, array $player): array;
    public function delete(int $id): void;
}
