<?php

namespace App\Http\Requests;

use App\Models\GamePlayer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GamePlayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gamePlayer' => ['required', 'array'],

            'gamePlayer.player_id' => ['required', 'numeric', 'exists:players,id'],
            'gamePlayer.game_id' => ['required', 'numeric', 'exists:games,id'],
            'gamePlayer.role' => ['required', 'string', Rule::in(GamePlayer::ROLES)],
            'gamePlayer.score' => ['nullable', 'numeric'],
            'gamePlayer.ingame_player_id' => ['required', 'numeric'],
        ];
    }

    public function getData(): array
    {
        return $this->validated()['gamePlayer'];
    }
}
