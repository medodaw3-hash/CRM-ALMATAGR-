{{-- resources/views/components/table.blade.php
     Generic table wrapper. Use the head/body slots, or pass :columns and :rows for simple cases.

     Slot usage (more flexible):
        <x-table>
            <x-slot:head>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </x-slot>
            @foreach($leads as $lead)
                <tr><td>{{ $lead->name }}</td><td>...</td></tr>
            @endforeach
        </x-table>
--}}
@props([
    'columns' => null,
    'rows' => null,
    'empty' => 'No records found.',
])

<div {{ $attributes->class(['bg-white rounded-xl border border-ink-100 shadow-soft overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ink-50 text-left">
                @isset($head)
                    @php
                        // Apply the styled th class to all <th> in the slot
                    @endphp
                    {{ $head }}
                @elseif($columns)
                    <tr class="text-xs text-ink-500 uppercase tracking-wider">
                        @foreach($columns as $col)
                            <th class="px-4 py-3 font-medium">{{ is_array($col) ? $col['label'] : $col }}</th>
                        @endforeach
                    </tr>
                @endisset
            </thead>
            <tbody class="divide-y divide-ink-100">
                @if($rows && count($rows) === 0)
                    <tr><td colspan="100" class="px-4 py-12 text-center text-ink-500">{{ $empty }}</td></tr>
                @else
                    {{ $slot }}
                @endif
            </tbody>
        </table>
    </div>

    @isset($footer)
        <div class="px-4 py-3 border-t border-ink-100 flex items-center justify-between text-sm">
            {{ $footer }}
        </div>
    @endisset
</div>

<style>
    /* Default styling for ths and tds inside this table */
    [data-table-styled] th { padding: 0.75rem 1rem; font-weight: 500; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: rgb(107 114 128); }
    [data-table-styled] td { padding: 0.75rem 1rem; }
</style>
