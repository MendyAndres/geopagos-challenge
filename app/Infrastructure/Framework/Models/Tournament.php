<?php

namespace App\Infrastructure\Framework\Models;

use Database\Factories\TournamentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    /** @use HasFactory<\Database\Factories\TournamentFactory> */
    use HasFactory;

    protected static function newFactory()
    {
        return TournamentFactory::new();
    }

    protected $fillable = [
        'name',
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function winner()
    {
        return $this->hasOne(Player::class, 'id', 'winner_id');
    }
}
