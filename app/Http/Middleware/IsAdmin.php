<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // return redirect('/home');;
        // return $request->user();
        if ($request->user()->is_admin == 0) {
            return response()->json(['error' => 'Not authorized.'], 403);
        }else{
            return $next($request);
        }
    }
}
