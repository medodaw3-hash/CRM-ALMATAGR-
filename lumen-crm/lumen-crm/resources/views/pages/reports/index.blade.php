{{-- resources/views/pages/reports/index.blade.php --}}
<x-layouts.app :title="__('crm.reports.title')">

    @php
        $rangeKey = $range ?? '30d';
        $rangeLabel = __('crm.reports.range_'.$rangeKey);
    @endphp

    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-ink-900">{{ __('crm.reports.title') }}</h1>
            <p class="text-sm text-ink-500 mt-1">{{ __('crm.reports.subtitle', ['range' => $rangeLabel]) }}</p>
        </div>
        <div class="flex items-center gap-2">
            <select name="range" onchange="window.location.search='?range='+this.value"
                    class="h-9 px-3 rounded-lg border border-ink-200 bg-white text-sm font-medium text-ink-700">
                <option value="7d"  @selected($rangeKey === '7d')>{{ __('crm.reports.range_7d') }}</option>
                <option value="30d" @selected($rangeKey === '30d')>{{ __('crm.reports.range_30d') }}</option>
                <option value="90d" @selected($rangeKey === '90d')>{{ __('crm.reports.range_90d') }}</option>
                <option value="ytd" @selected($rangeKey === 'ytd')>{{ __('crm.reports.range_ytd') }}</option>
            </select>
            <x-button variant="secondary" icon="download" :href="route('reports.export', ['format' => 'pdf'])">{{ __('crm.reports.export_pdf') }}</x-button>
        </div>
    </div>

    {{-- الصف العلوي: التحويل + العملاء حسب الموظف --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

        <x-card>
            <div class="flex items-baseline justify-between">
                <div>
                    <div class="text-sm font-medium text-ink-900">{{ __('crm.reports.conversion_rate') }}</div>
                    <div class="text-xs text-ink-500 mt-0.5">{{ __('crm.reports.lead_to_client') }}</div>
                </div>
                <div class="text-end">
                    <div class="text-2xl font-semibold text-ink-900 latin-nums">{{ $conversionRate ?? '0' }}%</div>
                    <div class="text-xs font-medium {{ ($conversionDelta ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ ($conversionDelta ?? 0) >= 0 ? '+' : '' }}{{ $conversionDelta ?? 0 }}% {{ __('crm.reports.vs_prev') }}
                    </div>
                </div>
            </div>
            <svg viewBox="0 0 600 180" class="w-full h-44 mt-3" dir="ltr">
                <defs>
                    <linearGradient id="grad-conv-rate" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#10b981" stop-opacity="0.18"/>
                        <stop offset="100%" stop-color="#10b981" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <g stroke="#eef0f2" stroke-width="1">
                    <line x1="0" y1="40"  x2="600" y2="40"/>
                    <line x1="0" y1="90"  x2="600" y2="90"/>
                    <line x1="0" y1="140" x2="600" y2="140"/>
                </g>
                <path d="{{ $conversionAreaPath ?? 'M0,140 L60,120 L120,130 L180,90 L240,100 L300,75 L360,80 L420,55 L480,65 L540,40 L600,30 L600,180 L0,180 Z' }}" fill="url(#grad-conv-rate)"/>
                <path d="{{ $conversionLinePath ?? 'M0,140 L60,120 L120,130 L180,90 L240,100 L300,75 L360,80 L420,55 L480,65 L540,40 L600,30' }}"
                      fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </x-card>

        <x-card :title="__('crm.reports.leads_per_agent')" :subtitle="__('crm.reports.leads_per_agent_subtitle')">
            <div class="space-y-3">
                @php
                    $agents = $agentStats ?? [
                        ['name' => 'Sara Ahmed', 'count' => 38, 'pct' => 88, 'delta' => '+12%', 'positive' => true],
                        ['name' => 'Yusuf Adel', 'count' => 29, 'pct' => 67, 'delta' => '+5%',  'positive' => true],
                        ['name' => 'Mona Khalid','count' => 22, 'pct' => 51, 'delta' => '−3%', 'positive' => false],
                        ['name' => 'Omar Kareem','count' => 17, 'pct' => 39, 'delta' => '±0',  'positive' => null],
                    ];
                @endphp

                @foreach($agents as $agent)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <div class="flex items-center gap-2 min-w-0">
                                <x-avatar :name="$agent['name']" size="sm" />
                                <span class="text-ink-700 truncate">{{ $agent['name'] }}</span>
                            </div>
                            <div class="flex items-baseline gap-2 shrink-0">
                                <span class="font-semibold text-ink-900">{{ $agent['count'] }}</span>
                                <span class="text-xs font-medium
                                             {{ ($agent['positive'] ?? null) === true ? 'text-emerald-600' : '' }}
                                             {{ ($agent['positive'] ?? null) === false ? 'text-rose-600' : '' }}
                                             {{ ($agent['positive'] ?? null) === null ? 'text-ink-500' : '' }}">
                                    {{ $agent['delta'] }}
                                </span>
                            </div>
                        </div>
                        <div class="h-1.5 bg-ink-100 rounded-full overflow-hidden">
                            <div class="h-full bg-brand-500 rounded-full" style="width: {{ $agent['pct'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>

    {{-- الصف السفلي: قمع المبيعات + أسباب الرفض --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <x-card :title="__('crm.reports.sales_funnel')" :subtitle="__('crm.reports.sales_funnel_subtitle')" class="lg:col-span-2">
            @php
                $funnel = $funnelStages ?? [
                    ['key' => 'new',        'count' => 128, 'pct' => 100, 'bg' => 'bg-ink-100',     'text' => 'text-ink-900',     'pctColor' => 'text-ink-500'],
                    ['key' => 'contacted',  'count' => 100, 'pct' => 78,  'bg' => 'bg-amber-100',   'text' => 'text-amber-900',   'pctColor' => 'text-amber-700'],
                    ['key' => 'interested', 'count' => 70,  'pct' => 55,  'bg' => 'bg-brand-100',   'text' => 'text-brand-700',   'pctColor' => 'text-brand-600'],
                    ['key' => 'converted',  'count' => 42,  'pct' => 33,  'bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'pctColor' => 'text-emerald-700'],
                ];
            @endphp

            <div class="space-y-3">
                @foreach($funnel as $stage)
                    <div class="relative">
                        <div class="h-12 rounded-lg {{ $stage['bg'] }} flex items-center justify-between px-4" style="width: {{ $stage['pct'] }}%">
                            <span class="text-sm font-medium {{ $stage['text'] }}">{{ __('crm.reports.funnel_'.$stage['key']) }}</span>
                            <span class="text-sm font-semibold {{ $stage['text'] }} latin-nums">
                                {{ $stage['count'] }}
                                @if(!$loop->first)
                                    <span class="text-xs font-normal {{ $stage['pctColor'] }}">· {{ $stage['pct'] }}%</span>
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>

        <x-card :title="__('crm.reports.rejection_reasons')" :subtitle="__('crm.reports.lost_deals', ['count' => $rejectionTotal ?? 0])">
            @php
                $reasons = $rejectionData ?? [
                    ['key' => 'price',      'pct' => 42, 'color' => 'bg-rose-500', 'stroke' => '#f43f5e'],
                    ['key' => 'budget',     'pct' => 23, 'color' => 'bg-rose-400', 'stroke' => '#fb7185'],
                    ['key' => 'competitor', 'pct' => 18, 'color' => 'bg-rose-300', 'stroke' => '#fda4af'],
                    ['key' => 'timing',     'pct' => 11, 'color' => 'bg-rose-200', 'stroke' => '#fecdd3'],
                    ['key' => 'other',      'pct' => 6,  'color' => 'bg-ink-200',  'stroke' => '#dde0e5'],
                ];

                $offset = 0;
                $segments = [];
                foreach ($reasons as $r) {
                    $segments[] = ['pct' => $r['pct'], 'offset' => -$offset, 'stroke' => $r['stroke']];
                    $offset += $r['pct'];
                }
                $top = $reasons[0] ?? null;
            @endphp

            <div class="relative w-40 h-40 mx-auto">
                <svg viewBox="0 0 36 36" class="w-full h-full -rotate-90" dir="ltr">
                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#fee2e2" stroke-width="3.6"/>
                    @foreach($segments as $seg)
                        <circle cx="18" cy="18" r="15.9" fill="none"
                                stroke="{{ $seg['stroke'] }}" stroke-width="3.6"
                                stroke-dasharray="{{ $seg['pct'] }} 100"
                                stroke-dashoffset="{{ $seg['offset'] }}"/>
                    @endforeach
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-2xl font-semibold text-ink-900 latin-nums">{{ $top['pct'] ?? 0 }}%</span>
                    <span class="text-xs text-ink-500">{{ __('crm.reports.top_reason') }}</span>
                </div>
            </div>

            <ul class="mt-4 space-y-2 text-sm">
                @foreach($reasons as $r)
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-ink-700">
                            <span class="w-2 h-2 rounded-sm {{ $r['color'] }}"></span>{{ __('crm.rejection_reasons.'.$r['key']) }}
                        </span>
                        <span class="font-medium text-ink-900 latin-nums">{{ $r['pct'] }}%</span>
                    </li>
                @endforeach
            </ul>
        </x-card>
    </div>
</x-layouts.app>
