<?php

namespace App\Actions;

use App\Infrastructure\DateRange;
use App\Models\GamePlayer;
use App\Models\Player;
use JetBrains\PhpStorm\ArrayShape;

class CalculatePlayerScoreForPeriodAction
{
    #[ArrayShape(['score' => "mixed", 'wins' => "int"])]
    public function execute(Player $player, DateRange $period): array
    {
        $games = $player->games()
            ->withPivot(['score', 'role', 'is_removed'])
            ->where('date', '>=', $period->getFrom())
            ->where('date', '<=', $period->getTo())
            ->whereNotNull('result')
            ->get();


        $score = 0.0;
        $wins = 0;
        foreach ($games as $game) {
            $score += $game->pivot->score;

            if ($game->result == GamePlayer::ROLES_TEAMS[$game->pivot->role]) {
                $score += 1.0;
                $wins++;
            }

            if ($game->pivot->is_removed) {
                $score -= 0.5;
            }
        }

        return [
            'score' => round($score, 1),
            'wins' => $wins,
        ];
    }
}
