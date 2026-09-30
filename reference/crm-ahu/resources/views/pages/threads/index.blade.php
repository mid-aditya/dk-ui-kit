{{-- resources/views/pages/threads/index.blade.php --}}
<x-dashonic-horizontal-layout sidebar="1"
    with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
    with-header="{{ request()->get('with-header') ?? 0 }}"
    with-footer="{{ request()->get('with-footer') ?? 0 }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="min-h-screen bg-gray-900 p-6">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <i class="bx bxs-dashboard text-blue-500 mr-3 text-4xl"></i>
                        My Threads
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

        {{-- Status Cards (Inbound / Chat / Email) --}}
        {{-- <div class="mb-6">
            <div id="status-cards" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if(isset($statusCards))
                    @foreach($statusCards as $card)
                        <div class="bg-gray-800 rounded-2xl p-6 transform hover:scale-[1.02] transition-all duration-300 shadow-lg cursor-pointer status-card"
                             data-flag="{{ $card->name === 'Inbound' ? 0 : ($card->name === 'Chat' ? 1 : 2) }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center
                                        @if($card->name === 'Inbound') bg-gradient-to-br from-green-500/20 to-green-600/20
                                        @elseif($card->name === 'Chat') bg-gradient-to-br from-blue-500/20 to-blue-600/20
                                        @else bg-gradient-to-br from-purple-500/20 to-purple-600/20 @endif">
                                        @if($card->name === 'Inbound')
                                            <i class="bx bxs-phone-incoming text-2xl text-green-500"></i>
                                        @elseif($card->name === 'Chat')
                                            <i class="bx bxs-message-rounded text-2xl text-blue-500"></i>
                                        @else
                                            <i class="bx bxs-envelope text-2xl text-purple-500"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-white">{{ $card->count }}</h3>
                                        <p class="text-gray-400 text-sm">{{ $card->name }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-gray-700/30 text-gray-400 text-xs font-medium">Total</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div> --}}

        {{-- Filters --}}
        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Filters</h3>
                <div class="flex gap-2">
                    <button id="clear-filter-btn" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition">Clear/Refresh</button>
                    <button id="search-filter-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition">Search</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Data Number - akan memenuhi 1 kolom (pada md+ menjadi 1/3 lebar) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-400">Search</label>
                    <input type="text" id="filter-genesis" placeholder="Search Phone, User or Agent..." class="mt-1 block w-full p-3 bg-gray-700/50 text-gray-300 rounded-lg border border-gray-600 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Date Range - tetap menempati 1 kolom penuh (pada md+ menjadi kolom ketiga) -->
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-400">Date Range</label>
                    <div class="flex gap-2 mt-1">
                        <input type="date" id="filter-start-date" class="p-3 bg-gray-700/50 text-gray-300 rounded-lg border border-gray-600 text-sm flex-1">
                        <span class="text-gray-400 self-center">to</span>
                        <input type="date" id="filter-end-date" class="p-3 bg-gray-700/50 text-gray-300 rounded-lg border border-gray-600 text-sm flex-1">
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center">
                        <i class="bx bxs-conversation text-xl text-blue-500"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Thread List</h2>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-400">
                    <span>Show</span>
                    <select id="entries-select" class="bg-gray-700/50 text-gray-300 rounded-lg border border-gray-600 px-3 py-1">
                        @foreach([5,10,15,30] as $n)
                            <option value="{{ $n }}" {{ request('entries',10)==$n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                    <span>entries</span>
                    <span class="ml-4">
                        Showing <span id="from-entry">0</span> to <span id="to-entry">0</span> of <span id="total-entries">0</span> entries
                    </span>
                </div>
            </div>

            <div class="relative">
                <div id="loading-spinner" class="absolute inset-0 bg-gray-800/70 flex items-center justify-center z-10 hidden">
                    <div class="loader"></div>
                </div>

                <table class="w-full border-0 text-sm text-left text-white border border-gray-700 rounded-xl overflow-auto">
                    <thead class="bg-gray-700 text-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-center">Phone</th>
                            <th class="px-4 py-3 text-center">User</th>
                            <th class="px-4 py-3 text-center">Agent</th>
                            {{-- <th class="px-4 py-3 text-center">Channel</th> --}}
                            <th class="px-4 py-3 text-center">Created At</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="thread-body">
                        {{-- Data diisi oleh JS --}}
                    </tbody>
                </table>
            </div>

            <div id="pagination-links" class="mt-6"></div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            // Clock
            const updateClock = () => {
                const now = new Date();
                const date = now.toLocaleDateString('id-ID', {weekday:'long', day:'numeric', month:'long', year:'numeric'});
                const time = now.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:false});
                document.getElementById('currentDateTime').innerHTML = `<div class="text-xl">${date}</div><div class="text-2xl font-bold">${time}</div>`;
            };
            updateClock(); setInterval(updateClock, 1000);

            document.addEventListener('DOMContentLoaded', () => {
                const tbody = document.getElementById('thread-body');
                const paginationDiv = document.getElementById('pagination-links');
                const spinner = document.getElementById('loading-spinner');
                const entriesSelect = document.getElementById('entries-select');

                const filterGenesis = document.getElementById('filter-genesis');
                // const filterFlag = document.getElementById('filter-flag');
                const filterStart = document.getElementById('filter-start-date');
                const filterEnd = document.getElementById('filter-end-date');

                const baseUrl = "{{ route('threads.index') }}";

                const getChannelBadge = (flag) => {
                    const map = {
                        0: {text: 'Inbound', color: 'bg-green-600/20 text-green-400'},
                        1: {text: 'Chat',    color: 'bg-blue-600/20 text-blue-400'},
                        2: {text: 'Email',   color: 'bg-purple-600/20 text-purple-400'}
                    };
                    const d = map[flag] || {text: 'Unknown', color: 'bg-gray-600/20 text-gray-400'};
                    return `<span class="px-3 py-1 rounded-full text-xs font-medium ${d.color}">${d.text}</span>`;
                };

                const initDropdowns = () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Tutup semua dropdown saat klik di luar
                    document.addEventListener('click', (e) => {
                        if (!e.target.closest('.action-dropdown-toggle') && !e.target.closest('.action-dropdown-menu')) {
                            document.querySelectorAll('.action-dropdown-menu').forEach(menu => {
                                menu.classList.add('hidden');
                            });
                        }
                    });

                    // Toggle dropdown
                    document.querySelectorAll('.action-dropdown-toggle').forEach(toggle => {
                        toggle.onclick = (e) => {
                            e.preventDefault();
                            e.stopPropagation();

                            const menu = toggle.nextElementSibling;

                            // Tutup semua menu lain
                            document.querySelectorAll('.action-dropdown-menu').forEach(m => {
                                if (m !== menu) m.classList.add('hidden');
                            });

                            // Toggle menu ini
                            menu.classList.toggle('hidden');
                        };
                    });

                    // Follow Up → buka ticketing (sama seperti detail sebelumnya)
                    document.querySelectorAll('.menu-follow-up').forEach(btn => {
                        btn.onclick = (e) => {
                            e.preventDefault();
                            const threadId = btn.dataset.id;
                            const phone = btn.dataset.phone;

                            if (threadId && phone) {
                                window.location.href = `/ticketing?phone=${encodeURIComponent(phone)}&threadid=${encodeURIComponent(threadId)}`;
                            }
                        };
                    });

                    // Ignore Thread
                    document.querySelectorAll('.menu-ignore').forEach(btn => {
                        btn.onclick = async (e) => {
                            e.preventDefault();
                            const threadId = btn.dataset.id;

                            if (!confirm('Apakah Anda yakin ingin mengabaikan thread ini?')) return;

                            try {
                                const res = await fetch(`/threads/${threadId}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: threadId
                                    })
                                });

                                if (res.ok) {
                                    alert('Thread berhasil di-ignore.');
                                    fetchThreads(); // refresh table
                                } else {
                                    alert('Gagal meng-ignore thread.');
                                }
                            } catch (err) {
                                console.error(err);
                                alert('Terjadi kesalahan.');
                            }
                        };
                    });

                    // Prank Call
                    document.querySelectorAll('.menu-prank').forEach(btn => {
                        btn.onclick = async (e) => {
                            e.preventDefault();
                            const threadId = btn.dataset.id;

                            if (!confirm('Tandai thread ini sebagai Prank Call?')) return;

                            try {
                                const res = await fetch(`/threads/prankcall/${threadId}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: threadId
                                    })
                                });

                                if (res.ok) {
                                    alert('Thread ditandai sebagai Prank Call.');
                                    fetchThreads(); // refresh table
                                } else {
                                    alert('Gagal menandai prank call.');
                                }
                            } catch (err) {
                                console.error(err);
                                alert('Terjadi kesalahan.');
                            }
                        };
                    });
                };

                const fetchThreads = async (page = 1) => {
                    spinner.classList.remove('hidden');

                    const params = new URLSearchParams({
                        page,
                        entries: entriesSelect.value,
                        search: filterGenesis.value,
                        // flag: filterFlag.value,
                        start_date: filterStart.value,
                        end_date: filterEnd.value
                    });

                    try {
                        const res = await fetch(`${baseUrl}?${params}`, {
                            headers: {'X-Requested-With': 'XMLHttpRequest'}
                        });
                        const json = await res.json();

                        // Render Table
                        if (!json.data.length) {
                            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-12 text-gray-400">No threads found.</td></tr>`;
                        } else {
                            tbody.innerHTML = json.data.map((t, i) => {
                                const no = (json.pagination.current_page - 1) * json.pagination.per_page + i + 1;
                                const bg = i % 2 === 0 ? 'bg-gray-800/30' : '';
                                return `
                                    <tr class="${bg} hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 text-center">${no}</td>
                                        <td class="px-4 py-3 text-center font-mono text-blue-300">${t.phone || '-'}</td>
                                        <td class="px-4 py-3 text-center">${t.ticket_user?.name || '-'}</td>
                                        <td class="px-4 py-3 text-center">${t.user_agent.user.name || '-'}</td>
                                        <td class="px-4 py-3 text-center">${t.created_at_formatted || '-'}</td>
                                        <td class="px-4 py-3 text-center relative">
                                            <button type="button" class="action-dropdown-toggle p-2 rounded-lg hover:bg-gray-600/50 text-gray-400 hover:text-white transition">
                                                <i class="bx bx-dots-vertical-rounded text-xl"></i>
                                            </button>

                                            <div class="action-dropdown-menu hidden absolute right-0 mt-2 w-56 bg-gray-800 rounded-xl shadow-2xl border border-gray-700 z-50 overflow-hidden">
                                                <!-- Follow Up (sama seperti detail) -->
                                                <a href="#"
                                                class="menu-follow-up flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition"
                                                data-id="${t.id}"
                                                data-phone="${t.phone || ''}">
                                                    <i class="fas fa-headset text-green-400"></i>
                                                    Follow Up
                                                </a>

                                                <!-- Ignore -->
                                                <button type="button"
                                                        class="menu-ignore w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition text-left"
                                                        data-id="${t.id}">
                                                    <i class="fas fa-ban text-yellow-400"></i>
                                                    Ignore
                                                </button>

                                                <!-- Prank Call -->
                                                <button type="button"
                                                        class="menu-prank w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:bg-red-900/50 hover:text-red-400 transition text-left border-t border-gray-700"
                                                        data-id="${t.id}">
                                                    <i class="fas fa-phone-slash text-red-400"></i>
                                                    Prank Call
                                                </button>
                                            </div>
                                        </td>
                                    </tr>`;
                            }).join('');
                        }
                        initDropdowns();

                        // Update info
                        const from = (json.pagination.current_page - 1) * json.pagination.per_page + 1;
                        const to = Math.min(json.pagination.current_page * json.pagination.per_page, json.pagination.total);
                        document.getElementById('from-entry').textContent = from;
                        document.getElementById('to-entry').textContent = to;
                        document.getElementById('total-entries').textContent = json.pagination.total;

                        // Render Pagination
                        if (json.pagination.last_page <= 1) {
                            paginationDiv.innerHTML = '';
                        } else {
                            let html = `<div class="flex justify-between items-center text-white">`;
                            html += json.pagination.current_page > 1
                                ? `<a href="#" data-page="${json.pagination.current_page-1}" class="pagination-link px-4 py-2 bg-gray-700 rounded hover:bg-gray-600">Previous</a>`
                                : `<span class="px-4 py-2 bg-gray-700 rounded text-gray-500">Previous</span>`;

                            html += `<div class="flex gap-2">`;
                            for (let i = 1; i <= json.pagination.last_page; i++) {
                                const active = i === json.pagination.current_page ? 'bg-blue-600 font-bold' : 'bg-gray-700 hover:bg-gray-600';
                                html += `<a href="#" data-page="${i}" class="pagination-link px-3 py-1 rounded ${active}">${i}</a>`;
                            }
                            html += `</div>`;

                            html += json.pagination.current_page < json.pagination.last_page
                                ? `<a href="#" data-page="${json.pagination.current_page+1}" class="pagination-link px-4 py-2 bg-gray-700 rounded hover:bg-gray-600">Next</a>`
                                : `<span class="px-4 py-2 bg-gray-700 rounded text-gray-500">Next</span>`;
                            html += `</div>`;

                            paginationDiv.innerHTML = html;
                            document.querySelectorAll('.pagination-link').forEach(link => {
                                link.onclick = e => { e.preventDefault(); fetchThreads(link.dataset.page); };
                            });
                        }

                        // Update Status Cards (jika ada status_counts)
                        // if (json.status_counts) {
                        //     document.querySelectorAll('.status-card').forEach(card => {
                        //         const flag = card.dataset.flag;
                        //         const count = json.status_counts[Object.keys(json.status_counts).find(k =>
                        //             (k === 'Inbound' && flag == 0) ||
                        //             (k === 'Chat' && flag == 1) ||
                        //             (k === 'Email' && flag == 2)
                        //         )] || 0;
                        //         card.querySelector('h3').textContent = count;
                        //     });
                        // }

                    } catch (e) {
                        console.error(e);
                        tbody.innerHTML = `<tr><td colspan="7" class="text-center py-12 text-red-400">Error loading data</td></tr>`;
                    } finally {
                        spinner.classList.add('hidden');
                    }
                };

                // Events
                document.getElementById('search-filter-btn').onclick = () => fetchThreads(1);
                document.getElementById('clear-filter-btn').onclick = () => {
                    filterGenesis.value = filterStart.value = filterEnd.value = '';
                    fetchThreads(1);
                };
                entriesSelect.onchange = () => fetchThreads(1);

                // Optional: detail button
                document.addEventListener('click', e => {
                    const btn = e.target.closest('.detail-btn');
                    if (!btn) return;

                    const threadId = btn.dataset.id;
                    const phone    = btn.dataset.phone;

                    if (!threadId || !phone) {
                        console.warn('threadid atau phone tidak ditemukan');
                        return;
                    }

                    window.location.href = `/ticketing?phone=${encodeURIComponent(phone)}&threadid=${encodeURIComponent(threadId)}`;
                });


                // // Status card click → filter otomatis
                // document.querySelectorAll('.status-card').forEach(card => {
                //     card.onclick = () => {
                //         filterFlag.value = card.dataset.flag;
                //         fetchThreads(1);
                //     };
                // });

                // Load pertama
                fetchThreads();
            });
        </script>
    </x-slot>

    <style>
        .loader { border-radius:50%; width:2.5em; height:2.5em; border:0.4em solid #1d4ed8; border-right-color:transparent; animation:spin 1s linear infinite; }
        @keyframes spin { to { transform:rotate(360deg); } }
    </style>
</x-dashonic-horizontal-layout>
