<?php

namespace Tests\Unit\Application\Tournaments\DTOs;

use App\Application\Players\DTOs\PlayerDTO;
use App\Application\Tournaments\DTOs\PlayedTournamentDTO;
use App\Domain\Players\Entities\Player;
use App\Domain\Tournaments\Entities\Tournament;
use PHPUnit\Framework\TestCase;

class PlayedTournamentDTOTest extends TestCase
{
    public function testFromArrayCreatesCorrectDto()
    {
        $tournament = new Tournament(
            1,
            'Wimbledon',
            'male',
            '2',
        );

        $player = new Player(
            2,
            'Novak Djokovic',
            99,
            'male',
            99,
            99,
            null,
            1
        );

        $playerDTO = PlayerDTO::fromPlayer($player);

        $playedTournamentDTO = PlayedTournamentDTO::fromArray($tournament, $playerDTO);

        $this->assertInstanceOf(PlayedTournamentDTO::class, $playedTournamentDTO);
        $this->assertEquals($tournament->getId(), $playedTournamentDTO->id);
        $this->assertEquals($tournament->getName(), $playedTournamentDTO->name);
        $this->assertInstanceOf(PlayerDTO::class, $playedTournamentDTO->winner);
        $this->assertEquals($player->getId(), $playedTournamentDTO->winner->id);
        $this->assertEquals($player->getName(), $playedTournamentDTO->winner->name);
    }
}
