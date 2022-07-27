<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ManageFcmToken
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
        if ($request->hasCookie('FCM_TOKEN')) {
            $user = auth()->user();
            if ($user) {
                $user->update(['fcm_token' => $request->cookie('FCM_TOKEN')]);
            }
            else {
                User::query()->where('fcm_token', $request->cookie('FCM_TOKEN'))
                    ->update(['fcm_token' => null]);
            }
        }
        return $next($request);
    }
}
