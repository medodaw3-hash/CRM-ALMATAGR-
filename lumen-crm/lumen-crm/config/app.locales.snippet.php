<?php
// config/app.php — add this snippet to your existing config/app.php
// Just add the 'supported_locales' key. Keep your other config values.

return [
    // ... your existing config ...

    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => 'en',

    // Add this:
    'supported_locales' => [
        'en' => ['name' => 'English',  'native' => 'English',  'dir' => 'ltr', 'flag' => '🇬🇧'],
        'ar' => ['name' => 'Arabic',   'native' => 'العربية',  'dir' => 'rtl', 'flag' => '🇸🇦'],
    ],

    // ... rest of your config ...
];
