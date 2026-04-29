{{-- resources/views/partials/sidebar.blade.php --}}
@php
    $isRtl = in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']);

    // start-0 = inset-inline-start (left in LTR, right in RTL)
    $navItems = [
        ['route' => 'dashboard',      'label' => __('Dashboard'),  'icon' => 'grid'],
        ['route' => 'leads.index',    'label' => __('Leads'),      'icon' => 'inbox',
         'badge' => class_exists(\App\Models\Lead::class) ? \App\Models\Lead::count() : null],
        ['route' => 'followups.index','label' => __('Follow-ups'), 'icon' => 'clock',
         'badge' => class_exists(\App\Models\Followup::class) ? \App\Models\Followup::dueToday()->count() : null,
         'badge_color' => 'amber'],
        ['route' => 'clients.index',  'label' => __('Clients'),    'icon' => 'users'],
        ['route' => 'reports.index',  'label' => __('Reports'),    'icon' => 'chart'],
    ];
@endphp

{{-- start-0 = pinned to the appropriate side via logical CSS --}}
<aside class="w-64 shrink-0 bg-ink-950 text-ink-300 flex flex-col fixed inset-y-0 start-0 z-30">

    {{-- Brand --}}
    <div class="h-16 px-5 flex items-center gap-2.5 border-b border-white/5">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-pop shrink-0">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
            </svg>
        </div>
        <div class="min-w-0">
            <div class="text-white font-semibold tracking-tight">{{ __('Lumen') }}</div>
            <div class="text-[11px] text-ink-400 -mt-0.5">{{ __('Sales CRM') }}</div>
        </div>
    </div>

    {{-- Workspace switcher --}}
    <button class="mx-3 mt-3 px-3 py-2 rounded-lg flex items-center justify-between hover:bg-white/5 text-start transition">
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-6 h-6 rounded-md bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[11px] font-semibold shrink-0">
                {{ mb_strtoupper(mb_substr(auth()->user()->team->name ?? 'AC', 0, 2)) }}
            </div>
            <div class="min-w-0">
                <div class="text-sm text-white truncate">{{ auth()->user()->team->name ?? 'Acme Co.' }}</div>
                <div class="text-[11px] text-ink-400">{{ __('Sales workspace') }}</div>
            </div>
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 15l5 5 5-5"/><path d="M7 9l5-5 5 5"/></svg>
    </button>

    {{-- Nav --}}
    <nav class="flex-1 px-3 mt-4 space-y-0.5 overflow-y-auto">
        <div class="px-2 pb-1.5 text-[11px] uppercase tracking-wider text-ink-500 font-medium">{{ __('Workspace') }}</div>

        @foreach($navItems as $item)
            @php
                $active = request()->routeIs($item['route'])
                          || request()->routeIs(str_replace('.index', '.*', $item['route']));
            @endphp
            <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                      {{ $active ? 'bg-white/10 text-white' : 'hover:bg-white/5 text-ink-300' }}">
                <span class="w-4 h-4 shrink-0 {{ $active ? 'text-white' : 'text-ink-400' }}">
                    <x-icon :name="$item['icon']" />
                </span>
                <span class="flex-1 truncate">{{ $item['label'] }}</span>
                @if(!empty($item['badge']))
                    @php $color = $item['badge_color'] ?? 'gray'; @endphp
                    <span class="text-[11px] font-medium px-1.5 py-0.5 rounded shrink-0 ltr:font-mono
                                 {{ $color === 'amber' ? 'bg-amber-500/15 text-amber-300' : 'bg-white/5 text-ink-300' }}">
                        {{ $item['badge'] }}
                    </span>
                @endif
            </a>
        @endforeach

        <div class="px-2 pt-5 pb-1.5 text-[11px] uppercase tracking-wider text-ink-500 font-medium">{{ __('Account') }}</div>
        <a href="{{ Route::has('settings') ? route('settings') : '#' }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm hover:bg-white/5 text-ink-300">
            <span class="w-4 h-4 text-ink-400 shrink-0"><x-icon name="settings" /></span>
            {{ __('Settings') }}
        </a>

        {{-- Language switcher --}}
        <a href="{{ Route::has('locale.switch') ? route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') : '?lang=' . (app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm hover:bg-white/5 text-ink-300">
            <span class="w-4 h-4 text-ink-400 shrink-0">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
            </span>
            <span class="flex-1">{{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}</span>
            <span class="text-[10px] uppercase tracking-wide bg-white/5 px-1.5 py-0.5 rounded text-ink-400 shrink-0">
                {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
            </span>
        </a>
    </nav>

    {{-- User card --}}
    <div class="m-3 p-3 rounded-xl bg-white/5 flex items-center gap-3">
        @php
            $userName = auth()->user()->name ?? __('Guest');
            $parts = preg_split('/\s+/', trim($userName));
            $initials = mb_strtoupper(mb_substr($parts[0] ?? 'U', 0, 1) . mb_substr($parts[1] ?? '', 0, 1));
        @endphp
        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-pink-500 flex items-center justify-center text-white text-xs font-semibold shrink-0">
            {{ $initials }}
        </div>
        <div class="flex-1 min-w-0">
            <div class="text-sm text-white font-medium truncate">{{ $userName }}</div>
            <div class="text-[11px] text-ink-400 truncate">{{ auth()->user()->role ?? __('Member') }}</div>
        </div>
        @auth
            <form method="POST" action="{{ route('logout') }}" class="contents">
                @csrf
                <button type="submit" class="text-ink-400 hover:text-white shrink-0" title="{{ __('Sign out') }}">
                    {{-- Icon flips automatically because we use rtl:scale-x-[-1] --}}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="rtl:scale-x-[-1]">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" x2="9" y1="12" y2="12"/>
                    </svg>
                </button>
            </form>
        @endauth
    </div>
</aside>
