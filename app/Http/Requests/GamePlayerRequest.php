<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        ];
    }

    public function getData(): array
    {
        return $this->validated()['gamePlayer'];
    }
}
