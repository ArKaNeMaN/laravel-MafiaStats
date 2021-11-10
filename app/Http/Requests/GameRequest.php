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
            && is_null($this->user()?->player())
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

        $data['date'] = $data['date'] ?? Carbon::now();
        $data['leader_id'] = $data['leader_id'] ?? $this->user()->player()->id;

        return $data;
    }

    public function getData(){
        return $this->validated()['game'];
    }
}
