<?php

namespace App\Http\Middleware;

use App\Interfaces\MustVerifyPhone;
use Closure;
use Illuminate\Http\Request;

class EnsurePhoneIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyPhone &&
                ! $request->user()->hasVerifiedPhone())) {
            return $request->expectsJson()
                ? abort(403, 'Your phone number is not verified.')
                : redirect()->route('phone-verification');
        }
        return $next($request);
    }
}
