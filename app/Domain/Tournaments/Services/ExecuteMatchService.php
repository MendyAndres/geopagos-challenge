<?php
declare(strict_types=1);

namespace App\Domain\Tournaments\Services;

use App\Domain\Players\Entities\Player;

class ExecuteMatchService
{

    /**
     * Executes a match between two players based on their skill levels and additional factors.
     *
     * This method incorporates random luck and additional skill attributes to determine
     * the winner between two players in a specified tournament type.
     *
     * @param Player $player1
     * @param Player $player2
     * @param string $tournamentType
     *
     * @return Player
     */
    public function execute(Player $player1, Player $player2, string $tournamentType): Player
    {
        $luckyPlayer1 = rand(-30, 30);
        $luckyPlayer2 = rand(-30, 30);

        $skillLevelPlayer1 = $player1->getSkillLevel() + $luckyPlayer1;
        $skillLevelPlayer2 = $player2->getSkillLevel() + $luckyPlayer2;

        [$otherSkillsPlayer1, $otherSkillsPlayer2] = $this->prepareMatch($tournamentType, $player1, $player2);

        $player1Total = $skillLevelPlayer1 + $otherSkillsPlayer1;
        $player2Total = $skillLevelPlayer2 + $otherSkillsPlayer2;

        return ($player1Total > $player2Total) ? $player1 : $player2;

    }

    /**
     * Prepares a match based on the tournament type and the given players.
     *
     * @param string $tournamentType
     * @param Player $player1
     * @param Player $player2
     *
     * @return array
     */
    private function prepareMatch(string $tournamentType, Player $player1, Player $player2): array
    {
        return match ($tournamentType) {
            'female' => $this->femaleMatch($player1, $player2),
            'male' => $this->maleMatch($player1, $player2),
        };
    }

    /**
     * @param Player $player1
     * @param Player $player2
     * @return array
     */
    private function femaleMatch(Player $player1, Player $player2): array
    {
        $otherSkillsPlayer1 = $player1->getReactionTime();
        $otherSkillsPlayer2 = $player2->getReactionTime();

        return [$otherSkillsPlayer1, $otherSkillsPlayer2];
    }


    /**
     * @param Player $player1
     * @param Player $player2
     * @return array
     */
    private function maleMatch(Player $player1, Player $player2): array
    {
        $otherSkillsPlayer1 = $player1->getStrengthLevel() + $player1->getSpeedLevel() ;
        $otherSkillsPlayer2 = $player2->getStrengthLevel() + $player2->getSpeedLevel();

        return [$otherSkillsPlayer1, $otherSkillsPlayer2];
    }
}
