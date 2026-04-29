{{-- resources/views/pages/dashboard.blade.php --}}
<x-layouts.app :title="__('crm.nav.dashboard')">

    @php
        $hour = now()->hour;
        $greetingKey = $hour < 12 ? 'greeting_morning' : ($hour < 18 ? 'greeting_afternoon' : 'greeting_evening');
        $firstName = explode(' ', auth()->user()->name ?? 'Friend')[0];
    @endphp

    {{-- ترويسة الصفحة --}}
    <div class="flex items-end justify-between mb-7 flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-ink-900">
                {{ __('crm.dashboard.'.$greetingKey, ['name' => $firstName]) }}
            </h1>
            <p class="text-sm text-ink-500 mt-1">{{ __('crm.dashboard.subtitle') }}</p>
        </div>

        <div class="flex items-center gap-2">
            <div class="flex items-center bg-white border border-ink-200 rounded-lg p-0.5 text-sm" role="group">
                @foreach(['7d', '30d', '90d'] as $range)
                    <a href="?range={{ $range }}"
                       class="px-3 py-1.5 rounded-md transition
                              {{ ($currentRange ?? '30d') === $range ? 'bg-ink-900 text-white' : 'text-ink-500 hover:text-ink-900' }}">
                        {{ $range }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- بطاقات KPI --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <x-kpi-card :label="__('crm.dashboard.kpi_leads_today')"
                    :value="$kpi['leads_today'] ?? 0"
                    :delta="(($kpi['leads_today_change'] ?? 0) >= 0 ? '+' : '').($kpi['leads_today_change'] ?? 0).'%'"
                    icon="inbox">
            <div class="flex items-end gap-0.5 h-8">
                @foreach(($kpi['leads_sparkline'] ?? [35,50,25,70,60,80,45,65,55,75,50,90]) as $i => $v)
                    @php
                        $color = $i < 6 ? 'bg-ink-100' : ($i < 9 ? 'bg-ink-200' : ($i < 11 ? 'bg-ink-300' : 'bg-brand-500'));
                    @endphp
                    <div class="w-1.5 {{ $color }} rounded-sm" style="height: {{ $v }}%"></div>
                @endforeach
            </div>
        </x-kpi-card>

        <x-kpi-card :label="__('crm.dashboard.kpi_followups_today')"
                    :value="$kpi['followups_today'] ?? 0"
                    :delta="__('crm.dashboard.overdue_count', ['count' => $kpi['followups_overdue'] ?? 0])"
                    delta-variant="rose"
                    icon="clock"
                    icon-tint="amber">
            @php
                $done = $kpi['followups_done'] ?? 0;
                $total = max(1, $kpi['followups_today'] ?? 1);
                $pct = round(($done / $total) * 100);
            @endphp
            <div class="flex items-center gap-2">
                <div class="flex-1 h-1.5 bg-ink-100 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-500 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>
                <span class="text-[11px] text-ink-500 font-medium">
                    {{ __('crm.dashboard.done_progress', ['done' => $done, 'total' => $kpi['followups_today'] ?? 0]) }}
                </span>
            </div>
        </x-kpi-card>

        <x-kpi-card :label="__('crm.dashboard.kpi_converted')"
                    :value="$kpi['converted'] ?? 0"
                    :delta="'+'.($kpi['converted_change'] ?? 0).'%'"
                    icon="check"
                    icon-tint="emerald">
            <div class="text-xs text-ink-500">
                <span class="latin-nums">${{ number_format($kpi['converted_value'] ?? 0) }}</span>
                <span class="text-ink-400">{{ __('crm.dashboard.total_value') }}</span>
            </div>
        </x-kpi-card>

        <x-kpi-card :label="__('crm.dashboard.kpi_rejected')"
                    :value="$kpi['rejected'] ?? 0"
                    :delta="($kpi['rejected_change'] ?? 0).'%'"
                    delta-variant="gray"
                    icon="x"
                    icon-tint="rose">
            <div class="text-xs text-ink-500">
                {{ __('crm.dashboard.top_reason', ['reason' => $kpi['top_rejection_reason'] ?? '—']) }}
            </div>
        </x-kpi-card>
    </div>

    {{-- صف الرسوم البيانية --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        <x-card :title="__('crm.dashboard.conversion_rate')"
                :subtitle="__('crm.dashboard.conversion_subtitle')"
                class="lg:col-span-2">
            <x-slot:actions>
                <div class="flex items-center gap-3 text-xs">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-sm bg-brand-500"></span><span class="text-ink-500">{{ __('crm.dashboard.this_period') }}</span></span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-sm bg-ink-200"></span><span class="text-ink-500">{{ __('crm.dashboard.previous') }}</span></span>
                </div>
            </x-slot>

            <svg viewBox="0 0 600 200" class="w-full h-48" dir="ltr">
                <defs>
                    <linearGradient id="grad-conversion" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#3b6ef5" stop-opacity="0.18"/>
                        <stop offset="100%" stop-color="#3b6ef5" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <g stroke="#eef0f2" stroke-width="1">
                    <line x1="0" y1="40" x2="600" y2="40"/>
                    <line x1="0" y1="90" x2="600" y2="90"/>
                    <line x1="0" y1="140" x2="600" y2="140"/>
                </g>
                <path d="{{ $conversionPathPrev ?? 'M0,150 L50,140 L100,145 L150,130 L200,135 L250,120 L300,125 L350,115 L400,120 L450,110 L500,115 L550,105 L600,108' }}"
                      fill="none" stroke="#dde0e5" stroke-width="2" stroke-linecap="round"/>
                <path d="{{ $conversionAreaPath ?? 'M0,160 L50,140 L100,150 L150,110 L200,120 L250,90 L300,95 L350,70 L400,80 L450,55 L500,60 L550,40 L600,45 L600,200 L0,200 Z' }}"
                      fill="url(#grad-conversion)"/>
                <path d="{{ $conversionPath ?? 'M0,160 L50,140 L100,150 L150,110 L200,120 L250,90 L300,95 L350,70 L400,80 L450,55 L500,60 L550,40 L600,45' }}"
                      fill="none" stroke="#3b6ef5" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </x-card>

        <x-card :title="__('crm.dashboard.rejection_reasons')" :subtitle="__('crm.dashboard.rejection_subtitle')">
            <div class="space-y-3.5">
                @foreach(($rejectionReasons ?? [
                    ['key' => 'price',      'pct' => 42, 'color' => 'bg-rose-500'],
                    ['key' => 'budget',     'pct' => 23, 'color' => 'bg-rose-400'],
                    ['key' => 'competitor', 'pct' => 18, 'color' => 'bg-rose-300'],
                    ['key' => 'timing',     'pct' => 11, 'color' => 'bg-rose-200'],
                    ['key' => 'other',      'pct' => 6,  'color' => 'bg-ink-300'],
                ]) as $r)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="text-ink-700">{{ __('crm.rejection_reasons.'.$r['key']) }}</span>
                            <span class="text-ink-500 font-medium">{{ $r['pct'] }}%</span>
                        </div>
                        <div class="h-1.5 bg-ink-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $r['color'] }} rounded-full" style="width: {{ $r['pct'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>

    {{-- النشاط الأخير + ملخّص خط المبيعات --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <x-card :title="__('crm.dashboard.recent_activity')" :padded="false" class="lg:col-span-2">
            <x-slot:actions>
                <a href="#" class="text-xs text-brand-600 hover:text-brand-700 font-medium">{{ __('crm.dashboard.view_all') }} →</a>
            </x-slot>
            <ul class="divide-y divide-ink-100">
                @forelse($recentActivities ?? [] as $activity)
                    <li class="px-5 py-3.5 flex items-center gap-3 hover:bg-ink-50/50">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <x-icon name="check" class="w-3.5 h-3.5" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm text-ink-900 truncate">{{ $activity->description }}</div>
                            <div class="text-xs text-ink-500">
                                {{ $activity->user->name ?? '' }} · <x-countdown :date="$activity->created_at" past />
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-12 text-center text-sm text-ink-500">{{ __('crm.followups.empty_subtitle') }}</li>
                @endforelse
            </ul>
        </x-card>

        <x-card :title="__('crm.dashboard.pipeline')">
            <x-slot:actions>
                <span class="text-xs text-ink-500">{{ __('crm.dashboard.leads_count', ['count' => $pipelineTotal ?? 0]) }}</span>
            </x-slot>
            <div class="space-y-3">
                @php
                    $stages = $pipelineStages ?? [
                        ['key' => 'new',        'count' => 38, 'pct' => 30, 'dot' => 'bg-ink-400',     'bar' => 'bg-ink-400'],
                        ['key' => 'followup',   'count' => 29, 'pct' => 23, 'dot' => 'bg-amber-500',   'bar' => 'bg-amber-500'],
                        ['key' => 'interested', 'count' => 22, 'pct' => 17, 'dot' => 'bg-brand-500',   'bar' => 'bg-brand-500'],
                        ['key' => 'converted',  'count' => 28, 'pct' => 22, 'dot' => 'bg-emerald-500', 'bar' => 'bg-emerald-500'],
                        ['key' => 'rejected',   'count' => 11, 'pct' => 8,  'dot' => 'bg-rose-500',    'bar' => 'bg-rose-500'],
                    ];
                @endphp
                @foreach($stages as $s)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="flex items-center gap-2 text-sm text-ink-700">
                                <span class="w-2 h-2 rounded-full {{ $s['dot'] }}"></span>{{ __('crm.status.'.$s['key']) }}
                            </span>
                            <span class="text-sm text-ink-500 font-medium">{{ $s['count'] }}</span>
                        </div>
                        <div class="h-1.5 bg-ink-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $s['bar'] }} rounded-full" style="width: {{ $s['pct'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>
</x-layouts.app>
