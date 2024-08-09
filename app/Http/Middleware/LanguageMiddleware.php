<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Illuminate\Http\Request;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Cookie::has('language')) {
            app()->setLocale(Cookie::queued('language') ?: Cookie::get('language'));
        }

        return $next($request);
    }
}
