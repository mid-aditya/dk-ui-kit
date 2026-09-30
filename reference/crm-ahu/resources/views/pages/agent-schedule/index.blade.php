<x-dashonic-horizontal-layout sidebar="1" with-sidebar="1" with-header="1" with-footer="1">
    <style>
        .overflow-auto::-webkit-scrollbar {
            width: 10px;
            height: 10px;
            background: transparent;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #2563eb;
            border-radius: 8px;
            border: 2px solid transparent;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        .overflow-auto {
            scrollbar-color: #2563eb transparent;
            scrollbar-width: thin;
        }
    </style>

    <div class="min-h-screen bg-gray-900 p-6">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <i class="bx bx-calendar text-blue-500 mr-3 text-4xl"></i>
                        Agent Schedule
                    </h1>
                    <p class="mt-2 text-gray-400 flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        Welcome back, {{ auth()->user()->name }}
                    </p>
                </div>
                <div class="text-right bg-gray-800/50 p-3 rounded-lg shadow-lg">
                    <div class="text-gray-300 text-lg font-semibold" id="currentDateTime"></div>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="text-white text-xl font-semibold">Daftar Jadwal Agent</div>
                <a href="{{ route('agent-schedule.create') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="bx bx-plus-circle mr-2 text-xl"></i>
                    Tambah Jadwal
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success bg-green-100 text-green-800 rounded-lg p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger bg-red-100 text-red-800 rounded-lg p-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="get" class="mb-6">
                <div class="flex flex-wrap gap-3 items-center">
                    <div class="flex-1 min-w-[220px]">
                        <input type="text"
                               name="q"
                               class="w-full bg-gray-700/50 border-0 text-white rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500"
                               placeholder="Cari nama / username / email"
                               value="{{ request()->get('q') ?? '' }}">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl px-6 py-2.5 transition-colors flex items-center">
                            <i class="bx bx-search mr-2 text-xl"></i>
                            Cari
                        </button>
                        <a href="{{ route('agent-schedule.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl px-6 py-2.5 transition-colors flex items-center">
                            <i class="bx bx-refresh mr-2 text-xl"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            <div class="flex justify-between items-center mb-4 text-gray-400 text-sm">
                <div>
                    Showing {{ $dates->firstItem() ?? 0 }} to {{ $dates->lastItem() ?? 0 }} of {{ $dates->total() }} entries
                </div>
            </div>

            <div class="overflow-auto rounded-xl border border-gray-700">
                @php
                    $channelClassMap = [
                        1 => 'bg-blue-600/20 text-blue-300',
                        3 => 'bg-emerald-600/20 text-emerald-300',
                        4 => 'bg-yellow-600/20 text-yellow-300',
                        6 => 'bg-purple-600/20 text-purple-300',
                        7 => 'bg-cyan-600/20 text-cyan-300',
                    ];
                    $rowNumber = ($dates->currentPage() - 1) * $dates->perPage() + 1;
                @endphp
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr class="bg-gray-700/70">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Jumlah Agent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Channel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse ($dates as $dateRow)
                            @php
                                $dateKey = \Carbon\Carbon::parse($dateRow->date_schedule)->format('Y-m-d');
                                $daySchedules = $schedules->get($dateKey, collect());
                                $channelKeys = $daySchedules->pluck('channel')->unique()->values();
                            @endphp
                            <tr class="hover:bg-gray-700/30">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $rowNumber++ }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ \Carbon\Carbon::parse($dateRow->date_schedule)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $daySchedules->count() }} agent
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse ($channelKeys as $channelKey)
                                            @php
                                                $channelKey = (int) $channelKey;
                                                $channelLabel = $channelOptions[$channelKey] ?? $channelKey;
                                                $channelClass = $channelClassMap[$channelKey] ?? 'bg-gray-700 text-gray-300';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $channelClass }}">
                                                {{ $channelLabel }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">-</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    <a href="{{ route('agent-schedule.date', $dateKey) }}"
                                       class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white border-0">
                                        <i class="bx bx-detail mr-1"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada jadwal agent yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($dates->hasPages())
                <div class="flex justify-end mt-6">
                    {{ $dates->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <x-slot name="js">
        <script>
            function updateDateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };
                const timeOptions = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };

                const date = now.toLocaleDateString('id-ID', options);
                const time = now.toLocaleTimeString('id-ID', timeOptions);

                document.getElementById('currentDateTime').innerHTML = `
                    <div class="text-xl">${date}</div>
                    <div class="text-2xl font-bold">${time}</div>
                `;
            }

            $(document).ready(function() {
                updateDateTime();
                setInterval(updateDateTime, 1000);
            });
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
