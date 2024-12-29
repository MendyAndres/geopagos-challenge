<?php

namespace Tests\Unit\Domain\Tournaments\Entities;

use App\Domain\Tournaments\Entities\Tournament;
use PHPUnit\Framework\TestCase;

class TournamentTest extends TestCase
{
    public function testTournamentCreation()
    {
        $tournament = new Tournament(1, 'Buenos Aires Open', 'male', null);

        $this->assertEquals(1, $tournament->getId());
        $this->assertEquals('Buenos Aires Open', $tournament->getName());
        $this->assertEquals('male', $tournament->getType());
        $this->assertNull($tournament->getWinner());
    }
}
