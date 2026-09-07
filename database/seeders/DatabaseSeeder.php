<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Player;
use App\Models\GameMatch;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the database with 18 teams (each with 4 main players + 1 reserve)
     * and 1 initial game match.
     */
    public function run(): void
    {
        // Create 18 teams
        for ($i = 1; $i <= 18; $i++) {
            $team = Team::create([
                'name'  => "Team $i",
                'order' => $i,
            ]);

            // Create 4 main players (slot 0-3) + 1 reserve (slot 4)
            for ($slot = 0; $slot < 4; $slot++) {
                Player::create([
                    'team_id' => $team->id,
                    'name'    => "Player " . ($slot + 1),
                    'slot'    => $slot,
                ]);
            }

            // Reserve player
            Player::create([
                'team_id' => $team->id,
                'name'    => 'Reserve',
                'slot'    => 4,
            ]);
        }

        // Seed 1 initial game match
        GameMatch::create([
            'match_number' => 1,
        ]);

        $this->command->info('Seeded 18 teams with 5 players each, and 1 game match.');
    }
}
