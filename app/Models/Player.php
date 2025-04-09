<?php

namespace App\Models;

use App\Models\MatchLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'role',
        'rank',
        'xp',
        'money',
        'stamina',
        'mechanics',
        'strategy',
        'decision_making',
        'communication',
    ];
    // app/Models/Player.php

    public function promoteIfEligible()
    {
        $ranks = [
            'Warrior',
            'Elite',
            'Master',
            'Grandmaster',
            'Epic',
            'Legend',
            'Mythic',
            'Mythic Honor',
            'Mythical Glory',
            'Mythical Immortal',
        ];

        // Stars needed for each rank
        $starsNeeded = [
            'Warrior' => 3,
            'Elite' => 4,
            'Master' => 5,
            'Grandmaster' => 5,
            'Epic' => 5,
            'Legend' => 6,
            'Mythic' => 25,
            'Mythic Honor' => 25,
            'Mythical Glory' => 50,
            'Mythical Immortal' => 100,
        ];

        $currentRankIndex = array_search($this->rank, $ranks);

        if ($currentRankIndex !== false && $currentRankIndex < count($ranks) - 1) {
            $needed = $starsNeeded[$this->rank] ?? 5;

            if ($this->stars >= $needed) {
                $this->rank = $ranks[$currentRankIndex + 1];
                $this->stars = 0; // reset stars after promotion
                $this->money += 2000; // bonus for promotion
                $this->save();
            }
        }
    }

    public function matchLogs()
    {
        return $this->hasMany(MatchLog::class);
    }

}
