<x-dashonic-horizontal-layout sidebar="0">


    <style>
        .timeline-container::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 3px;
            background: #3b82f6;
            transform: translateY(-50%);
            z-index: 1;
        }

        .timeline-item {
            position: relative;
            min-width: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 2;
        }

        .timeline-icon {
            margin-top: 10px;
            margin-bottom: 100px;
            background: #1f2937;
            border: 2px solid #374151;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .timeline-icon:hover {
            border-color: #3b82f6;
            transform: scale(1.05);
        }

        .layer-transition {
            font-size: 9px;
            color: #9ca3af;
        }

        /* SweetAlert email modal theme */
        .swal2-popup.email-body-modal {
            background: #1f2937 !important;
            color: #f9fafb !important;
            width: min(1400px, 96vw) !important;
            max-width: min(1400px, 96vw) !important;
        }

        .swal2-popup.email-body-modal .swal2-title {
            color: #f9fafb !important;
        }

        .swal2-popup.email-body-modal hr {
            border-color: #374151 !important;
        }

        .swal2-popup.email-body-modal .swal2-html-container {
            margin-top: 0.75rem !important;
            overflow: hidden !important;
        }

        .email-body-content {
            max-height: 70vh;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .email-body-text {
            white-space: pre-wrap;
            line-height: 1.6;
            word-break: break-word;
        }

        .email-loading-state {
            min-height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* SweetAlert preview follow-up modal theme */
        .swal2-popup.preview-followup-modal {
            background: #374151 !important;
            color: #f9fafb !important;
        }

        .swal2-popup.preview-followup-modal .swal2-title {
            color: #f9fafb !important;
        }

        /* Bigger modal for combined details */
        .modal-xxl {
            max-width: 1400px;
            width: 95%;
        }
    </style>

    <!-- Container utama untuk menjaga layout tetap terpusat dan responsif -->
    <div class="container mx-auto px-2 sm:px-4 md:px-6">
        <div class="min-h-screen bg-gray-900 py-4 md:py-6 max-w-full">
            <!-- Header Section -->
            <div class="mb-4 sm:mb-6 md:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white flex items-center">
                            <i class="bx bxs-dashboard text-blue-500 mr-2 sm:mr-3 text-2xl sm:text-3xl md:text-4xl"></i>
                            <span class="truncate">Result Ticket Dashboard</span>
                        </h1>
                        <p class="mt-1 sm:mt-2 text-gray-400 flex items-center text-sm sm:text-base">
                            <i class="fas fa-user-circle mr-1 sm:mr-2"></i>
                            <span class="truncate">Welcome back, {{ auth()->user()->name }}</span>
                        </p>
                    </div>
                    <div class="text-center sm:text-right bg-gray-800/50 p-2 sm:p-3 rounded-lg shadow-lg min-w-0">
                        <div class="text-gray-300 text-sm sm:text-base md:text-lg font-semibold whitespace-nowrap"
                            id="currentDateTime"></div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div onclick="goToTicketSLA('near')"
                    class="{{ request('card_all_date') && request('sla_filter') === 'near' ? 'bg-lime-500/15' : 'bg-gray-800' }} rounded-xl p-6 shadow-lg flex items-center justify-between cursor-pointer hover:bg-gray-750 transition-all duration-300 transform hover:scale-105">
                    <div>
                        {{-- <h3 class="text-3xl font-bold text-white" id="TicketNearSLA">0</h3> --}}
                        <h3 class="text-3xl font-bold text-white" id="TicketNearSLA">{{ $nearSlaCount ?? 0 }}</h3>
                        <p class="text-gray-400 text-base mt-1">Tiket Near SLA</p>
                        <p class="text-yellow-400 text-sm mt-3 font-medium">Mendekati batas waktu SLA</p>
                        <p class="text-yellow-300 text-xs mt-1">
                            Near SLA: H-{{ $nearSlaOffset ?? 1 }} hari
                        </p>
                    </div>
                    <div class="w-20 h-20 bg-yellow-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-white text-3xl"></i>
                    </div>
                </div>

                <div onclick="goToTicketReply(1)"
                    class="{{ request('card_all_date') && request('active_layer3') == 1 ? 'bg-lime-500/15' : 'bg-gray-800' }} rounded-xl p-6 shadow-lg flex items-center justify-between cursor-pointer hover:bg-gray-750 transition-all duration-300 transform hover:scale-105">
                    <div>
                        {{-- <h3 class="text-3xl font-bold text-white" id="TicketNearSLA">0</h3> --}}
                        <h3 class="text-3xl font-bold text-white" id="TicketNearSLA">{{ $activeLayer3Count ?? 0 }}</h3>
                        <p class="text-gray-400 text-base mt-1">Tiket Reply Layer 2</p>
                        <p class="text-green-400 text-sm mt-3 font-medium">Ticket yang sudah ada aktifitas di layer 2
                        </p>
                    </div>
                    <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-clock text-white text-3xl"></i>
                    </div>
                </div>

                <div onclick="goToTicketStatus('OVER-SLA')"
                    class="{{ request('card_all_date') && request('sla_filter') === 'over' ? 'bg-lime-500/15' : 'bg-gray-800' }} rounded-xl p-6 shadow-lg flex items-center justify-between cursor-pointer hover:bg-gray-750 transition-all duration-300 transform hover:scale-105">
                    <div>
                        {{-- <h3 class="text-3xl font-bold text-white" id="TicketOverSLA">0</h3> --}}
                        <h3 class="text-3xl font-bold text-white" id="TicketOverSLA">{{ $overSlaCount ?? 0 }}</h3>
                        <p class="text-gray-400 text-base mt-1">Tiket Over SLA</p>
                        <p class="text-red-400 text-sm mt-3 font-medium">Melewati batas waktu SLA</p>
                    </div>
                    <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-exclamation-triangle text-white text-3xl"></i>
                    </div>
                </div>

                <div onclick="goToTicketStatus('RE-OPEN')"
                    class="{{ request('card_all_date') && request('status') === 'RE-OPEN' ? 'bg-lime-500/15' : 'bg-gray-800' }} rounded-xl p-6 shadow-lg flex items-center justify-between cursor-pointer hover:bg-gray-750 transition-all duration-300 transform hover:scale-105">
                    <div>
                        <h3 class="text-3xl font-bold text-white" id="TicketReopen">{{ $reopenCount ?? 0 }}</h3>
                        <p class="text-gray-400 text-base mt-1">Tiket Re-Open</p>
                        <p class="text-purple-400 text-sm mt-3 font-medium">Ticket yang sudah di re-open</p>
                    </div>
                    <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-redo text-white text-3xl"></i>
                    </div>
                </div>

                <div onclick="goToTicketStatus('RE-EXTEND')"
                    class="{{ request('card_all_date') && request('status') === 'RE-EXTEND' ? 'bg-lime-500/15' : 'bg-gray-800' }} rounded-xl p-6 shadow-lg flex items-center justify-between cursor-pointer hover:bg-gray-750 transition-all duration-300 transform hover:scale-105">
                    <div>
                        <h3 class="text-3xl font-bold text-white" id="TicketReextend">{{ $reextendCount ?? 0 }}</h3>
                        <p class="text-gray-400 text-base mt-1">Tiket Re-Extend</p>
                        <p class="text-orange-400 text-sm mt-3 font-medium">Ticket yang sudah di re-extend</p>
                    </div>
                    <div class="w-20 h-20 bg-orange-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-sync-alt text-white text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="bg-gray-800 rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 shadow-lg">
                <!-- Filter Section -->
                <div class="mb-4 sm:mb-6">
                    <h3 class="text-lg sm:text-xl font-semibold text-white mb-3 sm:mb-4 flex items-center">
                        <i class="bx bx-filter-alt text-blue-500 mr-2"></i>
                        Filter Data
                    </h3>
                    <form method="GET" action="{{ route('chat.v3.ticket.result.index') }}" id="filterForm">
                        @if (request('all_agent'))
                            <input type="hidden" name="all_agent" value="1">
                        @endif
                        <input type="hidden" name="sla_filter" id="slaFilterInput" value="{{ request('sla_filter') }}">
                        <input type="hidden" name="active_layer3" id="activelayerFilterInput"
                            value="{{ request('active_layer3') }}">
                        <input type="hidden" name="card_all_date" id="cardAllDateInput"
                            value="{{ request('card_all_date') }}">
                        <input type="hidden" name="apply_date_with_ai_apa" id="applyDateWithAiApaInput"
                            value="{{ request('apply_date_with_ai_apa', 0) }}">

                        <!-- Filter Utama: Kategori dan Subkategori -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Kategori @if ($requireCategorySelection)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <select
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    name="category_id" id="categorySelect"
                                    @if ($requireCategorySelection) required @endif>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Subkategori @if ($requireCategorySelection)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <select
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    name="subcategory_id" id="subcategorySelect"
                                    @if ($requireCategorySelection) required @endif>
                                    <option value="">Pilih Subkategori</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}"
                                            {{ request('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                            {{ $subcategory->nama_jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                    <i class="bx bx-search mr-2"></i>
                                    Tampilkan Data
                                </button>
                            </div>
                        </div>

                        @if (!$requireCategorySelection)
                            <div class="mb-4">
                                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                                    <div class="flex items-center">
                                        <i class="bx bx-info-circle text-green-500 mr-2"></i>
                                        <p class="text-green-800 text-sm">
                                            <strong>Mode Single Form:</strong> Data akan ditampilkan tanpa perlu memilih
                                            kategori dan subkategori terlebih dahulu. Filter kategori dan subkategori
                                            bersifat opsional.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                                    <div class="flex items-center">
                                        <i class="bx bx-info-circle text-blue-500 mr-2"></i>
                                        <p class="text-blue-800 text-sm">
                                            <strong>Mode Multiple Form:</strong> Anda harus memilih kategori dan
                                            subkategori
                                            terlebih dahulu untuk menampilkan data.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Filter Tambahan -->
                        @if (!$requireCategorySelection || (request('category_id') && request('subcategory_id')))
                            <div class="border-t border-gray-600 pt-3 sm:pt-4">
                                <h4 class="text-base sm:text-lg font-medium text-white mb-3 sm:mb-4 flex items-center">
                                    <i class="bx bx-slider-alt text-blue-500 mr-2"></i>
                                    Filter Tambahan
                                </h4>
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-3 sm:gap-4 mb-4">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                                        <input type="text"
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="search" value="{{ request('search') }}"
                                            placeholder="Search ticket number, payload data...">
                                        <p class="mt-1 text-xs text-gray-400">Saat search diisi, hasil akan mencari ke
                                            semua tanggal.</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Type Layanan</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="type_layanan">
                                            <option value="">Semua</option>
                                            @foreach ($typeLayanan as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ request('type_layanan') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Direktorat</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="master_category_id" id="master_category_id">
                                            <option value="">Semua</option>
                                            @foreach ($masterCategoryOptions as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ request('master_category_id') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Category
                                            Report</label>
                                        <select id="master_category_report" name="master_category_report"
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            data-selected="{{ request('master_category_report') }}">
                                            <option value="">-- Pilih Direktorat dulu --</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Enquiry
                                            Type</label>
                                        <select id="master_enquiry_type_id" name="master_enquiry_type_id"
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            data-selected="{{ request('master_enquiry_type_id') }}">
                                            <option value="">-- Pilih Direktorat dulu --</option>
                                        </select>

                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Enquiry
                                            Detail</label>
                                        <select id="master_enquiry_detail_id" name="master_enquiry_detail_id"
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            data-selected="{{ request('master_enquiry_detail_id') }}">
                                            <option value="">-- Pilih Enquiry Type dulu --</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Problem</label>
                                        <select id="master_problem_id" name="master_problem_id"
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            data-selected="{{ request('master_problem_id') }}">
                                            <option value="">-- Pilih Enquiry Type dulu --</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Ticket
                                            Position</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="ticket_position">
                                            <option value="">Semua</option>
                                            @foreach ($ticketPositionOptions as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ request('ticket_position') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Site</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="site">
                                            <option value="">Semua</option>
                                            @php
                                                $siteOptions = ($siteMap ?? []) + ['.jakbar@ahu.go.id' => 'MPP Jakarta Barat'];
                                            @endphp
                                            @foreach ($siteOptions as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ request('site') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Sumber Interaksi</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="flaging">
                                            <option value="">Semua</option>
                                            @foreach ($flagingOptions as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ request('flaging') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Status Rekaman</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="missing_recording">
                                            <option value="">Semua</option>
                                            <option value="1" {{ request('missing_recording') == '1' ? 'selected' : '' }}>
                                                Tanpa Rekaman
                                            </option>
                                        </select>
                                        <p class="mt-1 text-xs text-gray-400">Khusus tiket Inbound Call dan WA Call.</p>
                                    </div>

                                    {{-- <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="status">
                                            <option value="">Semua</option>
                                            @foreach ($statusOptions as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ request('status') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="status">
                                            <option value="">Semua</option>

                                            <option value="OVER-SLA"
                                                {{ request('status') == 'OVER-SLA' ? 'selected' : '' }}>OVER-SLA
                                            </option>
                                            <option value="RE-OPEN"
                                                {{ request('status') == 'RE-OPEN' ? 'selected' : '' }}>RE-OPEN</option>
                                            <option value="RE-EXTEND"
                                                {{ request('status') == 'RE-EXTEND' ? 'selected' : '' }}>RE-EXTEND
                                            </option>

                                            @foreach ($statusOptions as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ request('status') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Priority</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="priority">
                                            <option value="">Semua</option>
                                            @foreach ($priorityOptions as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ request('priority') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">AI APA Filter</label>
                                        <select
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="ai_apa_filter">
                                            <option value="">Semua</option>
                                            <option value="success" {{ request('ai_apa_filter') === 'success' ? 'selected' : '' }}>
                                                Success
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- FILTER TANGGAL (DI BAWAH) -->
                                <div class="grid grid-cols-12 gap-3 sm:gap-4 mb-4">
                                    <div class="col-span-12 md:col-span-6">
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal
                                            Dari</label>
                                        <input type="date"
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="date_from" value="{{ request('date_from', now()->format('Y-m-d')) }}">
                                    </div>

                                    <div class="col-span-12 md:col-span-6">
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal
                                            Sampai</label>
                                        <input type="date"
                                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            name="date_to" value="{{ request('date_to', now()->format('Y-m-d')) }}">
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                        <i class="bx bx-search mr-2"></i>
                                        Filter
                                    </button>
                                    <a href="{{ route('chat.v3.ticket.result.index') }}"
                                        class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                        <i class="bx bx-refresh mr-2"></i>
                                        Reset
                                    </a>
                                    @php
                                        $userAgent = auth()->user()->user_agent ?? null;
                                    @endphp

                                    <!-- Tombol Export Excel -->
                                    <button type="button" onclick="exportToExcel()"
                                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                        <i class="bx bx-download mr-2"></i>
                                        Export
                                    </button>
                                    <a href="{{ route('chat.v3.ticket.result.export-history') }}" target="_blank" rel="noopener"
                                        class="bg-slate-600 hover:bg-slate-700 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                        <i class="bx bx-history mr-2"></i>
                                        History Export
                                    </a>

                                    @if ((!$userAgent || !in_array($userAgent->user_type, ['l3', 'l4'], true)) && !request('all_agent'))
                                        <a href="{{ request()->fullUrlWithQuery(['all_agent' => 1, 'date_from' => $viewAllDateFrom, 'date_to' => now()->format('Y-m-d')]) }}"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition">
                                            <i class="bx bx-group mr-2"></i>
                                            View All Ticket
                                        </a>
                                    @endif

                                    {{-- @if ($userAgent && is_null($userAgent->user_type) && request('all_agent'))
                                    <a href="{{ request()->url() }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700 transition ml-2">

                                        <i class="bx bx-user mr-2"></i>
                                        View My Ticket
                                    </a>
                                    @endif --}}
                                </div>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Data Table -->
                @if (!$requireCategorySelection || (request('category_id') && request('subcategory_id')))
                    @if ($resultTickets && $resultTickets->count() > 0)
                        <div class="bg-gray-700 rounded-xl overflow-hidden">
                            <!-- Wrapper khusus untuk horizontal scroll hanya di tabel -->
                            <div class="w-full overflow-x-auto">
                                <div class="scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-700">
                                    <table class="w-full min-w-max table-auto">
                                        <thead class="bg-gray-600">
                                            <tr>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    No</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Actions</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Ticket Number</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Agent</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Nama Entitas</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Flaging</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Status</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Priority</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Tipe Layanan</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Layanan </th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    Created At</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    SLA</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                    AI Status</th>
                                                {{-- @foreach ($payloadHeaders as $fieldName => $label)
<th
                                                                                                                                                                class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                                                                                                                                                {{ $label }}
                                                                                                                                                            </th>
@endforeach --}}
                                                
                                            </tr>
                                        </thead>
                                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                                            @foreach ($resultTickets as $index => $ticket)
                                                <tr class="hover:bg-gray-700 transition-colors duration-200">
                                                    <td
                                                        class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-300">
                                                        {{ $resultTickets->firstItem() + $index }}
                                                    </td>
                                                    <td
                                                        class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-1 sm:space-x-2">
                                                            {{-- @if (!current_agent() || !current_agent()->user_agent || !is_null(current_agent()->user_agent->user_type)) --}}
                                                                <button type="button"
                                                                    class="text-purple-600 hover:text-purple-900 transition-colors duration-200"
                                                                    onclick="openSlaManagementModal({{ $ticket->id }}, '{{ $ticket->ticket_number }}')"
                                                                    title="Manage SLA">
                                                                    <i class="bx bx-time text-base sm:text-lg"></i>
                                                                </button>
                                                                {{-- Hanya tampilkan tombol View Interaction jika genesisnumber tidak null --}}
                                                                @if ($ticket->genesisnumber)
                                                                    <button type="button"
                                                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200 js-view-payload-btn"
                                                                        data-flaging="{{ $ticket->flaging }}"
                                                                        data-genesisnumber="{{ $ticket->genesisnumber }}"
                                                                        onclick="viewPayload({{ $ticket->flaging }}, '{{ $ticket->genesisnumber }}', {{ $ticket->id }}, '{{ $ticket->ticket_number }}', '{{ optional($ticket->created_at)->toIso8601String() }}')"
                                                                        title="View Interaction">
                                                                        <i class="bx bx-show text-base sm:text-lg"></i>
                                                                    </button>
                                                                @endif
                                                                <!-- Tombol Add Detail - HANYA untuk Layer 2, 3, 4 -->
                                                                <button type="button"
                                                                    class="text-purple-600 hover:text-purple-900 transition-colors duration-200"
                                                                    onclick="openAddDetailModal({{ $ticket->id }})"
                                                                    title="Add Detail">
                                                                    <i
                                                                        class="bx bx-plus-circle text-base sm:text-lg"></i>
                                                                </button>
                                                            {{-- @endif --}}
                                                        </div>
                                                    </td>
                                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $ticket->ticket_number }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-300">
                                                        @if ($ticket->user_agent && $ticket->user_agent->user)
                                                            <div class="flex items-center">
                                                                <i class="bx bx-user-circle text-gray-400 mr-2"></i>
                                                                <span
                                                                    class="truncate">{{ $ticket->user_agent->user->name }}</span>
                                                            </div>
                                                        @elseif($ticket->user_agent && $ticket->user_agent->username)
                                                            <div class="flex items-center">
                                                                <i class="bx bx-user-circle text-gray-400 mr-2"></i>
                                                                <span
                                                                    class="truncate">{{ $ticket->user_agent->username }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td
                                                        class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-300">
                                                        @php
                                                            $companyName = '-';

                                                            // 1) Ambil dari extra_data jika ada (sesuai modal detail)
                                                            if (isset($ticket->extra_data)) {
                                                                $extra = $ticket->extra_data;
                                                                $extraName = is_array($extra)
                                                                    ? ($extra['name'] ?? null)
                                                                    : ($extra->name ?? null);
                                                                if (is_string($extraName) && trim($extraName) !== '') {
                                                                    $companyName = $extraName;
                                                                }
                                                            }

                                                            // 2) Fallback: cari di payload
                                                            if ($companyName === '-') {
                                                                $payloadData = $ticket->payload;

                                                                if (is_string($payloadData)) {
                                                                    $decoded = json_decode($payloadData, true);
                                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                                        $payloadData = $decoded;
                                                                    }
                                                                }

                                                                if ($payloadData && is_array($payloadData)) {
                                                                    if (isset($payloadData[0]) && is_array($payloadData[0])) {
                                                                        // Format array of objects
                                                                        foreach ($payloadData as $item) {
                                                                            $fName = isset($item['field_name'])
                                                                                ? strtolower(trim($item['field_name']))
                                                                                : '';
                                                                            $label = isset($item['label'])
                                                                                ? strtolower(trim($item['label']))
                                                                                : '';

                                                                            if ($fName === 'name' || $label === 'nama perusahaan') {
                                                                                $companyName = $item['value'] ?? '-';
                                                                                break;
                                                                            }
                                                                        }

                                                                        if ($companyName === '-') {
                                                                            foreach ($payloadData as $item) {
                                                                                $fName = isset($item['field_name'])
                                                                                    ? strtolower(trim($item['field_name']))
                                                                                    : '';
                                                                                $label = isset($item['label'])
                                                                                    ? strtolower(trim($item['label']))
                                                                                    : '';

                                                                                if (
                                                                                    str_contains($fName, 'perusahaan') ||
                                                                                    str_contains($label, 'perusahaan') ||
                                                                                    str_contains($fName, 'company') ||
                                                                                    str_contains($label, 'company')
                                                                                ) {
                                                                                    $companyName = $item['value'] ?? '-';
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    } else {
                                                                        // Format key-value
                                                                        foreach ($payloadData as $key => $val) {
                                                                            $keyLower = strtolower(trim($key));
                                                                            if (
                                                                                $keyLower === 'name' ||
                                                                                $keyLower === 'nama_perusahaan' ||
                                                                                $keyLower === 'company_name'
                                                                            ) {
                                                                                $companyName = $val;
                                                                                break;
                                                                            }
                                                                        }

                                                                        if ($companyName === '-') {
                                                                            foreach ($payloadData as $key => $val) {
                                                                                $keyLower = strtolower(trim($key));
                                                                                if (
                                                                                    str_contains($keyLower, 'perusahaan') ||
                                                                                    str_contains($keyLower, 'company')
                                                                                ) {
                                                                                    $companyName = $val;
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if ($companyName !== '-' && !is_array($companyName)) {
                                                                $companyName = strip_tags((string) $companyName);
                                                            } elseif (is_array($companyName)) {
                                                                $companyName = json_encode($companyName);
                                                            }
                                                        @endphp
                                                        <span class="truncate block max-w-xs"
                                                            title="{{ $companyName }}">{{ $companyName }}</span>
                                                    </td>
                                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                                                                                                                                                                                                                                                                                                    @if ($ticket->flaging == 1) bg-blue-100 text-blue-800
                                                                                                                                                                                                                                                                                                                                    @elseif($ticket->flaging == 2) bg-green-100 text-green-800
                                                                                                                                                                                                                                                                                                                                    @elseif($ticket->flaging == 3) bg-yellow-100 text-yellow-800
                                                                                                                                                                                                                                                                                                                                    @elseif($ticket->flaging == 6) bg-gray-100 text-gray-800
                                                                                                                                                                                                                                                                                                                                    @else bg-gray-100 text-gray-800 @endif">
                                                            {{ $ticket->flaging_label }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                        @if ($ticket->status)
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                                                                                                                                                                                                                                                                                                                                                                @if ($ticket->status == 'open') bg-red-100 text-red-800
                                                                                                                                                                                                                                                                                                                                                                                                @elseif($ticket->status == 'resolved') bg-green-100 text-green-800
                                                                                                                                                                                                                                                                                                                                                                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                                {{ ucfirst($ticket->status) }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                        @if ($ticket->priority)
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                                                                                                                                                                                                                                                                                                                                                                @if ($ticket->priority == 'urgent') bg-red-100 text-red-800
                                                                                                                                                                                                                                                                                                                                                                                                @elseif($ticket->priority == 'high') bg-yellow-100 text-yellow-800
                                                                                                                                                                                                                                                                                                                                                                                                @else bg-blue-100 text-blue-800 @endif">
                                                                {{ ucfirst($ticket->priority) }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td
                                                        class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-300">
                                                        {{ $ticket->tipe_layanan }}
                                                    </td>
                                                    <td
                                                        class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-300">
                                                        @php
                                                            $layanan = '-';
                                                            $payloadData = $ticket->payload;

                                                            // Pastikan payload jadi array
                                                            if (is_string($payloadData)) {
                                                                $decoded = json_decode($payloadData, true);
                                                                if (json_last_error() === JSON_ERROR_NONE) {
                                                                    $payloadData = $decoded;
                                                                }
                                                            }

                                                            if ($payloadData && is_array($payloadData)) {
                                                                // ===== FORMAT BARU (ARRAY OF OBJECTS) =====
                                                                if (
                                                                    isset($payloadData[0]) &&
                                                                    is_array($payloadData[0])
                                                                ) {
                                                                    // 1. Exact match untuk customer_category + ambil additional_data.name
                                                                    foreach ($payloadData as $item) {
                                                                        $fName = isset($item['field_name'])
                                                                            ? strtolower(trim($item['field_name']))
                                                                            : '';
                                                                        $label = isset($item['label'])
                                                                            ? strtolower(trim($item['label']))
                                                                            : '';

                                                                        if (
                                                                            $fName === 'customer_category' ||
                                                                            $label === 'service category'
                                                                        ) {
                                                                            // Prioritas: additional_data.name
                                                                            if (
                                                                                isset(
                                                                                    $item['additional_data']['name'],
                                                                                ) &&
                                                                                is_string(
                                                                                    $item['additional_data']['name'],
                                                                                )
                                                                            ) {
                                                                                $layanan = trim(
                                                                                    $item['additional_data']['name'],
                                                                                );
                                                                            }
                                                                            // Fallback ke value jika additional_data.name tidak ada
                                                                            elseif (isset($item['value'])) {
                                                                                $layanan = $item['value'];
                                                                            }
                                                                            break;
                                                                        }
                                                                    }

                                                                    // 2. Partial match fallback (jika exact tidak ketemu)
                                                                    if ($layanan === '-') {
                                                                        foreach ($payloadData as $item) {
                                                                            $fName = isset($item['field_name'])
                                                                                ? strtolower(trim($item['field_name']))
                                                                                : '';
                                                                            $label = isset($item['label'])
                                                                                ? strtolower(trim($item['label']))
                                                                                : '';

                                                                            if (
                                                                                str_contains(
                                                                                    $fName,
                                                                                    'customer_category',
                                                                                ) ||
                                                                                str_contains($label, 'customer') ||
                                                                                str_contains($label, 'service category')
                                                                            ) {
                                                                                if (
                                                                                    isset(
                                                                                        $item['additional_data'][
                                                                                            'name'
                                                                                        ],
                                                                                    ) &&
                                                                                    is_string(
                                                                                        $item['additional_data'][
                                                                                            'name'
                                                                                        ],
                                                                                    )
                                                                                ) {
                                                                                    $layanan = trim(
                                                                                        $item['additional_data'][
                                                                                            'name'
                                                                                        ],
                                                                                    );
                                                                                } elseif (isset($item['value'])) {
                                                                                    $layanan = $item['value'];
                                                                                }
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                // ===== FORMAT LAMA (associative array) =====
                                                                else {
                                                                    // Untuk format lama biasanya tidak punya additional_data → tetap pakai value
                                                                    foreach ($payloadData as $key => $val) {
                                                                        $keyLower = strtolower(trim($key));
                                                                        if ($keyLower === 'customer_category') {
                                                                            $layanan = $val;
                                                                            break;
                                                                        }
                                                                    }

                                                                    if ($layanan === '-') {
                                                                        foreach ($payloadData as $key => $val) {
                                                                            $keyLower = strtolower(trim($key));
                                                                            if (
                                                                                str_contains(
                                                                                    $keyLower,
                                                                                    'customer_category',
                                                                                )
                                                                            ) {
                                                                                $layanan = $val;
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            // Sanitasi output
                                                            if ($layanan !== '-' && !is_array($layanan)) {
                                                                $layanan = strip_tags((string) $layanan);
                                                            } elseif (is_array($layanan)) {
                                                                $layanan = json_encode($layanan);
                                                            }
                                                        @endphp

                                                        <span class="truncate block max-w-xs"
                                                            title="{{ $layanan }}">
                                                            {{ $layanan }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-300">
                                                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                                                    </td>
                                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                        @php
                                                            $badgeClass = $ticket->sla_badge_class ?? 'bg-green-100 text-green-800';
                                                            $statusText = $ticket->sla_display ?? 'Normal';
                                                        @endphp

                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                                            {{ $statusText }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm">
                                                        @php
                                                            $displayAiAnalysis = $ticket->successful_ai_analysis ?? $ticket->ai_analysis;
                                                        @endphp
                                                        @if ($displayAiAnalysis)
                                                            @php
                                                                $aiStatus = $displayAiAnalysis->status;
                                                                $aiBadgeClass = match ($aiStatus) {
                                                                    'pending' => 'bg-gray-100 text-gray-800',
                                                                    'uploading', 'analyzing' => 'bg-blue-100 text-blue-800 animate-pulse',
                                                                    'success' => 'bg-green-100 text-green-800',
                                                                    'failed' => 'bg-red-100 text-red-800',
                                                                    default => 'bg-gray-100 text-gray-800',
                                                                };
                                                                $aiStatusLabel = match ($aiStatus) {
                                                                    'pending' => 'Scheduled',
                                                                    'uploading' => 'Uploading',
                                                                    'analyzing' => 'Analyzing',
                                                                    'success' => 'Success',
                                                                    'failed' => 'Failed',
                                                                    default => ucfirst($aiStatus),
                                                                };
                                                            @endphp
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $aiBadgeClass }}">
                                                                {{ $aiStatusLabel }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-500 text-xs">-</span>
                                                        @endif
                                                    </td>
                                                    {{-- Payload dynamic columns are intentionally disabled for the listing table. --}}
                                                    {{-- <td
                                                        class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-1 sm:space-x-2">
                                                            @if (!current_agent() || !current_agent()->user_agent || !is_null(current_agent()->user_agent->user_type))
                                                                <button type="button"
                                                                    class="text-purple-600 hover:text-purple-900 transition-colors duration-200"
                                                                    onclick="openSlaManagementModal({{ $ticket->id }}, '{{ $ticket->ticket_number }}')"
                                                                    title="Manage SLA">
                                                                    <i class="bx bx-time text-base sm:text-lg"></i>
                                                                </button>
                                                                <!-- Hanya tampilkan tombol View Interaction jika genesisnumber tidak null -->
                                                                @if ($ticket->genesisnumber)
                                                                    <button type="button"
                                                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200 js-view-payload-btn"
                                                                        data-flaging="{{ $ticket->flaging }}"
                                                                        data-genesisnumber="{{ $ticket->genesisnumber }}"
                                                                        onclick="viewPayload({{ $ticket->flaging }}, '{{ $ticket->genesisnumber }}', {{ $ticket->id }}, '{{ $ticket->ticket_number }}', '{{ optional($ticket->created_at)->toIso8601String() }}')"
                                                                        title="View Interaction">
                                                                        <i class="bx bx-show text-base sm:text-lg"></i>
                                                                    </button>
                                                                @endif
                                                                <!-- Tombol Add Detail - HANYA untuk Layer 2, 3, 4 -->
                                                                <button type="button"
                                                                    class="text-purple-600 hover:text-purple-900 transition-colors duration-200"
                                                                    onclick="openAddDetailModal({{ $ticket->id }})"
                                                                    title="Add Detail">
                                                                    <i
                                                                        class="bx bx-plus-circle text-base sm:text-lg"></i>
                                                                </button>
                                                            @endif
                                                            <button type="button"
                                                                class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                                                onclick="viewDetails({{ $ticket->id }})"
                                                                title="View Details">
                                                                <i class="bx bx-info-circle text-base sm:text-lg"></i>
                                                            </button>
                                                        </div>
                                                    </td> --}}
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 sm:p-6 md:p-8 text-center">
                            <div class="flex flex-col items-center">
                                <i class="bx bx-info-circle text-3xl sm:text-4xl text-blue-500 mb-3 sm:mb-4"></i>
                                <h3 class="text-base sm:text-lg font-semibold text-blue-800 mb-2">Tidak ada data ticket
                                    ditemukan</h3>
                                {{-- <p class="text-sm sm:text-base text-blue-600">untuk kategori dan subkategori yang dipilih.
                                </p> --}}
                                @if (request('all_agent') && !$resultTickets)
                                    <p class="text-sm sm:text-base text-blue-600"> Silakan pilih filter terlebih dahulu
                                        untuk
                                        menampilkan
                                        <strong>semua tiket agent</strong>.
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 sm:p-6 md:p-8 text-center">
                        <div class="flex flex-col items-center">
                            <i class="bx bx-error-circle text-3xl sm:text-4xl text-yellow-500 mb-3 sm:mb-4"></i>
                            @if ($requireCategorySelection)
                                <h3 class="text-base sm:text-lg font-semibold text-yellow-800 mb-2">Pilih Kategori dan
                                    Subkategori</h3>
                                <p class="text-sm sm:text-base text-yellow-600">untuk menampilkan data ticket dalam
                                    Mode
                                    Multiple Form.
                                </p>
                            @else
                                <h3 class="text-base sm:text-lg font-semibold text-yellow-800 mb-2">Tidak ada data
                                    ticket
                                    ditemukan</h3>
                                <p class="text-sm sm:text-base text-yellow-600">untuk filter yang dipilih dalam Mode
                                    Single
                                    Form.</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Pagination -->
                @if ($resultTickets && method_exists($resultTickets, 'hasPages') && $resultTickets->hasPages())
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-600">
                        <div class="text-gray-400 text-xs sm:text-sm mb-3 sm:mb-0 text-center sm:text-left">
                            Menampilkan {{ $resultTickets->firstItem() }} sampai {{ $resultTickets->lastItem() }}
                            dari {{ $resultTickets->total() }} data
                        </div>
                        <div class="flex items-center justify-center space-x-1 sm:space-x-2">
                            {{ $resultTickets->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan payload -->
    <div class="modal fade" id="payloadModal" tabindex="-1" aria-labelledby="payloadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-gray-800 border border-gray-600">
                <div class="modal-header border-b border-gray-600">
                    <h5 class="modal-title text-white" id="payloadModalLabel">
                        <i class="bx bx-code-alt text-blue-500 mr-2"></i>
                        Payload Data
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <pre id="payloadContent" class="bg-gray-900 text-gray-300 p-4 rounded-lg border border-gray-600"
                        style="max-height: 400px; overflow-y: auto; font-family: 'Courier New', monospace;"></pre>
                </div>
                <div class="modal-footer border-t border-gray-600">
                    <!-- <button type="button"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200"
                        data-bs-dismiss="modal">Tutup</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Detail Ticket (Dashboard) -->
    <div class="modal fade" id="addDetailDashboardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xxl">
            <div class="modal-content bg-gray-900 border-0">
                <div class="modal-header bg-gray-800 border-0">
                    <h5 class="modal-title text-white flex items-center">
                        <i class="fas fa-plus-circle mr-2 text-purple-400"></i>
                        <span id="modal-add-detail-title">Add Ticket Detail</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Detail Ticket (Gabungan) -->
                    <div id="combined-details-content" class="text-gray-300">
                        <div class="text-gray-400 text-sm">Memuat detail ticket...</div>
                    </div>

                    <hr class="my-6 border-gray-700">

                    <h6 class="text-white font-semibold mb-3 flex items-center">
                        <i class="fas fa-pen mr-2 text-purple-400"></i>
                        Add Ticketing Detail
                    </h6>

                    <!-- Form Add Detail -->
                    <form id="addDetailDashboardForm" class="mt-6">
                        <input type="hidden" id="detail-ticket-id" name="ticket_id">
                        <input type="hidden" id="detail-ticket-position" name="ticket_position">
                        <input type="hidden" id="detail-flaging" name="flaging" value="1">
                        <input type="hidden" id="detail-channel-id" name="channel_id" value="15">

                        <div class="mb-4">
                            <label class="form-label text-white text-sm flex items-center mb-2">
                                <i class="fas fa-user-edit mr-2 text-blue-400"></i>
                                Nama Penginput <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="created_by_name" id="created_by_name"
                                class="form-control bg-gray-700 focus:bg-gray-700 text-white border-0 focus:ring-2 focus:ring-blue-500 w-full rounded-lg px-4 py-2"
                                placeholder="Masukkan nama anda" required>
                        </div>

                        <!-- Note (Wajib) -->
                        <div class="mb-4">
                            <label class="form-label text-white text-sm flex items-center">
                                <i class="fas fa-sticky-note mr-2 text-purple-400"></i>
                                Note <span class="text-red-500 ml-1">*</span>
                            </label>
                            <textarea
                                class="form-control bg-gray-700 disabled:bg-gray-700 focus:bg-gray-700 text-white border-0 focus:ring-2 focus:ring-purple-500"
                                id="detail-note-input" name="note" rows="4" placeholder="Add your note here..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Attachments (Multiple)</label>
                            <input type="file" id="attachments-input" multiple
                                accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx" class="hidden">

                            <button type="button" onclick="document.getElementById('attachments-input').click()"
                                class="bg-gray-600 hover:bg-gray-500 text-white text-sm py-2 px-4 rounded-lg transition-colors border border-gray-500">
                                <i class="fas fa-plus mr-2"></i> Pilih File
                            </button>

                            <div id="file-list-container" class="mt-3 flex flex-wrap gap-2">
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Maksimal 25MB per file. Format: PDF, Image, Word,
                                Excel.</p>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label text-white text-sm flex items-center">
                                <i class="fas fa-flag mr-2 text-blue-400"></i>
                                Status
                            </label>
                            <select
                                class="form-select bg-gray-700 disabled:bg-gray-700 focus:bg-gray-700 text-white border-0 focus:ring-2 focus:ring-blue-500"
                                id="detail-status-input" name="status">
                                <option value="">Pilih Status (Opsional)</option>
                                @foreach ($statusOptions as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Priority -->
                        <div class="mb-4">
                            <label class="form-label text-white text-sm flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2 text-yellow-400"></i>
                                Priority
                            </label>
                            <select
                                class="form-select bg-gray-700 disabled:bg-gray-700 focus:bg-gray-700 text-white border-0 focus:ring-2 focus:ring-yellow-500"
                                id="detail-priority-input" name="priority">
                                <option value="">Pilih Priority (Opsional)</option>
                                @foreach ($priorityOptions as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Escalation Unit (hanya untuk Layer 2) -->
                        <div class="mb-4" id="detail-escalation-unit-container" style="display: none;">
                            <label class="form-label text-white text-sm flex items-center">
                                <i class="fas fa-building mr-2 text-green-400"></i>
                                Escalation Unit
                            </label>
                            <select
                                class="form-select bg-gray-700 disabled:bg-gray-700 focus:bg-gray-700 text-white border-0 focus:ring-2 focus:ring-green-500"
                                id="detail-escalation-unit-input" name="escalation_unit">
                                <option value="">Pilih Escalation Unit</option>
                                <!-- Options akan di-load via AJAX -->
                            </select>
                        </div>

                        <!-- Dropdown Eskalasi (ganti checkbox) -->
                        <div class="mb-4" id="detail-escalation-container">
                            <label class="form-label text-white text-sm flex items-center">
                                <i class="fas fa-arrow-up mr-2 text-orange-400"></i>
                                Eskalasi ke Layer Berikutnya
                            </label>
                            <select
                                class="form-select bg-gray-700 disabled:bg-gray-700 focus:bg-gray-700 text-white border-0 focus:ring-2 focus:ring-orange-500"
                                id="detail-escalation-input" name="escalation">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            {{-- <small class="text-gray-400 mt-1" id="detail-escalation-hint">-</small> --}}
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit"
                                class="btn btn-purple bg-purple-600 hover:bg-purple-700 text-white">
                                <i class="fas fa-save mr-1"></i>
                                Save Detail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="applySlaExtensionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-gray-800">
                <div class="modal-header border-gray-700">
                    <h5 class="modal-title text-white">
                        <i class="fa fa-clock text-blue-500 mr-2"></i>
                        Manage SLA - <span id="apply-sla-ticket-number"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="apply-sla-ticket-id">
                    <div id="sla-view-only-alert" class="alert alert-warning d-none">
                        <i class="fa fa-eye mr-2"></i>
                        Mode view-only untuk layer L3/L4. Anda hanya bisa melihat data SLA.
                    </div>

                    <!-- Current SLA Info -->
                    <div class="card bg-gray-700 mb-3">
                        <div class="card-body">
                            <h6 class="text-white mb-3">Current SLA Status</h6>
                            <div class="row text-white">
                                <div class="col-md-6">
                                    <small class="text-muted">Base SLA:</small>
                                    <div id="current-base-sla" class="h5">-</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Effective SLA:</small>
                                    <div id="current-effective-sla" class="h5 text-success">-</div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Extended:</small>
                                <div id="current-extended" class="text-info">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#tab-problem-extension">
                                Problem Extensions
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-custom-sla">
                                Custom SLA
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-history">
                                History
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-reopen">
                                Re-Open
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab: Problem Extensions -->
                        <div class="tab-pane fade show active" id="tab-problem-extension">
                            <div id="available-extensions-container">
                                <p class="text-muted">Loading available extensions...</p>
                            </div>

                            <!-- Inline Form (hidden by default) -->
                            <div id="problem-extension-form-container" class="mt-3" style="display: none;">
                                <div class="card bg-gray-600">
                                    <div
                                        class="card-header bg-gray-700 d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 text-white">
                                            <i class="fa fa-edit mr-2"></i>Apply Extension Level <span
                                                id="selected-extension-level"></span>
                                        </h6>
                                        <button type="button" class="btn btn-outline-light btn-sm"
                                            onclick="cancelExtensionForm()">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info mb-3">
                                            <i class="fa fa-clock mr-2"></i>
                                            SLA akan ditambah: <strong id="selected-extension-days"></strong>
                                        </div>
                                        <form id="problem-extension-form">
                                            <input type="hidden" id="selected-extension-id">
                                            <div class="mb-3">
                                                <label class="form-label text-white">Nama Agent <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="extension-agent-name"
                                                    class="form-control bg-gray-500 text-white border-0"
                                                    placeholder="Masukkan nama agent" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-white">Alasan <span
                                                        class="text-danger">*</span></label>
                                                <textarea id="extension-reason" class="form-control bg-gray-500 text-white border-0" rows="3"
                                                    placeholder="Masukkan alasan extend SLA..." required></textarea>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-check mr-1"></i>Apply Extension
                                                </button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="cancelExtensionForm()">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Custom SLA -->
                        <div class="tab-pane fade" id="tab-custom-sla">
                            <form id="custom-sla-form">
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle mr-2"></i>
                                    Custom SLA akan menggantikan SLA problem dan extensions yang ada
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="unlimited-sla-check">
                                    <label class="form-check-label text-white" for="unlimited-sla-check">
                                        Unlimited SLA (Tidak ada batas waktu)
                                    </label>
                                </div>

                                {{-- <div id="custom-sla-input-group">
                                    <div class="mb-3">
                                        <label class="form-label text-white">Custom SLA (dalam menit)</label>
                                        <input type="number" class="form-control bg-gray-600 text-white border-0"
                                            id="custom-sla-minutes" min="1" placeholder="Contoh: 1440 = 1 hari">
                                        <small class="text-muted">1440 menit = 1 hari, 4320 = 3 hari</small>
                                    </div>
                                </div> --}}
                                <div id="custom-sla-input-group">
                                    <div class="mb-3">
                                        <label class="form-label text-white">Custom SLA (dalam hari)</label>
                                        <input type="number"
                                            class="form-control bg-gray-600 focus:bg-gray-500 text-white border-0"
                                            id="custom-sla-days" min="1"
                                            placeholder="Contoh: 1 = 1 hari, 3 = 3 hari">
                                        <small class="text-muted">Masukkan jumlah hari kerja untuk SLA custom</small>
                                    </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white">Alasan <span class="text-danger">*</span></label>
                            <textarea class="form-control bg-gray-600 focus:bg-gray-500 text-white border-0" id="custom-sla-reason"
                                rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-1"></i>Apply Custom SLA
                        </button>
                        </form>
                    </div>

                    <!-- Tab: History -->
                    <div class="tab-pane fade" id="tab-history">
                        <div class="table-responsive">
                            <table class="table table-dark table-sm">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Type</th>
                                        <th>SLA Added</th>
                                        <th>By</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody id="sla-history-tbody">
                                    <tr>
                                        <td colspan="5" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab: Re-Open -->
                    <div class="tab-pane fade" id="tab-reopen">
                        <form id="reopen-sla-form">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Re-Open akan memperpanjang SLA ticket yang sudah Over SLA
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Nama <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control bg-gray-600 focus:bg-gray-500 text-white border-0"
                                    id="reopen-name" placeholder="Masukkan nama penanggung jawab" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Perpanjangan SLA (dalam hari) <span
                                        class="text-danger">*</span></label>
                                <input type="number"
                                    class="form-control bg-gray-600 focus:bg-gray-500 text-white border-0"
                                    id="reopen-sla-days" min="1" placeholder="Contoh: 3 = 3 hari" required>
                                <small class="text-muted">Masukkan jumlah hari kerja untuk perpanjangan SLA</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Alasan <span class="text-danger">*</span></label>
                                <textarea class="form-control bg-gray-600 focus:bg-gray-500 text-white border-0" id="reopen-reason" rows="3"
                                    required placeholder="Jelaskan alasan re-open ticket"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-redo mr-1"></i>Apply Re-Open
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-gray-700">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
        </div> <!-- Close modal fade -->
    </div> <!-- Close min-h-screen -->
</div> <!-- Close container -->
@include('pages.outbound-ticket-dashboard.partials.modals')
</x-dashonic-horizontal-layout>
        <script>
        const apiBase = '/outbound';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const filterFormEl = document.getElementById('filterForm');
        const aiApaFilterEl = document.querySelector('select[name="ai_apa_filter"]');
        const dateFromEl = document.querySelector('input[name="date_from"]');
        const dateToEl = document.querySelector('input[name="date_to"]');
        const applyDateWithAiApaInputEl = document.getElementById('applyDateWithAiApaInput');

        if (filterFormEl && aiApaFilterEl && applyDateWithAiApaInputEl) {
            const markDateFilterForAiApa = () => {
                if (aiApaFilterEl.value === 'success') {
                    applyDateWithAiApaInputEl.value = '1';
                }
            };

            dateFromEl?.addEventListener('change', markDateFilterForAiApa);
            dateToEl?.addEventListener('change', markDateFilterForAiApa);

            filterFormEl.addEventListener('submit', () => {
                if (aiApaFilterEl.value !== 'success') {
                    applyDateWithAiApaInputEl.value = '0';
                }
            });
        }

        let sttActiveSessionId = 0;

        function setSTTTicketNumber(ticketNumber) {
            const el = document.getElementById('stt-ticket-number');
            if (!el) return;

            const wrapEl = document.getElementById('stt-ticket-number-wrap');
            if (ticketNumber) {
                el.textContent = String(ticketNumber);
                wrapEl?.classList.remove('hidden');
            } else {
                el.textContent = '';
                wrapEl?.classList.add('hidden');
            }
        }

        function resetSTTDashboardUI() {
            const timestampEl = document.getElementById('stt-timestamp');
            if (timestampEl) timestampEl.textContent = '';

            const statusEl = document.getElementById('stt-status');
            if (statusEl) statusEl.textContent = '';

            const loadingEl = document.getElementById('sttResultLoading');
            if (loadingEl) {
                loadingEl.textContent = '';
                loadingEl.style.display = 'none';
            }

            const agentScoresEl = document.getElementById('stt-agent-scores');
            if (agentScoresEl) agentScoresEl.innerHTML = '';

            const avgAgentScoreEl = document.getElementById('stt-avg-agent-score');
            if (avgAgentScoreEl) avgAgentScoreEl.textContent = '0';

            const customerScoresEl = document.getElementById('stt-customer-scores');
            if (customerScoresEl) customerScoresEl.innerHTML = '';

            ['stt-collector-data', 'stt-additional-info', 'stt-schedule-info'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.innerHTML = '';
            });

            ['stt-collector-section', 'stt-info-section', 'stt-service-threat-section'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add('hidden');
            });

            ['stt-opening-greeting', 'stt-closing-greeting', 'stt-threat-status', 'stt-threat-source'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = '-';
            });

            const summaryTitleEl = document.getElementById('stt-summary-title');
            if (summaryTitleEl) summaryTitleEl.textContent = '';

            const summaryPointsEl = document.getElementById('stt-summary-points');
            if (summaryPointsEl) summaryPointsEl.innerHTML = '';

            const agentScoreEl = document.getElementById('stt-agent-score');
            if (agentScoreEl) agentScoreEl.textContent = '0%';
        }

        function beginSTTSession(ticketNumber) {
            sttActiveSessionId += 1;
            setSTTTicketNumber(ticketNumber);
            resetSTTDashboardUI();
            return sttActiveSessionId;
        }

        function showSTTNew(event, ticketId, uniqueid, recordingUrl = null, ticketNumber = null) {
            if (event) event.stopPropagation();

            const sessionId = beginSTTSession(ticketNumber);
            console.log('STT Triggered:', { ticketId, uniqueid, recordingUrl, ticketNumber, sessionId });

            // 1️⃣ Show modal & loading state IMMEDIATELY
            const modal = document.getElementById('sttDashboardModal');
            const statusEl = document.getElementById('stt-status');
            const loadingEl = document.getElementById('sttResultLoading');

            if (modal) {
                // To trigger animation, we must remove 'hidden' first but keep opacity at 0
                modal.classList.remove('hidden');
                modal.classList.add('opacity-0');
                modal.style.display = 'flex'; 

                // Use requestAnimationFrame to let the browser process the display change
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        modal.classList.remove('opacity-0');
                        modal.classList.add('opacity-100');
                    });
                });
            } else {
                console.error('STT Modal not found in DOM!');
            }
            if (statusEl) statusEl.textContent = 'queuing...';
            if (loadingEl) {
                loadingEl.textContent = 'Analyzing...';
                loadingEl.style.display = 'block';
            }

            // Close any existing SweetAlert (like the "eye" preview modal)
            if (typeof Swal !== 'undefined' && Swal.isVisible()) {
                Swal.close();
            }

            if (recordingUrl) {
                requestSummary(ticketId, recordingUrl, sessionId);
                return;
            }
            Swal.fire({
                title: 'Loading Recording...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/outbound/recording-by-uniqueid/${uniqueid}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(result => {
                    Swal.close();
                    if (result.success && result.data) {
                        const data = result.data;
                        requestSummary(ticketId, data.recordingfile_url, sessionId);
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tidak Ada Rekaman',
                            text: 'Tidak ada data rekaman untuk tiket ini.',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching recording data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data rekaman. Coba lagi.',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function closeSTTDashboardModal() {
            // Invalidate any in-flight polling so stale results can't overwrite the UI
            sttActiveSessionId += 1;
            setSTTTicketNumber(null);
            resetSTTDashboardUI();

            const modal = document.getElementById('sttDashboardModal');
            if (modal) {
                // Smooth fade out
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');
                
                // Wait for the duration of the transition (matching transition-opacity duration-300)
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.style.display = 'none';
                    modal.classList.remove('opacity-0'); // Reset opacity for next open
                }, 300);
            }
        }

        // --- Defensive closing handlers ---
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeSTTDashboardModal();
            }
        });

        // Initialize listeners once DOM is ready (or if already ready)
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSTTListeners);
        } else {
            initSTTListeners();
        }

        function initSTTListeners() {
            const modal = document.getElementById('sttDashboardModal');
            if (modal) {
                modal.addEventListener('click', (e) => {
                    // If clicking the backdrop directly (not its children)
                    if (e.target === modal) {
                        closeSTTDashboardModal();
                    }
                });
            }
        }

        async function callApi(url, method = 'GET', data = null) {
            const options = {
                method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin',
            };
            if (data) {
                options.headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
                options.body = new URLSearchParams(data);
            }
            const res = await fetch(url, options);
            const text = await res.text();
            let json;
            try {
                json = JSON.parse(text);
            } catch {
                json = {
                    error: text
                };
            }
            if (!res.ok) throw new Error(json.error || json.message || res.statusText);
            return json;
        }

        // ====== STT flow ======
        async function requestSummary(ticketId, recordingUrl, sessionId) {
            if (sessionId !== sttActiveSessionId) return;
            console.log('requestSummary started:', { ticketId, recordingUrl, sessionId });
            const loadingEl = document.getElementById('sttResultLoading');
            const statusEl = document.getElementById('stt-status');

            try {
                // Perform the API call
                // 2️⃣ Queue the STT process in the background
                const startResponse = await callApi(`${apiBase}/${ticketId}/stt`, 'POST', {
                    recording_url: recordingUrl,
                    ticket_type: 'result'
                });

                if (statusEl) {
                    statusEl.textContent = String(startResponse.status || 'waiting_webhook').toLowerCase();
                }

                if (String(startResponse.status || '').toLowerCase() === 'success' && startResponse.response) {
                    loadingEl.style.display = 'none';
                    const output = transformResponse(startResponse.response);
                    populateSTTDashboard(output);
                    return;
                }

                if (String(startResponse.status || '').toLowerCase() === 'failed') {
                    loadingEl.textContent = startResponse.message || 'Failed to generate summary.';
                    return;
                }

                loadingEl.textContent = 'Analyze request sudah dikirim. Menunggu webhook dari Kirana.';
            } catch (err) {
                if (sessionId !== sttActiveSessionId) return;
                if (loadingEl) loadingEl.textContent = 'Failed to start STT: ' + err.message;
                alert('Failed to start STT: ' + err.message);
            }
        }

        async function pollSummary(ticketId, loadingEl, sessionId, tries = 0, maxTries = 30, requestGroupId = null) {
            if (sessionId !== sttActiveSessionId) return;
            try {
                const query = new URLSearchParams({
                    ticket_type: 'result'
                });
                if (requestGroupId) {
                    query.set('request_group_id', requestGroupId);
                }
                const res = await callApi(`${apiBase}/${ticketId}/stt/latest?${query.toString()}`);
                if (sessionId !== sttActiveSessionId) return;
                const status = String(res.status || '').toLowerCase();

                document.getElementById('stt-status').textContent = status;

                if (status === 'success') {
                    loadingEl.style.display = 'none';
                    const response = JSON.stringify(res.response);
                    // const kiranaResponse = JSON.parse((JSON.stringify(res.response.response, null, 2)));
                    // response.summary = kiranaResponse
                    const output = transformResponse(res.response);
                    console.log(output);
                    populateSTTDashboard(output);
                    return;
                }

                if (['queued', 'uploading', 'analyzing', 'waiting_webhook', 'fetching_asummary', 'none', 'getting_result'].includes(status)) {
                    loadingEl.textContent = 'Analyze request sudah dikirim. Menunggu webhook dari Kirana.';
                    return;
                }

                if (status === 'failed') {
                    loadingEl.textContent = res.message || 'Failed to generate summary.';
                    return;
                }

                // Unknown → continue polling a bit more
                loadingEl.textContent = 'No result available.';
            } catch (e) {
                if (sessionId !== sttActiveSessionId) return;
                loadingEl.textContent = 'Error: ' + e.message;
            }
        }

        function parseResponseFragments(respStr) {
            // keep your original (unused now, but left for compatibility)
            respStr = respStr.replace(/":\s*}(?=\s*[,}])/g, '":{}');

            const objs = [];
            let depth = 0,
                start = -1,
                inString = false,
                esc = false;

            for (let i = 0; i < respStr.length; i++) {
                const ch = respStr[i];

                if (inString) {
                    if (esc) {
                        esc = false;
                        continue;
                    }
                    if (ch === '\\') {
                        esc = true;
                        continue;
                    }
                    if (ch === '"') {
                        inString = false;
                        continue;
                    }
                    continue;
                } else if (ch === '"') {
                    inString = true;
                    esc = false;
                    continue;
                }

                if (ch === '{') {
                    if (depth === 0) start = i;
                    depth++;
                } else if (ch === '}') {
                    depth--;
                    if (depth === 0 && start !== -1) {
                        const frag = respStr.slice(start, i + 1);
                        objs.push(frag);
                        start = -1;
                    }
                }
            }
            return objs;
        }

        function safeParse(objStr) {
            try {
                return JSON.parse(objStr);
            } catch {
                return null;
            }
        }

        /**
         * Extracts the JSON object value of a top-level key like "prompt_summary_json"
         * from a concatenated string of objects. Handles {"key":} as {}.
         */
        function extractSection(str, sectionKey) {
            // Normalize empty-object shorthand around the target key ONLY
            const keyRe = new RegExp(`\\{\\s*"${sectionKey}"\\s*:\\s*`, 'g');
            const m = keyRe.exec(str);
            if (!m) return {}; // not found

            let i = m.index + m[0].length;

            // Skip whitespace
            while (i < str.length && /\s/.test(str[i])) i++;

            // Handle {"key":}
            if (str[i] === '}') return {};

            // Require an object
            if (str[i] !== '{') return {};

            // Balanced-brace capture for the object literal
            let depth = 0,
                start = i,
                inString = false,
                esc = false;
            for (; i < str.length; i++) {
                const ch = str[i];

                if (inString) {
                    if (esc) {
                        esc = false;
                        continue;
                    }
                    if (ch === '\\') {
                        esc = true;
                        continue;
                    }
                    if (ch === '"') {
                        inString = false;
                        continue;
                    }
                    continue;
                } else if (ch === '"') {
                    inString = true;
                    esc = false;
                    continue;
                }

                if (ch === '{') depth++;
                else if (ch === '}') {
                    depth--;
                    if (depth === 0) {
                        const frag = str.slice(start, i + 1);
                        const obj = safeParse(frag);
                        return obj && typeof obj === 'object' ? obj : {};
                    }
                }
            }
            return {};
        }

        function transformResponse(input) {
            // Work on a normalized copy so {"x":} becomes {"x":{}} globally
            const resp = String(input.response || '').replace(/":\s*}(?=\s*[,}])/g, '":{}');

            // Extract each section independently (robust against other junk)
            const summary = extractSection(resp, 'prompt_summary_json');
            const collector = extractSection(resp, 'prompt_collector_json'); // {} if empty
            const agent = extractSection(resp, 'prompt_score_agent_common_json');
            const customer = extractSection(resp, 'prompt_score_customer_json');
            const threat = extractSection(resp, 'prompt_ancaman_json');

            const num = v => (typeof v === 'number' ? v : Number(v ?? 0)) || 0;

            return {
                timestamp: input.DT,
                status: input.status,
                summary: {
                    title: summary.rangkuman || "",
                    points: Array.isArray(summary.poin_penting) ? summary.poin_penting : []
                },
                collector: {
                    agent_score: num(collector.agent_score),
                    customer_data: {
                        agent: collector.agent || "",
                        nama: collector.nama_cust || collector.nama || "",
                        phone: collector.phone_cust || collector.phone || "",
                        email: collector.email_cust || collector.email || "",
                        alamat: collector.alamat_cust || collector.alamat || "",
                        kantor: collector.nama_kantor_cust || collector.kantor || "",
                        alamat_kantor: collector.alamat_kantor_cust || collector.alamat_kantor || "",
                        mobil: collector.jenis_mobil_cust || collector.mobil || "",
                        plat_mobil: collector.plat_mobil_cust || collector.plat_mobil || "",
                        motor: collector.jenis_motor_cust || collector.motor || "",
                        plat_motor: collector.plat_motor_cust || collector.plat_motor || ""
                    },
                    info_lain: Array.isArray(collector.info_lain) ? collector.info_lain : [],
                    penjadwalan: Array.isArray(collector.penjadwalan) ? collector.penjadwalan : []
                },
                agent_scores: {
                    pemahaman: {
                        score: num(agent.pemahaman),
                        reason: agent.pemahaman_alasan || ""
                    },
                    komunikasi: {
                        score: num(agent.komunikasi),
                        reason: agent.komunikasi_alasan || ""
                    },
                    keramahan: {
                        score: num(agent.keramahan),
                        reason: agent.keramahan_alasan || ""
                    },
                    kecepatan: {
                        score: num(agent.kecepatan_respon),
                        reason: agent.kecepatan_respon_alasan || ""
                    }
                },
                customer_scores: {
                    pemahaman: {
                        score: num(customer.pemahaman_customer),
                        reason: customer.pemahaman_customer_alasan || ""
                    },
                    penyampaian: {
                        score: num(customer.penyampaian_customer),
                        reason: customer.penyampaian_customer_alasan || ""
                    },
                    marah: {
                        score: num(customer.marah),
                        reason: customer.marah_alasan || ""
                    },
                    kepuasan: num(customer.kepuasan_customer)
                },
                service: {
                    salam_pembuka: agent.salam_pembuka || '',
                    salam_penutup: agent.salam_penutup || ''
                },
                threat: {
                    ada_ancaman: threat.ada_ancaman || '',
                    sumber_ancaman: threat.sumber_ancaman || ''
                }
            };
        }


        // Fungsi untuk populate data ke dashboard
        function populateSTTDashboard(data) {
            // Set timestamp
            const timestamp = data.timestamp || new Date().toLocaleString('id-ID');
            document.getElementById('stt-timestamp').textContent = timestamp;

            // Set status
            document.getElementById('stt-status').textContent = data.status ? data.status : 'Success';

            // Summary tab
            if (data.summary) {
                const summaryTitleEl = document.getElementById('stt-summary-title');
                if (summaryTitleEl) summaryTitleEl.textContent = data.summary.title || 'Ringkasan Interaksi';

                const summaryPointsEl = document.getElementById('stt-summary-points');
                if (summaryPointsEl) {
                    summaryPointsEl.innerHTML = '';
                    if (data.summary.points && Array.isArray(data.summary.points)) {
                        data.summary.points.forEach((point, index) => {
                            const pointDiv = document.createElement('div');
                            pointDiv.className = 'flex items-start gap-2 p-2 bg-gray-700/50 rounded-lg';
                            pointDiv.innerHTML = `
                                    <div class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 text-xs">${index + 1}</div>
                                    <p class="text-gray-300 text-sm pt-0.5">${point}</p>
                                `;
                            summaryPointsEl.appendChild(pointDiv);
                        });
                    }
                }
            }

            // Agent score
            if (data.collector && data.collector.agent_score !== undefined) {
                const agentScore = (data.collector.agent_score * 100).toFixed(1);
                document.getElementById('stt-agent-score').textContent = agentScore + '%';
            }

            // Agent scores section
            if (data.agent_scores) {
                const agentScoresEl = document.getElementById('stt-agent-scores');
                agentScoresEl.innerHTML = '';
                let totalScore = 0;
                let scoreCount = 0;

                const iconMap = {
                    'pemahaman': {
                        icon: 'brain',
                        label: 'Pemahaman'
                    },
                    'komunikasi': {
                        icon: 'comments',
                        label: 'Komunikasi'
                    },
                    'keramahan': {
                        icon: 'smile',
                        label: 'Keramahan'
                    },
                    'kecepatan': {
                        icon: 'clock',
                        label: 'Kecepatan Respon'
                    }
                };

                Object.keys(data.agent_scores).forEach(key => {
                    const score = data.agent_scores[key];
                    if (score && score.score !== undefined) {
                        totalScore += score.score;
                        scoreCount++;
                        const scoreColor = getScoreColor(score.score);
                        const scoreBg = getScoreBg(score.score);
                        const iconInfo = iconMap[key] || {
                            icon: 'star',
                            label: key.charAt(0).toUpperCase() + key.slice(1)
                        };

                        const scoreCard = document.createElement('div');
                        scoreCard.className = 'bg-gray-700/30 rounded-lg border-gray-600/50 p-3 hover:bg-gray-700/50 transition-colors';
                        scoreCard.innerHTML = `
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-${iconInfo.icon} text-blue-400 text-sm"></i>
                                        <h3 class="font-semibold text-white text-sm">${iconInfo.label}</h3>
                                    </div>
                                    <span class="text-lg font-bold px-3 py-1 rounded ${scoreColor}">${score.score}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                    <div class="h-2 rounded-full progress-bar ${scoreBg}" style="width: ${score.score}%"></div>
                                </div>
                                <p class="text-xs text-gray-300">${score.reason || '-'}</p>
                            `;
                        agentScoresEl.appendChild(scoreCard);
                    }
                });

                // Average score
                if (scoreCount > 0) {
                    const avgScore = (totalScore / scoreCount).toFixed(1);
                    document.getElementById('stt-avg-agent-score').textContent = avgScore;
                }
            }

            // Customer scores section
            if (data.customer_scores) {
                const customerScoresEl = document.getElementById('stt-customer-scores');
                customerScoresEl.innerHTML = '';

                // Pemahaman
                if (data.customer_scores.pemahaman) {
                    const score = data.customer_scores.pemahaman;
                    const scoreColor = getScoreColor(score.score);
                    const scoreBg = getScoreBg(score.score);
                    customerScoresEl.innerHTML += `
                            <div class="bg-gray-700/30 rounded-lg border-gray-600/50 p-3 hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-lightbulb text-blue-400 text-sm"></i>
                                        <h3 class="font-semibold text-white text-sm">Pemahaman Customer</h3>
                                    </div>
                                    <span class="text-lg font-bold px-3 py-1 rounded ${scoreColor}">${score.score}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                    <div class="h-2 rounded-full progress-bar ${scoreBg}" style="width: ${score.score}%"></div>
                                </div>
                                <p class="text-xs text-gray-300">${score.reason || '-'}</p>
                            </div>
                        `;
                }

                // Penyampaian
                if (data.customer_scores.penyampaian) {
                    const score = data.customer_scores.penyampaian;
                    const scoreColor = getScoreColor(score.score);
                    const scoreBg = getScoreBg(score.score);
                    customerScoresEl.innerHTML += `
                            <div class="bg-gray-700/30 rounded-lg border-gray-600/50 p-3 hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-comment-dots text-blue-400 text-sm"></i>
                                        <h3 class="font-semibold text-white text-sm">Penyampaian Customer</h3>
                                    </div>
                                    <span class="text-lg font-bold px-3 py-1 rounded ${scoreColor}">${score.score}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                    <div class="h-2 rounded-full progress-bar ${scoreBg}" style="width: ${score.score}%"></div>
                                </div>
                                <p class="text-xs text-gray-300">${score.reason || '-'}</p>
                            </div>
                        `;
                }

                // Marah
                const marahScore = data.customer_scores.marah?.score || 0;
                customerScoresEl.innerHTML += `
                        <div class="bg-gray-700/30 rounded-lg border-gray-600/50 p-3">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-angry text-gray-400 text-sm"></i>
                                <h3 class="font-semibold text-white text-sm">Tingkat Kemarahan</h3>
                            </div>
                            <div class="text-center py-3">
                                <div class="text-3xl font-bold text-green-400 mb-2">${marahScore}</div>
                                <div class="inline-flex items-center gap-2 bg-green-900/50 text-green-300 px-3 py-1 rounded-full text-xs">
                                    <i class="fas fa-check-circle"></i>
                                    <p class="font-medium">Tidak ada indikasi kemarahan</p>
                                </div>
                            </div>
                        </div>
                    `;

                // Kepuasan
                const kepuasan = data.customer_scores.kepuasan || 0;
                const scoreColor = getScoreColor(kepuasan);
                const scoreBg = getScoreBg(kepuasan);
                customerScoresEl.innerHTML += `
                        <div class="bg-gray-700/30 rounded-lg border-gray-600/50 p-3">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-heart text-purple-400 text-sm"></i>
                                <h3 class="font-semibold text-white text-sm">Kepuasan Customer</h3>
                            </div>
                            <div class="text-center py-3">
                                <div class="text-3xl font-bold mb-2 ${scoreColor}">${kepuasan}%</div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="h-2 rounded-full progress-bar ${scoreBg}" style="width: ${kepuasan}%"></div>
                                </div>
                            </div>
                        </div>
                    `;
            }

            renderSTTAdditionalData(data);

        }

        function renderSTTAdditionalData(data) {
            renderCollectorData(data.collector?.customer_data || {});
            renderListData('stt-additional-info', data.collector?.info_lain || []);
            renderListData('stt-schedule-info', data.collector?.penjadwalan || []);

            const hasInfo = (data.collector?.info_lain || []).length > 0 || (data.collector?.penjadwalan || []).length > 0;
            document.getElementById('stt-info-section')?.classList.toggle('hidden', !hasInfo);

            const hasServiceOrThreat = Boolean(data.service?.salam_pembuka || data.service?.salam_penutup || data.threat?.ada_ancaman || data.threat?.sumber_ancaman);
            document.getElementById('stt-service-threat-section')?.classList.toggle('hidden', !hasServiceOrThreat);
            setTextValue('stt-opening-greeting', data.service?.salam_pembuka || '-');
            setTextValue('stt-closing-greeting', data.service?.salam_penutup || '-');
            setTextValue('stt-threat-status', data.threat?.ada_ancaman || '-');
            setTextValue('stt-threat-source', data.threat?.sumber_ancaman ? `Sumber: ${data.threat.sumber_ancaman}` : '-');
        }

        function renderCollectorData(customerData) {
            const labels = {
                agent: 'Agent Terdeteksi', nama: 'Nama Customer', phone: 'Phone Customer', email: 'Email Customer',
                alamat: 'Alamat Customer', kantor: 'Nama Kantor', alamat_kantor: 'Alamat Kantor', mobil: 'Jenis Mobil',
                plat_mobil: 'Plat Mobil', motor: 'Jenis Motor', plat_motor: 'Plat Motor'
            };
            const entries = Object.entries(labels).filter(([key]) => customerData[key]);
            const section = document.getElementById('stt-collector-section');
            const container = document.getElementById('stt-collector-data');
            if (!section || !container) return;
            section.classList.toggle('hidden', entries.length === 0);
            container.innerHTML = entries.map(([key, label]) => `
                <div class="bg-gray-700/60 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">${escapeHtml(label)}</p>
                    <p class="text-sm font-semibold text-white break-words">${escapeHtml(customerData[key])}</p>
                </div>
            `).join('');
        }

        function renderListData(containerId, items) {
            const container = document.getElementById(containerId);
            if (!container) return;
            container.innerHTML = items.length ? items.map((item, index) => `
                <div class="flex items-start gap-2 text-sm text-gray-300">
                    <span class="bg-gray-600 text-white rounded-full w-5 h-5 flex items-center justify-center flex-shrink-0 text-xs">${index + 1}</span>
                    <span>${escapeHtml(item)}</span>
                </div>
            `).join('') : '<p class="text-sm text-gray-400">-</p>';
        }

        function setTextValue(id, value) {
            const el = document.getElementById(id);
            if (el) el.textContent = value;
        }


        // Helper functions untuk score color (dark theme)
        function getScoreColor(score) {
            if (score >= 90) return 'text-green-300 bg-green-900/30 border-green-600';
            if (score >= 70) return 'text-yellow-300 bg-yellow-900/30 border-yellow-600';
            return 'text-red-300 bg-red-900/30 border-red-600';
        }

        function getScoreBg(score) {
            if (score >= 90) return 'bg-green-500';
            if (score >= 70) return 'bg-yellow-500';
            return 'bg-red-500';
        }

        // ====== Event binding ======
        document.addEventListener('DOMContentLoaded', () => {

            // Close modal button
            document.getElementById('sttResultCloseBtn')?.addEventListener('click', () => {
                document.getElementById('sttResultModal').classList.add('hidden');
            });
        });
        </script>
<script>
    window.currentAgent = @json(current_agent());
    window.isSlaViewOnly = @json(auth()->user() && (auth()->user()->isLayer3() || auth()->user()->isLayer4()));
    // Update current date time
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
            timeZone: 'Asia/Jakarta'
        };
        const dateTimeString = now.toLocaleDateString('id-ID', options);
        const dateTimeElement = document.getElementById('currentDateTime');
        if (dateTimeElement) {
            dateTimeElement.textContent = dateTimeString;
        }
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();

    function exportToExcel() {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        const dateFrom = formData.get('date_from') || new Date().toISOString().slice(0, 10);
        const dateTo = formData.get('date_to') || new Date().toISOString().slice(0, 10);
        const startDate = new Date(`${dateFrom}T00:00:00`);
        const endDate = new Date(`${dateTo}T00:00:00`);

        if (Number.isNaN(startDate.getTime()) || Number.isNaN(endDate.getTime())) {
            Swal.fire({
                icon: 'info',
                title: 'Tanggal tidak valid',
                text: 'Silakan isi tanggal export dengan benar.',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        if (startDate > endDate) {
            Swal.fire({
                icon: 'info',
                title: 'Range tanggal tidak valid',
                text: 'Tanggal Dari tidak boleh lebih besar dari Tanggal Sampai.',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        const params = new URLSearchParams();
        for (let [key, value] of formData.entries()) {
            if (value !== '') {
                params.append(key, value);
            }
        }

        const exportUrl = '{{ route('chat.v3.ticket.result.export') }}?' + params.toString();
        const historyUrl = '{{ route('chat.v3.ticket.result.export-history') }}?watch=1';
        const historyWindow = window.open(historyUrl, '_blank');
        if (historyWindow) {
            historyWindow.opener = null;
        }

        Swal.fire({
            title: 'Membuat export job...',
            html: 'Request export sedang dimasukkan ke antrean.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(exportUrl, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (!response.ok) {
                    return response.json().catch(() => null).then(payload => {
                        throw new Error(payload?.message || 'Gagal membuat export job.');
                    });
                }
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Response export tidak valid.');
                }
                return response.json();
            })
            .then(payload => {
                Swal.close();

                if (!payload.success) {
                    throw new Error(payload.message || 'Gagal membuat export job.');
                }

                const data = payload.data || {};

                if (data.download_url) {
                    if (historyWindow && !historyWindow.closed) {
                        historyWindow.close();
                    }
                    window.location.href = data.download_url;
                    Swal.fire({
                        icon: 'success',
                        title: 'File export tersedia',
                        text: payload.message || 'File dengan filter yang sama sudah tersedia dan akan diunduh.',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }

                if (data.running) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Export sedang berjalan',
                        text: payload.message || 'Export dengan filter yang sama sedang diproses. Silakan cek Export History.',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Export diproses',
                    text: historyWindow
                        ? 'Export sedang diproses. Tab Export History sudah dibuka.'
                        : 'Export sedang diproses. Jika tab history tidak terbuka, klik tombol History Export.',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#3b82f6'
                });
            })
            .catch(error => {
                console.error('Export error:', error);
                if (historyWindow && !historyWindow.closed) {
                    historyWindow.close();
                }
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat membuat export job: ' + error.message,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#3b82f6'
                });
            });
    }

    function loadEnquiryTypesByCategory(categoryId, preserveValue) {
        const enquiryTypeSelect = document.getElementById('master_enquiry_type_id');
        const enquiryDetailSelect = document.getElementById('master_enquiry_detail_id');
        const problemSelect = document.getElementById('master_problem_id');

        if (!enquiryTypeSelect) {
            return Promise.resolve();
        }

        enquiryTypeSelect.innerHTML = '<option value="">Loading...</option>';
        if (enquiryDetailSelect) {
            enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
        }
        if (problemSelect) {
            problemSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
        }

        if (!categoryId) {
            enquiryTypeSelect.innerHTML = '<option value="">-- Pilih Direktorat dulu --</option>';
            return Promise.resolve();
        }

        return fetch(`{{ url('api/master/enquiry-type/by-category') }}/${categoryId}`)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Enquiry Type' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                enquiryTypeSelect.innerHTML = '<option value="">-- Pilih Enquiry Type --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        enquiryTypeSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = enquiryTypeSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) enquiryTypeSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch enquiry type:', err);
                enquiryTypeSelect.innerHTML = '<option value="">-- Pilih Direktorat dulu --</option>';
            });
    }

    function loadCategoryReportsByCategory(categoryId, preserveValue) {
        const reportSelect = document.getElementById('master_category_report');

        if (!reportSelect) {
            return Promise.resolve();
        }

        reportSelect.innerHTML = '<option value="">Loading...</option>';

        if (!categoryId) {
            reportSelect.innerHTML = '<option value="">-- Pilih Direktorat dulu --</option>';
            return Promise.resolve();
        }

        return fetch(`/chat/v3/ticket/reports/by-category/${categoryId}`)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Category Report' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                reportSelect.innerHTML = '<option value="">-- Pilih Category Report --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        reportSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = reportSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) reportSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch category report:', err);
                reportSelect.innerHTML = '<option value="">-- Pilih Direktorat dulu --</option>';
            });
    }

    function loadEnquiryTypesByReport(reportId, preserveValue) {
        const enquiryTypeSelect = document.getElementById('master_enquiry_type_id');
        const enquiryDetailSelect = document.getElementById('master_enquiry_detail_id');
        const problemSelect = document.getElementById('master_problem_id');

        if (!enquiryTypeSelect) {
            return Promise.resolve();
        }

        enquiryTypeSelect.innerHTML = '<option value="">Loading...</option>';
        if (enquiryDetailSelect) {
            enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
        }
        if (problemSelect) {
            problemSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
        }

        if (!reportId) {
            enquiryTypeSelect.innerHTML = '<option value="">-- Pilih Category Report dulu --</option>';
            return Promise.resolve();
        }

        return fetch(`{{ url('api/master/enquiry-type/by-report') }}/${reportId}`)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Enquiry Type' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                enquiryTypeSelect.innerHTML = '<option value="">-- Pilih Enquiry Type --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        enquiryTypeSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = enquiryTypeSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) enquiryTypeSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch enquiry type by report:', err);
                enquiryTypeSelect.innerHTML = '<option value="">-- Pilih Category Report dulu --</option>';
            });
    }

    function loadEnquiryDetailsByReport(reportId, enquiryTypeId, preserveValue) {
        const enquiryDetailSelect = document.getElementById('master_enquiry_detail_id');

        if (!enquiryDetailSelect) {
            return Promise.resolve();
        }

        enquiryDetailSelect.innerHTML = '<option value="">Loading...</option>';

        if (!reportId) {
            enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Category Report dulu --</option>';
            return Promise.resolve();
        }

        if (!enquiryTypeId) {
            enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
            return Promise.resolve();
        }

        let requestUrl = `{{ url('api/master/enquiry-details/by-report') }}/${reportId}`;
        requestUrl += `?enquiry_type_id=${encodeURIComponent(enquiryTypeId)}`;

        return fetch(requestUrl)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Enquiry Detail' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Enquiry Detail --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        enquiryDetailSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = enquiryDetailSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) enquiryDetailSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch enquiry detail by report:', err);
                enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
            });
    }

    function loadEnquiryDetailsByType(enquiryTypeId, preserveValue) {
        const enquiryDetailSelect = document.getElementById('master_enquiry_detail_id');

        if (!enquiryDetailSelect) {
            return Promise.resolve();
        }

        enquiryDetailSelect.innerHTML = '<option value="">Loading...</option>';

        if (!enquiryTypeId) {
            enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
            return Promise.resolve();
        }

        return fetch(`{{ url('api/master/enquiry-details/by-enquiry-type') }}/${enquiryTypeId}`)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Enquiry Detail' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Enquiry Detail --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        enquiryDetailSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = enquiryDetailSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) enquiryDetailSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch enquiry detail:', err);
                enquiryDetailSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
            });
    }

    function loadProblemsByDetail(enquiryDetailId, preserveValue) {
        const problemSelect = document.getElementById('master_problem_id');

        if (!problemSelect) {
            return Promise.resolve();
        }

        problemSelect.innerHTML = '<option value="">Loading...</option>';

        if (!enquiryDetailId) {
            problemSelect.innerHTML = '<option value="">-- Pilih Enquiry Detail dulu --</option>';
            return Promise.resolve();
        }

        return fetch(`{{ url('api/master/problems/by-enquiry-detail') }}/${enquiryDetailId}`)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Problem' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                problemSelect.innerHTML = '<option value="">-- Pilih Problem --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        problemSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = problemSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) problemSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch problem by detail:', err);
                problemSelect.innerHTML = '<option value="">-- Pilih Enquiry Detail dulu --</option>';
            });
    }

    function loadProblemsByCategory(categoryId, preserveValue) {
        const problemSelect = document.getElementById('master_problem_id');

        if (!problemSelect) {
            return Promise.resolve();
        }

        problemSelect.innerHTML = '<option value="">Loading...</option>';

        if (!categoryId) {
            problemSelect.innerHTML = '<option value="">-- Pilih Direktorat dulu --</option>';
            return Promise.resolve();
        }

        return fetch(`{{ url('api/master/problems/by-category') }}/${categoryId}`)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Problem' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                problemSelect.innerHTML = '<option value="">-- Pilih Problem --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        problemSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = problemSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) problemSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch problem by category:', err);
                problemSelect.innerHTML = '<option value="">-- Pilih Direktorat dulu --</option>';
            });
    }

    function loadProblemsByType(enquiryTypeId, preserveValue) {
        const problemSelect = document.getElementById('master_problem_id');

        if (!problemSelect) {
            return Promise.resolve();
        }

        problemSelect.innerHTML = '<option value="">Loading...</option>';

        if (!enquiryTypeId) {
            problemSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
            return Promise.resolve();
        }

        return fetch(`{{ url('api/master/problems/by-enquiry-type') }}/${enquiryTypeId}`)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Problem' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                problemSelect.innerHTML = '<option value="">-- Pilih Problem --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        problemSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = problemSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) problemSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch problem by type:', err);
                problemSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
            });
    }

    function loadProblemsByReport(reportId, enquiryTypeId, preserveValue) {
        const problemSelect = document.getElementById('master_problem_id');

        if (!problemSelect) {
            return Promise.resolve();
        }

        problemSelect.innerHTML = '<option value="">Loading...</option>';

        if (!reportId) {
            problemSelect.innerHTML = '<option value="">-- Pilih Category Report dulu --</option>';
            return Promise.resolve();
        }

        let requestUrl = `{{ url('api/master/problems/by-report') }}/${reportId}`;
        if (enquiryTypeId) {
            requestUrl += `?enquiry_type_id=${encodeURIComponent(enquiryTypeId)}`;
        }

        return fetch(requestUrl)
            .then(res => {
                if (!res.ok) throw new Error(res.status === 500 ? 'Server error saat memuat Problem' :
                    'Gagal memuat data');
                return res.json();
            })
            .then(data => {
                problemSelect.innerHTML = '<option value="">-- Pilih Problem --</option>';
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        problemSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                }
                if (preserveValue) {
                    const opt = problemSelect.querySelector(`option[value="${preserveValue}"]`);
                    if (opt) problemSelect.value = preserveValue;
                }
            })
            .catch(err => {
                console.error('Error fetch problem by report:', err);
                problemSelect.innerHTML = '<option value="">-- Pilih Enquiry Type dulu --</option>';
            });
    }

    const masterCategorySelect = document.getElementById('master_category_id');
    const masterCategoryReportSelect = document.getElementById('master_category_report');
    const masterEnquiryTypeSelect = document.getElementById('master_enquiry_type_id');
    const masterEnquiryDetailSelect = document.getElementById('master_enquiry_detail_id');

    if (masterCategorySelect) {
        masterCategorySelect.addEventListener('change', function() {
            loadCategoryReportsByCategory(this.value, null);
            loadEnquiryTypesByCategory(this.value, null);
            loadProblemsByCategory(this.value, null);
        });
    }

    if (masterCategoryReportSelect) {
        masterCategoryReportSelect.addEventListener('change', function() {
            const reportId = this.value;
            if (reportId) {
                loadEnquiryTypesByReport(reportId, null);
                loadEnquiryDetailsByReport(reportId, null, null);
                const typeId = masterEnquiryTypeSelect && masterEnquiryTypeSelect.value ? masterEnquiryTypeSelect.value : null;
                loadProblemsByReport(reportId, typeId || null, null);
                return;
            }

            const categoryId = masterCategorySelect && masterCategorySelect.value ? masterCategorySelect.value : null;
            loadEnquiryTypesByCategory(categoryId, null);
            loadProblemsByCategory(categoryId, null);
        });
    }

    if (masterEnquiryTypeSelect) {
        masterEnquiryTypeSelect.addEventListener('change', function() {
            const reportId = masterCategoryReportSelect && masterCategoryReportSelect.value ?
                masterCategoryReportSelect.value :
                null;

            if (reportId) {
                loadEnquiryDetailsByReport(reportId, this.value, null);
                if (this.value) {
                    loadProblemsByReport(reportId, this.value, null);
                } else {
                    loadProblemsByReport(reportId, null, null);
                }
                return;
            }

            loadEnquiryDetailsByType(this.value, null);
            if (this.value) {
                loadProblemsByType(this.value, null);
            } else {
                const categoryId = masterCategorySelect && masterCategorySelect.value ? masterCategorySelect.value : null;
                loadProblemsByCategory(categoryId, null);
            }
        });
    }

    if (masterEnquiryDetailSelect) {
        masterEnquiryDetailSelect.addEventListener('change', function() {
            const detailId = this.value;
            if (detailId) {
                loadProblemsByDetail(detailId, null);
                return;
            }

            const reportId = masterCategoryReportSelect && masterCategoryReportSelect.value ?
                masterCategoryReportSelect.value :
                null;
            const typeId = masterEnquiryTypeSelect && masterEnquiryTypeSelect.value ? masterEnquiryTypeSelect.value : null;
            const categoryId = masterCategorySelect && masterCategorySelect.value ? masterCategorySelect.value : null;

            if (reportId) {
                loadProblemsByReport(reportId, typeId || null, null);
                return;
            }

            if (typeId) {
                loadProblemsByType(typeId, null);
                return;
            }

            loadProblemsByCategory(categoryId, null);
        });
    }

    (function restoreMasterFiltersOnLoad() {
        const reportSelect = document.getElementById('master_category_report');
        const enquiryTypeSelect = document.getElementById('master_enquiry_type_id');
        const enquiryDetailSelect = document.getElementById('master_enquiry_detail_id');
        const problemSelect = document.getElementById('master_problem_id');

        const preservedReport = (reportSelect?.getAttribute('data-selected') || '').trim();
        const preservedType = (enquiryTypeSelect?.getAttribute('data-selected') || '').trim();
        const preservedDetail = (enquiryDetailSelect?.getAttribute('data-selected') || '').trim();
        const preservedProblem = (problemSelect?.getAttribute('data-selected') || '').trim();
        const categoryId = masterCategorySelect && masterCategorySelect.value ? masterCategorySelect.value : null;

        if (!categoryId) {
            return;
        }

        loadCategoryReportsByCategory(categoryId, preservedReport || null);

        if (preservedReport) {
            loadEnquiryTypesByReport(preservedReport, preservedType || null)
                .then(() => {
                    if (!preservedType) {
                        return loadProblemsByReport(preservedReport, null, preservedProblem || null);
                    }
                    return loadEnquiryDetailsByReport(preservedReport, preservedType, preservedDetail || null);
                })
                .then(() => {
                    if (preservedDetail) {
                        return loadProblemsByDetail(preservedDetail, preservedProblem || null);
                    }
                    if (preservedType) {
                        return loadProblemsByReport(preservedReport, preservedType, preservedProblem || null);
                    }
                    return loadProblemsByReport(preservedReport, null, preservedProblem || null);
                });
            return;
        }

        loadEnquiryTypesByCategory(categoryId, preservedType || null)
            .then(() => {
                if (!preservedType) {
                    return loadProblemsByCategory(categoryId, preservedProblem || null);
                }
                return loadEnquiryDetailsByType(preservedType, preservedDetail || null);
            })
            .then(() => {
                if (preservedDetail) {
                    return loadProblemsByDetail(preservedDetail, preservedProblem || null);
                }
                if (preservedType) {
                    return loadProblemsByType(preservedType, preservedProblem || null);
                }
                return loadProblemsByCategory(categoryId, preservedProblem || null);
            });
    })();

    // Data tickets untuk JavaScript
    @php
        $ticketsDataForJs = [];
        if ($resultTickets) {
            $ticketsDataForJs = $resultTickets
                ->getCollection()
                ->map(function ($ticket) {
                    $data = $ticket->toArray();
                    $data['sla_display'] = $ticket->sla_display ?? 'Normal';

                    // Pastikan relasi ikut terisi untuk modal detail
                    $data['company'] = $ticket->company ? $ticket->company->toArray() : null;
                    $data['user_agent'] = $ticket->user_agent ? $ticket->user_agent->toArray() : null;
                    $data['category'] = $ticket->category ? $ticket->category->toArray() : null;
                    $data['subcategory'] = $ticket->subcategory ? $ticket->subcategory->toArray() : null;
                    $data['article'] = $ticket->article ? $ticket->article->toArray() : null;

                    return $data;
                })
                ->values()
                ->all();
        }
    @endphp

    const ticketsData = @json($ticketsDataForJs);
    window.ticketsData = ticketsData;

    // Event listener untuk perubahan kategori
    const categorySelect = document.getElementById('categorySelect');
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            const subcategorySelect = document.getElementById('subcategorySelect');
            subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';

            if (categoryId) {
                fetch(`{{ url('chat/v3/ticket/result/subcategories') }}/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.nama_jenis;
                            subcategorySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const form = document.getElementById('filterForm');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'category_id';
                        input.value = categoryId;
                        form.appendChild(input);
                        form.submit();
                    });
            }
        });
    }

    const payloadCache = new Map();
    const payloadPendingRequests = new Map();

    function getPayloadCacheKey(flaging, genesisnumber) {
        return `${flaging}:${genesisnumber}`;
    }

    function fetchPayloadData(flaging, genesisnumber, ticketCreatedAt = null) {
        const cacheKey = `${getPayloadCacheKey(flaging, genesisnumber)}:${ticketCreatedAt || ''}`;

        if (payloadCache.has(cacheKey)) {
            return Promise.resolve(payloadCache.get(cacheKey));
        }

        if (payloadPendingRequests.has(cacheKey)) {
            return payloadPendingRequests.get(cacheKey);
        }

        const request = fetch('/chat/v3/ticket/get-genesis-header', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    flaging: flaging,
                    genesisnumber: genesisnumber,
                    ticket_created_at: ticketCreatedAt
                })
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    payloadCache.set(cacheKey, result);
                }

                return result;
            })
            .finally(() => {
                payloadPendingRequests.delete(cacheKey);
            });

        payloadPendingRequests.set(cacheKey, request);
        return request;
    }

    function openEmailLoadingModal() {
        Swal.fire({
            title: 'Email Body',
            background: '#1f2937',
            color: '#f9fafb',
            html: `
                <div class="email-loading-state">
                    <div class="text-center">
                        <div class="mb-3 text-gray-200">Memuat isi email...</div>
                        <div class="text-sm text-gray-400">Mohon tunggu sebentar</div>
                    </div>
                </div>
            `,
            width: '1400px',
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
                popup: 'email-body-modal',
                title: 'text-white'
            },
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function renderEmailBodyModal(html) {
        const modalOptions = {
            title: 'Email Body',
            background: '#1f2937',
            color: '#f9fafb',
            html,
            width: '1400px',
            confirmButtonText: 'Tutup',
            allowOutsideClick: true,
            showConfirmButton: true,
            customClass: {
                popup: 'email-body-modal',
                title: 'text-white',
                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white'
            }
        };

        if (Swal.isVisible()) {
            Swal.update(modalOptions);
            Swal.hideLoading();
            return;
        }

        Swal.fire(modalOptions);
    }

    function prefetchEmailPayload(flaging, genesisnumber) {
        if (Number(flaging) !== 4 || !genesisnumber) {
            return;
        }

        fetchPayloadData(flaging, genesisnumber).catch(error => {
            console.warn('Email prefetch failed:', error);
        });
    }

    function viewPayload(flaging, genesisnumber, ticketId, ticketNumber = null, ticketCreatedAt = null) {
        if (flaging == 4) {
            openEmailLoadingModal();
        }

        fetchPayloadData(flaging, genesisnumber, ticketCreatedAt)
            .then(result => {
                if (!result.success) {
                    Swal.fire('Error', result.message || 'Gagal memuat data', 'error');
                    return;
                }

                const data = result.data;

                if (flaging == 1 || flaging == 2 || flaging == 7) {
                    Swal.fire({
                        title: 'Recording Data',
                        html: `
                    <div class="text-left text-black">
                        <div class="mb-4">
                            <p><strong>Recording ID:</strong> ${data.uniqueid}</p>
                            <p><strong>Call Date:</strong> ${data.calldate}</p>
                        </div>
                        <div class="mt-4">
                            <audio controls class="w-full">
                                <source src="${data.recordingfile_url}">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                        <div class="mt-4 border-t pt-4 flex flex-col gap-2">
                            <button onclick='showSTTNew(event, ${JSON.stringify(ticketId)}, ${JSON.stringify(data.uniqueid)}, ${JSON.stringify(data.recordingfile_url)}, ${JSON.stringify(ticketNumber || '')})' class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <i class="fas fa-robot"></i> Analyze with Kirana AI
                            </button>
                        </div>
                    </div>
                `,
                        width: '600px',
                        confirmButtonText: 'Tutup',
                        customClass: {
                            popup: 'bg-white text-black',
                            title: 'text-black',
                            confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white'
                        }
                    });
                    return;
                }

                if (flaging == 3) {
                    let chatHtml = '<div class="chat-container">';
                    data.forEach(item => {
                        const isUser = item.sender_type === 'user';
                        const msg = item.message ?? '';
                        const time = new Date(item.created_at || Date.now()).toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        chatHtml += `
                <div class="message-wrapper ${isUser ? 'user-msg' : 'bot-msg'}">
                    <div class="message-bubble">
                        <div class="message-text">${msg.replace(/\n/g, '<br>')}</div>
                        <div class="message-time">${time}</div>
                    </div>
                </div>`;
                    });
                    chatHtml += '</div>';

                    Swal.fire({
                        title: '<strong>📱 Riwayat Percakapan</strong>',
                        html: chatHtml,
                        width: '700px',
                        background: '#f0f2f5',
                        showConfirmButton: true,
                        confirmButtonText: 'Tutup',
                        allowOutsideClick: true,
                        customClass: {
                            popup: 'chat-swal',
                            title: 'swal-title-chat',
                            confirmButton: 'swal-btn-close'
                        },
                        didOpen: () => {
                            const style = document.createElement('style');
                            style.innerHTML = `
                        .chat-swal { border-radius: 20px !important; font-family: 'Segoe UI', system-ui, sans-serif; }
                        .swal-title-chat { color: #111827 !important; font-size: 1.4rem !important; margin-bottom: 10px !important; }
                        .chat-container { padding: 20px 10px; max-height: 70vh; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; }
                        .message-wrapper { display: flex; margin: 4px 12px; }
                        .user-msg { justify-content: flex-start; }
                        .bot-msg  { justify-content: flex-end; }
                        .message-bubble { max-width: 70%; padding: 10px 14px; border-radius: 18px; position: relative; box-shadow: 0 1px 2px rgba(0,0,0,0.15); animation: fadeIn 0.3s ease; }
                        .user-msg .message-bubble { background: #111827; color: white; border-bottom-left-radius: 4px; }
                        .bot-msg .message-bubble { background: white; color: #111827; border-bottom-right-radius: 4px; }
                        .message-text { font-size: 15px; line-height: 1.4; white-space: pre-wrap; }
                        .message-time { font-size: 11px; opacity: 0.7; margin-top: 6px; text-align: right; }
                        .swal-btn-close { background: #3b82f6 !important; border-radius: 12px !important; padding: 10px 24px !important; }
                        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
                    `;
                            document.head.appendChild(style);
                        }
                    });
                    return;
                }

                if (flaging == 4) {
                    const normalizeDisplayText = (value) => {
                        const original = value ?? '';
                        if (!original) return '';

                        const decodeUtf8Bytes = (input) => {
                            try {
                                const bytes = Uint8Array.from(input, c => c.charCodeAt(0) & 0xff);
                                return new TextDecoder('utf-8', { fatal: false }).decode(bytes);
                            } catch (e) {
                                return input;
                            }
                        };

                        let text = original;

                        // Attempt a couple of rounds to undo common mojibake
                        for (let i = 0; i < 2; i++) {
                            const decoded = decodeUtf8Bytes(text);
                            if (!decoded || decoded === text) break;
                            text = decoded;
                        }

                        // Manual replacements for common punctuation artifacts
                        const map = {
                            'â€œ': '“',
                            'â€�': '”',
                            'â€˜': '‘',
                            'â€™': '’',
                            'â€“': '–',
                            'â€”': '—',
                            'â€¦': '…',
                            'Â ': ' ',
                            'Â': '',
                        };
                        Object.keys(map).forEach((bad) => {
                            text = text.split(bad).join(map[bad]);
                        });

                        // Remove control characters (keep tabs/newlines)
                        text = text.replace(/[\u0000-\u0008\u000B\u000C\u000E-\u001F\u007F-\u009F]/g, '');

                        // Fix replacement characters (�). Try to turn them into quotes when they wrap words.
                        if (text.includes('\uFFFD')) {
                            // Opening quote before word
                            text = text.replace(/(\*?)\uFFFD+(?=[A-Za-z0-9])/g, '$1“');
                            // Closing quote after word
                            text = text.replace(/([A-Za-z0-9])\uFFFD+(\*?)/g, '$1”$2');
                            // Remove any remaining replacement chars
                            text = text.replace(/\uFFFD+/g, '');
                        }

                        return text;
                    };

                    const escapeHtml = (value) => {
                        const div = document.createElement('div');
                        div.textContent = value ?? '';
                        return div.innerHTML;
                    };

                    let bodyText = normalizeDisplayText((data.body_text || '').trim());
                    if (!bodyText && data.body_html) {
                        const temp = document.createElement('div');
                        temp.innerHTML = data.body_html;
                        bodyText = normalizeDisplayText((temp.textContent || temp.innerText || '').trim());
                    }

                    const subject = normalizeDisplayText(data.subject || '(No Subject)');
                    const from = normalizeDisplayText(data.from || '-');
                    const to = normalizeDisplayText(data.to || '-');
                    const sentDate = data.sent_date
                        ? new Date(data.sent_date).toLocaleString('id-ID')
                        : '-';

                    const attachments = Array.isArray(data.attachments) ? data.attachments : [];
                    const attachmentItems = attachments.map(att => {
                        const name = att.filename || `Attachment ${att.id}`;
                        return `
                            <li class="mb-1">
                                <a href="/email/attachment/${encodeURIComponent(att.id)}/download" target="_blank"
                                   class="text-blue-600 hover:underline">
                                    ${escapeHtml(name)}
                                </a>
                            </li>
                        `;
                    }).join('');

                    const attachmentsHtml = attachmentItems
                        ? `
                            <div class="mt-3">
                                <div class="font-semibold mb-1">Attachment</div>
                                <ul class="text-left list-disc pl-5">
                                    ${attachmentItems}
                                </ul>
                            </div>
                        `
                        : '';

                    renderEmailBodyModal(`
                            <div class="email-body-content text-left text-white space-y-3">
                                <div><strong>Subject:</strong> ${escapeHtml(subject)}</div>
                                <div><strong>From:</strong> ${escapeHtml(from)}</div>
                                <div><strong>To:</strong> ${escapeHtml(to)}</div>
                                <div><strong>Date:</strong> ${escapeHtml(sentDate)}</div>
                                <hr class="my-2">
                                <div class="email-body-text">${escapeHtml(bodyText || '-')}</div>
                                ${attachmentsHtml}
                            </div>
                        `);
                    return;
                }
            })
            .catch(err => Swal.fire('Error', 'Terjadi kesalahan: ' + err, 'error'));
    }


    function renderTicketDetails(ticket, options = {}) {
        const containerId = options.containerId || 'combined-details-content';
        const prefix = options.prefix || 'combined';
        const container = document.getElementById(containerId);

        if (!container || !ticket) return;

        function getFlagingLabel(flaging) {
            switch (flaging) {
                case 1:
                    return 'Inbound Call';
                case 2:
                    return 'Outbound Call';
                case 3:
                    return 'Chat';
                case 4:
                    return 'Email';
                case 5:
                    return 'Blast Thread';
                case 6:
                    return 'Tatap Muka';
                case 7:
                    return 'WA Call';
                default:
                    return 'Unknown';
            }
        }

        function getFlagingBadgeClass(flaging) {
            switch (flaging) {
                case 1:
                    return 'bg-primary';
                case 2:
                    return 'bg-success';
                case 3:
                    return 'bg-warning';
                case 4:
                    return 'bg-info';
                case 5:
                    return 'bg-dark';
                case 6:
                    return 'bg-secondary';
                case 7:
                    return 'bg-success';
                default:
                    return 'bg-secondary';
            }
        }

        // Helper to get payload value safely in JS
        function getPayloadValue(t, field) {
            let displayValue = '-'; // Variabel sementara untuk menampung nilai

            // 1. Cek extra_data
            let extra = t.extra_data;
            if (typeof extra === 'string') {
                try {
                    extra = JSON.parse(extra);
                } catch (e) {}
            }

            if (extra && typeof extra === 'object' && extra[field] !== undefined) {
                displayValue = extra[field];
            } else {
                // 2. Cek payload
                let p = t.payload;
                if (typeof p === 'string') {
                    try {
                        p = JSON.parse(p);
                    } catch (e) {}
                }

                if (Array.isArray(p)) {
                    const item = p.find(x => x.field_name === field);
                    if (item) {
                        const specialFields = ['customer_category', 'enquiry_type', 'enquiry_detail', 'problem',
                            'escalation_unit'
                        ];
                        if (specialFields.includes(field) && item.additional_data && item.additional_data.name) {
                            displayValue = item.additional_data.name;
                        } else {
                            displayValue = item.value || '-';
                        }
                    }
                } else if (p && typeof p === 'object') {
                    displayValue = p[field] !== undefined ? p[field] : '-';
                }
            }

            // --- LOGIKA TAMBAHAN UNTUK ATTACHMENT ---
            // Jika fieldnya adalah attachment dan ada isinya
            if (field === 'attachment' && displayValue !== '-' && displayValue !== null && displayValue !== '') {
                // Hapus slash di awal jika ada agar tidak double slash di URL
                const cleanPath = displayValue.toString().replace(/^\//, '');
                const url = `/storage/${cleanPath}`;

                return `
                        <a href="${url}"
                        target="_blank"
                        class="inline-flex items-center text-blue-400 hover:text-blue-300 underline font-semibold">
                            <i class="bx bx-paperclip mr-1"></i>
                            Download
                        </a>
                    `;
            }

            return displayValue;
        }

        const flagingLabel = getFlagingLabel(ticket.flaging);
        const flagingBadgeClass = getFlagingBadgeClass(ticket.flaging);

        const detailsHtml = `
            <div class="space-y-4">
                <div class="flex items-center">
                    <h6 class="text-white font-semibold flex items-center">
                        <i class="bx bx-info-circle text-blue-500 mr-2"></i>
                        Detail Ticket
                    </h6>
                </div>

                <!-- Section: Informasi Dasar -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Informasi Dasar -->
                    <div class="bg-gray-700/50 p-4 rounded-xl">
                        <h6 class="text-white mb-3 flex items-center border-b border-gray-600 pb-2 font-semibold">
                            <i class="bx bx-id-card text-blue-500 mr-2"></i>
                            Informasi Dasar
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Ticket Number:</span>
                                <span class="text-white font-medium">${ticket.ticket_number || '-'}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Recording ID:</span>
                                <span class="text-white font-medium">${ticket.genesisnumber || '-'}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Company:</span>
                                <span class="text-white font-medium text-end">${ticket.company?.name || '-'}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">User Agent:</span>
                                <span class="text-white font-medium text-end">${ticket.user_agent?.user?.name || ticket.user_agent?.username || '-'}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Sumber Interaksi:</span>
                                <span class="badge ${flagingBadgeClass}">${flagingLabel}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Status:</span>
                                <span class="text-white font-medium">${ticket.status ? ticket.status.charAt(0).toUpperCase() + ticket.status.slice(1) : '-'}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Priority:</span>
                                <span class="text-white font-medium">${ticket.priority ? ticket.priority.charAt(0).toUpperCase() + ticket.priority.slice(1) : '-'}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">SLA:</span>
                                <span class="text-white font-medium text-end">${ticket.sla_display || '-'}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Article:</span>
                                <span class="text-white font-medium text-end">${ticket.article?.title || '-'}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 text-sm">Ticket Position:</span>
                                <span class="text-white font-medium">
                                    ${ticket.ticket_position === '2' ? 'Layer 1.5' :
                ticket.ticket_position === '3' ? 'Layer 2' :
                    ticket.ticket_position === '4' ? 'Layer 3' :
                        (ticket.ticket_position || 'Layer 1')}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Detail Data Payload -->
                <div class="bg-gray-700/50 p-4 rounded-xl">
                     <h6 class="text-white mb-3 flex items-center border-b border-gray-600 pb-2 font-semibold">
                        <i class="bx bx-data text-purple-500 mr-2"></i>
                        Detail Data Payload
                    </h6>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2">
                        @foreach ($payloadHeaders as $fieldName => $label)
                            <div class="flex justify-between items-center py-1 border-b border-gray-700 last:border-0 hover:bg-gray-700/30 px-2 rounded transition-colors">
                                <span class="text-gray-400 text-sm w-1/2 pr-2 truncate" title="{{ $label }}">{{ $label }}:</span>
                                <span class="text-white font-medium text-sm w-1/2 text-end break-words">
                                    ${getPayloadValue(ticket, '{{ $fieldName }}')}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section: Ticket Journey Timeline -->
                <div class="bg-gray-700/50 p-4 rounded-xl">
                    <h6 class="text-white mb-3 flex items-center border-b border-gray-600 pb-2 font-semibold">
                        <i class="fas fa-route text-blue-400 mr-2"></i>
                        Ticket Journey Timeline
                    </h6>
                    <div class="timeline-container relative">
                        <div id="${prefix}-ticket-timeline" class="flex overflow-x-auto space-x-4 relative overflow-y-hidden">
                            <!-- Timeline akan dimuat di sini -->
                        </div>
                    </div>
                    <!-- Timeline Detail Display -->
                    <div id="${prefix}-timeline-detail-display" class="mt-4 p-4 bg-gray-800 rounded-lg border border-gray-700 hidden">
                        <div class="flex items-center justify-between mb-3">
                            <h6 class="text-white font-semibold text-sm" id="${prefix}-detail-title">Timeline Detail</h6>
                            <button type="button" onclick="closeDashboardTimelineDetailDisplay('${prefix}')" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="${prefix}-detail-content">
                            <!-- Detail akan dimuat di sini -->
                        </div>
                    </div>
                </div>

                <!-- Footer Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-400">
                    <div class="flex items-center">
                        <i class="bx bx-calendar mr-2"></i>
                        Created: <span class="text-gray-300 ml-1 font-medium">${ticket.created_at ? new Date(ticket.created_at).toLocaleString('id-ID') : '-'}</span>
                    </div>
                    <div class="flex items-center md:justify-end">
                        <i class="bx bx-time mr-2"></i>
                        Updated: <span class="text-gray-300 ml-1 font-medium">${ticket.updated_at ? new Date(ticket.updated_at).toLocaleString('id-ID') : '-'}</span>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML = detailsHtml;
    }

    async function loadDashboardTicketTimeline(ticketId, prefix = 'dashboard') {
        try {
            const response = await fetch(`/chat/v3/ticket/ticket-timeline/${ticketId}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            const timelineContainer = document.getElementById(`${prefix}-ticket-timeline`);
            if (!timelineContainer) return;

            if (data.success && data.data.length > 0) {
                timelineContainer.innerHTML = '';
                const sortedData = data.data.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

                sortedData.forEach((detail, index) => {
                    const timelineItem = document.createElement('div');
                    const positionClass = index % 2 === 0 ? 'even' : 'odd';
                    timelineItem.className =
                        `timeline-item relative flex flex-col items-center ${positionClass}`;

                    const createdDate = new Date(detail.created_at);
                    const formattedDate = createdDate.toLocaleString('id-ID');
                    const agentName = detail.user_agent?.user_name || detail.user_agent?.username ||
                        'Unknown Agent';
                    const attachmentsJson = detail.attachments ? JSON.stringify(detail.attachments).replace(
                        /"/g, '&quot;') : '[]';

                    // Icon channel
                    let channelIcon = '<i class="fas fa-comment text-gray-400"></i>';
                    if (detail.channel) {
                        if (detail.channel.icon_src) {
                            channelIcon =
                                `<img src="${detail.channel.icon_src}" alt="${detail.channel.name}" class="w-8 h-8 rounded-full object-cover">`;
                        } else {
                            switch (detail.channel.code) {
                                case 'fb':
                                    channelIcon = '<i class="fab fa-facebook text-blue-500"></i>';
                                    break;
                                case 'ig':
                                    channelIcon = '<i class="fab fa-instagram text-pink-500"></i>';
                                    break;
                                case 'telegram':
                                    channelIcon = '<i class="fab fa-telegram text-blue-400"></i>';
                                    break;
                                case 'whatsapp':
                                    channelIcon = '<i class="fab fa-whatsapp text-green-500"></i>';
                                    break;
                                default:
                                    channelIcon = '<i class="fas fa-comment text-gray-400"></i>';
                            }
                        }
                    }

                    // Layer info
                    let layerTransitionText = '';
                    if (detail.ref_id) {
                        const prev = sortedData.find(p => p.id == detail.ref_id);
                        if (prev) {
                            const fromLayer = prev.layer || 1;
                            const toLayer = detail.layer || 1;
                            const fromLabel = formatLayerLabel(fromLayer);
                            const toLabel = formatLayerLabel(toLayer);
                            layerTransitionText = fromLayer !== toLayer ?
                                `${fromLabel} → ${toLabel}` :
                                `${toLabel}`;
                        }
                    } else {
                        layerTransitionText = `Start ${formatLayerLabel(detail.layer || 1)}`;
                    }

                    timelineItem.innerHTML = `
                        <div class="timeline-icon relative z-10 flex items-center justify-center w-16 h-16 rounded-full cursor-pointer transition-all duration-300 group"
                            onclick='showDashboardTimelineDetail("${prefix}", ${index}, "${detail.channel?.name || 'Ticket Detail'}", "${formattedDate}", "${agentName}", ${JSON.stringify(detail.note || 'Tidak ada catatan')}, "${detail.status || ''}", "${detail.layer || ''}", "${layerTransitionText}", ${attachmentsJson})'>
                            <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center group-hover:bg-gray-600 transition-colors">
                            ${channelIcon}
                            </div>
                            <div class="layer-transition text-xs absolute bottom-[-25px] left-1/2 transform -translate-x-1/2 whitespace-nowrap bg-black/70 px-1 py-0.5 rounded">
                            ${layerTransitionText}
                            </div>
                        </div>
                    `;

                    timelineContainer.appendChild(timelineItem);
                });
            } else {
                timelineContainer.innerHTML = '<p class="text-gray-400 text-center py-2">No timeline yet</p>';
            }
        } catch (error) {
            console.error('Error loading dashboard timeline:', error);
            const fallbackContainer = document.getElementById(`${prefix}-ticket-timeline`);
            if (fallbackContainer) {
                fallbackContainer.innerHTML =
                    '<p class="text-red-400 text-center py-2">Failed to load timeline</p>';
            }
        }
    }

    function showDashboardTimelineDetail(prefix, index, channelName, formattedDate, agentName, note, status, layer,
        layerTransition, attachments = []) {
        const content = document.getElementById(`${prefix}-detail-content`);
        const title = document.getElementById(`${prefix}-detail-title`);
        const display = document.getElementById(`${prefix}-timeline-detail-display`);

        // Helper untuk merender list attachment
        let attachmentHtml = '';
        if (attachments && attachments.length > 0) {
            attachmentHtml = `<div class="mt-3">
                <span class="text-gray-400 block mb-1">Attachments:</span>
                <div class="flex flex-wrap gap-2">`;

            attachments.forEach(path => {
                const fileName = path.split('/').pop();
                const fullUrl = `${window.location.origin}/storage${path}`;

                // Cek jika file adalah gambar untuk menampilkan icon yang berbeda
                const isImage = /\.(jpg|jpeg|png|gif)$/i.test(fileName);
                const icon = isImage ? 'fa-image' : 'fa-file-alt';

                attachmentHtml += `
                    <a href="${fullUrl}" target="_blank"
                    class="flex items-center bg-gray-600 hover:bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg transition-colors border border-gray-500">
                        <i class="fas ${icon} mr-2"></i>
                        <span class="truncate max-w-[150px]">${fileName}</span>
                    </a>`;
            });

            attachmentHtml += `</div></div>`;
        }

        // Tampilkan note lengkap tanpa dipotong
        function formatNote(text) {
            if (!text) return 'Tidak ada catatan';
            // Hapus tag HTML jika ada, tapi tampilkan semua teks
            return text.replace(/<[^>]*>/g, '');
        }

        content.innerHTML = `
            <div class="space-y-2 text-sm">
                <div><span class="text-gray-400">Channel:</span> <span class="text-white">${channelName}</span></div>
                <div><span class="text-gray-400">Waktu:</span> <span class="text-white">${formattedDate}</span></div>
                <div><span class="text-gray-400">Agent:</span> <span class="text-white">${agentName}</span></div>
                ${layerTransition ? `<div><span class="text-gray-400">Layer:</span> <span class="text-blue-300">${layerTransition}</span></div>` : ''}
                ${status ? `<div><span class="text-gray-400">Status:</span> <span class="text-blue-300">${status}</span></div>` : ''}
                <div class="bg-gray-700 p-2 rounded mt-2 text-white whitespace-pre-wrap break-words">${formatNote(note)}</div>

                ${attachmentHtml}
            </div>
        `;
        title.textContent = 'Timeline Detail';
        display.classList.remove('hidden');
    }

    function closeDashboardTimelineDetailDisplay(prefix) {
        document.getElementById(`${prefix}-timeline-detail-display`).classList.add('hidden');
    }

    function formatLayerLabel(layerValue) {
        const layer = String(layerValue || '1');
        switch (layer) {
            case '2':
                return 'Layer 1.5';
            case '3':
                return 'Layer 2';
            case '4':
                return 'Layer 3';
            default:
                return 'Layer 1';
        }
    }

    // function loadTicketSLA() {
    //     fetch('{{ route('chat.v3.ticket.sla') }}', {
    //         method: 'GET',
    //         headers: {
    //             'Accept': 'application/json',
    //             'X-Requested-With': 'XMLHttpRequest'
    //         }
    //     })
    //         .then(response => response.json())
    //         .then(res => {
    //             if (!res.count) return;
    //             document.getElementById('TicketNearSLA').innerText = res.count.near_sla ?? 0;
    //             document.getElementById('TicketOverSLA').innerText = res.count.over_sla ?? 0;
    //         })
    //         .catch(err => {
    //             console.error('Error load Ticket SLA:', err);
    //             document.getElementById('TicketNearSLA').innerText = '0';
    //             document.getElementById('TicketOverSLA').innerText = '0';
    //         });
    // }

    // Redirect dengan filter SLA
    // function goToTicketSLA(type) {
    //     const url = new URL("{{ route('chat.v3.ticket.result.index') }}", window.location.origin);
    //     url.searchParams.set('sla_status', type);
    //     window.location.href = url.toString();
    // }

    document.addEventListener('DOMContentLoaded', function() {
        // loadTicketSLA();
    });


    // ===========================
    // FUNGSI OPEN MODAL ADD DETAIL
    // ===========================
    async function openAddDetailModal(ticketId) {
        try {
            const combinedDetailsContainer = document.getElementById('combined-details-content');
            if (combinedDetailsContainer) {
                combinedDetailsContainer.innerHTML =
                    '<div class="text-gray-400 text-sm">Memuat detail ticket...</div>';
            }

            // 1. Ambil detail ticket
            const response = await fetch(`/chat/v3/ticket/ticket-detail/${ticketId}`);
            const data = await response.json();

            if (!data.success) {
                Swal.fire('Error', 'Gagal memuat detail ticket', 'error');
                return;
            }

            const ticketFromList = Array.isArray(window.ticketsData)
                ? window.ticketsData.find(t => t.id == ticketId)
                : null;
            const ticket = {
                ...(ticketFromList || {}),
                ...(data.data || {}),
                company: data.data?.company ?? ticketFromList?.company,
                user_agent: data.data?.user_agent ?? ticketFromList?.user_agent,
                category: data.data?.category ?? ticketFromList?.category,
                subcategory: data.data?.subcategory ?? ticketFromList?.subcategory,
                article: data.data?.article ?? ticketFromList?.article
            };
            window.currentAddDetailTicket = ticket;

            // --- PENTING: RESET FORM DI AWAL SEBELUM ISI DATA ---
            document.getElementById('addDetailDashboardForm').reset();

            // 2. Isi data teks/hidden dasar
            document.getElementById('detail-ticket-id').value = ticket.id;
            document.getElementById('detail-ticket-position').value = ticket.ticket_position || '1';

            renderTicketDetails(ticket, {
                containerId: 'combined-details-content',
                prefix: 'combined'
            });

            // 3. PANGGIL MASTER DATA (Autofill)
            // Pastikan menggunakan ticket.escalation_unit (sesuai field di DB)
            await loadTicketMasterData(ticket.status, ticket.priority, ticket.escalation_unit);

            // 4. LOGIKA TAMPILAN LAYER
            const currentUser = window.currentAgent;
            const userType = currentUser.user_agent?.user_type;

            if (userType === 'l2') {
                document.getElementById('detail-escalation-unit-container').style.display = 'block';
                // document.getElementById('detail-escalation-hint').textContent = 'Yes = Eskalasi ke Layer 3';
            } else {
                document.getElementById('detail-escalation-unit-container').style.display = 'none';
            }

            // 5. LOCK JIKA CLOSED
            handleTicketClosedStatus(ticket.status);
            applyLayer1EscalatedDetailFieldLocks(ticket, userType);

            await loadDashboardTicketTimeline(ticketId, 'combined');
            const modal = new bootstrap.Modal(document.getElementById('addDetailDashboardModal'));
            modal.show();

        } catch (error) {
            console.error('Error opening modal:', error);
        }
    }

    function applyLayer1EscalatedDetailFieldLocks(ticket, userType) {
        const ticketPosition = String(ticket?.ticket_position || '1');
        const isLayer1 = (userType === null || userType === undefined || userType === '');
        const isTicketEscalated = ticketPosition !== '1';

        const statusValue = String(ticket?.status || '').toLowerCase();
        const isClosed = statusValue === 'close' || statusValue === 'closed';
        if (isClosed) return;

        const shouldLock = isLayer1 && isTicketEscalated;

        const setLocked = (el, locked) => {
            if (!el) return;
            if (locked) {
                el.dataset.locked = '1';
                el.setAttribute('disabled', 'disabled');
            } else {
                delete el.dataset.locked;
                el.removeAttribute('disabled');
            }
        };

        const statusSelect = document.getElementById('detail-status-input');
        const prioritySelect = document.getElementById('detail-priority-input');
        const escalationSelect = document.getElementById('detail-escalation-input');
        const escalationUnitSelect = document.getElementById('detail-escalation-unit-input');

        setLocked(statusSelect, shouldLock);
        setLocked(prioritySelect, shouldLock);
        setLocked(escalationSelect, shouldLock);
        setLocked(escalationUnitSelect, shouldLock);

        if (shouldLock && escalationSelect) {
            escalationSelect.value = '0';
        }
    }

    async function loadTicketMasterData(currentStatus, currentPriority, currentEscalationId) {
        try {
            const response = await fetch(@json(route('ticket.ticket.status.priority')));
            const data = await response.json();

            const normalizeValue = (value) => String(value ?? '').trim().toLowerCase();
            const setSelectByValue = (selectEl, targetValue) => {
                if (!selectEl) return false;
                const normalizedTarget = normalizeValue(targetValue);
                if (!normalizedTarget) return false;

                let found = false;
                Array.from(selectEl.options).forEach(option => {
                    const normalizedValue = normalizeValue(option.value);
                    const normalizedText = normalizeValue(option.textContent);
                    if (normalizedValue === normalizedTarget || normalizedText === normalizedTarget) {
                        option.selected = true;
                        found = true;
                    }
                });
                return found;
            };

            if (data.success) {
                const statusSelect = document.getElementById('detail-status-input');
                const prioritySelect = document.getElementById('detail-priority-input');
                const escalationUnitSelect = document.getElementById('detail-escalation-unit-input');

                // --- Status ---
                if (statusSelect && Array.isArray(data.statuses)) {
                    statusSelect.innerHTML = '<option value="">Pilih Status</option>';
                    data.statuses.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.name;
                        option.textContent = item.name;
                        statusSelect.appendChild(option);
                    });
                    setSelectByValue(statusSelect, currentStatus);
                }

                // --- Priority ---
                if (prioritySelect && Array.isArray(data.priorities)) {
                    prioritySelect.innerHTML = '<option value="">Pilih Priority</option>';
                    data.priorities.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.name;
                        option.textContent = item.name;
                        prioritySelect.appendChild(option);
                    });
                    setSelectByValue(prioritySelect, currentPriority);
                }

                // --- Escalation Unit ---
                if (escalationUnitSelect && Array.isArray(data.escalationUnits)) {
                    escalationUnitSelect.innerHTML = '<option value="">Pilih Unit</option>';
                    data.escalationUnits.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        escalationUnitSelect.appendChild(option);
                    });
                    setSelectByValue(escalationUnitSelect, currentEscalationId);
                }
            } else {
                const statusSelect = document.getElementById('detail-status-input');
                const prioritySelect = document.getElementById('detail-priority-input');
                const escalationUnitSelect = document.getElementById('detail-escalation-unit-input');

                setSelectByValue(statusSelect, currentStatus);
                setSelectByValue(prioritySelect, currentPriority);
                setSelectByValue(escalationUnitSelect, currentEscalationId);
            }
        } catch (error) {
            console.error('Error loadTicketMasterData:', error);
        }
    }

    function handleTicketClosedStatus(status) {
        const isClosed = (status || '').toLowerCase() === 'close'; // Pastikan 'closed' bukan 'close'

        if (isClosed) {
            const fields = document.querySelectorAll(
                '#addDetailDashboardForm input, #addDetailDashboardForm select, #addDetailDashboardForm textarea'
            );
            fields.forEach(field => field.setAttribute('disabled', 'disabled'));

            const submitButton = document.querySelector('#addDetailDashboardForm button[type="submit"]');
            if (submitButton) submitButton.style.display = 'none';

            if (!document.getElementById('alert-closed-ticket')) {
                const alert = document.createElement('div');
                alert.id = 'alert-closed-ticket';
                alert.className = 'alert alert-danger';
                alert.textContent = 'Tiket ini sudah CLOSED.';

                const form = document.getElementById('addDetailDashboardForm');
                if (form) form.insertBefore(alert, form.firstChild);
            }
        } else {
            const fields = document.querySelectorAll(
                '#addDetailDashboardForm input:not([readonly]), #addDetailDashboardForm select, #addDetailDashboardForm textarea'
            );
            fields.forEach(field => field.removeAttribute('disabled'));

            const submitButton = document.querySelector('#addDetailDashboardForm button[type="submit"]');
            if (submitButton) submitButton.style.display = '';

            const alert = document.getElementById('alert-closed-ticket');
            if (alert && alert.parentNode) alert.parentNode.removeChild(alert);
        }
    }

    // ===========================
    // LOAD ESCALATION UNITS (Layer 2)
    // ===========================
    // async function loadEscalationUnits(currentEscalationUnit) {
    //     try {
    //         const response = await fetch('/api/escalation-units'); // Sesuaikan endpoint
    //         const data = await response.json();

    //         const select = document.getElementById('detail-escalation-unit-input');
    //         select.innerHTML = '<option value="">Pilih Escalation Unit</option>';

    //         if (data.success && data.data) {
    //             data.data.forEach(unit => {
    //                 const option = document.createElement('option');
    //                 option.value = unit.id;
    //                 option.textContent = unit.name;
    //                 if (unit.id == currentEscalationUnit) {
    //                     option.selected = true;
    //                 }
    //                 select.appendChild(option);
    //             });
    //         }
    //     } catch (error) {
    //         console.error('Error loading escalation units:', error);
    //     }
    // }

    // ===========================
    // EVENT: STATUS CHANGE → AUTO DISABLE ESKALASI JIKA CLOSED
    // ===========================
    document.getElementById('detail-status-input').addEventListener('change', function() {
        const status = this.value.toLowerCase();
        const escalationSelect = document.getElementById('detail-escalation-input');
        if (!escalationSelect) return;

        if (escalationSelect.dataset.locked === '1') {
            escalationSelect.value = '0';
            escalationSelect.disabled = true;
            return;
        }

        if (status === 'closed') {
            escalationSelect.value = '0'; // Set No
            escalationSelect.disabled = true; // Disabled
        } else {
            escalationSelect.disabled = false; // Enable kembali
        }
    });

    // ===========================
    // ADD DETAIL MULTIPLE ATTACHMENT
    // ===========================

    let selectedFiles = []; // Array untuk menampung file

    // Handle saat user memilih file
    document.getElementById('attachments-input').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const maxSize = 25 * 1024 * 1024;

        files.forEach(file => {
            // Cek duplikasi nama file agar tidak double
            if (selectedFiles.some(f => f.name === file.name)) return;

            // Validasi ukuran
            if (file.size > maxSize) {
                Swal.fire('Error', `File "${file.name}" terlalu besar (Max 25MB)`, 'error');
                return;
            }

            selectedFiles.push(file);
        });

        renderFileList();
        this.value = ''; // Reset input agar bisa pilih file yang sama jika tadi dihapus
    });

    // Fungsi untuk menampilkan daftar file dengan tombol hapus
    function renderFileList() {
        const container = document.getElementById('file-list-container');
        container.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const div = document.createElement('div');
            div.className =
                "flex items-center bg-blue-900/40 text-blue-200 text-xs px-3 py-2 rounded-lg border border-blue-700/50 group";

            div.innerHTML = `
                <i class="fas fa-file-alt mr-2"></i>
                <span class="truncate max-w-[150px]">${file.name}</span>
                <button type="button" onclick="removeFile(${index})" class="ml-2 text-red-400 hover:text-red-300 transition-colors">
                    <i class="fas fa-times-circle"></i>
                </button>
            `;
            container.appendChild(div);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.js-view-payload-btn[data-flaging="4"]').forEach((button) => {
            const prefetch = () => prefetchEmailPayload(button.dataset.flaging, button.dataset.genesisnumber);

            button.addEventListener('mouseenter', prefetch, { once: true });
            button.addEventListener('focus', prefetch, { once: true });
            button.addEventListener('touchstart', prefetch, { once: true, passive: true });
        });
    });

    // Fungsi untuk menghapus file dari antrean
    function removeFile(index) {
        selectedFiles.splice(index, 1);
        renderFileList();
    }

    // ===========================
    // SUBMIT FORM ADD DETAIL
    // ===========================
    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function getSelectedText(selectEl) {
        if (!selectEl || !selectEl.options || selectEl.selectedIndex < 0) return '-';
        const option = selectEl.options[selectEl.selectedIndex];
        if (!option || !option.value) return '-';
        return option.text || option.value || '-';
    }

    function buildAddDetailPreviewHtml(preview) {
        const attachmentsHtml = preview.attachments.length ?
            `<ul class="list-disc pl-5 space-y-1">
                ${preview.attachments.map(name => `<li>${escapeHtml(name)}</li>`).join('')}
            </ul>` :
            `<span class="text-gray-400">-</span>`;

        return `
            <div class="text-left text-white space-y-3 text-sm">
                <div>
                    <span class="text-gray-400">Ticket Number:</span>
                    <span class="text-white font-semibold ml-1">${escapeHtml(preview.ticketNumber || '-')}</span>
                </div>
                <div>
                    <span class="text-gray-400">Nama Penginput:</span>
                    <span class="text-white font-semibold ml-1">${escapeHtml(preview.createdBy || '-')}</span>
                </div>
                <div>
                    <span class="text-gray-400">Note:</span>
                    <div class="mt-1 bg-gray-800 p-2 rounded whitespace-pre-wrap">${escapeHtml(preview.note || '-')}</div>
                </div>
                <div>
                    <span class="text-gray-400">Status:</span>
                    <span class="text-white font-semibold ml-1">${escapeHtml(preview.status || '-')}</span>
                </div>
                <div>
                    <span class="text-gray-400">Priority:</span>
                    <span class="text-white font-semibold ml-1">${escapeHtml(preview.priority || '-')}</span>
                </div>
                <div>
                    <span class="text-gray-400">Escalation Unit:</span>
                    <span class="text-white font-semibold ml-1">${escapeHtml(preview.escalationUnit || '-')}</span>
                </div>
                <div>
                    <span class="text-gray-400">Eskalasi ke Layer Berikutnya:</span>
                    <span class="text-white font-semibold ml-1">${escapeHtml(preview.escalation || '-')}</span>
                </div>
                <div>
                    <span class="text-gray-400">Attachments:</span>
                    <div class="mt-1">${attachmentsHtml}</div>
                </div>
            </div>
        `;
    }

    async function submitAddDetailForm(formEl) {
        const formData = new FormData(formEl);

        // Hapus attachments[] bawaan form agar tidak bentrok
        formData.delete('attachments[]');

        // Masukkan file dari array selectedFiles ke FormData
        selectedFiles.forEach(file => {
            formData.append('attachments[]', file);
        });

        try {
            const response = await fetch('/chat/v3/ticket/ticket-detail/add', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                Swal.fire('Success', result.message, 'success').then(() => {
                    selectedFiles = []; // Reset array
                    location.reload();
                });
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    document.getElementById('addDetailDashboardForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        const escalationUnitContainer = document.getElementById('detail-escalation-unit-container');
        const isEscalationUnitVisible = escalationUnitContainer &&
            escalationUnitContainer.style.display !== 'none';

        const previewData = {
            ticketNumber: window.currentAddDetailTicket?.ticket_number || '-',
            createdBy: document.getElementById('created_by_name')?.value?.trim() || '-',
            note: document.getElementById('detail-note-input')?.value?.trim() || '-',
            status: getSelectedText(document.getElementById('detail-status-input')),
            priority: getSelectedText(document.getElementById('detail-priority-input')),
            escalationUnit: isEscalationUnitVisible ?
                getSelectedText(document.getElementById('detail-escalation-unit-input')) :
                '-',
            escalation: getSelectedText(document.getElementById('detail-escalation-input')),
            attachments: selectedFiles.map(file => file.name)
        };

        const previewResult = await Swal.fire({
            title: 'Anda akan follow up:',
            html: buildAddDetailPreviewHtml(previewData),
            showCancelButton: true,
            confirmButtonText: 'Lanjut Submit',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'preview-followup-modal',
                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white',
                cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white'
            }
        });

        if (!previewResult.isConfirmed) return;

        const confirmResult = await Swal.fire({
            title: 'Konfirmasi Submit',
            text: 'Anda yakin? Detail ticket yang sudah disimpan tidak bisa diubah.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280'
        });

        if (!confirmResult.isConfirmed) return;

        await submitAddDetailForm(this);
    });
    // document.getElementById('addDetailDashboardForm').addEventListener('submit', async function (e) {
    //     e.preventDefault();

    //     const formData = new FormData(this);
    //     const data = Object.fromEntries(formData.entries());

    //     try {
    //         const response = await fetch('/chat/v3/ticket/ticket-detail/add', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    //             },
    //             body: JSON.stringify(data)
    //         });

    //         const result = await response.json();

    //         if (result.success) {
    //             Swal.fire('Success', result.message, 'success').then(() => {
    //                 location.reload(); // Reload page
    //             });
    //         } else {
    //             Swal.fire('Error', result.message, 'error');
    //         }
    //     } catch (error) {
    //         console.error('Error submitting detail:', error);
    //         Swal.fire('Error', 'Terjadi kesalahan saat menyimpan detail', 'error');
    //     }
    // });


    // Function untuk open modal SLA management
    function openSlaManagementModal(ticketId, ticketNumber) {
        $('#apply-sla-ticket-id').val(ticketId);
        $('#apply-sla-ticket-number').text(ticketNumber);

        // Apply view-only mode for L3/L4
        setSlaViewOnlyState();

        // Load current SLA status
        loadCurrentSla(ticketId);

        // Load available extensions
        loadAvailableExtensions(ticketId);

        // Load history
        loadSlaHistory(ticketId);

        $('#applySlaExtensionModal').modal('show');
    }

    function setSlaViewOnlyState() {
        if (!window.isSlaViewOnly) {
            return;
        }

        $('#sla-view-only-alert').removeClass('d-none');

        // Disable all inputs and buttons in SLA forms
        $('#problem-extension-form input, #problem-extension-form textarea, #problem-extension-form button')
            .prop('disabled', true);
        $('#custom-sla-form input, #custom-sla-form textarea, #custom-sla-form button')
            .prop('disabled', true);
        $('#reopen-sla-form input, #reopen-sla-form textarea, #reopen-sla-form button')
            .prop('disabled', true);

        // Hide inline form for extensions
        $('#problem-extension-form-container').hide();
    }

    // Load current SLA status
    function loadCurrentSla(ticketId) {
        $.ajax({
            url: `/tickets/${ticketId}/sla/calculate`,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                $('#current-base-sla').text(formatDays(data.base_sla_days));
                $('#current-effective-sla').text(data.formatted);
                $('#current-extended').text(formatDays(data.extended_days) + ' extended');

                if (data.is_unlimited) {
                    $('#current-effective-sla').html('<span class="badge bg-warning">Unlimited</span>');
                }
            }
        });
    }

    // Load available extensions
    function loadAvailableExtensions(ticketId) {
        $.ajax({
            url: `/tickets/${ticketId}/sla/available-extensions`,
            type: 'GET',
            success: function(response) {
                renderAvailableExtensions(response.data.available);
            },
            error: function(xhr) {
                $('#available-extensions-container').html(
                    '<div class="alert alert-warning">Tidak ada extension tersedia atau ticket tidak memiliki problem terkait</div>'
                );
            }
        });
    }

    // Render available extensions
    function renderAvailableExtensions(extensions) {
        const container = $('#available-extensions-container');
        container.empty();

        // Reset and hide the form when loading new extensions
        cancelExtensionForm();

        if (extensions.length === 0) {
            container.html(
                '<div class="alert alert-info">Semua extension sudah digunakan atau tidak ada extension untuk problem ini</div>'
            );
            return;
        }

        extensions.forEach(ext => {
            const actionButton = window.isSlaViewOnly
                ? `<button class="btn btn-secondary btn-sm" disabled title="View only">View Only</button>`
                : `<button class="btn btn-primary btn-sm" onclick="showExtensionForm(${ext.id}, ${ext.extension_level}, '${ext.formatted_sla}')">
                        <i class="fa fa-plus mr-1"></i>Apply
                    </button>`;

            container.append(`
                <div class="card bg-gray-700 mb-2" id="extension-card-${ext.id}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-1">Extension Level ${ext.extension_level}</h6>
                                <p class="text-muted mb-0">+${ext.formatted_sla}</p>
                                ${ext.description ? `<small class="text-muted">${ext.description}</small>` : ''}
                            </div>
                            ${actionButton}
                        </div>
                    </div>
                </div>
            `);
        });
    }

    // Show extension form (inline, not SweetAlert)
    function showExtensionForm(extensionId, extensionLevel, formattedSla) {
        if (window.isSlaViewOnly) {
            return;
        }

        // Set selected extension info
        $('#selected-extension-id').val(extensionId);
        $('#selected-extension-level').text(extensionLevel);
        $('#selected-extension-days').text('+' + formattedSla);

        // Clear previous form values
        $('#extension-agent-name').val('');
        $('#extension-reason').val('');

        // Show the form container
        $('#problem-extension-form-container').slideDown();

        // Scroll to form
        $('#problem-extension-form-container')[0].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });

        // Focus on agent name input
        setTimeout(() => $('#extension-agent-name').focus(), 300);
    }

    // Cancel/hide extension form
    function cancelExtensionForm() {
        $('#problem-extension-form-container').slideUp();
        $('#selected-extension-id').val('');
        $('#selected-extension-level').text('');
        $('#extension-agent-name').val('');
        $('#extension-reason').val('');
    }

    // Handle problem extension form submit
    $('#problem-extension-form').submit(function(e) {
        e.preventDefault();

        if (window.isSlaViewOnly) {
            Swal.fire('Info', 'Mode view-only. Anda tidak dapat apply extension.', 'info');
            return;
        }

        const ticketId = $('#apply-sla-ticket-id').val();
        const extensionId = $('#selected-extension-id').val();
        const agentName = $('#extension-agent-name').val().trim();
        const reason = $('#extension-reason').val().trim();

        if (!agentName) {
            Swal.fire('Error', 'Nama agent wajib diisi!', 'error');
            return;
        }
        if (!reason) {
            Swal.fire('Error', 'Alasan wajib diisi!', 'error');
            return;
        }

        $.ajax({
            url: `/tickets/${ticketId}/sla/apply-problem-extension`,
            type: 'POST',
            data: JSON.stringify({
                problem_sla_extension_id: extensionId,
                agent_name: agentName,
                reason: reason
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire('Berhasil', response.message, 'success');
                cancelExtensionForm();
                loadCurrentSla(ticketId);
                loadAvailableExtensions(ticketId);
                loadSlaHistory(ticketId);
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Gagal apply extension', 'error');
            }
        });
    });

    // Submit Re-Open form
    $('#reopen-sla-form').submit(function(e) {
        e.preventDefault();

        if (window.isSlaViewOnly) {
            Swal.fire('Info', 'Mode view-only. Anda tidak dapat apply Re-Open.', 'info');
            return;
        }

        const ticketId = $('#apply-sla-ticket-id').val();
        const name = $('#reopen-name').val();
        const slaDays = $('#reopen-sla-days').val();
        const reason = $('#reopen-reason').val();

        $.ajax({
            url: `/tickets/${ticketId}/sla/apply-reopen`,
            type: 'POST',
            data: JSON.stringify({
                name: name,
                sla_days: parseInt(slaDays),
                reason: reason
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire('Berhasil', response.message, 'success');
                $('#reopen-sla-form')[0].reset();
                loadCurrentSla(ticketId);
                loadSlaHistory(ticketId);
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Gagal apply Re-Open', 'error');
            }
        });
    });

    // Toggle unlimited SLA
    $('#unlimited-sla-check').change(function() {
        if ($(this).is(':checked')) {
            $('#custom-sla-input-group').hide();
            $('#custom-sla-days').prop('required', false);
        } else {
            $('#custom-sla-input-group').show();
            $('#custom-sla-days').prop('required', true);
        }
    });

    // Submit custom SLA
    $('#custom-sla-form').submit(function(e) {
        e.preventDefault();

        if (window.isSlaViewOnly) {
            Swal.fire('Info', 'Mode view-only. Anda tidak dapat apply custom SLA.', 'info');
            return;
        }

        const ticketId = $('#apply-sla-ticket-id').val();
        const isUnlimited = $('#unlimited-sla-check').is(':checked');
        // const customMinutes = $('#custom-sla-minutes').val();
        const customDays = $('#custom-sla-days').val();
        const reason = $('#custom-sla-reason').val();

        $.ajax({
            url: `/tickets/${ticketId}/sla/apply-custom`,
            type: 'POST',
            data: JSON.stringify({
                is_unlimited: isUnlimited,
                // custom_sla_minutes: isUnlimited ? null : parseInt(customMinutes),
                custom_sla_days: isUnlimited ? null : parseInt(customDays),
                reason: reason
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire('Berhasil', response.message, 'success');
                $('#custom-sla-form')[0].reset();
                loadCurrentSla(ticketId);
                loadSlaHistory(ticketId);
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Gagal apply custom SLA', 'error');
            }
        });
    });

    // Load SLA history
    function loadSlaHistory(ticketId) {
        $.ajax({
            url: `/tickets/${ticketId}/sla/history`,
            type: 'GET',
            success: function(response) {
                renderSlaHistory(response.data);
            }
        });
    }

    let isCardFilterSubmit = false;

    function setCardBypassDate() {
        const cardAllDateInput = document.getElementById('cardAllDateInput');
        if (cardAllDateInput) {
            cardAllDateInput.value = '1';
        }

        const dateFromInput = document.querySelector('input[name="date_from"]');
        const dateToInput = document.querySelector('input[name="date_to"]');
        if (dateFromInput) dateFromInput.value = '';
        if (dateToInput) dateToInput.value = '';
    }

    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function() {
            if (isCardFilterSubmit) {
                isCardFilterSubmit = false;
                return;
            }

            const cardAllDateInput = document.getElementById('cardAllDateInput');
            if (cardAllDateInput) {
                cardAllDateInput.value = '';
            }
        });
    }

    function goToTicketSLA(type) {
        // Set nilai pada input hidden
        document.getElementById('slaFilterInput').value = type;

        // Reset filter card lain agar tidak aktif bersamaan
        document.getElementById('activelayerFilterInput').value = '';
        isCardFilterSubmit = true;
        setCardBypassDate();

        // Submit form filter secara otomatis
        document.getElementById('filterForm').submit();
    }

    function goToTicketReply(type) {
        // Reset filter card lain agar tidak aktif bersamaan
        document.getElementById('slaFilterInput').value = '';

        // Set nilai pada input hidden
        document.getElementById('activelayerFilterInput').value = type;
        isCardFilterSubmit = true;
        setCardBypassDate();

        // Submit form filter secara otomatis
        document.getElementById('filterForm').submit();
    }

    function goToTicketStatus(status) {
        // Reset filter card lain agar tidak aktif bersamaan
        document.getElementById('slaFilterInput').value = '';
        document.getElementById('activelayerFilterInput').value = '';
        isCardFilterSubmit = true;
        setCardBypassDate();

        const statusSelect = document.querySelector('select[name="status"]');
        if (statusSelect) {
            statusSelect.value = status;
        }

        // Submit form filter secara otomatis
        document.getElementById('filterForm').submit();
    }

    // Render SLA history
    function renderSlaHistory(history) {
        const tbody = $('#sla-history-tbody');
        tbody.empty();

        if (history.length === 0) {
            tbody.append('<tr><td colspan="5" class="text-center">Belum ada history</td></tr>');
            return;
        }

        history.forEach(h => {
            const action = (h.action || '').toLowerCase();
            let badgeClass = 'bg-secondary';
            if (action === 'extended') badgeClass = 'bg-info';
            if (action === 'status_changed') badgeClass = 'bg-warning';
            if (action === 'closed') badgeClass = 'bg-danger';
            if (action === 'reopened') badgeClass = 'bg-success';

            const transitionText = h.old_status && h.new_status ?
                ` (${h.old_status} → ${h.new_status})` :
                '';
            const type = `<span class="badge ${badgeClass}">${h.action_label || h.action || '-'}${transitionText}</span>`;
            const timeValue = h.extended_at ? new Date(h.extended_at).toLocaleString('id-ID') : '-';

            tbody.append(`
                <tr>
                    <td>${timeValue}</td>
                    <td>${type}</td>
                    <td>${h.formatted_sla_added || '-'}</td>
                    <td>${h.actor_name || '-'}</td>
                    <td>${h.reason || h.trigger_source || '-'}</td>
                </tr>
            `);
        });
    }

    // function formatMinutes(minutes) {
    //     if (!minutes) return '0 menit';
    //     if (minutes < 60) return minutes + ' menit';
    //     if (minutes < 1440) return (minutes / 60).toFixed(1) + ' jam';
    //     return (minutes / 1440).toFixed(1) + ' hari';
    // }
    function formatDays(days) {
        if (!days) return '0 hari';
        if (days < 1) return days + ' hari';
        if (days == 1) return '1 hari';
        return days + ' hari';
    }
</script>
