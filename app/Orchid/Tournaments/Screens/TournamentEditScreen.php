<?php

namespace App\Orchid\Tournaments\Screens;

use App\Http\Requests\TourRequest;
use App\Models\Tournament;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TournamentEditScreen extends Screen
{
    protected Tournament $tour;

    public function query(Tournament $tour): array
    {
        $this->tour = $tour;

        $this->name = $this->tour->exists
            ? "Редактирование турнира '{$this->tour->name}'"
            : 'Создание турнира';

        return [
            'tournament' => $this->tour,
        ];
    }

    public function commandBar(): array
    {
        return $this->tour->exists ? [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
            Button::make('Удалить')
                ->icon('trash')
                ->method('delete'),
        ] : [
            Button::make('Создать')
                ->icon('plus')
                ->method('create'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('tournament.name')
                    ->title('Название')
                    ->placeholder('Название турнира'),

                TextArea::make('tournament.description')
                    ->title('Описание')
                    ->placeholder('Описание турнира'),
            ]),
        ];
    }

    public function create(TourRequest $req){
        $tour = Tournament::create($req->getData());

        Toast::success("Турнир $tour->name создан.");

        return redirect()->route('app.mafia.tournaments.edit', $tour);
    }

    public function save(Tournament $tour, TourRequest $req){
        $tour->updateOrFail($req->getData());

        Toast::info("Турнир $tour->name изменён.");

        return back();
    }

    public function delete(Tournament $tour){
        $name = $tour->name;
        $tour->deleteOrFail();

        Toast::info("Турнир $name удалён.");

        return redirect()->route('app.mafia.tournaments.list');
    }
}
