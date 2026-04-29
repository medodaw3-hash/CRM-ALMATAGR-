{{-- resources/views/components/timeline-item.blade.php
     Usage:
        <x-timeline-item type="call" title="Call with Khaled" :time="$call->created_at" :duration="'8 min'">
            Discussed pricing for 5 branches.
        </x-timeline-item>
--}}
@props([
    'type' => 'note',  // note | call | email | followup | status | created
    'title' => '',
    'time' => null,
    'duration' => null,
    'author' => null,
])

@php
    $iconMap = [
        'note'     => ['icon' => 'note',  'bg' => 'bg-ink-100',     'ring' => 'ring-ink-200',     'stroke' => '#4b5159'],
        'call'     => ['icon' => 'phone', 'bg' => 'bg-brand-50',    'ring' => 'ring-brand-200',   'stroke' => '#3b6ef5'],
        'email'    => ['icon' => 'mail',  'bg' => 'bg-violet-50',   'ring' => 'ring-violet-200',  'stroke' => '#7c3aed'],
        'followup' => ['icon' => 'clock', 'bg' => 'bg-amber-50',    'ring' => 'ring-amber-200',   'stroke' => '#d97706'],
        'status'   => ['icon' => 'check', 'bg' => 'bg-emerald-50',  'ring' => 'ring-emerald-200', 'stroke' => '#059669'],
        'created'  => ['icon' => 'plus',  'bg' => 'bg-ink-100',     'ring' => 'ring-ink-200',     'stroke' => '#4b5159'],
    ];
    $cfg = $iconMap[$type] ?? $iconMap['note'];
@endphp

<li class="pl-6 relative">
    <span class="absolute -left-[11px] top-0.5 w-5 h-5 rounded-full {{ $cfg['bg'] }} border-2 border-white ring-2 {{ $cfg['ring'] }} flex items-center justify-center">
        <x-icon :name="$cfg['icon']" class="w-2.5 h-2.5" stroke="{{ $cfg['stroke'] }}" stroke-width="3" />
    </span>

    <div class="flex items-baseline gap-2 flex-wrap">
        @if($title)
            <span class="text-sm font-medium text-ink-900">{{ $title }}</span>
        @endif
        @if($time)
            <span class="text-xs text-ink-400">
                <x-countdown :date="$time" past />
                @if($duration) · {{ $duration }} @endif
            </span>
        @endif
    </div>

    @if(trim($slot))
        <div class="text-sm text-ink-700 mt-1">{{ $slot }}</div>
    @endif

    @if($author)
        <div class="text-xs text-ink-400 mt-1">by {{ $author }}</div>
    @endif
</li>
