<?php

namespace Tests\Unit\Domain\Players\Entities;

use App\Domain\Players\Entities\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testPlayerCreation()
    {
        $player = new Player(1, 'Guillermo Coria', 90, 'male', 50, 60, null, 1);

        $this->assertEquals(1, $player->getId());
        $this->assertEquals('Guillermo Coria', $player->getName());
        $this->assertEquals(90, $player->getSkillLevel());
        $this->assertEquals('male', $player->getGender());
        $this->assertEquals(50, $player->getStrengthLevel());
        $this->assertEquals(60, $player->getSpeedLevel());
        $this->assertEquals(1, $player->getTournamentId());
    }

    public function testMalePlayerValidation()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The male players must have strength and speed levels');

        new Player(
            1,
            'Roger Federer',
            90,
            'male',
            null,
            null,
            null,
            1);
    }

    public function testFemalePlayerValidation()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The female players must have reaction time');

        new Player(
            null,
            'Ana Ivanovic',
            85,
            'female',
            null,
            null,
            null, // reaction_time
            1
        );


    }
}
