<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserSession;
class ApiAuthentication
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
        if (!empty($request->header('Authorization')) && UserSession::whereToken($request->header('Authorization'))->exists()) {
            return $next($request);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Your session has been expired! please login again.',
            'data' => null
        ], 401);

    }
}
