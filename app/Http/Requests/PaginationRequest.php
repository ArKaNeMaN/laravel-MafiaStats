<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{

    public bool $isPaginate = false;
    public int $page = 1;
    public int $perPage = 10;

    public const PAGE_INPUT_KEY = 'p';
    public const PER_PAGE_INPUT_KEY = 'pp';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->isPaginate = $this->hasAny([self::PAGE_INPUT_KEY, self::PER_PAGE_INPUT_KEY]);
        $this->page = (int) $this->get(self::PAGE_INPUT_KEY, $this->page);
        $this->perPage = (int) $this->get(self::PER_PAGE_INPUT_KEY, $this->perPage);

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
            self::PAGE_INPUT_KEY => ['numeric', 'nullable', 'min:1'],
            self::PER_PAGE_INPUT_KEY => ['numeric', 'nullable', 'min:1', 'max:100'],
        ];
    }

    public function doPaginate($q, $cols = ['*']){
        return $this->isPaginate
            ? $this->qPaginate($q, $cols)
            : $q->get();
    }

    private function qPaginate($q, $cols = ['*']){
        return $q->paginate($this->perPage, $cols, self::PAGE_INPUT_KEY, $this->page);
    }
}
