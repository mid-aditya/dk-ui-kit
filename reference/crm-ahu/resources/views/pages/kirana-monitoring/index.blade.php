<x-dashonic-horizontal-layout sidebar="1" with-sidebar="1" with-header="1" with-footer="1">
    <div class="min-h-screen bg-gray-900 p-6">
        <div class="mb-8 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="bx bx-pulse text-cyan-400 mr-3 text-4xl"></i>
                    Kirana Analysis Monitoring
                </h1>
                <p class="mt-2 text-gray-400">Monitor success, failed, retry, dan step-by-step log manual maupun batch.</p>
            </div>
            <div class="rounded-xl bg-gray-800/70 px-4 py-3 text-right shadow-lg">
                <div class="text-sm text-gray-400">Live Monitoring</div>
                <div class="text-lg font-semibold text-white" id="currentDateTime"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <div class="rounded-2xl bg-gradient-to-br from-emerald-500/15 via-emerald-500/5 to-transparent p-5 shadow-lg shadow-emerald-900/10">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-300">Current Success</div>
                        <div class="mt-3 text-3xl font-bold text-white">{{ number_format($summary['analysis_success']) }}</div>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-300">
                        <i class="bx bx-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-red-500/15 via-red-500/5 to-transparent p-5 shadow-lg shadow-red-900/10">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-red-300">Current Failed</div>
                        <div class="mt-3 text-3xl font-bold text-white">{{ number_format($summary['analysis_failed']) }}</div>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-500/15 text-red-300">
                        <i class="bx bx-x-circle text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-amber-500/15 via-amber-500/5 to-transparent p-5 shadow-lg shadow-amber-900/10">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-300">Current Pending</div>
                        <div class="mt-3 text-3xl font-bold text-white">{{ number_format($summary['analysis_pending']) }}</div>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/15 text-amber-300">
                        <i class="bx bx-time-five text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-cyan-500/15 via-cyan-500/5 to-transparent p-5 shadow-lg shadow-cyan-900/10">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-300">Waiting Webhook</div>
                        <div class="mt-3 text-3xl font-bold text-white">{{ number_format($summary['analysis_waiting_webhook']) }}</div>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-500/15 text-cyan-300">
                        <i class="bx bx-transfer-alt text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-400">Analyze sudah dikirim, menunggu callback webhook</div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
            <div class="xl:col-span-2 rounded-2xl bg-gray-800 p-6 shadow-lg">
                <form method="get" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <input type="text" name="search" value="{{ $filters['search'] }}"
                        class="bg-gray-700/50 border-0 rounded-xl text-white px-4 py-2.5"
                        placeholder="Search ticket / request / filename">
                    <select name="source" class="bg-gray-700/50 border-0 rounded-xl text-white px-4 py-2.5">
                        <option value="">All Source</option>
                        <option value="manual" @selected($filters['source'] === 'manual')>Manual</option>
                        <option value="batch" @selected($filters['source'] === 'batch')>Batch</option>
                    </select>
                    <select name="ticket_type" class="bg-gray-700/50 border-0 rounded-xl text-white px-4 py-2.5">
                        <option value="">All Ticket Type</option>
                        <option value="outbound" @selected($filters['ticket_type'] === 'outbound')>Outbound</option>
                        <option value="result" @selected($filters['ticket_type'] === 'result')>Result Ticket</option>
                    </select>
                    <select name="status" class="bg-gray-700/50 border-0 rounded-xl text-white px-4 py-2.5">
                        <option value="">All Final Status</option>
                        <option value="success" @selected($filters['status'] === 'success')>Success</option>
                        <option value="failed" @selected($filters['status'] === 'failed')>Failed</option>
                        <option value="skipped" @selected($filters['status'] === 'skipped')>Skipped</option>
                        <option value="rejected" @selected($filters['status'] === 'rejected')>Rejected</option>
                        <option value="processing" @selected($filters['status'] === 'processing')>Processing</option>
                    </select>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] }}"
                        class="bg-gray-700/50 border-0 rounded-xl text-white px-4 py-2.5">
                    <input type="date" name="date_to" value="{{ $filters['date_to'] }}"
                        class="bg-gray-700/50 border-0 rounded-xl text-white px-4 py-2.5">
                    <input type="text" name="ticket_id" value="{{ $filters['ticket_id'] }}"
                        class="bg-gray-700/50 border-0 rounded-xl text-white px-4 py-2.5"
                        placeholder="Ticket ID">
                    <input type="text" name="request_group_id" value="{{ $filters['request_group_id'] }}"
                        class="bg-gray-700/50 border-0 rounded-xl text-white px-4 py-2.5"
                        placeholder="Request Group ID">
                    <div class="xl:col-span-4 flex gap-3">
                        <button type="submit" class="rounded-xl bg-cyan-600 hover:bg-cyan-700 px-5 py-2.5 text-white font-medium">
                            Apply Filter
                        </button>
                        <a href="{{ url()->current() }}" class="rounded-xl bg-gray-700 hover:bg-gray-600 px-5 py-2.5 text-white font-medium">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

        </div>

        <div class="rounded-2xl bg-gray-800 p-6 shadow-lg mb-6">
            <div class="flex items-center justify-between gap-3 mb-4">
                <h2 class="text-xl font-semibold text-white">Attempt Summary</h2>
                <div class="flex items-center gap-3 text-sm text-gray-400">
                    <span>1 row = 1 attempt/request group, pending tidak ditampilkan</span>
                    @if ($filters['request_group_id'] || $filters['ticket_id'])
                        @php
                            $resetDetailQuery = collect(request()->query())->except(['request_group_id', 'ticket_id'])->toArray();
                            $resetDetailUrl = request()->url() . (count($resetDetailQuery) ? '?' . http_build_query($resetDetailQuery) : '');
                        @endphp
                        <a href="{{ $resetDetailUrl }}"
                            class="inline-flex items-center rounded-lg bg-gray-700/70 px-3 py-2 text-gray-200 hover:bg-gray-700">
                            <i class="bx bx-reset mr-1"></i> Reset Detail
                        </a>
                    @endif
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-700 text-left text-gray-400">
                            <th class="pb-3">Ticket</th>
                            <th class="pb-3">Type</th>
                            <th class="pb-3">Source</th>
                            <th class="pb-3">Attempt</th>
                            <th class="pb-3">Final Status</th>
                            <th class="pb-3">Error</th>
                            <th class="pb-3">Conversation</th>
                            <th class="pb-3">Steps</th>
                            <th class="pb-3">Started</th>
                            <th class="pb-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($attempts as $attempt)
                            <tr class="hover:bg-gray-700/30">
                                <td class="py-3 text-white">{{ $attempt->ticket_id }}</td>
                                <td class="py-3 text-gray-300">{{ strtoupper($attempt->ticket_type) }}</td>
                                <td class="py-3 text-gray-300">{{ strtoupper($attempt->source) }}</td>
                                <td class="py-3 text-gray-300">#{{ $attempt->attempt_no }}</td>
                                <td class="py-3">
                                    @php
                                        $badgeClass = match ($attempt->status) {
                                            'success' => 'bg-emerald-500/20 text-emerald-300',
                                            'failed' => 'bg-red-500/20 text-red-300',
                                            'processing', 'started' => 'bg-blue-500/20 text-blue-300',
                                            'skipped', 'rejected' => 'bg-yellow-500/20 text-yellow-300',
                                            'legacy' => 'bg-slate-500/20 text-slate-300',
                                            default => 'bg-gray-500/20 text-gray-300',
                                        };
                                    @endphp
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">{{ strtoupper($attempt->status) }}</span>
                                </td>
                                <td class="py-3 text-gray-300">{{ $attempt->error_category ?: '-' }}</td>
                                <td class="py-3 text-gray-400">{{ $attempt->conversation_id ?: '-' }}</td>
                                <td class="py-3 text-gray-300">{{ $attempt->total_steps ?: 'Legacy' }}</td>
                                <td class="py-3 text-gray-300">{{ $attempt->started_at }}</td>
                                <td class="py-3">
                                    @if (str_starts_with((string) $attempt->request_group_id, 'legacy-analysis-'))
                                        <span class="inline-flex items-center rounded-lg bg-gray-700/50 px-3 py-2 text-gray-400">
                                            Legacy Data
                                        </span>
                                    @else
                                        @php
                                            $detailQuery = collect(request()->query())
                                                ->except(['request_group_id'])
                                                ->merge(['request_group_id' => $attempt->request_group_id])
                                                ->toArray();
                                            $detailUrl = request()->url() . '?' . http_build_query($detailQuery);
                                            $isActiveDetail = $filters['request_group_id'] === $attempt->request_group_id;
                                        @endphp
                                        <a href="{{ $detailUrl }}"
                                            class="inline-flex items-center rounded-lg px-3 py-2 {{ $isActiveDetail ? 'bg-cyan-500 text-white' : 'bg-cyan-600/20 text-cyan-300 hover:bg-cyan-600/30' }}">
                                            <i class="bx bx-show mr-1"></i> Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-8 text-center text-gray-400">Belum ada data monitoring.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $attempts->links() }}
            </div>
        </div>

        <div class="rounded-2xl bg-gray-800 p-6 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-white">Step-by-Step Logs</h2>
                <div class="text-sm text-gray-400">Filter by request group atau ticket untuk melihat detail langkah.</div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-700 text-left text-gray-400">
                            <th class="pb-3">Time</th>
                            <th class="pb-3">Request</th>
                            <th class="pb-3">Ticket</th>
                            <th class="pb-3">Source</th>
                            <th class="pb-3">Step</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Message</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($detailLogs as $log)
                            <tr class="hover:bg-gray-700/30 align-top">
                                <td class="py-3 text-gray-300">{{ $log->created_at }}</td>
                                <td class="py-3 text-gray-400">{{ $log->request_group_id }}</td>
                                <td class="py-3 text-white">{{ $log->ticket_id }}</td>
                                <td class="py-3 text-gray-300">{{ strtoupper($log->source) }}</td>
                                <td class="py-3 text-gray-300">{{ $log->step_order }}. {{ $log->step_label }}</td>
                                <td class="py-3 text-gray-300">{{ $log->status }}</td>
                                <td class="py-3 text-gray-300 max-w-[560px]">
                                    <div>{{ $log->message }}</div>
                                    @if (!empty($log->context))
                                        <details class="mt-2">
                                            <summary class="cursor-pointer text-cyan-300">View context</summary>
                                            <pre class="mt-2 whitespace-pre-wrap rounded-lg bg-gray-900 p-3 text-xs text-gray-300">{{ json_encode($log->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </details>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400">Pilih `request_group_id` atau `ticket_id` untuk melihat detail langkah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            function updateDateTime() {
                const now = new Date();
                document.getElementById('currentDateTime').textContent = now.toLocaleString('id-ID');
            }
            updateDateTime();
            setInterval(updateDateTime, 1000);
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
