<x-dashonic-horizontal-layout sidebar="0">
    <x-slot name="css">
        <style>
            .menu-item.active {
                background-color: #3b82f6 !important;
                color: white !important;
            }

            .menu-item.active p {
                color: rgba(255, 255, 255, 0.8) !important;
            }

            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
            }

            #scroll-area::-webkit-scrollbar {
                width: 6px;
            }

            #scroll-area::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }
        </style>
    </x-slot>

    <div class="min-h-screen bg-gray-900 p-4 sm:p-6">
        <div class="max-w-[1600px] mx-auto">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar -->
                <aside class="w-full lg:w-80 bg-gray-800 rounded-2xl shadow-lg overflow-hidden flex-shrink-0">
                    <div class="p-6 border-b border-gray-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                                <i class='bx bxs-pie-chart-alt-2 text-white text-xl'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white tracking-tight leading-none">Reports Hub</h2>
                                <p class="text-[0.65rem] font-medium text-blue-400 uppercase tracking-wider mt-1">
                                    Analytics v3.0</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <p class="text-[0.65rem] font-bold text-gray-500 uppercase tracking-widest px-4 mb-4">Categories
                        </p>
                        <nav class="space-y-1">
                            <button onclick="switchRepo('all')" id="nav-all"
                                class="menu-item active w-full flex items-start gap-3 p-4 text-gray-400 hover:bg-gray-700 rounded-xl transition-all duration-200">
                                <i class="bx bx-grid-alt text-xl"></i>
                                <div class="text-left">
                                    <span class="font-medium text-sm">All Reports</span>
                                    <p class="text-[0.7rem] opacity-70">Complete data overview</p>
                                </div>
                            </button>
                            <button onclick="switchRepo('calls')" id="nav-calls"
                                class="menu-item w-full flex items-start gap-3 p-4 text-gray-400 hover:bg-gray-700 rounded-xl transition-all duration-200">
                                <i class="bx bx-phone-call text-xl"></i>
                                <div class="text-left">
                                    <span class="font-medium text-sm">Call Analytics</span>
                                    <p class="text-[0.7rem] opacity-70">Telephony metrics</p>
                                </div>
                            </button>
                            <button onclick="switchRepo('tickets')" id="nav-tickets"
                                class="menu-item w-full flex items-start gap-3 p-4 text-gray-400 hover:bg-gray-700 rounded-xl transition-all duration-200">
                                <i class="bx bx-certification text-xl"></i>
                                <div class="text-left">
                                    <span class="font-medium text-sm">Ticketing & CS</span>
                                    <p class="text-[0.7rem] opacity-70">Support productivity</p>
                                </div>
                            </button>
                            <button onclick="switchRepo('wallboards')" id="nav-wallboards"
                                class="menu-item w-full flex items-start gap-3 p-4 text-gray-400 hover:bg-gray-700 rounded-xl transition-all duration-200">
                                <i class="bx bx-tv text-xl"></i>
                                <div class="text-left">
                                    <span class="font-medium text-sm">Live Wallboards</span>
                                    <p class="text-[0.7rem] opacity-70">Real-time monitoring</p>
                                </div>
                            </button>
                            <button onclick="switchRepo('omni')" id="nav-omni"
                                class="menu-item w-full flex items-start gap-3 p-4 text-gray-400 hover:bg-gray-700 rounded-xl transition-all duration-200">
                                <i class="bx bx-broadcast text-xl"></i>
                                <div class="text-left">
                                    <span class="font-medium text-sm">Omni Blast</span>
                                    <p class="text-[0.7rem] opacity-70">Multi-channel messaging</p>
                                </div>
                            </button>
                        </nav>
                    </div>
                </aside>

                <!-- Content Area -->
                <main
                    class="flex-1 bg-gray-800 rounded-2xl shadow-lg p-6 lg:p-8 overflow-y-auto max-h-[calc(100vh-3rem)]"
                    id="scroll-area">
                    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                        <div>
                            <h1 class="text-3xl font-extrabold text-white tracking-tight" id="repo-title">Reports Hub
                            </h1>
                            <p class="text-gray-400 mt-2 text-sm max-w-lg leading-relaxed" id="repo-desc">
                                Access centralized data, real-time analytics, and operational performance metrics across
                                all channels.
                            </p>
                        </div>
                        <div class="relative w-full md:w-72 group">
                            <i
                                class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-xl transition-colors group-focus-within:text-blue-400'></i>
                            <input type="text" id="report-search" placeholder="Search reports..."
                                onkeyup="filterReports()"
                                class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all placeholder:text-gray-600">
                        </div>
                    </header>

                    <div id="reports-sections-container">
                        <!-- CALL ANALYTICS -->
                        <section class="repo-section mb-10" id="group-calls">
                            <div class="flex items-center gap-4 mb-6">
                                <h3 class="text-lg font-bold text-white uppercase tracking-wider text-opacity-80">Call
                                    Analytics</h3>
                                <div class="h-[1px] flex-1 bg-gradient-to-r from-gray-700 to-transparent"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="{{ route('call-report.index') }}" class="card-repo block group h-full"
                                    data-name="call report">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-phone-call text-3xl text-pink-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Call Report</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Dialer transaction logs</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('daily-report.index') }}" class="card-repo block group h-full"
                                    data-name="daily update">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-calendar-check text-3xl text-pink-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Daily Report</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Daily summary metrics</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- <a href="{{ route('report.cdr') }}" class="card-repo block group h-full"
                                    data-name="cdr records">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-history text-3xl text-pink-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">CDR Records</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Core server records</p>
                                            </div>
                                        </div>
                                    </div>
                                </a> -->
                                <a href="{{ route('report.aht') }}" class="card-repo block group h-full"
                                    data-name="agent aht productivity tracking">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-timer text-3xl text-pink-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Agent AHT</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Productivity tracking</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ route('report.agent-login') }}" class="card-repo block group h-full"
                                    data-name="agent login and logout activity">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-timer text-3xl text-pink-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Agent Login</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Login and logout activity</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('report.csat') }}" class="card-repo block group h-full"
                                    data-name="csat customer satisfaction survey">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-smile text-3xl text-pink-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">CSAT Report</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Customer satisfaction survey</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </section>

                        <!-- TICKETING -->
                        <section class="repo-section mb-10" id="group-tickets">
                            <div class="flex items-center gap-4 mb-6">
                                <h3 class="text-lg font-bold text-white uppercase tracking-wider text-opacity-80">
                                    Ticketing & CS</h3>
                                <div class="h-[1px] flex-1 bg-gradient-to-r from-gray-700 to-transparent"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="{{ route('ticket-summary') }}" class="card-repo block group h-full"
                                    data-name="ticketing summary lifecycle">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-spreadsheet text-3xl text-blue-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Ticketing Summary</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Status distribution</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('tm-report.index') }}" class="card-repo block group h-full"
                                    data-name="cs performance team metrics support">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-support text-3xl text-blue-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">CS Performance</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Support team metrics</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('report.ai-agent-performance.index') }}" class="card-repo block group h-full"
                                    data-name="ai agent performance recording kirana analysis score">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-bot text-3xl text-emerald-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">AI Agent Performance</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Recording analysis score</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </section>

                        <!-- WALLBOARDS -->
                        <section class="repo-section mb-10" id="group-wallboards">
                            <div class="flex items-center gap-4 mb-6">
                                <h3 class="text-lg font-bold text-white uppercase tracking-wider text-opacity-80">Live
                                    Wallboards</h3>
                                <div class="h-[1px] flex-1 bg-gradient-to-r from-gray-700 to-transparent"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="{{ route('wallboard-dev') }}" class="card-repo block group h-full"
                                    data-name="wallboard ahu live traffic">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-chat text-3xl text-green-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Wallboard AHU</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Real-time traffic</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('wallboard-pimpinan') }}" class="card-repo block group h-full"
                                    data-name="wallboard pimpinan">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-bar-chart-alt-2 text-3xl text-green-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Wallboard Pimpinan</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Real-time traffic</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('wallboard-agent') }}" class="card-repo block group h-full"
                                    data-name="wallboard agent">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-user-pin text-3xl text-green-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Wallboard Agent</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Real-time traffic</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </section>

                        <!-- OMNI -->
                        <section class="repo-section mb-10" id="group-omni">
                            <div class="flex items-center gap-4 mb-6">
                                <h3 class="text-lg font-bold text-white uppercase tracking-wider text-opacity-80">Omni
                                    Blast</h3>
                                <div class="h-[1px] flex-1 bg-gradient-to-r from-gray-700 to-transparent"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {{-- <a href="{{ route('report.omnichat') }}" class="card-repo block group h-full"
                                    data-name="omni analytics whatsapp email chat">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-message-detail text-3xl text-purple-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Omni Analytics</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Multi-channel data</p>
                                            </div>
                                        </div>
                                    </div>
                                </a> --}}
                                <a href="{{ route('dashboard.schedule.blast') }}" class="card-repo block group h-full"
                                    data-name="outbound blast dashboard analytics whatsapp email campaign">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-bar-chart-alt-2 text-3xl text-purple-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Outbound Blast Dashboard</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Blast KPI and analytics</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('chat.v3.report.blast-history') }}" class="card-repo block group h-full"
                                    data-name="blast history audit logs campaign">
                                    <div
                                        class="bg-gray-700 p-5 rounded-xl h-full flex hover:bg-blue-600 transition-colors duration-200">
                                        <div class="flex items-center gap-4">
                                            <i
                                                class='bx bx-send text-3xl text-purple-400 group-hover:text-white transition-colors'></i>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">Blast History</h4>
                                                <p class="text-sm text-gray-300 group-hover:text-white/80 mt-0.5">
                                                    Broadcast audit logs</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            const groupData = {
                all: { title: 'Reports Hub', desc: 'Access centralized data, real-time analytics, and operational performance metrics across all channels.' },
                calls: { title: 'Call Center Analytics', desc: 'In-depth monitoring for inbound and outbound PBX transactions and agent productivity.' },
                tickets: { title: 'Support & Ticketing', desc: 'Comprehensive recap of ticket lifecycles, team performance, and resolution benchmarks.' },
                wallboards: { title: 'Monitoring Wallboards', desc: 'Real-time visual monitoring for operation centers, leadership, and agent hubs.' },
                omni: { title: 'Omnichannel & Blast', desc: 'Statistics for integrated chat channels and mass communication history.' }
            };

            let currentCategory = 'all';

            function switchRepo(slug) {
                currentCategory = slug;

                // Nav buttons
                document.querySelectorAll('.menu-item').forEach(b => b.classList.remove('active'));
                document.getElementById(`nav-${slug}`).classList.add('active');

                // Header text
                document.getElementById('repo-title').textContent = groupData[slug].title;
                document.getElementById('repo-desc').textContent = groupData[slug].desc;

                // Scroll to top
                document.getElementById('scroll-area').scrollTo({ top: 0, behavior: 'smooth' });

                // Refilter
                filterReports();
            }

            function filterReports() {
                const query = document.getElementById('report-search').value.toLowerCase();

                document.querySelectorAll('.repo-section').forEach(sec => {
                    const sectionId = sec.id.replace('group-', '');
                    const isCorrectCategory = currentCategory === 'all' || sectionId === currentCategory;

                    let hasVisibleCards = false;
                    const cards = sec.querySelectorAll('.card-repo');

                    cards.forEach(card => {
                        const name = card.getAttribute('data-name').toLowerCase();
                        const matchesSearch = name.includes(query);

                        if (isCorrectCategory && matchesSearch) {
                            card.style.display = 'block';
                            hasVisibleCards = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (hasVisibleCards) {
                        sec.style.display = 'block';
                    } else {
                        sec.style.display = 'none';
                    }
                });
            }

            // Initial call
            filterReports();
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
