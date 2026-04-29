{{-- resources/views/components/badge.blade.php
     Usage:
        <x-badge>New</x-badge>
        <x-badge variant="amber" dot>Follow-up</x-badge>
        <x-badge variant="emerald" dot pulse>Active</x-badge>

     Variants map to lead statuses:
        gray     -> New
        amber    -> Follow-up
        brand    -> Interested
        emerald  -> Converted / Active
        rose     -> Rejected / Overdue
--}}
@props([
    'variant' => 'gray',  // gray | amber | brand | emerald | rose | violet
    'dot' => false,
    'pulse' => false,
    'size' => 'sm',       // xs | sm
])

@php
    $variants = [
        'gray'    => ['bg' => 'bg-ink-100',     'text' => 'text-ink-700',     'dot' => 'bg-ink-400'],
        'amber'   => ['bg' => 'bg-amber-50',    'text' => 'text-amber-700',   'dot' => 'bg-amber-500'],
        'brand'   => ['bg' => 'bg-brand-50',    'text' => 'text-brand-700',   'dot' => 'bg-brand-500'],
        'emerald' => ['bg' => 'bg-emerald-50',  'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
        'rose'    => ['bg' => 'bg-rose-50',     'text' => 'text-rose-700',    'dot' => 'bg-rose-500'],
        'violet'  => ['bg' => 'bg-violet-50',   'text' => 'text-violet-700',  'dot' => 'bg-violet-500'],
    ];
    $v = $variants[$variant] ?? $variants['gray'];
    $padding = $size === 'xs' ? 'px-1.5 py-0.5 text-[10px]' : 'px-2 py-1 text-xs';
@endphp

<span {{ $attributes->class([
    'inline-flex items-center gap-1.5 font-medium rounded-md',
    $padding, $v['bg'], $v['text'],
]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $v['dot'] }} {{ $pulse ? 'animate-pulse' : '' }}"></span>
    @endif
    {{ $slot }}
</span>
