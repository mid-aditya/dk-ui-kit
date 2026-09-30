<x-dashonic-horizontal-layout sidebar="1" with-sidebar="1" with-header="1" with-footer="1">
    <div class="min-h-screen bg-gray-900 p-3">
        <!-- Page Header -->
        <div class="mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-white flex items-center">
                        <i class="bx bx-smile text-blue-500 mr-2 text-xl"></i>
                        Dashboard CSAT
                    </h1>
                    <p class="mt-1 text-gray-400 flex items-center text-xs">
                        <i class="fas fa-chart-line mr-1"></i>
                        Kepuasan Pelanggan dari IVR PBX (PABXCC) — 1=Puas, 2=Cukup Puas, 3=Kurang Puas
                    </p>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="bg-red-500/20 border border-red-500 text-red-200 rounded-xl p-4 mb-6 text-sm">
                <i class="bx bx-error-circle mr-1"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-800 rounded-2xl p-4 transform hover:scale-[1.02] transition-all duration-300 shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-500/20 flex items-center justify-center">
                        <i class="bx bx-phone text-xl text-blue-500"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-1">{{ number_format($totalCsat) }}</h3>
                <p class="text-gray-400 text-xs">Total Record CSAT (IVR)</p>
            </div>

            <div class="bg-gray-800 rounded-2xl p-4 transform hover:scale-[1.02] transition-all duration-300 shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-green-500/20 flex items-center justify-center">
                        <i class="bx bx-check-circle text-xl text-green-500"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-1">{{ number_format($csatFilled) }}</h3>
                <p class="text-gray-400 text-xs">CSAT Terisi</p>
            </div>

            <div class="bg-gray-800 rounded-2xl p-4 transform hover:scale-[1.02] transition-all duration-300 shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-500/20 flex items-center justify-center">
                        <i class="bx bx-line-chart text-xl text-yellow-500"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-1">{{ $responseRate }}%</h3>
                <p class="text-gray-400 text-xs">Tingkat Pengisian</p>
            </div>

            <div class="bg-gray-800 rounded-2xl p-4 transform hover:scale-[1.02] transition-all duration-300 shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-red-500/20 flex items-center justify-center">
                        <i class="bx bx-x-circle text-xl text-red-500"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-1">{{ number_format($csatEmpty) }}</h3>
                <p class="text-gray-400 text-xs">CSAT Belum Diisi</p>
            </div>
        </div>

        <!-- Filters Section -->
        <form method="GET" action="{{ route('report.csat') }}" class="bg-gray-800 rounded-2xl p-4 mb-6 shadow-lg">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-gray-400 text-xs mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from', \Carbon\Carbon::now()->startOfYear()->format('Y-m-d')) }}"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-xs mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-400 text-xs mb-1">Kanal</label>
                    <select name="flaging" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                        <option value="">Semua</option>
                        <option value="1" {{ request('flaging') == '1' ? 'selected' : '' }}>Inbound</option>
                        <option value="7" {{ request('flaging') == '7' ? 'selected' : '' }}>WA Call</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-xs mb-1">Agent</label>
                    <select name="user_agent_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                        <option value="">Semua Agent</option>
                        @foreach ($agentOptions as $agent)
                            <option value="{{ $agent->id }}" {{ request('user_agent_id') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 text-xs mb-1">Status CSAT</label>
                    <select name="csat_status" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                        <option value="">Semua</option>
                        <option value="filled" {{ request('csat_status') == 'filled' ? 'selected' : '' }}>Terisi</option>
                        <option value="empty" {{ request('csat_status') == 'empty' ? 'selected' : '' }}>Belum Diisi</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        <i class="bx bx-filter-alt mr-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('report.csat') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        <i class="bx bx-reset mr-1"></i> Reset
                    </a>
                </div>
                <a href="{{ route('report.csat.export', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <i class="bx bx-download mr-1"></i> Export Excel
                </a>
            </div>
        </form>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-800 rounded-2xl p-4 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Distribusi Skor CSAT</h3>
                <div class="w-full h-72">
                    <canvas id="csatDistributionChart"></canvas>
                </div>
            </div>
            <div class="bg-gray-800 rounded-2xl p-4 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Tren CSAT per Hari</h3>
                <div class="w-full h-72">
                    <canvas id="csatTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Report Table -->
        <div class="bg-gray-800 rounded-2xl p-4 mb-6 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Detail Laporan CSAT</h3>
                <div class="text-gray-400 text-xs">
                    Total: <span class="text-white font-semibold">{{ $totalCsat }}</span>
                    <span class="ml-2">(menampilkan {{ $tickets->count() }} tiket per halaman)</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700" id="csatTable">
                    <thead class="bg-gray-700/50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">No</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pelapor</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Kanal</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nomor Tiket</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Tiket</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Waktu CSAT</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Skor</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Keterangan</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Agent</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse($tickets as $i => $row)
                            <tr class="hover:bg-gray-700/50 transition-colors">
                                <td class="px-3 py-2 whitespace-nowrap text-xs text-white">{{ $tickets->firstItem() + $i }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-xs text-white">{{ $row['customer_name'] ?? '-' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-xs text-white">{{ $row['flaging_label'] ?? '-' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-xs text-white">{{ $row['ticket_number'] ?? '-' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-xs text-white">{{ $row['ticket_created_at'] ?? '-' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-xs text-white">{{ $row['csat_time'] }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @php
                                        $badge = match ($row['csat_score']) {
                                            '1' => 'bg-green-500',
                                            '2' => 'bg-yellow-500',
                                            '3' => 'bg-red-500',
                                            default => 'bg-gray-600',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full text-white {{ $badge }}">
                                        {{ $row['csat_score'] ?? 'Belum Diisi' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-xs text-white">{{ $row['csat_label'] ?? 'Belum Diisi' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-xs text-white">{{ $row['agent'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-3 py-2 text-center text-gray-400">
                                    <i class="bx bx-info-circle text-xl mb-1"></i>
                                    <p class="text-xs">Tidak ada data</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tickets->hasPages())
                <div class="flex justify-end mt-4">
                    <div class="pagination-wrapper">
                        {{ $tickets->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function () {
            // ----- Chart Distribusi Skor -----
            const distData = JSON.parse('{!! json_encode($distChart) !!}');

            const distCtx = document.getElementById('csatDistributionChart').getContext('2d');
            new Chart(distCtx, {
                type: 'doughnut',
                data: {
                    labels: distData.labels,
                    datasets: [{
                        data: distData.values,
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(107, 114, 128, 0.6)'
                        ],
                        borderColor: '#1f2937',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { color: '#d1d5db' }
                        }
                    }
                }
            });

            // ----- Chart Tren Harian -----
            const trendData = JSON.parse('{!! json_encode($trendChart) !!}');

            const trendCtx = document.getElementById('csatTrendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendData.labels,
                    datasets: [{
                        label: 'Total CSAT',
                        data: trendData.total,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true
                    }, {
                        label: 'CSAT Terisi',
                        data: trendData.filled,
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { color: '#d1d5db' }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#9ca3af' },
                            grid: { color: 'rgba(107, 114, 128, 0.2)' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#9ca3af', precision: 0 },
                            grid: { color: 'rgba(107, 114, 128, 0.2)' }
                        }
                    }
                }
            });
        });
    </script>
</x-dashonic-horizontal-layout>
