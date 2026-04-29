{{-- resources/views/components/avatar.blade.php
     Usage:
        <x-avatar :name="$user->name" />
        <x-avatar :name="$user->name" size="lg" />
        <x-avatar :name="$lead->store_name" color="emerald" />
        <x-avatar :src="$user->avatar_url" :name="$user->name" />
--}}
@props([
    'name' => '',
    'src' => null,
    'size' => 'sm',          // xs | sm | md | lg | xl
    'color' => null,         // auto | gray | violet | emerald | brand | rose | amber | pink
    'ring' => false,
])

@php
    $sizes = [
        'xs' => 'w-5 h-5 text-[10px]',
        'sm' => 'w-6 h-6 text-[10px]',
        'md' => 'w-8 h-8 text-xs',
        'lg' => 'w-10 h-10 text-sm',
        'xl' => 'w-12 h-12 text-base',
    ];

    // Auto-pick a stable color from the name
    $palette = ['violet', 'emerald', 'brand', 'rose', 'amber', 'pink', 'cyan', 'indigo'];
    $autoColor = $palette[abs(crc32($name)) % count($palette)];
    $finalColor = $color ?? $autoColor;

    $colorMap = [
        'gray'    => 'bg-ink-500',
        'violet'  => 'bg-gradient-to-br from-violet-500 to-pink-500',
        'emerald' => 'bg-gradient-to-br from-emerald-500 to-teal-500',
        'brand'   => 'bg-gradient-to-br from-brand-500 to-brand-700',
        'rose'    => 'bg-gradient-to-br from-rose-500 to-orange-500',
        'amber'   => 'bg-gradient-to-br from-amber-400 to-orange-500',
        'pink'    => 'bg-gradient-to-br from-pink-500 to-fuchsia-500',
        'cyan'    => 'bg-gradient-to-br from-cyan-500 to-blue-500',
        'indigo'  => 'bg-gradient-to-br from-indigo-500 to-purple-500',
    ];
    $bg = $colorMap[$finalColor] ?? $colorMap['gray'];

    // Initials: "Sara Ahmed" -> "SA", "Cedar Coffee Co." -> "CC"
    $words = preg_split('/\s+/', trim($name));
    $initials = '';
    if (count($words) >= 2) {
        $initials = mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
    } elseif (!empty($words[0])) {
        $initials = mb_strtoupper(mb_substr($words[0], 0, 2));
    }
@endphp

<span {{ $attributes->class([
    $sizes[$size] ?? $sizes['sm'],
    'inline-flex items-center justify-center rounded-full text-white font-medium flex-shrink-0',
    $bg => !$src,
    'ring-2 ring-white' => $ring,
]) }} title="{{ $name }}">
    @if($src)
        <img src="{{ $src }}" alt="{{ $name }}" class="w-full h-full rounded-full object-cover">
    @else
        {{ $initials }}
    @endif
</span>
