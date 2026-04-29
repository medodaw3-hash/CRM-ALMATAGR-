{{-- resources/views/pages/clients/index.blade.php --}}
<x-layouts.app :title="__('crm.clients.title')">

    @php $isRtl = $isRtl ?? in_array(app()->getLocale(),['ar','he','fa','ur'],true); @endphp

    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-ink-900">{{ __('crm.clients.title') }}</h1>
            <p class="text-sm text-ink-500 mt-1">
                {{ __('crm.clients.subtitle', ['active' => $activeCount ?? 0, 'churned' => $churnedThisQuarter ?? 0]) }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="secondary" :href="route('clients.export')">{{ __('crm.clients.export_csv') }}</x-button>
            <x-button variant="primary" icon="plus" :href="route('clients.create')">{{ __('crm.clients.add_client') }}</x-button>
        </div>
    </div>

    {{-- التصفية --}}
    <form method="GET" class="flex items-center gap-2 mb-4 flex-wrap">
        <div class="relative flex-1 max-w-sm min-w-[200px]">
            <x-icon name="search" class="absolute {{ $isRtl ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 text-ink-400 w-3.5 h-3.5" />
            <input type="search" name="q" value="{{ request('q') }}"
                   class="w-full h-9 {{ $isRtl ? 'pr-9 pl-3' : 'pl-9 pr-3' }} rounded-lg bg-white border border-ink-200 text-sm placeholder-ink-400 focus:bg-white focus:ring-2 focus:ring-brand-500/20"
                   placeholder="{{ __('crm.clients.search') }}">
        </div>

        <select name="status" class="h-9 px-3 rounded-lg border border-ink-200 bg-white text-sm text-ink-700">
            <option value="">{{ __('crm.clients.all_status') }}</option>
            <option value="active" @selected(request('status')==='active')>{{ __('crm.status.active') }}</option>
            <option value="atrisk" @selected(request('status')==='atrisk')>{{ __('crm.status.atrisk') }}</option>
            <option value="churned" @selected(request('status')==='churned')>{{ __('crm.status.churned') }}</option>
        </select>

        <select name="city" class="h-9 px-3 rounded-lg border border-ink-200 bg-white text-sm text-ink-700">
            <option value="">{{ __('crm.clients.all_cities') }}</option>
            @foreach($cities ?? [] as $c)
                <option value="{{ $c }}" @selected(request('city')===$c)>{{ $c }}</option>
            @endforeach
        </select>

        <select name="plan" class="h-9 px-3 rounded-lg border border-ink-200 bg-white text-sm text-ink-700">
            <option value="">{{ __('crm.clients.all_plans') }}</option>
            <option value="starter">{{ __('crm.clients.plan_starter') }}</option>
            <option value="growth">{{ __('crm.clients.plan_growth') }}</option>
            <option value="enterprise">{{ __('crm.clients.plan_enterprise') }}</option>
        </select>
    </form>

    <x-table>
        <x-slot:head>
            <tr class="text-xs text-ink-500 uppercase tracking-wider">
                <th class="px-4 py-3 font-medium">{{ __('crm.clients.col_client') }}</th>
                <th class="px-4 py-3 font-medium">{{ __('crm.clients.col_status') }}</th>
                <th class="px-4 py-3 font-medium">{{ __('crm.clients.col_plan') }}</th>
                <th class="px-4 py-3 font-medium">{{ __('crm.clients.col_mrr') }}</th>
                <th class="px-4 py-3 font-medium">{{ __('crm.clients.col_owner') }}</th>
                <th class="px-4 py-3 font-medium">{{ __('crm.clients.col_since') }}</th>
                <th class="px-4 py-3 font-medium w-8"></th>
            </tr>
        </x-slot>

        @forelse($clients as $client)
            <tr class="hover:bg-ink-50/50 transition {{ $client->status === 'churned' ? 'opacity-70' : '' }}">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <x-avatar :name="$client->name" size="md" />
                        <div class="min-w-0">
                            <a href="{{ route('clients.show', $client) }}" class="font-medium text-ink-900 hover:text-brand-600 truncate block">
                                {{ $client->name }}
                            </a>
                            <div class="text-xs text-ink-500 truncate">{{ $client->website ?? $client->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3"><x-status-badge :status="$client->status" /></td>
                <td class="px-4 py-3 text-ink-700">
                    @if(!empty($client->plan))
                        {{ __('crm.clients.plan_'.$client->plan, [], '') ?: ucfirst($client->plan) }}
                    @else
                        —
                    @endif
                </td>
                <td class="px-4 py-3 font-medium text-ink-900 latin-nums">
                    @if($client->mrr)
                        ${{ number_format($client->mrr) }}
                    @else
                        <span class="text-ink-400 font-normal">—</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    @if($client->owner)
                        <div class="flex items-center gap-2">
                            <x-avatar :name="$client->owner->name" size="sm" />
                            <span class="text-ink-700">{{ explode(' ', $client->owner->name)[0] }}</span>
                        </div>
                    @else
                        <span class="text-ink-400 text-xs">{{ __('crm.clients.unassigned') }}</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-ink-500">{{ $client->created_at->locale(app()->getLocale())->isoFormat('MMM YYYY') }}</td>
                <td class="px-4 py-3 text-end">
                    <a href="{{ route('clients.show', $client) }}" class="text-xs text-brand-600 hover:text-brand-700 font-medium">{{ __('crm.clients.view') }} →</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-4 py-12 text-center text-ink-500">{{ __('crm.clients.no_clients') }}</td></tr>
        @endforelse

        @if(method_exists($clients ?? null, 'links'))
            <x-slot:footer>
                <div class="text-ink-500">
                    {{ __('crm.common.showing', ['from' => $clients->firstItem() ?? 0, 'to' => $clients->lastItem() ?? 0, 'total' => $clients->total() ?? 0]) }}
                </div>
                <div>{{ $clients->links() }}</div>
            </x-slot>
        @endif
    </x-table>
</x-layouts.app>
