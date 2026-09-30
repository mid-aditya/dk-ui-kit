<x-dashonic-horizontal-layout sidebar="1">
    <div class="min-h-screen bg-gray-900 p-6">
        <!-- Header Section -->
        <div class="mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <i class="bx bxs-group text-blue-500 mr-3 text-4xl"></i>
                        Agent Performance
                    </h1>
                    <p class="mt-2 text-gray-400 flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        Welcome back, {{ auth()->user()->name }}
                    </p>
                    <p class="mt-7 text-gray-400">Monitor and track agent activities in real-time</p>
                </div>
                <div class="text-right bg-gray-800/50 p-3 rounded-lg shadow-lg">
                    <div class="text-gray-300 text-lg font-semibold" id="currentDateTime"></div>
                    <p class="text-sm text-gray-400 mt-1">Last updated: <span id="lastUpdate">Just now</span></p>
                </div>
            </div>
        </div>

        <!-- Current Agent Status -->
        <div class="bg-gray-800 rounded-xl p-6 mb-8 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center mr-3">
                            <i class="bx bxs-user text-xl text-blue-500"></i>
                        </div>
                        Current Agent Status
                    </h2>
                    <p class="text-sm text-gray-400 mt-4">Real-time overview of agent activities</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span class="text-gray-300 text-sm">Ready</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span class="text-gray-300 text-sm">Offline</span>
                    </div>
                    <form id="search-form" class="relative">
                        <input type="text" 
                               id="search" 
                               placeholder="Search agents..." 
                               class="w-64 bg-gray-700 border-gray-600 text-white rounded-lg pl-10 pr-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-700/50 text-gray-300 text-sm">
                            <th class="px-6 py-3 text-left font-semibold">Agent</th>
                            <th class="px-6 py-3 text-left font-semibold">Status</th>
                            <th class="px-6 py-3 text-left font-semibold">Current Handle</th>
                            <th class="px-6 py-3 text-left font-semibold">Closed Today</th>
                            <th class="px-6 py-3 text-left font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="agent-list" class="divide-y divide-gray-700/30">
                        @foreach ($user_agents ?? [] as $agent)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                            {{ substr($agent->user->name ?? 'A', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ $agent->user->name ?? 'Anonymous' }}</div>
                                            <div class="text-gray-400 text-sm">{{ $agent->username ?? 'No Username' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($agent->aux == "ready")
                                        <span class="inline-flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            <span class="text-white">Ready</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                            <span class="text-white">Offline</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-white">{{ $agent->current_handle ?? 0 }}</td>
                                <td class="px-6 py-4 text-white">{{ $agent->closed_chat_today ?? 0 }}</td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-400 hover:text-blue-300 transition-colors">
                                        <i class="bx bx-show mr-1"></i> View Details
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="pagination-links" class="mt-6 flex justify-center"></div>
        </div>

        <!-- Agent Performance History -->
        <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-white">Performance History</h2>
                    <p class="text-sm text-gray-400 mt-1">Detailed agent performance metrics</p>
                </div>
                <div class="flex items-center gap-4">
                    <select id="timeRange" class="bg-gray-700 border-gray-600 text-white rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                    <input type="text" 
                           id="agentSearch" 
                           placeholder="Search agents..." 
                           class="w-64 bg-gray-700 border-gray-600 text-white rounded-lg pl-10 pr-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full" id="agent-lists">
                    <thead>
                        <tr class="bg-gray-700/50 text-gray-300 text-sm">
                            <th class="px-6 py-3 text-left font-semibold">Agent</th>
                            <th class="px-6 py-3 text-left font-semibold">Total Handled</th>
                            <th class="px-6 py-3 text-left font-semibold">Avg Response</th>
                            <th class="px-6 py-3 text-left font-semibold">Success Rate</th>
                            <th class="px-6 py-3 text-left font-semibold">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/30">
                        <!-- Dynamic content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            const defaultDateFilter = '{{ request()->get("date_filter", now()->format("Y-m-d")) }}';
            const defaultDateFilter2 = '{{ request()->get("date_filter2", now()->format("Y-m-d")) }}';

            function fetch_conversation() {
                $.get(`{{ route("analytic.general.report.conversation") }}?date_filter=${defaultDateFilter}&date_filter2=${defaultDateFilter2}`, (result) => {
                    Object.keys(result).forEach(key => {
                        const element = document.getElementById(key);
                        if (element) {
                            element.textContent = result[key];
                        }
                    });
                });
            }

            function fetch_agent_lists() {
                $.get(`{{ route("analytic.general.report.agent-lists") }}?date_filter=${defaultDateFilter}&date_filter2=${defaultDateFilter2}`, (result) => {
                    let rows = "";
                    result.forEach(agent => {
                        rows += `
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                            ${agent.user.name.charAt(0)}
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">${agent.user.name}</div>
                                            <div class="text-gray-400 text-sm">${agent.username}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-white">${agent.total_chat_handled}</td>
                                <td class="px-6 py-4 text-white">${agent.avg_chat_handled}</td>
                                <td class="px-6 py-4 text-white">${agent.success_rate || '0%'}</td>
                                <td class="px-6 py-4 text-white">
                                    ${generateRatingStars(agent.rating || 0)}
                                </td>
                            </tr>`;
                    });
                    $('#agent-lists tbody').html(rows);
                });
            }

            function generateRatingStars(rating) {
                const fullStars = Math.floor(rating);
                const halfStar = rating % 1 >= 0.5;
                const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
                
                let starsHtml = '';
                
                // Full stars
                for (let i = 0; i < fullStars; i++) {
                    starsHtml += '<i class="bx bxs-star text-yellow-400"></i>';
                }
                
                // Half star
                if (halfStar) {
                    starsHtml += '<i class="bx bxs-star-half text-yellow-400"></i>';
                }
                
                // Empty stars
                for (let i = 0; i < emptyStars; i++) {
                    starsHtml += '<i class="bx bx-star text-gray-500"></i>';
                }
                
                return starsHtml;
            }

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
                document.getElementById('lastUpdate').textContent = time;
            }

            $(document).ready(() => {
                // Initialize data and update every 30 seconds
                updateDateTime();
                setInterval(updateDateTime, 1000);
                
                // Initialize agent data
                fetch_agent_lists();
                
                // Update data every 30 seconds
                setInterval(fetch_agent_lists, 30000);

                // Search functionality
                $('#search-form').on('submit', function(event) {
                    event.preventDefault();
                    let searchTerm = $('#search').val();
                    $('#agent-list tr').each(function() {
                        const text = $(this).text().toLowerCase();
                        $(this).toggle(text.includes(searchTerm.toLowerCase()));
                    });
                });

                $('#search, #agentSearch').on('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const targetTable = this.id === 'search' ? '#agent-list' : '#agent-lists';
                    $(`${targetTable} tr`).each(function() {
                        const text = $(this).text().toLowerCase();
                        $(this).toggle(text.includes(searchTerm));
                    });
                });

                // Time range change handler
                $('#timeRange').on('change', function() {
                    fetch_agent_lists();
                });
            });
        </script>
    </x-slot>
</x-dashonic-horizontal-layout> 