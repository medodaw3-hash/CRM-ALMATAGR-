<?php
// app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Detects locale from (in order): query param `?lang=`, session, user preference, default.
     * Stores it in the session for subsequent requests.
     */
    public function handle(Request $request, Closure $next)
    {
        $supported = config('app.supported_locales', ['en', 'ar']);
        $default   = config('app.locale', 'en');

        // 1. URL parameter (?lang=ar) — set & remember
        if ($request->has('lang') && in_array($request->get('lang'), $supported)) {
            session(['locale' => $request->get('lang')]);
        }

        // 2. Session
        $locale = session('locale');

        // 3. Authenticated user's saved preference
        if (!$locale && $request->user() && !empty($request->user()->locale)) {
            $locale = $request->user()->locale;
        }

        // 4. Browser's Accept-Language header
        if (!$locale) {
            $locale = $request->getPreferredLanguage($supported);
        }

        // 5. Fallback to default
        if (!in_array($locale, $supported)) {
            $locale = $default;
        }

        App::setLocale($locale);
        session(['locale' => $locale]);

        // Share helpful values with all views
        view()->share([
            'currentLocale' => $locale,
            'isRtl'         => in_array($locale, ['ar', 'he', 'fa', 'ur']),
            'dir'           => in_array($locale, ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr',
        ]);

        return $next($request);
    }
}
