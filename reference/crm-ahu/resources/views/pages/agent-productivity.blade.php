<x-dashonic-horizontal-layout sidebar="1">
<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-line mr-3 text-blue-500"></i>
                        Agent Productivity
                    </h1>
                    <p class="mt-2 text-gray-400">Monitor performa dan produktivitas agent secara real-time</p>
                    {{-- <div class="mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-900 text-yellow-300">
                            <i class="fas fa-info-circle mr-2"></i>
                            Data Dummy - Akan diganti dengan data real setelah tabel tersedia
                        </span>
                    </div> --}}
                </div>
                <div class="text-right">
                    <div class="text-white text-lg font-medium" id="currentDateTime"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agent Information Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gray-800 rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Welcome back, {{ $agent->name ?? 'Agent' }}</h2>
                            <div class="flex items-center mt-2">
                                <div class="flex items-center mr-6">
                                    <span class="text-gray-400 mr-2">Header:</span>
                                    <span class="text-white font-medium">{{ $agent->name ?? 'Unknown' }} - </span>
                                    <span class="inline-flex items-center ml-2">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                        <span class="text-green-400 font-medium">Online</span>
                                    </span>
                                </div>
                                {{-- <div class="flex items-center">
                                    <span class="text-gray-400 mr-2">Shift:</span>
                                    <span class="text-white font-medium">Pagi (08:00-16:00)</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row mb-4">
        <!-- Gabungan 2 card pertama: Total Interaksi & Tiket Diproses -->
        <div class="col-md-8">
            <div class="bg-gray-800 rounded-2xl shadow-lg p-6 h-56 flex flex-col justify-between">
                <div class="flex items-center h-full">
                    <!-- Total Interaksi -->
                    <div class="flex-1 flex items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-white" id="totalInteractions">{{$totalInteraksi ?? 0}}</h3>
                            <p class="text-gray-400 text-sm mt-1">Total Interaksi</p>
                            <div class="mt-3">
                                <div class="flex items-center">
                                    <span class="text-gray-400 text-sm">Target: 0</span>
                                    {{-- <div class="ml-3 flex items-center">
                                        @if(($productivityData['interaction_performance'] ?? 0) >= 0)
                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                            <span class="text-green-400 text-sm font-medium">+{{ $productivityData['interaction_performance'] ?? 0 }}% above target</span>
                                        @else
                                            <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                            <span class="text-red-400 text-sm font-medium">{{ $productivityData['interaction_performance'] ?? 0 }}% below target</span>
                                        @endif
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center ml-5">
                            <i class="fas fa-handshake text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="border-l border-gray-700 h-24 mx-7"></div>
                    <!-- Tiket Diproses -->
                    <div class="flex-1 flex items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-white" id="ticketsProcessed">{{$totalTicket ?? 0}}</h3>
                            <p class="text-gray-400 text-sm mt-1">Tiket Diproses</p>
                            <div class="mt-3">
                                <div class="flex items-center">
                                    <span class="text-gray-400 text-sm">Target: 0</span>
                                    <div class="ml-3 flex items-center">
                                        {{-- @if(($productivityData['ticket_performance'] ?? 0) >= 0)
                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                            <span class="text-green-400 text-sm font-medium">+{{ $productivityData['ticket_performance'] ?? 0 }}% above target</span>
                                        @else
                                            <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                            <span class="text-red-400 text-sm font-medium">{{ $productivityData['ticket_performance'] ?? 0 }}% below target</span>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center ml-5">
                            <i class="fas fa-ticket-alt text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="border-l border-gray-700 h-24 mx-7"></div>
                    <div onclick="goToTicketSLA('near')" class="flex-1 flex items-center cursor-pointer">
                        <div>
                            <h3 class="text-2xl font-bold text-white" id="TicketNearSLA">0</h3>
                            <p class="text-gray-400 text-sm mt-1">Tiket Near SLA</p>
                            <div class="mt-3">
                                <div class="flex items-center">
                                    <div class="ml-3 flex items-center">
                                        {{-- @if(($productivityData['ticket_performance'] ?? 0) >= 0)
                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                            <span class="text-green-400 text-sm font-medium">+{{ $productivityData['ticket_performance'] ?? 0 }}% above target</span>
                                        @else
                                            <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                            <span class="text-red-400 text-sm font-medium">{{ $productivityData['ticket_performance'] ?? 0 }}% below target</span>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-yellow-600 rounded-full flex items-center justify-center ml-5">
                            <i class="fas fa-ticket-alt text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="border-l border-gray-700 h-24 mx-7"></div>
                    <div onclick="goToTicketSLA('over')" class="flex-1 flex items-center cursor-pointer">
                        <div>
                            <h3 class="text-2xl font-bold text-white" id="TicketOverSLA">0</h3>
                            <p class="text-gray-400 text-sm mt-1">Tiket Over SLA</p>
                            <div class="mt-3">
                                <div class="flex items-center">
                                    <div class="ml-3 flex items-center">
                                        {{-- @if(($productivityData['ticket_performance'] ?? 0) >= 0)
                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                            <span class="text-green-400 text-sm font-medium">+{{ $productivityData['ticket_performance'] ?? 0 }}% above target</span>
                                        @else
                                            <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                            <span class="text-red-400 text-sm font-medium">{{ $productivityData['ticket_performance'] ?? 0 }}% below target</span>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center ml-5">
                            <i class="fas fa-ticket-alt text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Channel Aktif tetap -->
        <div class="col-md-4">
            <div class="bg-gray-800 rounded-2xl shadow-lg p-6 h-56 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-3 space-x-2">
                            @foreach ($handles as $handles)

                                <img src="{{ asset($handles->channel->icon) }}" alt="Channel Icon" class="w-6 h-6">
                            @endforeach
                        </div>
                        <h3 class="text-2xl font-bold text-white">{{ $totalHandles ?? 0 }}/{{ $totalChannels ?? 0 }}</h3>
                        <p class="text-gray-400 text-sm mt-1">Channel Aktif</p>
                        {{-- <div class="mt-3">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-green-400 text-sm font-medium">All channels active</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Real-time Performance Section -->
    <div class="row">
        <div class="col-12">
            <div class="bg-gray-800 rounded-2xl shadow-lg p-6">
                <div class="flex items-center mb-6">
                    <i class="fas fa-clock text-pink-500 text-xl mr-3"></i>
                    <h3 class="text-xl font-bold text-white">Real-time Performance</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-left py-4 px-4 text-gray-400 font-medium">Metrics</th>
                                @foreach ($realtimePerformance as $perf)
                                    <th class="text-center py-4 px-4 text-gray-400 font-medium">
                                        <div class="flex items-center justify-center">
                                            @if ($perf['icon'])
                                                <img src="{{ asset($perf['icon']) }}" alt="{{ $perf['channel_name'] }}" class="w-5 h-5 mr-2">
                                            @endif
                                            {{ $perf['channel_name'] }}
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Interaksi --}}
                            <tr class="border-b border-gray-700">
                                <td class="py-4 px-4 text-white font-medium">Interaksi</td>
                                @foreach ($realtimePerformance as $perf)
                                    <td class="py-4 px-4 text-center text-white">{{ $perf['interaksi'] }}</td>
                                @endforeach
                            </tr>

                            {{-- Tiket --}}
                            <tr class="border-b border-gray-700">
                                <td class="py-4 px-4 text-white font-medium">Tiket</td>
                                @foreach ($realtimePerformance as $perf)
                                    <td class="py-4 px-4 text-center text-white">{{ $perf['tiket'] }}</td>
                                @endforeach
                            </tr>

                            {{-- FRT (placeholder sementara) --}}
                            <tr class="border-b border-gray-700">
                                <td class="py-4 px-4 text-white font-medium">FRT</td>
                                @foreach ($realtimePerformance as $perf)
                                    <td class="py-4 px-4 text-center text-white">{{ $perf['frt'] ?? '0s' }}</td>
                                @endforeach
                            </tr>

                            {{-- AHT (placeholder sementara) --}}
                            <tr class="border-b border-gray-700">
                                <td class="py-4 px-4 text-white font-medium">AHT</td>
                                @foreach ($realtimePerformance as $perf)
                                    <td class="py-4 px-4 text-center text-white">{{ $perf['aht'] ?? '0s' }}</td>
                                @endforeach
                            </tr>

                            {{-- Status (placeholder sementara) --}}
                            <tr>
                                <td class="py-4 px-4 text-white font-medium">Status</td>
                                @foreach ($realtimePerformance as $perf)
                                    @php
                                        $statusColor = $perf['status_color'] ?? 'gray';
                                        $statusText = $perf['status_text'] ?? 'No Data';
                                    @endphp
                                    <td class="py-4 px-4 text-center">
                                        <div class="flex items-center justify-center">
                                            <div class="w-3 h-3 bg-{{ $statusColor }}-500 rounded-full mr-2"></div>
                                            <span class="text-{{ $statusColor }}-400 text-sm">{{ $statusText }}</span>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    // Update current date and time
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        const dateTimeString = now.toLocaleDateString('id-ID', options);
        document.getElementById('currentDateTime').textContent = dateTimeString;
    }

    // Update date time every second
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Load real-time data
    function loadAgentProductivityData() {
        $.get('{{ route("agent-productivity-dashboard.data") }}')
            .done(function(data) {
                // Update KPI cards
                $('#totalInteractions').text(data.productivity.total_interactions);
                $('#ticketsProcessed').text(data.productivity.tickets_processed);

                // Update performance table
                updatePerformanceTable(data.performance);
            })
            .fail(function() {
                console.log('Failed to load productivity data');
            });
    }

    function updatePerformanceTable(performanceData) {
        // Update interactions
        $('tbody tr:eq(0) td:eq(1)').text(performanceData.phone.interactions);
        $('tbody tr:eq(0) td:eq(2)').text(performanceData.chat.interactions);
        $('tbody tr:eq(0) td:eq(3)').text(performanceData.whatsapp.interactions);
        $('tbody tr:eq(0) td:eq(4)').text(performanceData.email.interactions);

        // Update tickets
        $('tbody tr:eq(1) td:eq(1)').text(performanceData.phone.tickets);
        $('tbody tr:eq(1) td:eq(2)').text(performanceData.chat.tickets);
        $('tbody tr:eq(1) td:eq(3)').text(performanceData.whatsapp.tickets);
        $('tbody tr:eq(1) td:eq(4)').text(performanceData.email.tickets);

        // Update FRT
        $('tbody tr:eq(2) td:eq(1)').text(performanceData.phone.frt);
        $('tbody tr:eq(2) td:eq(2)').text(performanceData.chat.frt);
        $('tbody tr:eq(2) td:eq(3)').text(performanceData.whatsapp.frt);
        $('tbody tr:eq(2) td:eq(4)').text(performanceData.email.frt);

        // Update AHT
        $('tbody tr:eq(3) td:eq(1)').text(performanceData.phone.aht);
        $('tbody tr:eq(3) td:eq(2)').text(performanceData.chat.aht);
        $('tbody tr:eq(3) td:eq(3)').text(performanceData.whatsapp.aht);
        $('tbody tr:eq(3) td:eq(4)').text(performanceData.email.aht);

        // Update status
        updateStatusCell(4, 1, performanceData.phone);
        updateStatusCell(4, 2, performanceData.chat);
        updateStatusCell(4, 3, performanceData.whatsapp);
        updateStatusCell(4, 4, performanceData.email);
    }

    function updateStatusCell(row, col, data) {
        const cell = $('tbody tr:eq(' + row + ') td:eq(' + col + ')');
        const dot = cell.find('div:first');
        const text = cell.find('span:last');

        dot.removeClass('bg-green-500 bg-yellow-500 bg-red-500 bg-gray-500')
           .addClass('bg-' + data.status_color + '-500');
        text.removeClass('text-green-400 text-yellow-400 text-red-400 text-gray-400')
            .addClass('text-' + data.status_color + '-400')
            .text(data.status_text);
    }

    function loadTicketSLA() {
        fetch('{{ route("chat.v3.ticket.sla") }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(res => {
            if (!res.count) return;

            document.getElementById('TicketNearSLA').innerText = res.count.near_sla ?? 0;
            document.getElementById('TicketOverSLA').innerText = res.count.over_sla ?? 0;
        })
        .catch(err => {
            console.error('Error load Ticket SLA:', err);
            document.getElementById('TicketNearSLA').innerText = 0;
            document.getElementById('TicketOverSLA').innerText = 0;
        });
    }

    function goToTicketSLA(type) {
        const url = new URL("{{ route('chat.v3.ticket.result.index') }}", window.location.origin);
        url.searchParams.set('sla_status', type);
        window.location.href = url.toString();
    }

    // Initialize data loading
    document.addEventListener('DOMContentLoaded', function () {
        loadTicketSLA();
    });



</script>
</x-dashonic-horizontal-layout>
