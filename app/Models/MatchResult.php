<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchResult extends Model
{
    /**
     * PMWC placement point table.
     * Rank 1=10, 2=6, 3=5, 4=4, 5=3, 6=2, 7-8=1, 9-18=0
     */
    const PMWC_POINTS = [1 => 10, 2 => 6, 3 => 5, 4 => 4, 5 => 3, 6 => 2, 7 => 1, 8 => 1];

    protected $fillable = [
        'game_match_id',
        'team_id',
        'rank',
        'p0_kills',
        'p1_kills',
        'p2_kills',
        'p3_kills',
        'p4_kills',
    ];

    public function gameMatch(): BelongsTo
    {
        return $this->belongsTo(GameMatch::class, 'game_match_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get total kills by all players in this match result.
     */
    public function getTotalKills(): int
    {
        return (int) $this->p0_kills
             + (int) $this->p1_kills
             + (int) $this->p2_kills
             + (int) $this->p3_kills
             + (int) $this->p4_kills;
    }

    /**
     * Get placement points based on PMWC point system.
     */
    public function getPlacePoints(): int
    {
        return self::PMWC_POINTS[$this->rank] ?? 0;
    }

    /**
     * Get total points for this result (placement + kills).
     */
    public function getTotalPoints(): int
    {
        return $this->getPlacePoints() + $this->getTotalKills();
    }
}
