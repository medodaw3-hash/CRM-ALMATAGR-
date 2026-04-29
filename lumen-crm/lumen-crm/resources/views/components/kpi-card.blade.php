{{-- resources/views/components/kpi-card.blade.php
     A KPI tile for the dashboard.

     Usage:
        <x-kpi-card label="Leads today" value="24" delta="+12%" icon="inbox" />
        <x-kpi-card label="Follow-ups today" value="7" delta="3 overdue" delta-variant="rose" icon="clock" icon-tint="amber" />

     Slots:
        - default slot: appears below the value (sparkline, progress bar, sub-text)
--}}
@props([
    'label',
    'value',
    'delta' => null,
    'deltaVariant' => 'emerald',  // emerald | rose | gray
    'icon' => null,
    'iconTint' => 'gray',         // gray | amber | emerald | rose | brand
])

@php
    $tintMap = [
        'gray'    => 'bg-ink-50 text-ink-500',
        'amber'   => 'bg-amber-50 text-amber-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'rose'    => 'bg-rose-50 text-rose-600',
        'brand'   => 'bg-brand-50 text-brand-600',
    ];
    $deltaMap = [
        'emerald' => 'text-emerald-600 bg-emerald-50',
        'rose'    => 'text-rose-600 bg-rose-50',
        'gray'    => 'text-ink-500 bg-ink-100',
    ];
@endphp

<div {{ $attributes->class(['bg-white rounded-xl border border-ink-100 shadow-soft p-5']) }}>
    <div class="flex items-center justify-between">
        <div class="text-sm text-ink-500">{{ $label }}</div>
        @if($icon)
            <div class="w-7 h-7 rounded-md flex items-center justify-center {{ $tintMap[$iconTint] ?? $tintMap['gray'] }}">
                <x-icon :name="$icon" class="w-3.5 h-3.5" />
            </div>
        @endif
    </div>

    <div class="mt-2 flex items-baseline gap-2">
        <div class="text-3xl font-semibold tracking-tight text-ink-900">{{ $value }}</div>
        @if($delta)
            <div class="text-xs font-medium {{ $deltaMap[$deltaVariant] ?? $deltaMap['emerald'] }} px-1.5 py-0.5 rounded">{{ $delta }}</div>
        @endif
    </div>

    @if(trim($slot))
        <div class="mt-3">{{ $slot }}</div>
    @endif
</div>
