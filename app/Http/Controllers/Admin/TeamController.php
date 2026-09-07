<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Team::withCount('players')->orderBy('order')->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function create(): View
    {
        return view('admin.teams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
        ]);

        $team = Team::create([
            'name'  => $validated['name'],
            'order' => $validated['order'] ?? 0,
        ]);

        // Create 5 default player slots for the new team
        for ($slot = 0; $slot < 5; $slot++) {
            Player::create([
                'team_id' => $team->id,
                'name'    => $slot === 4 ? 'Reserve' : "Player " . ($slot + 1),
                'slot'    => $slot,
            ]);
        }

        return redirect()->route('admin.teams.index')
            ->with('success', "Tim '{$team->name}' berhasil ditambahkan.");
    }

    public function show(Team $team): View
    {
        $team->load(['players', 'matchResults.gameMatch']);
        return view('admin.teams.show', compact('team'));
    }

    public function edit(Team $team): View
    {
        $team->load('players');
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
        ]);

        $team->update([
            'name'  => $validated['name'],
            'order' => $validated['order'] ?? $team->order,
        ]);

        return redirect()->route('admin.teams.index')
            ->with('success', "Tim '{$team->name}' berhasil diperbarui.");
    }

    public function destroy(Team $team): RedirectResponse
    {
        $name = $team->name;
        $team->delete();

        return redirect()->route('admin.teams.index')
            ->with('success', "Tim '{$name}' berhasil dihapus.");
    }
}
