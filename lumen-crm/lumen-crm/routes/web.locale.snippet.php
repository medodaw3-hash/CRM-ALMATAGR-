<?php
// routes/web.php — add this route for the language switcher
// (or merge into your existing routes file)

use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', function (string $locale) {
    $supported = array_keys(config('app.supported_locales', ['en' => [], 'ar' => []]));

    if (in_array($locale, $supported)) {
        session(['locale' => $locale]);

        // If user is authenticated, persist their preference
        if (auth()->check() && \Schema::hasColumn('users', 'locale')) {
            auth()->user()->update(['locale' => $locale]);
        }
    }

    return back();
})->name('locale.switch');
