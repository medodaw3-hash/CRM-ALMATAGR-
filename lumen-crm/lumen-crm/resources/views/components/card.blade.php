{{-- resources/views/components/card.blade.php
     Usage:
        <x-card>...</x-card>
        <x-card title="Pipeline" subtitle="128 leads" :padded="false">...</x-card>
        <x-card title="Pipeline">
            <x-slot:actions>
                <button>...</button>
            </x-slot>
            ...
        </x-card>
--}}
@props([
    'title' => null,
    'subtitle' => null,
    'padded' => true,
    'shadow' => 'soft', // soft | card | pop | none
])

@php
    $shadowClass = match($shadow) {
        'card' => 'shadow-card',
        'pop'  => 'shadow-pop',
        'none' => '',
        default => 'shadow-soft',
    };
@endphp

<div {{ $attributes->class(['bg-white rounded-xl border border-ink-100', $shadowClass]) }}>
    @if($title || isset($actions))
        <div class="px-5 py-4 {{ $padded ? 'border-b border-ink-100' : '' }} flex items-center justify-between">
            <div>
                @if($title)<div class="text-sm font-medium text-ink-900">{{ $title }}</div>@endif
                @if($subtitle)<div class="text-xs text-ink-500 mt-0.5">{{ $subtitle }}</div>@endif
            </div>
            @isset($actions)<div>{{ $actions }}</div>@endisset
        </div>
    @endif

    <div class="{{ $padded ? 'p-5' : '' }}">
        {{ $slot }}
    </div>
</div>
