<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request Request Instance
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function redirectTo($request)
    {
        throw new AuthorizationException('Unauthorized to make a request', 401);
    }
}
