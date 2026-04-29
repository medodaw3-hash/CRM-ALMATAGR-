{{-- resources/views/partials/topbar.blade.php --}}
<header class="h-16 sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-ink-100 flex items-center px-7 gap-4">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-ink-500">
        @isset($breadcrumb)
            {{ $breadcrumb }}
        @else
            <span class="text-ink-900 font-medium">{{ $pageTitle ?? __('Dashboard') }}</span>
        @endisset
    </div>

    {{-- Global search --}}
    <div class="flex-1 max-w-md mx-auto relative">
        <svg class="absolute start-3 top-1/2 -translate-y-1/2 text-ink-400 pointer-events-none" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
        </svg>
        <input type="search"
               id="global-search"
               class="w-full ps-9 pe-12 h-9 rounded-lg bg-ink-50 border border-transparent text-sm placeholder-ink-400 focus:outline-none focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition"
               placeholder="{{ __('Search leads, clients, reports…') }}">
        <kbd class="absolute end-2 top-1/2 -translate-y-1/2 text-[11px] text-ink-400 bg-white border border-ink-200 px-1.5 py-0.5 rounded font-mono">⌘K</kbd>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-1.5">
        <a href="{{ Route::has('notifications') ? route('notifications') : '#' }}"
           class="h-9 w-9 rounded-lg hover:bg-ink-50 flex items-center justify-center text-ink-500 relative" title="{{ __('Notifications') }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
            </svg>
            @if(($unread ?? 0) > 0)
                <span class="absolute top-1.5 end-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
            @endif
        </a>

        @hasSection('topbar-actions')
            @yield('topbar-actions')
        @else
            <a href="{{ Route::has('leads.create') ? route('leads.create') : '#' }}"
               class="h-9 px-3 rounded-lg bg-ink-900 text-white text-sm font-medium hover:bg-ink-800 flex items-center gap-1.5 transition">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                {{ __('New lead') }}
            </a>
        @endif
    </div>
</header>
