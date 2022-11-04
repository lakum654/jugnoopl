<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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

        if (Auth::check()) {

            if (Auth::user()->role == 'supplier' || Auth::user()->role == 'shopkeeper' || Auth::user()->role == 'warehouse') {
                $request->merge(['warehouse_id','dfdf']);
                return redirect('user/u-dashboard');
            } else if (Auth::user()->role == 'admin') {
                return $next($request);
            } else {
                return Redirect('/');
            }
        }
         return Redirect('/');
    }
}
