<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
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
        $user = Auth::user();

        if ( ! $request->user()->subscribed('main')) {
            return redirect('/payment');
        }
        // elseif($user->subscribedToPlan('Energy Service 2', 'main')){
        //     return redirect('service.energy_service_2');
        // }
        // elseif($user->subscribedToPlan('Energy Service 3', 'main')){
        //     return redirect('service.energy_service_3');
        // }
        return $next($request);
    }
}
