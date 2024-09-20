<?php

namespace App\Traits\Merchant;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use App\Exceptions\ApiAccessException;
use App\Models\Settings\ApiAccess;

trait HasApiKeys
{
    public function apiAccess(): HasMany
    {
        if (Str::startsWith(request()->path(), ['sandbox'])) {
            return $this->setConnection(config('database.sandbox'))->hasMany(
                'App\Models\Settings\ApiAccess',
                'merchant_id',
                'id'
            );
        }

        return $this->hasMany(
            'App\Models\Settings\ApiAccess',
            'merchant_id',
            'id'
        );
    }

    public function getApiKeys()
    {
        $api = $this->apiAccess()->where('revoked', ApiAccess::STATUS_ACTIVE)
            ->first();

        if (!$api) {
            throw ApiAccessException::notSet();
        }

        return (object) [
            'api' => $api->key,
            'secret' => $api->secret
        ];
    }

    public function generateApiKeys()
    {
        $apiKeys = $this->apiAccess;

        $apiKeys
            ->each(
                function ($item) {
                    $item->revokeToken();
                }
            );

        $access = $this->apiAccess()->create([
            'revoked' => false,
            'description' => request()->input('description', null)
        ]);

        if (! $access) {
            throw ApiAccessException::notSet();
        }

        return $access;
    }

    public function isApiKeySet(): bool
    {
        return $this->apiAccess()->where('revoked', ApiAccess::STATUS_ACTIVE)->exists();
    }
}
