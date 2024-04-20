<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnlyGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()) {
            if(Auth::user()->role_id ==3 && Auth::user()->email_verified_at != null) {
                return redirect("HomepagePetani");
            }elseif(Auth::user()->role_id ==3 && Auth::user()->email_verified_at == null){
                Auth::logout();
                return redirect("login");
            }
            elseif(Auth::user()->role_id == 1){
                return redirect("DashboardSA");
            }elseif(Auth::user()->role_id == 2){
                return redirect("DashboardPemerintah");
            }elseif(Auth::user()->role_id == 4){
                return redirect("HomepageKT");
            }
        }
        return $next($request);
    }
}
