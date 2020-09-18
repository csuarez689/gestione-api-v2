<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

/**
 * Trait for apply query params for search, order and paginate eloquent builder
 * Can perform orderBy by any attribute
 * Only can perform search over $searchable model attribute
 * Car perform pagination between 5-50, otherwise will be set 20 results as default
 */
trait ApplyQueryParams
{
    /**
     * Perform sort, seach and paginate by http query params
     *
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     **/
    public function scopeApplyQueryParams($query)
    {

        // pagination restrictions
        $validator = Validator::make(request()->all(), [
            'per_page' => 'integer|max:200|min:5',
        ]);

        //get query params and sanitize them
        $sort_by = (request()->has('sort_by') &&  in_array(strtolower(request()->sort_by), $this->sortable)) ? request()->sort_by : null;
        $direction = (request()->has('direction') && strcasecmp(request()->direction, 'desc') == 0)  ? 'desc' : 'asc';
        $search = request()->search ?? '';
        $perPage = (request()->has('per_page') && !$validator->fails()) ? (int) request()->per_page : null;

        // Perform search
        if ($search) {
            $query->where(function ($q) use ($search) {
                foreach ($this->searchable as $field) {
                    $q->orWhere($field, 'like', "%$search%");
                }
            });
        }

        if ($sort_by) {
            //Perform sort
            $query->orderBy($sort_by, $direction);
        }


        if ($perPage) {
            //perform pagination
            $query = $query->paginate($perPage);
            //maintain query params in pagination
        } else {
            $query = $query->get();
        }
        return $query;
    }
}
