<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    /**
     * Show all teams with their players for bulk editing.
     */
    public function index(): \Illuminate\View\View
    {
        $teams = Team::with(['players' => function ($q) {
            $q->orderBy('slot');
        }])->orderBy('order')->get();

        return view('admin.players.index', compact('teams'));
    }

    /**
     * Update all players for a given team.
     * Expects request body: players[slot] = name
     */
    public function update(Request $request, Team $team): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'players'   => ['required', 'array'],
            'players.*' => ['required', 'string', 'max:255'],
        ]);

        foreach ($validated['players'] as $slot => $name) {
            $slot = (int) $slot;
            if ($slot < 0 || $slot > 4) {
                continue;
            }

            Player::updateOrCreate(
                ['team_id' => $team->id, 'slot' => $slot],
                ['name' => $name]
            );
        }

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => "Pemain tim '{$team->name}' berhasil diperbarui."]);
        }

        return redirect()->route('admin.teams.edit', $team)
            ->with('success', "Pemain tim '{$team->name}' berhasil diperbarui.");
    }
}
