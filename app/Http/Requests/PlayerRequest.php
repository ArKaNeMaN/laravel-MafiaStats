<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'player' => ['required', 'array'],

            'player.name' => ['required', 'string', 'max:64'],
            'player.nickname' => ['required', 'string', 'max:64'],
            'player.birthday' => ['nullable', 'date'],
        ];
    }

    public function getData(): array
    {
        return $this->validated()['player'];
    }
}
