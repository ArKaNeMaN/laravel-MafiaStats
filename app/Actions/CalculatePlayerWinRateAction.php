<?php

namespace App\Actions;

use App\Models\GamePlayer;
use App\Models\Player;

final class CalculatePlayerWinRateAction
{
    public function execute(Player $player): array
    {
        $games = $player->games()
            ->withPivot(['role'])
            ->whereNotNull('result')
            ->get();

        $wins = [
            'all' => 0,
            'black' => 0,
            'don' => 0,
            'red' => 0,
            'sheriff' => 0,
        ];
        $count = [
            'all' => $games->count(),
            'black' => 0,
            'don' => 0,
            'red' => 0,
            'sheriff' => 0,
        ];
        foreach ($games as $game) {
            if(is_null($game->result))
                continue;

            if ($game->result == GamePlayer::ROLES_TEAMS[$game->pivot->role]) {
                $wins['all']++;
                $wins[$game->pivot->role]++;
            }
            $count[$game->pivot->role]++;
        }

        $rates = [];
        foreach ($wins as $role => $winsByRole) {
            $rates[$role] = $winsByRole > 0 ? $winsByRole / $count[$role] : 0;
        }

        return $rates;
    }
}
