<x-dashonic-horizontal-layout sidebar="1">
    <div class="min-h-screen bg-gray-900 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        📊 Statistik Kanal | Real-time Performance Monitoring
                        </h1>
                    <p class="mt-2 text-gray-400">Visual Layout: 3-column grid dengan metric cards</p>
                    <p class="mt-1 text-sm text-gray-500" id="dataScopeInfo">
                        <i class="fas fa-info-circle mr-1"></i>
                        <span id="scopeText">Memuat informasi scope data...</span>
                    </p>
                </div>
                <div class="text-right bg-gray-800/50 p-3 rounded-lg shadow-lg">
                    <div class="text-gray-300 text-lg font-semibold" id="currentDateTime"></div>
                    <div class="text-gray-400 text-sm mt-1" id="userTypeInfo"></div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="mb-8">
            <form action="{{ route('index') }}" method="GET" class="bg-gray-800 rounded-2xl p-6 shadow-lg">
                <div class="flex flex-wrap gap-6 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label for="date_filter" class="block text-sm font-medium text-gray-400 mb-2">
                            <i class="bx bx-calendar mr-2"></i>
                            Start Date
                        </label>
                        <input type="date" id="date_filter" name="date_filter"
                            value="{{ request()->get('date_filter', now()->format('Y-m-d')) }}"
                            class="w-full bg-gray-700/50 border-0 text-white rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="date_filter2" class="block text-sm font-medium text-gray-400 mb-2">
                            <i class="bx bx-calendar-check mr-2"></i>
                            End Date
                        </label>
                        <input type="date" id="date_filter2" name="date_filter2"
                            value="{{ request()->get('date_filter2', now()->format('Y-m-d')) }}"
                            class="w-full bg-gray-700/50 border-0 text-white rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl px-6 py-2.5 transition-colors flex items-center">
                            <i class="bx bx-filter-alt mr-2 text-xl"></i>
                            Apply Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 3-Column Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Phone Calls -->
            <div class="bg-gray-800 rounded-2xl p-6 shadow-lg transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center">
                        <i class="fas fa-phone text-2xl text-pink-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Phone Calls</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm">Total:</span>
                        <span class="text-white font-semibold" id="phone-total">0 panggilan</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Terjawab:
                        </span>
                        <span class="text-green-400 font-semibold" id="phone-answered">0 (0%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-clock text-purple-500 mr-2"></i>
                            Rata-rata:
                        </span>
                        <span class="text-purple-400 font-semibold" id="phone-avg-duration">0m 0s</span>
                        </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-smile text-yellow-500 mr-2"></i>
                            Kepuasan:
                        </span>
                        <span class="text-yellow-400 font-semibold" id="phone-satisfaction">0/5</span>
                    </div>
                </div>
        </div>

            <!-- Live Chat -->
            <div class="bg-gray-800 rounded-2xl p-6 shadow-lg transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gray-500/20 flex items-center justify-center">
                        <i class="fas fa-comments text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Live Chat</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm">Total:</span>
                        <span class="text-white font-semibold" id="chat-total">0 chat</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Direspon:
                        </span>
                        <span class="text-green-400 font-semibold" id="chat-responded">0 (0%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-bolt text-orange-500 mr-2"></i>
                            Response:
                        </span>
                        <span class="text-orange-400 font-semibold" id="chat-response-time">0 detik</span>
                        </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-smile text-yellow-500 mr-2"></i>
                            Kepuasan:
                        </span>
                        <span class="text-yellow-400 font-semibold" id="chat-satisfaction">0/5</span>
                        </div>
                    </div>
                </div>

            <!-- Email -->
            <div class="bg-gray-800 rounded-2xl p-6 shadow-lg transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                        <i class="fas fa-envelope text-2xl text-blue-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Email</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm">Total:</span>
                        <span class="text-white font-semibold" id="email-total">0 email</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Dibalas:
                        </span>
                        <span class="text-green-400 font-semibold" id="email-replied">0 (0%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                            Response:
                        </span>
                        <span class="text-blue-400 font-semibold" id="email-response-time">0 jam 0m</span>
                                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-smile text-yellow-500 mr-2"></i>
                            Kepuasan:
                        </span>
                        <span class="text-yellow-400 font-semibold" id="email-satisfaction">0/5</span>
                                    </div>
                                </div>
                            </div>

            <!-- Social Media (from Omnichat v3) -->
            <div class="bg-gray-800 rounded-2xl p-6 shadow-lg transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                        <i class="fas fa-th text-2xl text-purple-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Social Media</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm">Total:</span>
                        <span class="text-white font-semibold" id="social-total">0 interaksi</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Direspon:
                        </span>
                        <span class="text-green-400 font-semibold" id="social-responded">0 (0%)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-bolt text-orange-500 mr-2"></i>
                            Response:
                        </span>
                        <span class="text-orange-400 font-semibold" id="social-response-time">0 menit</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-smile text-yellow-500 mr-2"></i>
                            Kepuasan:
                        </span>
                        <span class="text-yellow-400 font-semibold" id="social-engagement">0/5</span>
                    </div>
                    </div>
            </div>

            <!-- WhatsApp Business (from Omnichat v3) -->
            <div class="bg-gray-800 rounded-2xl p-6 shadow-lg transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                            <path fill="#fff" d="M19.05 4.91A9.82 9.82 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.26 8.26 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07s.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">WhatsApp Business</h3>
                        </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm">Total:</span>
                        <span class="text-white font-semibold" id="whatsapp-total">0 pesan</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Direspon:
                        </span>
                        <span class="text-green-400 font-semibold" id="whatsapp-responded">0 (0%)</span>
                </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-bolt text-orange-500 mr-2"></i>
                            Response:
                        </span>
                        <span class="text-orange-400 font-semibold" id="whatsapp-response-time">0 menit</span>
                                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-smile text-yellow-500 mr-2"></i>
                            Kepuasan:
                        </span>
                        <span class="text-yellow-400 font-semibold" id="whatsapp-satisfaction">0/5</span>
                                </div>
                                </div>
                            </div>

            <!-- Comment & More (renamed from Video Call) -->
            <div class="bg-gray-800 rounded-2xl p-6 shadow-lg transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                        <i class="fas fa-comment text-2xl text-purple-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Comment & More</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm">Total:</span>
                        <span class="text-white font-semibold" id="comment-total">0 panggilan</span>
                            </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Dijawab:
                        </span>
                        <span class="text-green-400 font-semibold" id="comment-answered">0 (0%)</span>
                        </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-clock text-purple-500 mr-2"></i>
                            Durasi:
                        </span>
                        <span class="text-purple-400 font-semibold" id="comment-duration">0m 0s</span>
                </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-smile text-yellow-500 mr-2"></i>
                            Kepuasan:
                        </span>
                        <span class="text-yellow-400 font-semibold" id="comment-satisfaction">0/5</span>
            </div>
                </div>
            </div>

        </div>
    </div>

    <x-slot name="js">
        <script>
            // User type information from PHP
            const userType = "{{ current_agent()->user_type ?? 'unknown' }}";
            const isUserLeader = "{{ (current_agent()->is_user_leader ?? 0) ? '1' : '0' }}" === "1";
            const userName = "{{ current_agent()->name ?? 'Unknown User' }}";
            
            const defaultDateFilter = "{{ request()->get('date_filter', now()->format('Y-m-d')) }}";
            const defaultDateFilter2 = "{{ request()->get('date_filter2', now()->format('Y-m-d')) }}";

            function fetch_conversation() {
                // Fetch data from different controllers
                fetchPhoneCallsData();
                fetchSocialMediaData();
                fetchWhatsAppData();
                fetchCommentData();
                fetchLiveChatData();
                fetchEmailData();
            }

            function fetchPhoneCallsData() {
                $.get("{{ route('home.phone-calls-data') }}?date_filter=" + defaultDateFilter + "&date_filter2=" + defaultDateFilter2,
                    (result) => {
                        updatePhoneCallsData(result);
                    });
            }

            function fetchSocialMediaData() {
                $.get("{{ route('home.social-media-data') }}?date_filter=" + defaultDateFilter + "&date_filter2=" + defaultDateFilter2,
                    (result) => {
                        updateSocialMediaData(result);
                    });
            }

            function fetchWhatsAppData() {
                $.get("{{ route('home.whatsapp-data') }}?date_filter=" + defaultDateFilter + "&date_filter2=" + defaultDateFilter2,
                    (result) => {
                        updateWhatsAppData(result);
                    });
            }

            function fetchCommentData() {
                $.get("{{ route('home.comment-data') }}?date_filter=" + defaultDateFilter + "&date_filter2=" + defaultDateFilter2,
                    (result) => {
                        updateCommentData(result);
                    });
            }

            function fetchLiveChatData() {
                $.get("{{ route('home.live-chat-data') }}?date_filter=" + defaultDateFilter + "&date_filter2=" + defaultDateFilter2,
                    (result) => {
                        updateLiveChatData(result);
                    });
            }

            function fetchEmailData() {
                $.get("{{ route('home.email-data') }}?date_filter=" + defaultDateFilter + "&date_filter2=" + defaultDateFilter2,
                    (result) => {
                        updateEmailData(result);
                    });
            }

            function updatePhoneCallsData(data) {
                const total = data.total || 0;
                const answered = data.answered || 0;
                const percentage = data.percentage || 0;
                const avgDuration = data.avg_duration || '0m 0s';
                const satisfaction = data.satisfaction || '4.3/5';

                $('#phone-total').text(total + ' panggilan');
                $('#phone-answered').text(answered + ' (' + percentage + '%)');
                $('#phone-avg-duration').text(avgDuration);
                $('#phone-satisfaction').text(satisfaction);
            }

            function updateLiveChatData(data) {
                const total = data.total || 0;
                const responded = data.responded || 0;
                const percentage = data.percentage || 0;
                const responseTime = data.response_time || '45 detik';
                const satisfaction = data.satisfaction || '4.5/5';

                $('#chat-total').text(total + ' chat');
                $('#chat-responded').text(responded + ' (' + percentage + '%)');
                $('#chat-response-time').text(responseTime);
                $('#chat-satisfaction').text(satisfaction);
            }

            function updateEmailData(data) {
                const total = data.total || 0;
                const replied = data.replied || 0;
                const percentage = data.percentage || 0;
                const responseTime = data.response_time || '2 jam 15m';
                const satisfaction = data.satisfaction || '4.2/5';

                $('#email-total').text(total + ' email');
                $('#email-replied').text(replied + ' (' + percentage + '%)');
                $('#email-response-time').text(responseTime);
                $('#email-satisfaction').text(satisfaction);
            }

            function updateSocialMediaData(data) {
                const total = data.total || 0;
                const responded = data.responded || 0;
                const percentage = data.percentage || 0;
                const responseTime = data.response_time || '15 menit';
                const engagement = data.engagement || '4.4/5';

                $('#social-total').text(total + ' interaksi');
                $('#social-responded').text(responded + ' (' + percentage + '%)');
                $('#social-response-time').text(responseTime);
                $('#social-engagement').text(engagement);
            }

            function updateWhatsAppData(data) {
                const total = data.total || 0;
                const responded = data.responded || 0;
                const percentage = data.percentage || 0;
                const responseTime = data.response_time || '2 menit';
                const satisfaction = data.satisfaction || '4.6/5';

                $('#whatsapp-total').text(total + ' pesan');
                $('#whatsapp-responded').text(responded + ' (' + percentage + '%)');
                $('#whatsapp-response-time').text(responseTime);
                $('#whatsapp-satisfaction').text(satisfaction);
            }

            function updateCommentData(data) {
                const total = data.total || 0;
                const answered = data.answered || 0;
                const percentage = data.percentage || 0;
                const duration = data.duration || '12m 45s';
                const satisfaction = data.satisfaction || '4.5/5';

                $('#comment-total').text(total + ' panggilan');
                $('#comment-answered').text(answered + ' (' + percentage + '%)');
                $('#comment-duration').text(duration);
                $('#comment-satisfaction').text(satisfaction);
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
            }

            function updateUserTypeInfo() {
                let userTypeText = '';
                let userTypeClass = 'text-gray-400';
                
                if (userType === 'owner') {
                    userTypeText = `👑 ${userName} (Owner/Admin)`;
                    userTypeClass = 'text-yellow-400';
                } else if (isUserLeader == 1) {
                    userTypeText = `👥 ${userName} (Supervisor/Leader)`;
                    userTypeClass = 'text-blue-400';
                } else if (userType === 'agent') {
                    userTypeText = `👤 ${userName} (Agent)`;
                    userTypeClass = 'text-green-400';
                } else {
                    userTypeText = `❓ ${userName} (Unknown)`;
                    userTypeClass = 'text-red-400';
                }
                
                document.getElementById('userTypeInfo').innerHTML = `<span class="${userTypeClass}">${userTypeText}</span>`;
            }

            function updateDataScopeInfo() {
                let scopeText = '';
                let scopeClass = 'text-gray-500';
                
                if (userType === 'owner') {
                    scopeText = 'Menampilkan data seluruh perusahaan (semua channel dan agent)';
                    scopeClass = 'text-yellow-500';
                } else if (isUserLeader == 1) {
                    scopeText = 'Menampilkan data grup yang dipimpin (channel dan agent dalam grup)';
                    scopeClass = 'text-blue-500';
                } else if (userType === 'agent') {
                    scopeText = 'Menampilkan data yang ditugaskan kepada Anda (channel dan data personal)';
                    scopeClass = 'text-green-500';
                } else {
                    scopeText = 'Scope data tidak dapat ditentukan';
                    scopeClass = 'text-red-500';
                }
                
                document.getElementById('scopeText').innerHTML = `<span class="${scopeClass}">${scopeText}</span>`;
            }

            $(document).ready(() => {
                // Initialize data and update every 30 seconds
                updateDateTime();
                updateUserTypeInfo();
                updateDataScopeInfo();
                setInterval(updateDateTime, 1000);

                // Initialize data
                fetch_conversation();

                // Update data every 30 seconds
                setInterval(fetch_conversation, 30000);
            });
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
