<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\GameMatch;
use App\Models\MatchResult;
use App\Models\Player;
use Illuminate\View\View;

class PublicDashboardController extends Controller
{
    public function index(): View
    {
        // ── Standings ──────────────────────────────────────────────
        $teams = Team::with(['matchResults', 'players'])->orderBy('order')->get();

        $standings = $teams->map(function (Team $team) {
            $results   = $team->matchResults;
            $placePts  = $results->sum(fn($r) => $r->getPlacePoints());
            $elimPts   = $results->sum(fn($r) => $r->getTotalKills());
            $wwcd      = $results->where('rank', 1)->count();
            $played    = $results->count();
            $bestRank  = $results->isNotEmpty() ? $results->min('rank') : null;
            $totalPts  = $placePts + $elimPts;

            return [
                'team'      => $team,
                'place_pts' => $placePts,
                'elim_pts'  => $elimPts,
                'wwcd'      => $wwcd,
                'played'    => $played,
                'best_rank' => $bestRank,
                'total_pts' => $totalPts,
            ];
        })->sortByDesc('total_pts')->values();

        // ── Most Kills ─────────────────────────────────────────────
        $results   = MatchResult::with(['team.players'])->get();
        $killsMap  = [];
        foreach ($results as $result) {
            $tid = $result->team_id;
            if (!isset($killsMap[$tid])) {
                $killsMap[$tid] = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0];
            }
            $killsMap[$tid][0] += $result->p0_kills;
            $killsMap[$tid][1] += $result->p1_kills;
            $killsMap[$tid][2] += $result->p2_kills;
            $killsMap[$tid][3] += $result->p3_kills;
            $killsMap[$tid][4] += $result->p4_kills;
        }

        $playerStats = [];
        foreach (Player::with('team')->get() as $player) {
            $kills = $killsMap[$player->team_id][$player->slot] ?? 0;
            $playerStats[] = [
                'name'     => $player->name,
                'team'     => $player->team->name ?? '—',
                'slot'     => $player->slot,
                'kills'    => $kills,
            ];
        }
        usort($playerStats, fn($a, $b) => $b['kills'] <=> $a['kills']);
        $topKillers = array_slice($playerStats, 0, 10);

        // ── Statistik Global ───────────────────────────────────────
        $totalMatches = GameMatch::count();
        $totalTeams   = $teams->count();
        $totalKills   = array_sum(array_column($playerStats, 'kills'));
        $leader       = $standings->first();
        $topKiller    = $topKillers[0] ?? null;

        // ── Chart: Total Poin per Tim (top 10) ────────────────────
        $top10 = $standings->take(10);
        $chartBar = [
            'labels'   => $top10->pluck('team')->map(fn($t) => $t->name)->values()->toArray(),
            'placePts' => $top10->pluck('place_pts')->values()->toArray(),
            'elimPts'  => $top10->pluck('elim_pts')->values()->toArray(),
        ];

        // ── Chart: Top 10 Killer ─────────────────────────────────
        $chartKillers = [
            'labels' => array_column(array_slice($topKillers, 0, 10), 'name'),
            'kills'  => array_column(array_slice($topKillers, 0, 10), 'kills'),
        ];

        // ── Chart: Tren poin top 5 tim per match ─────────────────
        $matchList  = GameMatch::orderBy('match_number')->get();
        $top5       = $standings->take(5);
        $colors     = ['#f59e0b', '#7c3aed', '#3b82f6', '#10b981', '#ef4444'];
        $lineDatasets = [];
        foreach ($top5->values() as $i => $entry) {
            $team = $entry['team'];
            $cum  = 0;
            $data = [];
            foreach ($matchList as $m) {
                $r = MatchResult::where('game_match_id', $m->id)
                    ->where('team_id', $team->id)->first();
                if ($r) $cum += $r->getTotalPoints();
                $data[] = $cum;
            }
            $lineDatasets[] = [
                'label'           => $team->name,
                'data'            => $data,
                'borderColor'     => $colors[$i],
                'backgroundColor' => $colors[$i] . '20',
                'tension'         => 0.4,
                'fill'            => true,
            ];
        }
        $chartLine = [
            'labels'   => $matchList->map(fn($m) => 'M'.$m->match_number)->values()->toArray(),
            'datasets' => $lineDatasets,
        ];

        return view('public.dashboard', compact(
            'standings', 'topKillers', 'totalMatches', 'totalTeams',
            'totalKills', 'leader', 'topKiller', 'chartBar', 'chartKillers', 'chartLine'
        ));
    }
}
