{{-- resources/views/components/modal.blade.php
     Lightweight modal driven by Alpine.js (or vanilla via [data-modal-toggle]).

     Usage:
        <x-modal id="schedule-followup" title="Schedule follow-up">
            <form>...</form>
            <x-slot:footer>
                <x-button variant="ghost" data-modal-close>Cancel</x-button>
                <x-button variant="primary" type="submit">Save</x-button>
            </x-slot>
        </x-modal>

        <button data-modal-open="schedule-followup">Open</button>
--}}
@props([
    'id',
    'title' => null,
    'size' => 'md', // sm | md | lg | xl
])

@php
    $widths = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
    ];
@endphp

<div id="{{ $id }}"
     data-modal
     class="hidden fixed inset-0 z-50 overflow-y-auto"
     role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title">

    {{-- Backdrop --}}
    <div data-modal-close
         class="fixed inset-0 bg-ink-950/40 backdrop-blur-sm transition-opacity"></div>

    {{-- Panel --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-pop w-full {{ $widths[$size] ?? $widths['md'] }} transform transition-all">

            @if($title)
                <div class="flex items-center justify-between px-5 py-4 border-b border-ink-100">
                    <h3 id="{{ $id }}-title" class="text-base font-semibold text-ink-900">{{ $title }}</h3>
                    <button data-modal-close type="button"
                            class="w-7 h-7 rounded-md hover:bg-ink-100 text-ink-500 flex items-center justify-center" aria-label="Close">
                        <x-icon name="x" class="w-4 h-4" />
                    </button>
                </div>
            @endif

            <div class="px-5 py-5">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="px-5 py-4 border-t border-ink-100 flex items-center justify-end gap-2 bg-ink-50/50 rounded-b-xl">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
