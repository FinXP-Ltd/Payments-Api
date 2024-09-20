<?php

namespace App\Traits\Support;

use Illuminate\Support\Str;

trait HasApiAccess
{
    public static function bootHasApiAccess(): void
    {
        static::creating(function ($model) {

            do {
                $key = self::KEY_PREFIX . Str::random(33);
                $isKeyExists = self::where('key', $key)->exists();
            } while (! empty($isKeyExists));

            $model->key = $key;

            do {
                $secret = self::SECRET_PREFIX . Str::random(33);
                $isSecretExists = self::where('secret', $secret)->exists();
            } while (! empty($isSecretExists));

            $model->secret = $secret;
        });
    }
}
