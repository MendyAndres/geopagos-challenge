<?php

namespace App\Infrastructure\Framework\Models;

use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory;

    protected static function newFactory()
    {
        return PlayerFactory::new();
    }

    protected $fillable = [
        'name',
        'gender',
        'skill_level',
        'strength_level',
        'reaction_time',
        'speed_level',
        'tournament_id',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
