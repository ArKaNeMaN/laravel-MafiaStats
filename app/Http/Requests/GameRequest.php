<?php

namespace App\Http\Requests;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(
            !$this->has('game.leader_id')
            && is_null($this->user()?->player_id)
        ) return false;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'game' => ['required', 'array'],

            'game.leader_id' => ['nullable', 'exists:players,id'],
            'game.best_red_id' => ['nullable', 'exists:players,id'],
            'game.best_black_id' => ['nullable', 'exists:players,id'],

            'game.date' => ['nullable', 'date'],
            'game.tournament_id' => ['nullable', 'exists:tournaments,id'],

            'game.result' => ['nullable', Rule::in(Game::RESULTS)],
            'game.description' => ['nullable', 'string', 'max:511'],
        ];
    }

    public function validated(): array
    {
        $data = parent::validated();

        $data['game']['date'] = $data['game']['date'] ?? Carbon::now();
        $data['game']['leader_id'] = $data['game']['leader_id'] ?? $this->user()->player_id;
        $data['game']['best_red_id'] = $data['game']['best_red_id'] ?? null;
        $data['game']['best_black_id'] = $data['game']['best_black_id'] ?? null;

        return $data;
    }

    public function getData(){
        return $this->validated()['game'];
    }
}
