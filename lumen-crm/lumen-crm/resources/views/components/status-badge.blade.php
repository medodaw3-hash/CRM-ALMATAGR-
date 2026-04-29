{{-- resources/views/components/status-badge.blade.php
     Maps a lead/client status to a translated, color-coded badge.

     Usage:
        <x-status-badge status="new" />
        <x-status-badge :status="$lead->status" />
--}}
@props([
    'status' => 'new',
    'size' => 'sm',
    'dot' => true,
])

@php
    $key = strtolower(preg_replace('/[^a-z]/i', '', (string) $status));

    $map = [
        'new'        => ['variant' => 'gray',    'label' => __('New')],
        'followup'   => ['variant' => 'amber',   'label' => __('Follow-up')],
        'interested' => ['variant' => 'brand',   'label' => __('Interested')],
        'converted'  => ['variant' => 'emerald', 'label' => __('Converted')],
        'rejected'   => ['variant' => 'rose',    'label' => __('Rejected')],
        'active'     => ['variant' => 'emerald', 'label' => __('Active'),  'pulse' => true],
        'atrisk'     => ['variant' => 'amber',   'label' => __('At risk')],
        'churned'    => ['variant' => 'gray',    'label' => __('Churned')],
    ];
    $config = $map[$key] ?? ['variant' => 'gray', 'label' => $status ?: '—'];
@endphp

<x-badge :variant="$config['variant']"
         :dot="$dot"
         :pulse="$config['pulse'] ?? false"
         :size="$size">
    {{ $config['label'] }}
</x-badge>
