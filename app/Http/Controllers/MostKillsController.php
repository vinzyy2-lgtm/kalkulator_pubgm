<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\MatchResult;
use Illuminate\View\View;

class MostKillsController extends Controller
{
    /**
     * Show the most kills leaderboard per player.
     * Aggregates kills by slot across all match results for each team.
     */
    public function index(): View
    {
        // Get all match results with team and team's players
        $results = MatchResult::with(['team.players'])->get();

        // Build a kills map: [team_id][slot] => total_kills
        $killsMap = [];
        foreach ($results as $result) {
            $teamId = $result->team_id;
            if (!isset($killsMap[$teamId])) {
                $killsMap[$teamId] = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0];
            }
            $killsMap[$teamId][0] += $result->p0_kills;
            $killsMap[$teamId][1] += $result->p1_kills;
            $killsMap[$teamId][2] += $result->p2_kills;
            $killsMap[$teamId][3] += $result->p3_kills;
            $killsMap[$teamId][4] += $result->p4_kills;
        }

        // Build leaderboard entries per player
        $leaderboard = [];
        $players = Player::with('team')->get();

        foreach ($players as $player) {
            $teamId = $player->team_id;
            $slot   = $player->slot;
            $kills  = $killsMap[$teamId][$slot] ?? 0;

            $leaderboard[] = [
                'player'    => $player,
                'team'      => $player->team,
                'slot_label'=> $player->getSlotLabel(),
                'kills'     => $kills,
            ];
        }

        // Sort by kills descending
        usort($leaderboard, fn($a, $b) => $b['kills'] <=> $a['kills']);

        return view('most-kills.index', compact('leaderboard'));
    }
}
