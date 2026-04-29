{{-- resources/views/pages/leads/show.blade.php --}}
<x-layouts.app :title="$lead->store_name">

    @php $isRtl = $isRtl ?? in_array(app()->getLocale(),['ar','he','fa','ur'],true); @endphp

    {{-- شريط الرجوع والإجراءات --}}
    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('leads.index') }}"
               class="h-8 w-8 rounded-lg border border-ink-200 bg-white hover:bg-ink-50 flex items-center justify-center text-ink-500">
                <x-icon :name="$isRtl ? 'chevron-right' : 'chevron-left'" class="w-3.5 h-3.5" />
            </a>
            <div class="flex items-center gap-2 text-sm text-ink-500">
                <a href="{{ route('leads.index') }}" class="hover:text-ink-900">{{ __('crm.leads.breadcrumb') }}</a>
                <span>/</span>
                <span class="text-ink-900 font-medium">{{ $lead->store_name }}</span>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <form method="POST" action="{{ route('leads.contact', $lead) }}" class="contents">
                @csrf
                <x-button variant="secondary" icon="phone" type="submit">{{ __('crm.leads.mark_contacted') }}</x-button>
            </form>

            <x-button variant="secondary" icon="clock" data-modal-open="schedule-followup">{{ __('crm.leads.schedule_followup') }}</x-button>

            @if($lead->status !== 'converted')
                <form method="POST" action="{{ route('leads.convert', $lead) }}" class="contents">
                    @csrf
                    <x-button variant="success" icon="check" type="submit">{{ __('crm.leads.convert_to_client') }}</x-button>
                </form>
            @endif

            @if($lead->status !== 'rejected')
                <x-button variant="ghost" data-modal-open="reject-lead">
                    <x-icon name="x" class="w-3.5 h-3.5 text-rose-500" />
                    <span class="text-rose-600">{{ __('crm.leads.reject') }}</span>
                </x-button>
            @endif

            <button class="h-9 w-9 rounded-lg border border-ink-200 bg-white text-ink-500 hover:bg-ink-50 flex items-center justify-center">
                <x-icon name="more" class="w-3.5 h-3.5" />
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ============ اللوحة الجانبية: معلومات المتجر ============ --}}
        <div class="lg:col-span-1 space-y-4">

            <x-card>
                <div class="flex items-center gap-3">
                    <x-avatar :name="$lead->store_name" size="xl" />
                    <div class="min-w-0">
                        <div class="font-semibold text-ink-900 truncate">{{ $lead->store_name }}</div>
                        <div class="text-xs text-ink-500">
                            {{ __('crm.leads.created_on', ['id' => str_pad($lead->id, 4, '0', STR_PAD_LEFT), 'date' => $lead->created_at->locale(app()->getLocale())->isoFormat('D MMM')]) }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2 flex-wrap">
                    <x-status-badge :status="$lead->status" />
                    @if($lead->is_hot ?? false)
                        <x-badge variant="amber">🔥 {{ __('crm.status.hot') }}</x-badge>
                    @endif
                </div>
            </x-card>

            <x-card :title="__('crm.leads.contact_info')" :padded="false">
                <dl class="px-5 py-4 space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-ink-500">{{ __('crm.leads.owner') }}</dt>
                        <dd class="text-ink-900 font-medium">{{ $lead->owner_name ?? '—' }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-ink-500">{{ __('crm.leads.phone') }}</dt>
                        <dd>
                            @if($lead->phone)
                                <a href="tel:{{ $lead->phone }}" class="text-ink-900 font-mono text-xs hover:text-brand-600" dir="ltr">{{ $lead->phone }}</a>
                            @else
                                <span class="text-ink-400">—</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-ink-500">{{ __('crm.leads.email') }}</dt>
                        <dd>
                            @if($lead->email)
                                <a href="mailto:{{ $lead->email }}" class="text-ink-900 truncate max-w-[180px] hover:text-brand-600" dir="ltr">{{ $lead->email }}</a>
                            @else
                                <span class="text-ink-400">—</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-ink-500">{{ __('crm.leads.city') }}</dt>
                        <dd class="text-ink-900">{{ $lead->city ?? '—' }}</dd>
                    </div>
                    @isset($lead->branches)
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-ink-500">{{ __('crm.leads.branches') }}</dt>
                            <dd class="text-ink-900">{{ $lead->branches }}</dd>
                        </div>
                    @endisset
                    @if($lead->deal_value)
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-ink-500">{{ __('crm.leads.deal_value') }}</dt>
                            <dd class="text-ink-900 font-semibold latin-nums">${{ number_format($lead->deal_value) }}</dd>
                        </div>
                    @endif
                </dl>
            </x-card>

            <x-card :title="__('crm.leads.assignment')" :padded="false">
                <div class="p-5">
                    @if($lead->agent)
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$lead->agent->name" size="md" />
                            <div class="flex-1">
                                <div class="text-sm font-medium text-ink-900">{{ $lead->agent->name }}</div>
                                <div class="text-xs text-ink-500">{{ $lead->agent->role ?? '' }}</div>
                            </div>
                            <button data-modal-open="reassign-lead" class="text-xs text-brand-600 hover:text-brand-700 font-medium">{{ __('crm.leads.reassign') }}</button>
                        </div>
                    @else
                        <button data-modal-open="reassign-lead"
                                class="w-full text-sm text-ink-500 border border-dashed border-ink-300 rounded-lg py-3 hover:bg-ink-50 hover:border-ink-400">
                            + {{ __('crm.leads.assign_agent') }}
                        </button>
                    @endif
                </div>
            </x-card>

            <x-card :title="__('crm.leads.tags')" :padded="false">
                <div class="p-5 flex flex-wrap gap-1.5">
                    @forelse($lead->tags ?? [] as $tag)
                        <span class="text-xs px-2 py-1 rounded-md bg-ink-100 text-ink-700">{{ $tag->name ?? $tag }}</span>
                    @empty
                    @endforelse
                    <button class="text-xs px-2 py-1 rounded-md border border-dashed border-ink-300 text-ink-500 hover:bg-ink-50">+ {{ __('crm.leads.add_tag') }}</button>
                </div>
            </x-card>
        </div>

        {{-- ============ اللوحة اليمنى/اليسرى: سجل النشاط ============ --}}
        <div class="lg:col-span-2 space-y-4">

            <x-card :padded="false">
                <div class="flex border-b border-ink-100 overflow-x-auto" role="tablist">
                    @foreach([
                        ['key' => 'note',     'icon' => 'note'],
                        ['key' => 'call',     'icon' => 'phone'],
                        ['key' => 'email',    'icon' => 'mail'],
                        ['key' => 'schedule', 'icon' => 'clock'],
                    ] as $i => $tab)
                        <button data-composer-tab="{{ $tab['key'] }}"
                                class="px-4 py-3 text-sm font-medium border-b-2 flex items-center gap-1.5 transition whitespace-nowrap
                                       {{ $i === 0 ? 'border-ink-900 text-ink-900' : 'border-transparent text-ink-500 hover:text-ink-900' }}">
                            <x-icon :name="$tab['icon']" class="w-3.5 h-3.5" />
                            {{ __('crm.leads.composer_'.$tab['key']) }}
                        </button>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('leads.activities.store', $lead) }}" class="p-4">
                    @csrf
                    <input type="hidden" name="type" value="note" id="composer-type">
                    <textarea name="body" rows="2"
                              class="w-full text-sm placeholder-ink-400 border-0 rounded-lg p-2 resize-none focus:ring-2 focus:ring-brand-500/20"
                              placeholder="{{ __('crm.leads.composer_placeholder') }}"></textarea>
                    <div class="flex items-center justify-end mt-2">
                        <x-button variant="primary" size="sm" type="submit">{{ __('crm.leads.post') }}</x-button>
                    </div>
                </form>
            </x-card>

            <x-card :padded="false">
                <div class="px-5 py-3.5 border-b border-ink-100 flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center gap-3">
                        <div class="text-sm font-medium text-ink-900">{{ __('crm.leads.activity') }}</div>
                        <div class="flex items-center gap-1 text-xs">
                            @foreach(['all' => __('crm.leads.all'), 'call' => __('crm.leads.calls'), 'note' => __('crm.leads.notes'), 'status' => __('crm.leads.col_status')] as $key => $label)
                                <button class="px-2 py-1 rounded {{ $loop->first ? 'text-ink-700 bg-ink-100 font-medium' : 'text-ink-500 hover:bg-ink-50' }}"
                                        data-activity-filter="{{ $key }}">{{ $label }}</button>
                            @endforeach
                        </div>
                    </div>
                    <button class="text-xs text-ink-500 hover:text-ink-900">{{ __('crm.leads.newest_first') }} ↓</button>
                </div>

                <div class="px-5 py-5">
                    <x-timeline>
                        @forelse($lead->activities ?? [] as $activity)
                            <x-timeline-item :type="$activity->type"
                                             :title="$activity->title"
                                             :time="$activity->created_at"
                                             :duration="$activity->duration ?? null"
                                             :author="$activity->user->name ?? null">
                                {{ $activity->body }}
                            </x-timeline-item>
                        @empty
                            <x-timeline-item type="created" :title="__('crm.leads.lead_created')" :time="$lead->created_at">
                                {{ $lead->source ? __('crm.leads.imported_via', ['source' => $lead->source]) : __('crm.leads.imported') }}
                            </x-timeline-item>
                        @endforelse
                    </x-timeline>
                </div>
            </x-card>
        </div>
    </div>

    {{-- ============ النوافذ المنبثقة ============ --}}
    <x-modal id="schedule-followup" :title="__('crm.leads.schedule_followup')">
        <form method="POST" action="{{ route('leads.followups.store', $lead) }}" id="schedule-followup-form">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-ink-700 mb-1.5">{{ __('crm.common.when') }}</label>
                    <input type="datetime-local" name="scheduled_at" required
                           class="w-full h-10 px-3 rounded-lg border border-ink-200 text-sm focus:ring-2 focus:ring-brand-500/20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-700 mb-1.5">{{ __('crm.common.note') }}</label>
                    <textarea name="note" rows="3"
                              class="w-full px-3 py-2 rounded-lg border border-ink-200 text-sm focus:ring-2 focus:ring-brand-500/20"></textarea>
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button variant="ghost" data-modal-close>{{ __('crm.common.cancel') }}</x-button>
            <x-button variant="primary" type="submit" form="schedule-followup-form">{{ __('crm.leads.schedule_followup') }}</x-button>
        </x-slot>
    </x-modal>

    <x-modal id="reject-lead" :title="__('crm.leads.reject')">
        <form method="POST" action="{{ route('leads.reject', $lead) }}" id="reject-lead-form">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-ink-700 mb-1.5">{{ __('crm.common.reason') }}</label>
                    <select name="reason" required class="w-full h-10 px-3 rounded-lg border border-ink-200 text-sm">
                        <option value="">{{ __('crm.common.select_reason') }}</option>
                        @foreach(['price', 'budget', 'competitor', 'timing', 'other'] as $r)
                            <option value="{{ $r }}">{{ __('crm.rejection_reasons.'.$r) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-700 mb-1.5">
                        {{ __('crm.common.note') }} ({{ __('crm.common.optional') }})
                    </label>
                    <textarea name="notes" rows="3" class="w-full px-3 py-2 rounded-lg border border-ink-200 text-sm"></textarea>
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button variant="ghost" data-modal-close>{{ __('crm.common.cancel') }}</x-button>
            <x-button variant="danger" type="submit" form="reject-lead-form">{{ __('crm.leads.reject') }}</x-button>
        </x-slot>
    </x-modal>

</x-layouts.app>
