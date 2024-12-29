<?php

namespace Tests\Unit\Application\Players\DTOs;

use App\Application\Players\DTOs\PlayerDTO;
use App\Domain\Players\Entities\Player;
use PHPUnit\Framework\TestCase;

class PlayerDTOTest extends TestCase
{
    public function testFromPlayerCreatesCorrectDto()
    {
        $player = new Player(
            1,
            'Rafa Nadal',
            85,
            'male',
            70,
            65,
            null,
            2
        );

        $playerDTO = PlayerDTO::fromPlayer($player);

        $this->assertInstanceOf(PlayerDTO::class, $playerDTO);
        $this->assertEquals($player->getId(), $playerDTO->id);
        $this->assertEquals($player->getname(), $playerDTO->name);
        $this->assertEquals($player->getSkillLevel(), $playerDTO->skill_level);
        $this->assertEquals($player->getGender(), $playerDTO->gender);
        $this->assertEquals($player->getStrengthLevel(), $playerDTO->strength_level);
        $this->assertEquals($player->getSpeedLevel(), $playerDTO->speed_level);
        $this->assertNull($playerDTO->reaction_time);
        $this->assertEquals($player->getTournamentId(), $playerDTO->tournament_id);
    }

    public function testDtoHandlesNullValuesCorrectly()
    {
        $player = new Player(
            null,
            'Martina Navratilova',
            85,
            'fermale',
            null,
            null,
            30,
            3
        );

        $playerDTO = PlayerDTO::fromPlayer($player);

        $this->assertNull($playerDTO->id);
        $this->assertEquals($player->getName(), $playerDTO->name);
        $this->assertEquals($player->getSkillLevel(), $playerDTO->skill_level);
        $this->assertEquals($player->getGender(), $playerDTO->gender);
        $this->assertNull($playerDTO->strength_level);
        $this->assertNull($playerDTO->speed_level);
        $this->assertEquals($player->getReactionTime(), $playerDTO->reaction_time);
        $this->assertEquals($player->getTournamentId(), $playerDTO->tournament_id);



    }
}
