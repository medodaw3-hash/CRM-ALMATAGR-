{{-- resources/views/components/lead-card.blade.php
     بطاقة عميل واحد على لوحة الكانبان.

     الاستخدام:
        <x-lead-card :lead="$lead" />

     الحقول المتوقّعة في $lead:
        id, store_name, city, sector, status, last_contact_at,
        next_followup_at, agent (مع name), deal_value (اختياري)
--}}
@props(['lead'])

@php
    $statusKey = strtolower(preg_replace('/[^a-z]/i', '', (string) $lead->status));
    $isOverdue = $lead->next_followup_at && \Carbon\Carbon::parse($lead->next_followup_at)->isPast();

    // حافة جانبية للتنبيه البصري على البطاقات المتأخرة
    $accent = '';
    if ($statusKey === 'followup' && $isOverdue) {
        $accent = 'border-s-2 border-s-rose-500';
    }
@endphp

<a href="{{ route('leads.show', $lead) }}"
   draggable="true"
   data-lead-id="{{ $lead->id }}"
   data-lead-status="{{ $lead->status }}"
   {{ $attributes->class([
        'lead-card block bg-white rounded-lg border border-ink-100 p-3.5 cursor-pointer',
        'transition hover:-translate-y-px hover:shadow-card hover:border-ink-200',
        $accent,
   ]) }}>

    {{-- الصف العلوي: اسم المتجر + شارة الحالة --}}
    <div class="flex items-start justify-between gap-2">
        <div class="font-medium text-sm text-ink-900 truncate">{{ $lead->store_name }}</div>
        <x-status-badge :status="$lead->status" size="xs" :dot="false" class="shrink-0 uppercase tracking-wide font-semibold" />
    </div>

    {{-- السطر الفرعي: المدينة · القطاع · القيمة --}}
    <div class="text-xs text-ink-500 mt-1 truncate">
        @if($lead->city) {{ $lead->city }} @endif
        @if($lead->sector) · {{ $lead->sector }} @endif
        @if(!empty($lead->deal_value)) · ${{ number_format($lead->deal_value) }} @endif
    </div>

    {{-- صف البيانات: آخر تواصل + المتابعة القادمة --}}
    <div class="mt-3 flex items-center justify-between text-xs">
        <span class="text-ink-500">
            {{ __('crm.leads.last') }}
            @if($lead->last_contact_at)
                <span class="text-ink-700"><x-countdown :date="$lead->last_contact_at" past /></span>
            @else
                <span class="text-ink-700">—</span>
            @endif
        </span>

        @if($lead->next_followup_at)
            <x-countdown :date="$lead->next_followup_at" />
        @else
            <span class="text-ink-400">{{ __('crm.leads.no_followup') }}</span>
        @endif
    </div>

    {{-- التذييل: أيقونة الموظف + رقم العميل --}}
    <div class="mt-2.5 flex items-center justify-between">
        <div class="flex {{ in_array(app()->getLocale(),['ar','he','fa','ur'],true) ? '-space-x-reverse -space-x-1.5' : '-space-x-1.5' }}">
            @if($lead->agent)
                <x-avatar :name="$lead->agent->name" size="xs" ring />
            @endif
        </div>
        <span class="text-[11px] font-medium text-ink-400" dir="ltr">#L-{{ str_pad($lead->id, 4, '0', STR_PAD_LEFT) }}</span>
    </div>
</a>
