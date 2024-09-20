<?php

namespace App\Http\Middleware;

use Closure;

use KeycloakGuard\Token;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class KeycloakAccess
{
    public function handle(Request $request, Closure $next, $parameter)
    {
        try {

            $client = $this->validateToken($request->bearerToken());

            if ($parameter != $client->scope) {
                throw new AuthorizationException('Unauthorize!');
            }

        } catch (AuthorizationException $e) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'status' => 'failed',
                'message' => $e->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
    private function validateToken($token)
    {
         try {

            return Token::decode($token, config('keycloak.realm_public_key'), config('keycloak.leeway'));

        } catch (\Exception $e) {
            info($e);
            throw new AuthorizationException('Unauthorize!');
        }
    }
}
