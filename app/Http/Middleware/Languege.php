<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Languege
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
        $locale=$request->segment(1);
        if (!array_key_exists($locale,config('app.locales'))){
            $segments=$request->segments();
            $segments[0]= config('app.fallback_locale');

            return redirect(implode('/',$segments));
        }

        app()->setLocale($locale);
        return $next($request);
    }
}
