<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameMatch;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function index(): View
    {
        $matches = GameMatch::withCount('matchResults')->orderBy('match_number')->get();
        return view('admin.matches.index', compact('matches'));
    }

    public function create(): View
    {
        $nextNumber = (GameMatch::max('match_number') ?? 0) + 1;
        return view('admin.matches.create', compact('nextNumber'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'match_number' => ['required', 'integer', 'min:1'],
        ]);

        $match = GameMatch::create($validated);

        return redirect()->route('admin.matches.show', $match)
            ->with('success', "Match #{$match->match_number} berhasil dibuat.");
    }

    public function show(GameMatch $match): View
    {
        $match->load(['matchResults.team']);
        $teams = Team::orderBy('order')->get();

        // Build results map: team_id => MatchResult
        $resultsMap = $match->matchResults->keyBy('team_id');

        return view('admin.matches.show', compact('match', 'teams', 'resultsMap'));
    }

    public function edit(GameMatch $match): View
    {
        return view('admin.matches.edit', compact('match'));
    }

    public function update(Request $request, GameMatch $match): RedirectResponse
    {
        $validated = $request->validate([
            'match_number' => ['required', 'integer', 'min:1'],
        ]);

        $match->update($validated);

        return redirect()->route('admin.matches.index')
            ->with('success', "Match #{$match->match_number} berhasil diperbarui.");
    }

    public function destroy(GameMatch $match): RedirectResponse
    {
        $number = $match->match_number;
        $match->delete();

        return redirect()->route('admin.matches.index')
            ->with('success', "Match #{$number} berhasil dihapus.");
    }
}
