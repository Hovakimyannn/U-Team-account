<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetermineGuard
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request                                                                          $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $role = $request->role;

        if (!$role) {
            $role = DB::query()
                ->select('role')
                ->from('sessions')
                ->where('id', '=', $request->session()->getId())
                ->value('role');
        }

        auth()->setDefaultDriver($role);

        return $next($request);
    }
}
