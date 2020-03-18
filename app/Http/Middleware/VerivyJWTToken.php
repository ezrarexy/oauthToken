<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;
use JWTAuthException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerivyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {
            $user = JWTAuth::toUser($request->input(key:'token'));
        } catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['token expired'], $e->getStatusCode);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['token invalid'], $e->getStatusCode);
            } else {
                return response()->json(['error'=>'token is required']);
            }
        }

        return $next($request);
    }
}
