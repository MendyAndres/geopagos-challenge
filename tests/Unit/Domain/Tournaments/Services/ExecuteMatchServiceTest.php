<?php

namespace Tests\Unit\Domain\Tournaments\Services;

use App\Domain\Players\Entities\Player;
use App\Domain\Tournaments\Services\ExecuteMatchService;
use PHPUnit\Framework\TestCase;

class ExecuteMatchServiceTest extends TestCase
{
    /**
     * Tests the execution of a match between two male players.
     * Asserts that the winner's ID matches one of the participating players' IDs.
 */
    public function testExecuteMatchMale(): void
    {
        $player1 = new Player(1, 'Roger', 70, 'male', 50, 60, null, null);
        $player2 = new Player(2, 'Rafa', 75, 'male', 45, 55, null, null);

        $service = new ExecuteMatchService();
        $winner = $service->execute($player1, $player2, 'male');

        $this->assertInstanceOf(Player::class, $winner);
        $this->assertContains($winner->getId(), [$player1->getId(), $player2->getId()]);
    }

    /**
     * Tests the execution of a match between two female players.
     * Asserts that the winner's ID matches one of the participating players' IDs.
     */
    public function testExecuteMatchFemale()
    {
        $service = new ExecuteMatchService();

        $player1 = new Player(3, 'Ana', 85, 'female', null, null, 50, null);
        $player2 = new Player(4, 'Sharapova', 80, 'female', null, null, 55, null);

        $winner = $service->execute($player1, $player2, 'female');

        $this->assertContains($winner->getId(), [3, 4]);
    }
}
