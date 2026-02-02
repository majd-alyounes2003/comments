<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $lastActivity = session('last_activity');
            $timeout = 600; // 10 minutes in seconds

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->with('error', 'جلسه شما به دلیل عدم فعالیت منقضی شده است. لطفا دوباره وارد شوید.');
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
