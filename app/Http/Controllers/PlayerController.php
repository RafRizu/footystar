<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function index()
    {
        $player = Player::where('user_id', auth()->id())->firstOrFail();
        $recentMatches = $player->matchLogs()->latest()->limit(5)->get();

        return view('dashboard', compact('player', 'recentMatches'));
    }

    public function train(Request $request)
    {
        $player = Player::where('user_id', Auth::id())->firstOrFail();

        if ($player->stamina < 10) {
            return redirect()->back()->with('error', 'Not enough stamina to train!');
        }

        // Training increases random skills
        $statToTrain = collect(['mechanics', 'strategy', 'decision_making', 'communication'])->random();
        $player->$statToTrain += rand(1, 5); // random small boost
        $player->stamina -= 10;
        $player->save();

        return redirect()->back()->with('success', "Training complete! Improved $statToTrain!");
    }

    public function playRanked()
    {
        $player = Player::where('user_id', auth()->id())->firstOrFail();

        $result = rand(0, 1) ? 'win' : 'loss'; // lowercase to match DB format

        // Determine stars and money based on result
        $starsChange = $result === 'win' ? 1 : -1;
        $moneyGained = $result === 'win' ? 500 : 100;

        // Update player stars and money
        $player->stars = max(0, $player->stars + $starsChange);
        $player->money += $moneyGained;

        $player->promoteIfEligible();
        $player->save();

        // Log the match
        $player->matchLogs()->create([
            'result' => $result,
            'stars_change' => $starsChange,
            'stars_after_match' => $player->stars,
            'rank_after_match' => $player->rank,
        ]);

        return redirect()->back()->with('success', "You played a match and " . ucfirst($result) . "!");
    }



    public function rest(Request $request)
    {
        $player = Player::where('user_id', Auth::id())->firstOrFail();

        // Rest restores stamina
        $player->stamina = min(100, $player->stamina + 30);
        $player->save();

        return redirect()->back()->with('success', 'Rested and recovered stamina!');
    }
}
