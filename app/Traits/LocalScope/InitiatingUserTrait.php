<?php

namespace App\Traits\LocalScope;

use Illuminate\Database\Eloquent\Builder;

trait InitiatingUserTrait
{
    public function scopeInitiatingUser(Builder $query, $userId): Builder
    {
        return $query->where('initiating_party_id', $userId);
    }
}
