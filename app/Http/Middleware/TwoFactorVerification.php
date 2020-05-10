<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Support\Str;
use App\Mail\TwoFactorAuthMail;

class TwoFactorVerification
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
        $user = auth()->user();
        if ($user->two_factor_expiry > \Carbon\Carbon::now()) {
            return $next($request);
        }

        $user->two_factor_token = Str::random(10);
        $user->save();
        \Mail::to($user)->send(new TwoFactorAuthMail($user->two_factor_token));
        return redirect('/two-fa');
        // return $next($request);
    }
}
