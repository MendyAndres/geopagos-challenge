<?php
declare(strict_types=1);

namespace App\Domain\Tournaments\Services;

use App\Domain\Players\Entities\Player;
use App\Domain\Tournaments\Entities\Tournament;

class ExecuteTournamentService
{
    public function __construct(private ExecuteMatchService $executeMatchService){}

    public function execute(array $players, Tournament $tournament): Player
    {

        $tournamentType = $tournament->getType();

        if (!$this->isPowerOfTwo(count($players))) {
            throw new \InvalidArgumentException('The number should be a power of two');
        }
        while (count($players) > 1) {
            $winners = [];

            $chunks = array_chunk($players, 2);

            foreach($chunks as $matchPlayers) {
                $player1 = $matchPlayers[0];
                $player2 = $matchPlayers[1];

                $winners[] = $this->executeMatchService->execute($player1, $player2, $tournamentType);
            }
            $players = $winners;
        }
        return $players[0];
    }

    private function isPowerOfTwo(int $number): bool
    {
        return ($number & ($number - 1)) == 0 && $number >= 2;
    }
}
