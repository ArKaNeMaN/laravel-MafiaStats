<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tournament' => ['required', 'array'],

            'tournament.name' => ['required', 'string', 'max:255'],
            'tournament.description' => ['nullable', 'string', 'max:1023'],
        ];
    }

    public function getData(): array
    {
        return $this->validated()['tournament'];
    }
}
