<?php

namespace App\Models;

use App\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatchLog extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'player_id',
        'result',
        'stars_change',
        'stars_after_match',
        'rank_after_match',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
