<?php

namespace App\Traits\Support;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, $searchTerm = null, $columns = []): Builder
    {
        if (sizeof($columns) < 1) {
            $columns = $this->_getSearchableFields();
        }

        if (is_null($searchTerm) || $searchTerm === '') {
            return $query;
        }

        $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);

        if (validateDate($searchTerm)) {
            $searchTerm = Carbon::createFromFormat('Y-m-d', $searchTerm)->format('Y-m-d');
        }

        return $query->whereLike($columns, $searchTerm);
    }

    private function _getSearchableFields()
    {
        return $this->searchable;
    }
}
