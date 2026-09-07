<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameMatch extends Model
{
    protected $fillable = ['match_number'];

    public function matchResults(): HasMany
    {
        return $this->hasMany(MatchResult::class, 'game_match_id');
    }
}
