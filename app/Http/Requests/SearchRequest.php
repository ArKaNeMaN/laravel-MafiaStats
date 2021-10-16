<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;

class SearchRequest extends PaginationRequest
{
    public function doSearch($q, array $searchParams){
        foreach ($searchParams as $input => $params){
            if(!$this->has($input))
                continue;

            $method = $params['method'] ?? 'orWhere';
            $attributes = (array) ($params['attrs'] ?? $input);
            $operator = $params['oper'] ?? null;

            $q->where(function ($q) use ($input, $method, $operator, $attributes) {
                foreach ($attributes as $attribute){
                    if($operator !== null)
                        $q->$method(
                            $attribute,
                            $operator,
                            $this->get($input)
                        );
                    else
                        $q->$method(
                            $attribute,
                            $this->get($input)
                        );
                }
            });
        }

        return $q;
    }

    public function doPaginatedSearch($q, array $search, $paginateCols = ['*']){
        return $this->doPaginate(
            $this->doSearch($q, $search),
            $paginateCols
        );
    }
}
