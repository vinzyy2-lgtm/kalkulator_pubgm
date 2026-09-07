<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = ['name', 'order'];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class)->orderBy('slot');
    }

    public function matchResults(): HasMany
    {
        return $this->hasMany(MatchResult::class);
    }

    /**
     * Get total points accumulated across all matches (place points + kill points).
     */
    public function getTotalPoints(): int
    {
        return $this->matchResults->sum(function (MatchResult $result) {
            return $result->getPlacePoints() + $result->getTotalKills();
        });
    }

    /**
     * Get standings data: total points, total kills, matches played, best rank.
     */
    public function getStandingsData(): array
    {
        $results = $this->matchResults;

        $totalPoints = $results->sum(fn(MatchResult $r) => $r->getPlacePoints() + $r->getTotalKills());
        $totalKills  = $results->sum(fn(MatchResult $r) => $r->getTotalKills());
        $matchesPlayed = $results->count();
        $bestRank = $results->isNotEmpty() ? $results->min('rank') : null;

        return [
            'total_points'  => $totalPoints,
            'total_kills'   => $totalKills,
            'matches_played'=> $matchesPlayed,
            'best_rank'     => $bestRank,
        ];
    }
}
