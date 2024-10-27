<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class InactivityLogout
{
    public function handle($request, Closure $next)
    {
        if (session()->has('last_activity')) {
            if (time() - session('last_activity') > config('session.lifetime') * 60) {
                Auth::logout();
                session()->invalidate();
                return redirect()->route('login')->with('status', 'Session expirée. Veuillez vous reconnecter.');
            }
        }

        session(['last_activity' => time()]);
        return $next($request);
    }
}
