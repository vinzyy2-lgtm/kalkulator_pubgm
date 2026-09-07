<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameMatch;
use App\Models\MatchResult;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class MatchResultController extends Controller
{
    /**
     * Store or update match results for a given match.
     * Accepts bulk submission of all 18 teams' results at once.
     *
     * Request format:
     *   results[team_id][rank] = int
     *   results[team_id][p0_kills] = int
     *   ...
     */
    public function store(Request $request, GameMatch $match): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'results'                  => ['required', 'array'],
            'results.*.rank'           => ['required', 'integer', 'min:1', 'max:18'],
            'results.*.p0_kills'       => ['nullable', 'integer', 'min:0'],
            'results.*.p1_kills'       => ['nullable', 'integer', 'min:0'],
            'results.*.p2_kills'       => ['nullable', 'integer', 'min:0'],
            'results.*.p3_kills'       => ['nullable', 'integer', 'min:0'],
            'results.*.p4_kills'       => ['nullable', 'integer', 'min:0'],
        ]);

        foreach ($validated['results'] as $teamId => $data) {
            MatchResult::updateOrCreate(
                [
                    'game_match_id' => $match->id,
                    'team_id'       => (int) $teamId,
                ],
                [
                    'rank'     => $data['rank'],
                    'p0_kills' => $data['p0_kills'] ?? 0,
                    'p1_kills' => $data['p1_kills'] ?? 0,
                    'p2_kills' => $data['p2_kills'] ?? 0,
                    'p3_kills' => $data['p3_kills'] ?? 0,
                    'p4_kills' => $data['p4_kills'] ?? 0,
                ]
            );
        }

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => "Hasil Match #{$match->match_number} berhasil disimpan."]);
        }

        return redirect()->route('admin.matches.show', $match)
            ->with('success', "Hasil Match #{$match->match_number} berhasil disimpan.");
    }

    /**
     * Get existing result for a specific team in a match (for AJAX quick input).
     */
    public function getResult(int $matchId, int $teamId): JsonResponse
    {
        $result = MatchResult::where('game_match_id', $matchId)
            ->where('team_id', $teamId)
            ->first();

        return response()->json(
            $result ?? [
                'rank'      => 18,
                'p0_kills'  => 0,
                'p1_kills'  => 0,
                'p2_kills'  => 0,
                'p3_kills'  => 0,
                'p4_kills'  => 0,
            ]
        );
    }
}
