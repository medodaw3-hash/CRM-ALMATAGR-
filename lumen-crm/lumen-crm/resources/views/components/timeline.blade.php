{{-- resources/views/components/timeline.blade.php
     Wraps a list of <x-timeline-item> children.

     Usage:
        <x-timeline>
            <x-timeline-item type="call" :time="$activity->created_at">
                Discussed pricing for 5 branches.
            </x-timeline-item>
        </x-timeline>
--}}
<ol {{ $attributes->class(['relative border-l-2 border-ink-100 ml-3 space-y-6']) }}>
    {{ $slot }}
</ol>
