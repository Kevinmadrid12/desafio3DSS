<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckAttendanceTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();
        if ($now->dayOfWeekIso == 6 && $now->hour >= 8 && $now->hour < 11) {
            return $next($request);
        }

        return redirect('/')->with('error', 'La toma de asistencia solo está disponible los sábados de 8:00 AM a 11:00 AM.');
    }
}
