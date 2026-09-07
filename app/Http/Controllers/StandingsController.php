<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\View\View;

class StandingsController extends Controller
{
    /**
     * Show the tournament standings leaderboard.
     * Sorted by total points (desc), then total kills (desc).
     */
    public function index(): View
    {
        $teams = Team::with('matchResults')->orderBy('order')->get();

        $standings = $teams->map(function (Team $team) {
            $data = $team->getStandingsData();
            return [
                'team'           => $team,
                'total_points'   => $data['total_points'],
                'total_kills'    => $data['total_kills'],
                'matches_played' => $data['matches_played'],
                'best_rank'      => $data['best_rank'],
            ];
        })
        ->sortByDesc('total_points')
        ->sortByDesc('total_kills') // secondary sort
        ->values();

        // Re-sort properly: primary by points desc, secondary by kills desc
        $standings = $standings->sortBy([
            ['total_points', 'desc'],
            ['total_kills', 'desc'],
        ])->values();

        return view('standings.index', compact('standings'));
    }
}
