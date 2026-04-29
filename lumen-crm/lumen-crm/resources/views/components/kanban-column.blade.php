{{-- resources/views/components/kanban-column.blade.php
     عمود في لوحة الكانبان (هدف للسحب والإفلات).

     الاستخدام:
        <x-kanban-column status="new" :leads="$grouped['new']" />
--}}
@props([
    'status' => 'new',
    'label' => null,    // إذا لم يُمرَّر، يُؤخذ من الترجمة تلقائيًا
    'leads' => [],
])

@php
    $statusKey = strtolower(preg_replace('/[^a-z]/i', '', (string) $status));
    $tints = [
        'new'        => ['dot' => 'bg-ink-400',     'bg' => 'bg-ink-50/60'],
        'followup'   => ['dot' => 'bg-amber-500',   'bg' => 'bg-amber-50/40'],
        'interested' => ['dot' => 'bg-brand-500',   'bg' => 'bg-brand-50/40'],
        'converted'  => ['dot' => 'bg-emerald-500', 'bg' => 'bg-emerald-50/40'],
        'rejected'   => ['dot' => 'bg-rose-500',    'bg' => 'bg-rose-50/40'],
    ];
    $t = $tints[$statusKey] ?? $tints['new'];
    $count = is_countable($leads) ? count($leads) : 0;

    // لو ما تم تمرير الـ label نأخذه من ملف الترجمة
    $finalLabel = $label ?? __('crm.status.'.$statusKey);
@endphp

<div {{ $attributes->class(['kanban-col w-80 shrink-0']) }}>

    {{-- رأس العمود --}}
    <div class="flex items-center justify-between px-1 mb-3">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full {{ $t['dot'] }}"></span>
            <span class="text-sm font-semibold text-ink-900">{{ $finalLabel }}</span>
            <span class="text-xs text-ink-500 bg-ink-100 px-1.5 py-0.5 rounded">{{ $count }}</span>
        </div>
        <a href="{{ route('leads.create', ['status' => $status]) }}"
           class="w-6 h-6 rounded-md hover:bg-ink-100 text-ink-500 flex items-center justify-center transition" title="{{ __('crm.leads.add_lead') }}">
            <x-icon name="plus" class="w-3.5 h-3.5" />
        </a>
    </div>

    {{-- منطقة الإفلات --}}
    <div data-kanban-dropzone
         data-status="{{ $status }}"
         class="space-y-2.5 {{ $t['bg'] }} rounded-xl p-2 min-h-[200px] transition-colors">
        @forelse($leads as $lead)
            <x-lead-card :lead="$lead" />
        @empty
            <div class="text-center text-xs text-ink-400 py-8 px-3"></div>
        @endforelse
    </div>
</div>
