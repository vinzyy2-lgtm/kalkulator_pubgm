<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    protected $fillable = ['team_id', 'name', 'slot'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get a human-readable label for this player's slot.
     */
    public function getSlotLabel(): string
    {
        $labels = [0 => 'P1', 1 => 'P2', 2 => 'P3', 3 => 'P4', 4 => 'Reserve'];
        return $labels[$this->slot] ?? "P{$this->slot}";
    }
}
