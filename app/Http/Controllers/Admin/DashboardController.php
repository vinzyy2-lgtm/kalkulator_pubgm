<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\GameMatch;
use App\Models\MatchResult;
use App\Models\Player;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with chart data.
     */
    public function index(): View
    {
        $allTeams   = Team::with(['players', 'matchResults'])->orderBy('order')->get();
        $allMatches = GameMatch::orderBy('match_number')->get();
        $totalMatches = $allMatches->count();
        $totalTeams   = $allTeams->count();

        // Build standings data
        $standings = $allTeams->map(function (Team $team) {
            $data = $team->getStandingsData();
            return array_merge(['team' => $team], $data);
        })->sortByDesc('total_points')->values();

        // Total kills across all results
        $totalKills = MatchResult::get()->sum(fn ($r) => $r->getTotalKills());

        // Build playerStats for most-kills quick view (top 10)
        $results = MatchResult::with(['team.players'])->get();
        $killsMap = [];
        foreach ($results as $result) {
            $teamId = $result->team_id;
            if (!isset($killsMap[$teamId])) {
                $killsMap[$teamId] = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0];
            }
            $killsMap[$teamId][0] += (int)$result->p0_kills;
            $killsMap[$teamId][1] += (int)$result->p1_kills;
            $killsMap[$teamId][2] += (int)$result->p2_kills;
            $killsMap[$teamId][3] += (int)$result->p3_kills;
            $killsMap[$teamId][4] += (int)$result->p4_kills;
        }

        $playerStats = [];
        $players = Player::with('team')->get();
        foreach ($players as $player) {
            $teamId = $player->team_id;
            $slot   = $player->slot;
            $kills  = $killsMap[$teamId][$slot] ?? 0;
            $playerStats[] = [
                'player'     => $player,
                'team'       => $player->team,
                'slot_label' => $player->getSlotLabel(),
                'kills'      => $kills,
            ];
        }
        usort($playerStats, fn($a, $b) => $b['kills'] <=> $a['kills']);
        $playerStats = array_slice($playerStats, 0, 10);

        // ===== Chart Data =====
        $top10Standings = $standings->take(10);

        // Bar chart stacked: Place Pts + Elim Pts per team (top 10)
        $barLabels    = [];
        $barPlacePts  = [];
        $barElimPts   = [];
        foreach ($top10Standings as $entry) {
            $barLabels[]   = $entry['team']->name;
            $placePts      = $entry['team']->matchResults->sum(fn($r) => $r->getPlacePoints());
            $elimPts       = $entry['team']->matchResults->sum(fn($r) => $r->getTotalKills());
            $barPlacePts[] = $placePts;
            $barElimPts[]  = $elimPts;
        }

        // Horizontal bar: Top 10 terminators (player kills)
        $hbarLabels = array_map(fn($p) => $p['player']->name . ' (' . $p['team']->name . ')', $playerStats);
        $hbarKills  = array_map(fn($p) => $p['kills'], $playerStats);

        // Doughnut: total place pts vs total elim pts across all matches
        $totalPlacePts = MatchResult::get()->sum(fn($r) => $r->getPlacePoints());
        $totalElimPts  = MatchResult::get()->sum(fn($r) => $r->getTotalKills());

        // Line chart: Cumulative points for top 5 teams per match
        $top5Teams    = $standings->take(5);
        $matchList    = GameMatch::orderBy('match_number')->get();
        $lineLabels   = $matchList->map(fn($m) => 'Match ' . $m->match_number)->values()->toArray();
        $lineDatasets = [];
        $colors       = ['#f59e0b', '#7c3aed', '#3b82f6', '#10b981', '#ef4444'];
        foreach ($top5Teams as $idx => $entry) {
            $team = $entry['team'];
            $cumulative = 0;
            $data = [];
            foreach ($matchList as $match) {
                $result = MatchResult::where('game_match_id', $match->id)
                    ->where('team_id', $team->id)->first();
                if ($result) {
                    $cumulative += $result->getTotalPoints();
                }
                $data[] = $cumulative;
            }
            $lineDatasets[] = [
                'label'           => $team->name,
                'data'            => $data,
                'borderColor'     => $colors[$idx] ?? '#888',
                'backgroundColor' => $colors[$idx] . '20',
                'tension'         => 0.4,
                'fill'            => true,
            ];
        }

        $chartData = [
            'bar' => [
                'labels'   => $barLabels,
                'placePts' => $barPlacePts,
                'elimPts'  => $barElimPts,
            ],
            'hbar' => [
                'labels' => $hbarLabels,
                'kills'  => $hbarKills,
            ],
            'doughnut' => [
                'placePts' => $totalPlacePts,
                'elimPts'  => $totalElimPts,
            ],
            'line' => [
                'labels'   => $lineLabels,
                'datasets' => $lineDatasets,
            ],
        ];

        return view('admin.dashboard.index', compact(
            'standings',
            'playerStats',
            'chartData',
            'allTeams',
            'allMatches',
            'totalMatches',
            'totalTeams',
            'totalKills'
        ));
    }
}
