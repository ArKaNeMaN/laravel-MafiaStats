<?php

namespace App\Orchid\Layouts\Games;

use App\Models\Game;
use App\Models\Player;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class GameEditLayout extends Rows
{
    protected function fields(): array
    {
        return [
            DateTimer::make('game.date')
                ->title('Дата проведения')
                ->placeholder('Укажите дату првоедения игры')
                ->format('Y-m-d')
                ->required(),

            Relation::make('game.leader_id')
                ->title('Ведущий')
                ->placeholder('Выберите ведущего')
                ->fromModel(Player::class, 'nickname')
                ->required(),

            Relation::make('game.best_red_id')
                ->title('Лучший мирный игрок')
                ->placeholder('Выберите лучшего мирного игрока')
                ->fromModel(Player::class, 'nickname'),

            Relation::make('game.best_black_id')
                ->title('Лучший игрок мафии')
                ->placeholder('Выберите лучшего игрока мафии')
                ->fromModel(Player::class, 'nickname'),

            Select::make('game.result')
                ->title('Результат игры')
                ->options(Game::RESULT_TITLES),
        ];
    }
}
