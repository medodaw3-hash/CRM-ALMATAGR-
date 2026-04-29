{{-- resources/views/components/button.blade.php
     Usage:
        <x-button>{{ __('Save') }}</x-button>
        <x-button variant="primary" href="...">{{ __('New lead') }}</x-button>
        <x-button variant="ghost" icon="phone">{{ __('Call') }}</x-button>

     Note: directional icons (chevrons, arrows) auto-flip in RTL via CSS.
--}}
@props([
    'variant' => 'secondary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'iconRight' => null,
    'iconFlip' => false,
    'disabled' => false,
])

@php
    $base = 'inline-flex items-center justify-center gap-1.5 font-medium rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-1 whitespace-nowrap';
    $sizes = [
        'sm' => 'h-8 px-2.5 text-xs',
        'md' => 'h-9 px-3 text-sm',
        'lg' => 'h-11 px-4 text-sm',
    ];
    $variants = [
        'primary'   => 'bg-ink-900 text-white hover:bg-ink-800 focus-visible:ring-ink-900',
        'secondary' => 'bg-white text-ink-700 border border-ink-200 hover:bg-ink-50 focus-visible:ring-ink-300',
        'ghost'     => 'text-ink-700 hover:bg-ink-100 focus-visible:ring-ink-300',
        'success'   => 'bg-emerald-600 text-white hover:bg-emerald-700 focus-visible:ring-emerald-500',
        'danger'    => 'bg-rose-600 text-white hover:bg-rose-700 focus-visible:ring-rose-500',
    ];
    $classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['secondary']);
    $iconClass = 'w-3.5 h-3.5 ' . ($iconFlip ? 'rtl-flip' : '');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        @if($icon)<span class="{{ $iconClass }}"><x-icon :name="$icon" /></span>@endif
        {{ $slot }}
        @if($iconRight)<span class="{{ $iconClass }}"><x-icon :name="$iconRight" /></span>@endif
    </a>
@else
    <button type="{{ $type }}" @if($disabled) disabled @endif {{ $attributes->class($classes) }}>
        @if($icon)<span class="{{ $iconClass }}"><x-icon :name="$icon" /></span>@endif
        {{ $slot }}
        @if($iconRight)<span class="{{ $iconClass }}"><x-icon :name="$iconRight" /></span>@endif
    </button>
@endif
