{{-- resources/views/pages/leads/index.blade.php --}}
<x-layouts.app :title="__('crm.leads.title')">

    {{-- ترويسة الصفحة --}}
    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-ink-900">{{ __('crm.leads.title') }}</h1>
            <p class="text-sm text-ink-500 mt-1">
                {{ __('crm.leads.subtitle', ['total' => $totalLeads ?? 0, 'closed' => $closedThisMonth ?? 0]) }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="secondary" icon="download" :href="route('leads.export')">{{ __('crm.leads.export') }}</x-button>
            <x-button variant="primary" icon="plus" :href="route('leads.create')">{{ __('crm.topbar.new_lead') }}</x-button>
        </div>
    </div>

    {{-- شريط التصفية والعرض --}}
    <div class="bg-white rounded-xl border border-ink-100 shadow-soft p-2 flex items-center gap-2 mb-5 flex-wrap">

        {{-- مبدّل العرض --}}
        <div class="flex items-center bg-ink-50 rounded-lg p-0.5" role="tablist">
            <a href="{{ route('leads.index', ['view' => 'kanban'] + request()->except('view', 'page')) }}"
               class="px-3 h-8 rounded-md text-sm font-medium flex items-center gap-1.5 transition
                      {{ ($view ?? 'kanban') === 'kanban' ? 'bg-white shadow-soft text-ink-900' : 'text-ink-500 hover:text-ink-900' }}">
                <x-icon name="kanban" class="w-3.5 h-3.5" />
                {{ __('crm.leads.kanban') }}
            </a>
            <a href="{{ route('leads.index', ['view' => 'table'] + request()->except('view', 'page')) }}"
               class="px-3 h-8 rounded-md text-sm font-medium flex items-center gap-1.5 transition
                      {{ ($view ?? 'kanban') === 'table' ? 'bg-white shadow-soft text-ink-900' : 'text-ink-500 hover:text-ink-900' }}">
                <x-icon name="list" class="w-3.5 h-3.5" />
                {{ __('crm.leads.table') }}
            </a>
        </div>

        <div class="w-px h-6 bg-ink-100 mx-1"></div>

        <button class="h-8 px-2.5 rounded-md text-sm text-ink-700 hover:bg-ink-50 flex items-center gap-1.5">
            <x-icon name="filter" class="w-3.5 h-3.5" />
            {{ __('crm.leads.filter') }}
        </button>

        <button class="h-8 px-2.5 rounded-md text-sm text-ink-700 hover:bg-ink-50 flex items-center gap-1.5">
            <x-icon name="sort" class="w-3.5 h-3.5" />
            {{ __('crm.leads.sort_by', ['field' => __('crm.leads.sort_last_contact')]) }}
        </button>

        <button class="h-8 px-2.5 rounded-md text-sm text-ink-700 hover:bg-ink-50 flex items-center gap-1.5">
            <x-icon name="users" class="w-3.5 h-3.5" />
            {{ __('crm.leads.agent', ['name' => __('crm.leads.agent_all')]) }}
        </button>

        <div class="flex-1"></div>

        <form method="GET" action="{{ route('leads.index') }}" class="relative">
            <x-icon name="search" class="absolute {{ ($isRtl ?? false) ? 'right-2.5' : 'left-2.5' }} top-1/2 -translate-y-1/2 text-ink-400 w-3.5 h-3.5" />
            <input type="search" name="q" value="{{ request('q') }}"
                   class="h-8 {{ ($isRtl ?? false) ? 'pr-8 pl-3' : 'pl-8 pr-3' }} rounded-md bg-ink-50 border-0 text-sm placeholder-ink-400 w-56 focus:bg-white focus:ring-2 focus:ring-brand-500/20"
                   placeholder="{{ __('crm.leads.search') }}">
        </form>
    </div>

    {{-- ============ عرض الكانبان ============ --}}
    @if(($view ?? 'kanban') === 'kanban')
        <div id="kanban-board" class="overflow-x-auto pb-4">
            <div class="flex gap-4 min-w-max">
                <x-kanban-column status="new"        :leads="$grouped['new']        ?? []" />
                <x-kanban-column status="followup"   :leads="$grouped['followup']   ?? []" />
                <x-kanban-column status="interested" :leads="$grouped['interested'] ?? []" />
                <x-kanban-column status="converted"  :leads="$grouped['converted']  ?? []" />
                <x-kanban-column status="rejected"   :leads="$grouped['rejected']   ?? []" />
            </div>
        </div>

    {{-- ============ عرض الجدول ============ --}}
    @else
        <x-table>
            <x-slot:head>
                <tr class="text-xs text-ink-500 uppercase tracking-wider">
                    <th class="px-4 py-3 font-medium w-8"><input type="checkbox" class="rounded border-ink-300"></th>
                    <th class="px-4 py-3 font-medium">{{ __('crm.leads.col_store') }}</th>
                    <th class="px-4 py-3 font-medium">{{ __('crm.leads.col_phone') }}</th>
                    <th class="px-4 py-3 font-medium">{{ __('crm.leads.col_status') }}</th>
                    <th class="px-4 py-3 font-medium">{{ __('crm.leads.col_last_contact') }}</th>
                    <th class="px-4 py-3 font-medium">{{ __('crm.leads.col_next_followup') }}</th>
                    <th class="px-4 py-3 font-medium">{{ __('crm.leads.col_agent') }}</th>
                    <th class="px-4 py-3 font-medium w-8"></th>
                </tr>
            </x-slot>

            @forelse($leads as $lead)
                <tr class="hover:bg-ink-50/50 transition cursor-pointer" onclick="window.location='{{ route('leads.show', $lead) }}'">
                    <td class="px-4 py-3" onclick="event.stopPropagation()">
                        <input type="checkbox" name="selected[]" value="{{ $lead->id }}" class="rounded border-ink-300">
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-ink-900">{{ $lead->store_name }}</div>
                        <div class="text-xs text-ink-500">
                            {{ $lead->city }}@if($lead->sector) · {{ $lead->sector }}@endif
                        </div>
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-ink-700" dir="ltr">{{ $lead->phone }}</td>
                    <td class="px-4 py-3"><x-status-badge :status="$lead->status" /></td>
                    <td class="px-4 py-3 text-ink-700"><x-countdown :date="$lead->last_contact_at" past /></td>
                    <td class="px-4 py-3"><x-countdown :date="$lead->next_followup_at" /></td>
                    <td class="px-4 py-3">
                        @if($lead->agent)
                            <div class="flex items-center gap-2">
                                <x-avatar :name="$lead->agent->name" size="sm" />
                                <span class="text-ink-700">{{ explode(' ', $lead->agent->name)[0] }}</span>
                            </div>
                        @else
                            <span class="text-ink-400 text-xs">{{ __('crm.leads.unassigned') }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-end" onclick="event.stopPropagation()">
                        <button class="w-7 h-7 rounded-md hover:bg-ink-100 text-ink-400 inline-flex items-center justify-center">
                            <x-icon name="more" class="w-3.5 h-3.5" />
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="px-4 py-12 text-center text-ink-500">{{ __('crm.leads.no_results') }}</td></tr>
            @endforelse

            @if(method_exists($leads ?? null, 'links'))
                <x-slot:footer>
                    <div class="text-ink-500">
                        {{ __('crm.common.showing', ['from' => $leads->firstItem() ?? 0, 'to' => $leads->lastItem() ?? 0, 'total' => $leads->total() ?? 0]) }}
                    </div>
                    <div>{{ $leads->links() }}</div>
                </x-slot>
            @endif
        </x-table>
    @endif

</x-layouts.app>
