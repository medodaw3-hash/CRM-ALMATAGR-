{{-- resources/views/pages/followups/index.blade.php --}}
<x-layouts.app :title="__('crm.followups.title')">

    @php
        $todayCount = isset($todayFollowups) ? $todayFollowups->count() : 0;
        $overdueCount = isset($overdueFollowups) ? $overdueFollowups->count() : 0;
        $tab = request('tab', 'today');
        $leadWord = $todayCount === 1 ? __('crm.followups.lead_singular') : __('crm.followups.lead_plural');
    @endphp

    {{-- البطاقة البطلة --}}
    <div class="bg-gradient-to-br from-ink-900 to-ink-950 text-white rounded-2xl p-7 mb-6 relative overflow-hidden">
        <div class="absolute -end-12 -top-12 w-64 h-64 rounded-full bg-brand-500/20 blur-3xl"></div>
        <div class="absolute end-20 bottom-0 w-48 h-48 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="relative">
            <div class="text-sm text-ink-300 font-medium">
                {{ __('crm.followups.today_label', ['date' => now()->locale(app()->getLocale())->isoFormat('dddd، D MMMM')]) }}
            </div>
            <h1 class="text-3xl font-semibold tracking-tight mt-1">
                {!! __('crm.followups.hero_count', [
                    'count' => '<span class="text-brand-400">'.$todayCount.'</span>',
                    'leads' => $leadWord,
                ]) !!}
            </h1>
            <p class="text-sm text-ink-300 mt-2 max-w-md">
                @if($overdueCount > 0)
                    {!! __('crm.followups.hero_message_overdue', [
                        'count' => '<span class="text-rose-300 font-medium">'.$overdueCount.'</span>',
                    ]) !!}
                @else
                    {{ __('crm.followups.hero_message_clear') }}
                @endif
            </p>
            <div class="mt-5 flex items-center gap-2 flex-wrap">
                @if($overdueCount > 0)
                    <a href="{{ route('followups.index', ['tab' => 'overdue']) }}"
                       class="h-9 px-4 rounded-lg bg-white text-ink-900 text-sm font-semibold hover:bg-ink-100 inline-flex items-center">{{ __('crm.followups.start_overdue') }}</a>
                @endif
                <a href="#"
                   class="h-9 px-4 rounded-lg bg-white/10 text-white text-sm font-medium hover:bg-white/15 border border-white/10 inline-flex items-center">{{ __('crm.followups.view_calendar') }}</a>
            </div>
        </div>
    </div>

    {{-- التبويبات --}}
    <div class="flex items-center gap-1 mb-4 border-b border-ink-100 overflow-x-auto">
        @php
            $tabs = [
                'overdue'  => ['label' => __('crm.followups.tab_overdue'),   'count' => $overdueCount,                                  'badge' => 'rose'],
                'today'    => ['label' => __('crm.followups.tab_today'),     'count' => $todayCount,                                    'badge' => 'gray'],
                'tomorrow' => ['label' => __('crm.followups.tab_tomorrow'),  'count' => isset($tomorrowFollowups) ? $tomorrowFollowups->count() : 0, 'badge' => 'gray'],
                'week'     => ['label' => __('crm.followups.tab_week'),      'count' => isset($weekFollowups) ? $weekFollowups->count() : 0, 'badge' => 'gray'],
                'done'     => ['label' => __('crm.followups.tab_completed'), 'count' => isset($doneFollowups) ? $doneFollowups->count() : 0, 'badge' => 'gray'],
            ];
        @endphp

        @foreach($tabs as $key => $t)
            <a href="{{ route('followups.index', ['tab' => $key]) }}"
               class="px-4 py-2.5 text-sm font-medium flex items-center gap-2 whitespace-nowrap transition
                      {{ $tab === $key ? 'text-ink-900 border-b-2 border-ink-900 -mb-px' : 'text-ink-500 hover:text-ink-900' }}">
                {{ $t['label'] }}
                @if($t['count'] > 0)
                    <span class="text-[11px] px-1.5 py-0.5 rounded font-semibold
                                 {{ $t['badge'] === 'rose' ? 'bg-rose-100 text-rose-700' : 'bg-ink-100 text-ink-600' }}">
                        {{ $t['count'] }}
                    </span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- قائمة المهام --}}
    <div class="bg-white rounded-xl border border-ink-100 shadow-soft divide-y divide-ink-100">
        @forelse($followups as $followup)
            @php
                $isOverdue = \Carbon\Carbon::parse($followup->scheduled_at)->isPast() && !$followup->completed_at;
                $isCompleted = (bool) $followup->completed_at;
                $isSoon = !$isOverdue && !$isCompleted && \Carbon\Carbon::parse($followup->scheduled_at)->diffInHours(now()) < 4;
            @endphp

            <div class="px-5 py-4 flex items-center gap-4 hover:bg-ink-50/40 group transition
                        {{ $isCompleted ? 'opacity-60' : '' }}
                        {{ $isSoon ? 'bg-amber-50/20' : '' }}">

                <form method="POST" action="{{ route('followups.toggle', $followup) }}" class="contents">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="w-5 h-5 rounded-full border-2 flex-shrink-0 flex items-center justify-center transition
                                   {{ $isCompleted ? 'bg-emerald-500 border-emerald-500' : 'border-ink-300 hover:border-emerald-500 hover:bg-emerald-50' }}">
                        @if($isCompleted)
                            <x-icon name="check" class="w-2.5 h-2.5 text-white" stroke-width="3.5" />
                        @endif
                    </button>
                </form>

                <a href="{{ route('leads.show', $followup->lead) }}" class="flex-1 min-w-0 group">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-sm {{ $isCompleted ? 'text-ink-500 line-through' : 'text-ink-900' }}">
                            {{ $followup->lead->store_name }}
                        </span>
                        @if(!$isCompleted)
                            <x-status-badge :status="$followup->lead->status" size="xs" :dot="false" class="uppercase tracking-wide" />
                        @endif
                    </div>
                    <div class="text-xs text-ink-500 mt-0.5">
                        @if($isCompleted)
                            {{ __('crm.followups.completed_at', ['time' => \Carbon\Carbon::parse($followup->completed_at)->locale(app()->getLocale())->isoFormat('h:mm A')]) }}
                        @else
                            {{ __('crm.followups.scheduled_at', [
                                'note' => $followup->note ?? __('crm.followups.no_note'),
                                'time' => \Carbon\Carbon::parse($followup->scheduled_at)->locale(app()->getLocale())->isoFormat('D MMM h:mm A'),
                            ]) }}
                        @endif
                    </div>
                </a>

                <div class="text-end">
                    @if($isCompleted)
                        <span class="inline-flex items-center gap-1 text-xs text-emerald-700 font-medium">{{ __('crm.status.done') }}</span>
                    @elseif($isOverdue)
                        <x-countdown :date="$followup->scheduled_at" class="font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded-md" />
                    @else
                        <x-countdown :date="$followup->scheduled_at" class="px-2 py-1 rounded-md bg-ink-100 font-medium" />
                    @endif
                </div>

                @if(!$isCompleted)
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                        <form method="POST" action="{{ route('leads.contact', $followup->lead) }}" class="contents">
                            @csrf
                            <button type="submit" class="h-8 px-2.5 rounded-md text-xs font-medium text-ink-700 bg-ink-100 hover:bg-ink-200 inline-flex items-center gap-1">
                                <x-icon name="phone" class="w-3 h-3" />
                                {{ __('crm.followups.call') }}
                            </button>
                        </form>
                        <button class="h-8 px-2.5 rounded-md text-xs font-medium text-ink-700 bg-ink-100 hover:bg-ink-200">
                            {{ __('crm.followups.reschedule') }}
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div class="px-5 py-16 text-center">
                <div class="text-3xl mb-2">🎉</div>
                <div class="text-sm font-medium text-ink-900">{{ __('crm.followups.empty_title') }}</div>
                <div class="text-xs text-ink-500 mt-1">{{ __('crm.followups.empty_subtitle') }}</div>
            </div>
        @endforelse
    </div>

    @if(method_exists($followups ?? null, 'links'))
        <div class="mt-4">{{ $followups->links() }}</div>
    @endif
</x-layouts.app>
