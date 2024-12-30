<?php
declare(strict_types=1);

namespace App\Domain\Players\Entities;

class Player
{
    public function __construct(
        private readonly ?int $id,
        private readonly string $name,
        private readonly int $skillLevel,
        private readonly string $gender,
        private readonly ?int $strengthLevel,
        private readonly ?int $speedLevel,
        private readonly ?int $reactionTime,
        private readonly ?int $tournamentId,
    ){
        $this->validate();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getSkillLevel(): int
    {
        return $this->skillLevel;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getStrengthLevel(): ?int
    {
        return $this->strengthLevel;
    }

    public function getSpeedLevel(): ?int
    {
        return $this->speedLevel;
    }

    public function getReactionTime(): ?int
    {
        return $this->reactionTime;
    }

    public function getTournamentId(): ?int
    {
        return $this->tournamentId;
    }

    /**
     * Validates the player's attributes based on their gender.
     *
     * Throws an exception if required attributes are missing for male or female players:
     * - Male players must have defined strength and speed levels.
     * - Female players must have a defined reaction time.
     *
     * @throws \InvalidArgumentException
     */
    private function validate(): void
    {
        if($this->gender === 'male') {
            if($this->strengthLevel === null || $this->speedLevel === null) {
                throw new \InvalidArgumentException('The male players must have strength and speed levels');
            }
        }

        if($this->gender === 'female') {
            if($this->reactionTime === null) {
                throw new \InvalidArgumentException('The female players must have reaction time');
            }
        }
    }
}
