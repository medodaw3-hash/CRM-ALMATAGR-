{{-- resources/views/layouts/app.blade.php --}}
@php
    $locale = app()->getLocale();
    $isRtl  = in_array($locale, ['ar', 'he', 'fa', 'ur']);
    $dir    = $isRtl ? 'rtl' : 'ltr';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Lumen CRM') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Latin --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;450;500;550;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Arabic — only loaded when needed (saves ~80kb) --}}
    @if($isRtl)
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="bg-[#fafbfc] text-ink-900 font-sans antialiased min-h-screen {{ $isRtl ? 'rtl' : 'ltr' }}">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        {{-- ms-64 = margin-start (left in LTR, right in RTL). This is THE key change. --}}
        <main class="flex-1 ms-64 min-w-0">
            @include('partials.topbar')

            <div class="px-7 py-7 max-w-[1600px] mx-auto">
                @isset($header)
                    <div class="mb-6">{{ $header }}</div>
                @endisset

                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>

    <div id="modals"></div>

    @stack('scripts')
</body>
</html>
