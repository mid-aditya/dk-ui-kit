<x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
    with-header="{{ request()->get('with-header') ?? 1 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">

    <style>
        /* ===================== */
        /* DARK PAGINATION FIX */
        /* ===================== */

        /* Normal page link */
        .pagination .page-link {
            background-color: #1f2937 !important;   /* gray-800 */
            color: #ffffff !important;
            border-color: #374151 !important;       /* gray-700 */
        }

        /* Hover tetap dark */
        .pagination .page-link:hover {
            background-color: #374151 !important;   /* gray-700 */
            color: #ffffff !important;
        }

        /* Active page */
        .pagination .page-item.active .page-link {
            background-color: #0d6efd !important;   /* primary */
            border-color: #0d6efd !important;
            color: #ffffff !important;
        }

        /* ✅ DISABLED tetap DARK (Prev, Next, dan "...") */
        .pagination .page-item.disabled .page-link,
        .pagination .page-item.disabled span {
            background-color: #111827 !important;   /* gray-900 */
            color: #9ca3af !important;              /* gray-400 */
            border-color: #1f2937 !important;
            cursor: not-allowed !important;
            opacity: 1 !important;
        }

        /* ✅ Hilangkan hover putih saat disabled */
        .pagination .page-item.disabled .page-link:hover {
            background-color: #111827 !important;
            color: #9ca3af !important;
        }

    </style>


    <!-- Header Section -->
    {{-- <div class="mb-8 mt-8 ml-3">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fa fa-ticket text-blue-500 mr-3 text-4xl"></i>
                    Ticketing
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
    </div> --}}
    <!-- Voice Call Component (Inline) -->
    <!-- <div id="incomingCallNotification" class="hidden fixed top-4 right-4 bg-white/90 backdrop-blur-xl border border-gray-300 shadow-2xl rounded-xl w-80 p-4 z-[99999] pointer-events-auto" style="animation: fade-in-down 0.4s ease-out both;">
        <div class="flex flex-col items-center text-center space-y-3">
            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center ring-4 ring-blue-300 animate-pulse">
                <i class="fas fa-phone-alt text-blue-500 text-xl animate-bounce"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Panggilan Masuk</h3>
                <p id="callerName" class="text-gray-700 font-semibold text-sm">Memuat...</p>
                <p id="callerNumber" class="text-gray-500 text-xs"></p>
            </div>
        </div>
        <div class="flex justify-center">
            <button onclick="acceptCall()" class="w-full py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-md transition-all text-sm">Terima</button>
        </div>
    </div> -->

    <!-- Active Voice Call -->
    <div id="voiceCallPopup" class="hidden fixed top-4 right-4 bg-white/90 backdrop-blur-xl border border-gray-300 shadow-2xl rounded-xl w-80 p-4 z-[99999] pointer-events-auto" style="animation: fade-in-down 0.4s ease-out both;">
        <div class="flex items-center space-x-3 mb-3">
            <img id="activeCallerAvatar" src="{{ asset('assets/images/users/avatar-1.jpg') }}" class="w-12 h-12 rounded-full ring-2 ring-green-400 object-cover">
            <div>
                <h4 id="activeCallerName" class="text-base font-bold text-gray-800">Memuat...</h4>
                <p id="activeCallerNumber" class="text-xs text-gray-600"></p>
                <div id="callTimer" class="text-green-600 text-xs mt-1 flex items-center space-x-1">
                    <i class="fas fa-clock"></i><span>00:00</span>
                </div>
            </div>
        </div>

        <div class="p-3 bg-gray-100 rounded-lg">
            <div class="space-y-2 text-xs text-gray-600">
                <div class="flex items-center">
                    <i class="far fa-envelope w-4"></i>
                    <span id="userEmail" class="ml-2">N/A</span>
                </div>
                <div class="flex items-center">
                    <i class="far fa-building w-4"></i>
                    <span id="userAddress" class="ml-2">N/A</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-2 mt-3">
            <button id="muteButton" onclick="toggleMute()" class="rounded-lg bg-gray-200 hover:bg-gray-300 p-2 text-gray-700">
                <i class="fas fa-microphone"></i>
            </button>
            <button id="speakerButton" onclick="toggleSpeaker()" class="rounded-lg bg-gray-200 hover:bg-gray-300 p-2 text-gray-700">
                <i class="fas fa-volume-up"></i>
            </button>
            <button id="holdButton" onclick="toggleHold()" class="rounded-lg bg-yellow-200 hover:bg-yellow-300 p-2 text-yellow-800">
                <i class="fas fa-pause"></i>
            </button>
            <button id="endButton" onclick="endCall()" class="rounded-lg bg-red-500 hover:bg-red-600 text-white p-2">
                <i class="fas fa-phone-slash"></i>
            </button>
        </div>
    </div>

    <style>
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        #incomingCallNotification, #voiceCallPopup {
            cursor: move;
            pointer-events: auto;
        }
    </style>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-2 bg-gray-800 p-2 rounded-xl h-[calc(100vh-3rem)] overflow-hidden">
        <!-- Profile Section -->
        <div class="lg:col-span-3">
            <div class="card bg-gray-900 border-0 mb-0 rounded-xl shadow-lg overflow-y-auto backdrop-blur-sm p-4 h-[calc(100vh-4rem)]">

                <!-- Header -->
                <div class="card-header bg-gray-900 rounded-t-xl border-0 p-4">
                    <h5 class="card-title mb-0 text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Profile
                    </h5>
                </div>

                <!-- Profile Container -->
                <div class="p-4 space-y-4 flex flex-col">

                    <!-- Profile Info -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="avatar-sm me-2 bg-gray-900 rounded-full p-0.5 ring-2 ring-blue-400" style="width: 48px; height: 48px; overflow: hidden; border-radius: 50%;">
                                <img src="${message_pict}" alt="Profile Image" class="w-full h-full object-cover" id="Profile_Image" onerror="this.onerror=null; this.src='/assets/images/users/Profile.png';">
                            </div>
                            <div class="text-truncate">
                                <h6 class="mb-0 font-size-14 text-white text-truncate" id="Profile_Nama" style="max-width: 150px;">
                                    Nama Pengguna
                                </h6>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a class="btn btn-link text-white font-size-12 p-0 dropdown-toggle shadow-none group" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fas fa-ellipsis-h group-hover:text-blue-400 transition-colors"></i>
                            </a>
                            <ul class="dropdown-menu bg-gray-900 border-0 dropdown-menu-end rounded-lg shadow-lg">
                                <li id="addCustomerButton" >
                                    <a class="dropdown-item text-white hover:bg-gray-700" href="#" id="Btn_AddCustomer" data-bs-toggle="modal" data-bs-target="#addCustomerBC">
                                        <i class="fa fa-plus-circle mr-2 text-blue-400"></i> Add PIC
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-white hover:bg-gray-700" href="#" id="Btn_FindPIC" data-bs-toggle="modal" data-bs-target="#findPICModal">
                                        <i class="fa fa-search mr-2 text-green-400"></i> Find PIC
                                    </a>
                                </li>
                                <li id="editCustomerButton" style="display: none;">
                                    <a class="dropdown-item text-white hover:bg-gray-700" href="#" id="Btn_EditCustomer" data-bs-toggle="modal" data-bs-target="#editCustomerBC">
                                        <i class="fa fa-edit mr-2 text-blue-400"></i> Edit PIC
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="card bg-gray-900 p-2 border-0 rounded-b-xl">
                        <div class="card-body bg-gray-800/50 border-0 rounded-lg backdrop-blur-sm">
                            <ul class="list-unstyled mb-0 space-y-4">
                                <li class="pb-2">
                                    <div class="d-flex align-items-center transform transition-all hover:translate-x-1">
                                        <div class="font-size-20 text-primary flex-shrink-0 me-3 bg-blue-500/10 rounded-full p-2">
                                            <i class="fas fa-phone-alt text-blue-400"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-white mb-1 font-size-13 opacity-70">No. Telepon</p>
                                            <h5 class="mb-0 font-size-14 font-semibold" id="Profile_NomorTelepon"></h5>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-2">
                                    <div class="d-flex align-items-center transform transition-all hover:translate-x-1">
                                        <div class="font-size-20 text-primary flex-shrink-0 me-3 bg-blue-500/10 rounded-full p-2">
                                            <i class="far fa-envelope text-blue-400"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-white mb-1 font-size-13 opacity-70">Email</p>
                                            <h5 class="mb-0 font-size-14 font-semibold" id="Profile_Email"></h5>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-2">
                                    <div class="d-flex align-items-center transform transition-all hover:translate-x-1">
                                        <div class="font-size-20 text-primary flex-shrink-0 me-3 bg-blue-500/10 rounded-full p-2">
                                            <i class="fa fa-home text-blue-400"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-white mb-1 font-size-13 opacity-70">Alamat</p>
                                            <h5 class="mb-0 font-size-14 font-semibold" id="Profile_Address"></h5>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card bg-gray-900 p-2 border-0 rounded-b-xl">
                        <div class="card-body bg-gray-800/50 border-0 rounded-lg backdrop-blur-sm">
                            <ul class="list-unstyled mb-0 space-y-4">
                                <li class="pb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="font-size-20 text-primary flex-shrink-0 me-3 bg-blue-500/10 rounded-full p-2">
                                            <i class="fas fa-university text-blue-400"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-white mb-1 font-size-13 opacity-70">Nama Perusahaan</p>
                                            <h5 class="mb-0 font-size-14 font-semibold" id="nama_perusahaan"></h5>
                                        </div>
                                        <div class="dropdown">
                                            <a class="btn btn-link text-white font-size-12 p-0 dropdown-toggle shadow-none group" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fas fa-ellipsis-h group-hover:text-blue-400 transition-colors"></i>
                                            </a>
                                            <ul class="dropdown-menu bg-gray-900 border-0 dropdown-menu-end rounded-lg shadow-lg">
                                                <li id="addPerusahaanButton" >
                                                    <a class="dropdown-item text-white hover:bg-gray-700" href="#" id="Btn_AddCustomerPerusahaan" data-bs-toggle="modal" data-bs-target="#addCustomerPerusahaan">
                                                        <i class="fa fa-plus-circle mr-2 text-blue-400"></i> Add Perusahaan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-white hover:bg-gray-700" href="#" id="Btn_FindCustomer" data-bs-toggle="modal" data-bs-target="#findCustomerModal">
                                                        <i class="fa fa-search mr-2 text-green-400"></i> Find Perusahaan
                                                    </a>
                                                </li>
                                                <li id="editPerusahaanButton" style="display: none;">
                                                    <a class="dropdown-item text-white hover:bg-gray-700" href="#" id="Btn_EditCustomerPerusahaan" data-bs-toggle="modal" data-bs-target="#editCustomerPerusahaan">
                                                        <i class="fa fa-edit mr-2 text-blue-400"></i> Edit Perusahaan
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-2">
                                    <div class="d-flex align-items-center transform transition-all hover:translate-x-1">
                                        <div class="font-size-20 text-primary flex-shrink-0 me-3 bg-blue-500/10 rounded-full p-2">
                                            <i class="far fa-envelope text-blue-400"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-white mb-1 font-size-13 opacity-70">Email</p>
                                            <h5 class="mb-0 font-size-14 font-semibold" id="email_perusahaan"></h5>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-2">
                                    <div class="d-flex align-items-center transform transition-all hover:translate-x-1">
                                        <div class="font-size-20 text-primary flex-shrink-0 me-3 bg-blue-500/10 rounded-full p-2">
                                            <i class="fas fa-phone-alt text-blue-400"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-white mb-1 font-size-13 opacity-70">No. Telepon</p>
                                            <h5 class="mb-0 font-size-14 font-semibold" id="phone_perusahaan"></h5>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Ticket Form Section -->
        <div class="lg:col-span-5">
            <div class="w-100 h-full">
                <div class="card bg-gray-900 border-0 mb-0 rounded-xl shadow-lg overflow-y-auto backdrop-blur-sm p-4 h-[calc(100vh-4rem)]">
                    <input type="hidden" id="ticket_user_id" name="chat_ticket_user_id">
                    <input type="hidden" id="inicallid" name="GenesisNumber">
                    <input type="hidden" id="article-id-field" name="km_article_id" value="">
                    <input type="hidden" name="flaging" value="1">
                    <input type="hidden" id="thread_id" value="">

                    <input type="hidden" id="hidden_full_name" name="hidden_full_name">
                    <input type="hidden" id="hidden_contact_number" name="hidden_contact_number">
                    <input type="hidden" id="hidden_email" name="hidden_email">
                    {{-- <!-- Category -->
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label flex items-center text-blue-400 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                                </svg>
                                Category Ticket <span class="text-rose-500 ml-1">*</span>
                            </label>
                            <select name="kategori"
                                class="form-control bg-gray-800/50 text-white border-0 focus:bg-gray-800/50 rounded-lg h-11 focus:ring-2 focus:ring-blue-500"
                                id="Form_Ticket_Kategori"
                                required>
                                <option value="" selected>Select Category</option>
                                @foreach ($chat_ticket_categories as $chat_ticket_category)
                                <option
                                    value="{{ $chat_ticket_category->name }}"
                                    data-id="{{ $chat_ticket_category->id }}">
                                    {{ $chat_ticket_category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Sub Category -->
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label flex items-center text-blue-400 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                </svg>
                                Sub Category Ticket <span class="text-rose-500 ml-1">*</span>
                            </label>
                            <select name="subkategori"
                                id="Form_Ticket_SubKategori"
                                class="form-select bg-gray-800/50 text-white border-0 focus:bg-gray-800/50 rounded-lg h-11 focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div> --}}





                    <x-ticket-form />
                    {{-- <form id="FormTicket" method="POST" action="/ticketing/ticket/create" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card bg-gray-900 border-0">
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <input type="hidden" id="ticket_user_id" name="ticket_user_id" value="">
                                                <!-- Agent Name -->
                                                <div class="col-12">
                                                    <div class="mb-4">
                                                        <label for="Form_Ticket_Agent_Name" class="form-label flex items-center text-blue-400 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                                            </svg>
                                                            Agent Name <span class="text-rose-500 ml-1">*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control !bg-gray-800/50 text-white border-0 focus:bg-gray-800/50 rounded-lg h-11 focus:ring-2 focus:ring-blue-500 px-3"
                                                            placeholder="Enter Name"
                                                            id="Form_Ticket_Agent_Name"
                                                            disabled="disabled"
                                                            value="{{ current_agent()->name }}">
                                                    </div>
                                                </div>



                                                <!-- Status -->
                                                <div class="col-12">
                                                    <div class="mb-4">
                                                        <label class="form-label flex items-center text-blue-400 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                            </svg>
                                                            Status <span class="text-rose-500 ml-1">*</span>
                                                        </label>
                                                        <select name="status"
                                                            class="form-control bg-gray-800/50 text-white border-0 focus:bg-gray-800/50 rounded-lg h-11 focus:ring-2 focus:ring-blue-500"
                                                            id="Form_Ticket_Status"
                                                            required>
                                                            <option value="" selected>Select Ticket Status</option>
                                                            @foreach ($chat_ticket_statuses as $chat_ticket_status)
                                                            <option value="{{ $chat_ticket_status->name }}">
                                                                {{ $chat_ticket_status->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Source Type -->
                                                <div class="col-12">
                                                    <div class="mb-4">
                                                        <label class="form-label flex items-center text-blue-400 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                                                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                                                            </svg>
                                                            Source Type <span class="text-rose-500 ml-1">*</span>
                                                        </label>
                                                        <select name="source_type"
                                                            class="form-control bg-gray-800/50 text-white border-0 focus:bg-gray-800/50 rounded-lg h-11 focus:ring-2 focus:ring-blue-500"
                                                            id="Form_Ticket_Source_Type"
                                                            required>
                                                            <option value="" selected>Select Source Type</option>
                                                            <option value="email">Email</option>
                                                            <option value="phone">Phone</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-gray-900 border-0">
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <!-- Subject -->
                                                <div class="col-12">
                                                    <div class="mb-4">
                                                        <label class="form-label flex items-center text-blue-400 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd" />
                                                            </svg>
                                                            Subject <span class="text-rose-500 ml-1">*</span>
                                                        </label>
                                                        <input type="text"
                                                            name="subject"
                                                            class="form-control bg-gray-800/50 text-white border-0 focus:bg-gray-800/50 rounded-lg h-11 focus:ring-2 focus:ring-blue-500"
                                                            id="Form_Ticket_Subject"
                                                            placeholder="Subject"
                                                            required>
                                                    </div>
                                                </div>


                                            </div>

                                            <!-- Pertanyaan -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-4">
                                                        <label class="form-label flex items-center text-blue-400 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                            </svg>
                                                            Pertanyaan <span class="text-rose-500 ml-1">*</span>
                                                        </label>
                                                        <textarea name="question"
                                                            id="Ticket_Complaints"
                                                            class="form-control bg-gray-800/50 text-white border-0 focus:bg-gray-800/50 rounded-lg resize-none focus:ring-2 focus:ring-blue-500"
                                                            rows="5"
                                                            placeholder="Pertanyaan..*"
                                                            required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Jawaban -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-4">
                                                        <label class="form-label flex items-center text-blue-400 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                            </svg>
                                                            Jawaban <span class="text-rose-500 ml-1">*</span>
                                                        </label>
                                                        <textarea name="answer"
                                                            id="Ticket_NoteAgent"
                                                            class="form-control bg-gray-800/50 text-white border-0 focus:bg-gray-800/50 rounded-lg resize-none focus:ring-2 focus:ring-blue-500"
                                                            rows="5"
                                                            placeholder="Jawaban..*"
                                                            required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- File Upload -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="relative group">
                                                        <label class="form-label flex items-center text-blue-400 font-medium mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                            </svg>
                                                            Attachments
                                                        </label>

                                                        <!-- Input File yang Disembunyikan -->
                                                        <input type="file" id="file-bc" name="files[]" hidden multiple onchange="updateFileName()">

                                                        <!-- Button Pilih File -->
                                                        <div class="flex items-center space-x-3">
                                                            <button type="button" onclick="document.getElementById('file-bc').click()"
                                                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all">
                                                                Pilih File
                                                            </button>

                                                            <!-- Area untuk Menampilkan Nama File -->
                                                            <span id="file-name" class="text-white opacity-70 text-sm">Tidak ada file dipilih</span>
                                                        </div>

                                                        <!-- Efek Hover -->
                                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 opacity-0 group-hover:opacity-5 rounded-lg pointer-events-none transition-opacity duration-300"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Save Button -->
                                            <div class="mt-4">
                                                <div class="text-end" id="buttonEndChat">
                                                    <button type="submit" class="btn btn-soft-primary w-sm group relative overflow-hidden rounded-lg px-6 py-2" id="buttonEndChatAction">
                                                        <span class="absolute inset-0 w-full h-full transition duration-300 ease-out opacity-0 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 group-hover:opacity-100"></span>
                                                        <span class="relative flex items-center justify-center">
                                                            <i class="fa fa-save mr-2"></i>Save & Closed
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form> --}}
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="lg:col-span-4">
            <div class="card bg-gray-900 border-0 mb-0 rounded-xl shadow-lg overflow-y-auto overflow-x-hidden backdrop-blur-sm p-4 h-[calc(100vh-4rem)]">
                <div id="article-detail-card" class="fixed inset-y-0 right-0 z-[100] transform translate-x-full transition-transform duration-300 ease-in-out bg-gray-900 backdrop-blur-sm w-full h-[calc(100vh-4rem)] overflow-y-auto shadow-2xl">
                    <div class="p-4 bg-gray-900 flex items-center justify-between border-b border-gray-700">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                            Detail Artikel
                        </h3>
                        <button onclick="hideArticleDetail()" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6">
                        <h2 id="article-title" class="text-2xl font-bold text-white mb-4"></h2>
                        <div id="article-content" class="text-gray-300 leading-relaxed ck-content mb-4"></div>
                        <a id="article-file" href="#" target="_blank" class="text-blue-400 hover:text-blue-500 hover:underline inline-flex items-center space-x-2 hidden">
                            <i class="fas fa-download"></i>
                            <span>Lihat Dokumen</span>
                        </a>
                    </div>
                </div>
                <div class="card-header bg-gray-900 border-0">
                    <ul class="nav rounded-top bg-gray-800 nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#history-ticket-list" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-history"></i></span>
                                <span class="d-none d-sm-block">History</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#related-articles" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-book-open"></i></span>
                                <span class="d-none d-sm-block">Knowledge Base</span>
                            </a>
                        </li>
                        @if(false)
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#data-infomed" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-book-open"></i></span>
                                <span class="d-none d-sm-block">Infomed</span>
                            </a>
                        </li>
                        @endif
                        {{--
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Knowledge-Base" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-brain"></i></span>
                                <span class="d-none d-sm-block">Knowledge Base</span>
                            </a>
                        </li>
                        --}}
                    </ul>
                </div>
                <div class="tab-content rounded-bottom overflow-hidden h-full bg-gray-900 p-2 text-muted">
                    <div class="tab-pane h-full overflow-y-auto overflow-x-hidden active show" id="history-ticket-list" role="tabpanel">
                        <div id="Div_CustomerHistory"
                        class="row"
                        style="height: 300px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #4B5563 #1F2937;">
                        <div class="px-4 py-2">
                            <ul class="list-unstyled chat-list"
                                id="history-ticket-list">
                                <!-- History items will be dynamically added here -->
                            </ul>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane h-full overflow-hidden" id="related-articles" role="tabpanel">
                        <x-ai-kb-chat
                            component-id="ticketingAiKb"
                            source-page="ticketing"
                            title="Knowledge Base"
                            empty-state="Tulis pertanyaan di bawah untuk memulai percakapan baru dengan AHU AI."
                        />
                    </div>
                    @if(false)
                    <div class="tab-pane h-full overflow-hidden" id="data-infomed" role="tabpanel">
                        <div class="card h-full bg-gray-900 border-0 rounded-xl shadow-lg overflow-hidden transform transition-all hover:shadow-blue-900/30 hover:shadow-xl backdrop-blur-sm">
                            <div class="card-header bg-gray-900 border-0 flex items-center justify-between">
                                <h5 class="card-title mb-0 text-white flex items-center">
                                    <i class="fas fa-book-open mr-2 text-blue-400"></i>
                                    History Ticket Infomedia
                                </h5>
                                {{-- <span class="badge bg-purple-500 text-white px-2 py-1 text-xs rounded-full">Knowledge Base</span> --}}
                            </div>
                            <div class="card-body p-4">
                                <div id="infomed-container-id" class="space-y-4 h-[calc(100vh-18rem)] overflow-y-auto">
                                    <p class="text-gray-400">Berikut History Ticket Perusahaan terkait.</p>
                                    <x-history-infomed />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    {{--
                    <div class="tab-pane h-full overflow-y-auto overflow-x-hidden" id="Knowledge-Base" role="tabpanel">
                        <div class="row">
                            <div class="col-12 h-[calc(100vh-12rem)] overflow-y-auto overflow-x-hidden" data-simplebar>
                                <div class="card bg-gray-900 border-0">
                                    <div class="card-body">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="text-white mb-2">Cari Knowledge Base</label>
                                                    <div class="flex gap-2">
                                                        <input
                                                            type="text"
                                                            id="kb-query"
                                                            class="form-control"
                                                            placeholder="Masukkan pertanyaan..."
                                                        >
                                                        <button id="kb-search" class="btn btn-primary">
                                                            Cari
                                                        </button>
                                                    </div>
                                                </div>

                                                <div id="kb-result" class="mt-3 text-white"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Find PIC Modal -->
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="findPICModal" tabindex="-1" aria-labelledby="findPICModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-gray-700 border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="findPICModalLabel">
                        <i class="fa fa-search mr-2"></i> Find Customer
                    </h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card bg-gray-900 border-0 rounded-0">
                    <div class="card-body">
                        <!-- Search Input -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="findPICSearchInput"
                                        placeholder="Search by name, email, or phone...">
                                    <button class="btn btn-primary" type="button" id="findPICSearchBtn">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Loading Indicator -->
                        <div id="findPICLoading" class="text-center py-4" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-white mt-2">Searching customers...</p>
                        </div>

                        <!-- Results Table -->
                        <div id="findPICResults" class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-dark table-hover">
                                <thead class="sticky-top bg-gray-800">
                                    <tr>
                                        <th class="text-white">Name</th>
                                        <th class="text-white">Email</th>
                                        <th class="text-white">Phone</th>
                                        <th class="text-white text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="findPICTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-400">
                                            Enter search keyword to find customers
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div id="findPICPagination" class="mt-3" style="display: none;">
                            <nav aria-label="Customer pagination">
                                <ul class="pagination justify-content-center" id="findPICPaginationList">
                                    <!-- Pagination buttons will be inserted here -->
                                </ul>
                            </nav>
                            <div class="text-center text-white text-sm" id="findPICPaginationInfo">
                                <!-- Pagination info will be inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Find Customer Modal -->
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="findCustomerModal" tabindex="-1" aria-labelledby="findCustomerModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-gray-700 border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="findCustomerModalLabel">
                        <i class="fa fa-search mr-2"></i> Find Perusahaan
                    </h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card bg-gray-900 border-0 rounded-0">
                    <div class="card-body">
                        <!-- Search Input -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="findCustomerSearchInput"
                                        placeholder="Search by name, email, or phone...">
                                    <button class="btn btn-primary" type="button" id="findCustomerSearchBtn">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Loading Indicator -->
                        <div id="findCustomerLoading" class="text-center py-4" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-white mt-2">Searching Perusahaan...</p>
                        </div>

                        <!-- Results Table -->
                        <div id="findCustomerResults" class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-dark table-hover">
                                <thead class="sticky-top bg-gray-800">
                                    <tr>
                                        <th class="text-white">Name</th>
                                        <th class="text-white">Email</th>
                                        <th class="text-white">Phone</th>
                                        <th class="text-white text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="findCustomerTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-400">
                                            Enter search keyword to find perusahaan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div id="findCustomerPagination" class="mt-3" style="display: none;">
                            <nav aria-label="Customer pagination">
                                <ul class="pagination justify-content-center" id="findCustomerPaginationList">
                                    <!-- Pagination buttons will be inserted here -->
                                </ul>
                            </nav>
                            <div class="text-center text-white text-sm" id="findCustomerPaginationInfo">
                                <!-- Pagination info will be inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
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
    </script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        // Initialize channel data from PHP variables
        (function() {
            window.channelPages = JSON.parse('{!! addslashes(json_encode($channel_pages)) !!}');
            window.channelAccounts = JSON.parse('{!! addslashes(json_encode($channel_accounts)) !!}');
        })();

        const loader = `<div class="auto-load text-center"><svg enable-background="new 0 0 0 0" height=60 id=L9 version=1.1 viewBox="0 0 100 100" x=0px xml:space=preserve xmlns=http://www.w3.org/2000/svg" xmlns:xlink=http://www.w3.org/1999/xlink y=0px><path d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50" fill=#fff><animateTransform attributeName=transform attributeType=XML dur=1s from="0 50 50" repeatCount=indefinite to="360 50 50" type=rotate /></path></svg></div>`;

        function openOffcanvasRight(el) {
            $('#offcanvasWithBothOptions').find('#channel_user_id').val($('#offcanvasWithBothOptions').attr('data-channel-user-id'));
            formInit_onChangeChannel($('#offcanvasWithBothOptions').attr('data-channel-id'))
            $('#offcanvasWithBothOptions').offcanvas('show');
        }

        function formInit_onChangeChannel(channel_id) {
            console.log("channel_id", channel_id);
            let cpages = channelPages.filter(cp => cp.channel_id == channel_id);

            $('#channel_page_id').html(`<option value="">Select Channel Page</option>`);
            cpages.forEach(cp => {
                $('#channel_page_id').append(`<option value="${cp.id}">${cp.name}</option>`);
            });

            if (channel_id == "2") {
                $('#channel_page').hide();
                $('#channel_account').show();

                $('#channel_account_id').html(`<option value="">Select Channel Account</option>`);
                channelAccounts.forEach(ca => {
                    $('#channel_account_id').append(`<option value="${ca.id}">${ca.name}</option>`);
                });
            } else {
                $('#channel_page').show();
                $('#channel_account').hide();
                $('#channel_account_id').val("");
            }
        }

        function formInit_onChangeChannelAccount(el) {
            let channel_account_id = $(el).val();
            console.log("channel_account_id", channel_account_id);
            let data_channel_account = channelAccounts.find(({
                id
            }) => id == channel_account_id);
            console.log("data_channel_account", data_channel_account);
            console.log("channel_page_id", data_channel_account.channel_page_id);
            $('select#channel_page_id').val(data_channel_account.channel_page_id);
            console.log($('#channel_page_id').val());
        }

        function submitFromInit(e) {
            e.preventDefault();
            let form = $('#formInit');
            let data = new FormData(form[0]);

            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(data) {
                    console.log("SUCCESS : ", data);

                    if (data.status) {
                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                            width: '150px',
                            customClass: {
                                popup: 'small-swal'
                            }
                        }).then(() => {
                            openChatHeader(data.data.header_id);
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed',
                            text: data.msg,
                            icon: 'error',
                            width: '150px',
                            customClass: {
                                popup: 'small-swal'
                            }
                        });
                    }
                },
                error: function(e) {
                    console.log("ERROR : ", e);
                }
            }).done(() => {
                getChatHeader(null, 1, false, true);
                $('#offcanvasWithBothOptions').offcanvas('hide');
            });
        }

        $('form#formInit').submit((e) => {
            e.preventDefault();
            let form = $('#formInit');
            let data = new FormData(form[0]);

            $('button.chat-end').prop("disabled", true);

            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(data) {
                    console.log("SUCCESS : ", data);
                },
                error: function(e) {
                    console.log("ERROR : ", e);
                }
            }).done(() => {
                getChatHeader(null, 1, false, true);
            });
        });

        // Pastikan DOM sudah ready
        // const buttonEndChat = document.getElementById('buttonEndChat');

        // buttonEndChat.addEventListener('click', function(e) {
        //     e.preventDefault();

        //     const form = document.getElementById('FormTicket');

        //     if (!form) {
        //         console.error('FormTicket tidak ditemukan!');
        //         return;
        //     }

        //     const formData = new FormData(form);

        //     for (let [key, value] of formData.entries()) {
        //         console.log(`${key}: ${value}`);
        //     }

        //     fetch("/ticketing/ticket/create", {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        //             },
        //             body: formData
        //         })
        //         .then(response => {
        //             if (!response.ok) {
        //                 throw new Error('Jaringan bermasalah / Request gagal');
        //             }
        //             return response.json();
        //         })
        //         .then(data => {
        //             console.log(data);

        //             if (data.success) {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Berhasil!',
        //                     text: 'Ticket berhasil dibuat!',
        //                 });
        //                 form.reset();
        //             } else {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Gagal!',
        //                     text: 'Gagal membuat ticket! ' + data.message,
        //                 });
        //                 console.log('Validation Errors:', data.data);
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Oops...',
        //                 text: 'Something went wrong! Cek console log.',
        //             });
        //         });
        // });

        // Panggil fungsi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const phone    = urlParams.get('phone');
            const threadId = urlParams.get('threadid');

            // State fase awal recording (dipakai ulang saat submit ticket)
            window.callRecordingInit = {
                attempted: false,
                success: false,
                uniqueid: '',
                phone: phone || ''
            };

            const ticketInput = document.getElementById('ticket_number');
            const ticketDisplay = document.getElementById('ticket_number_display');

            // helper set ticket (1 pintu)
            function setTicketNumber() {
                if (!ticketInput.value) {
                    ticketInput.value = generateTicketNumber();
                }
                ticketDisplay.textContent = ticketInput.value;
            }

            // 🔥 PRIORITAS: phone + threadId
            if (phone && threadId) {
                setTicketNumber();
                await getCustomerByPhone(phone);
                // ❌ TIDAK panggil storeCallThreads
            }

            // 🔹 Hanya phone
            else if (phone) {
                setTicketNumber();
                await getCustomerByPhone(phone);

                // ❌ DIKOMENTARI: Fase 1 recording tidak perlu di page load
                // Recording belum ada saat page load, fetch di sini hanya ambil recording lama
                // Fetch recording dilakukan saat SUBMIT TICKET (Fase 2 di ticket-form.js)
                // const uniqueid = await getRecordingByPhone(phone);
                // const inicallidInput = document.getElementById('inicallid');
                //
                // window.callRecordingInit.attempted = true;
                // window.callRecordingInit.success = !!uniqueid;
                // window.callRecordingInit.uniqueid = uniqueid || '';
                //
                // if (inicallidInput) {
                //     inicallidInput.value = uniqueid || '';
                // }

                await storeCallThreads(phone);
            }

            // 🔹 Tidak ada parameter
            else {
                await resetTicketHistory();
            }
        });


        // Add this function to handle phone number input and open voice call (now shows inline)
        function openVoiceCall(phone) {
            if (!phone) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter a phone number first!'
                });
                return;
            }

            // Show voice call inline instead of opening new window
            if (typeof showIncomingCall === 'function') {
                showIncomingCall(phone);
            } else {
                // Fallback: try to use voice-call.js function
                if (window.showIncomingCall) {
                    window.showIncomingCall(phone);
                } else {
                    console.error('showIncomingCall function not found');
                }
            }
        }

        // Function to get recording by phone number
        async function getRecordingByPhone(phone) {
            try {
                console.log(`Fetching recording for phone: ${phone}`);
                const response = await fetch(`/ticketing/ticket/recording/by-phone/${phone}`);

                if (!response.ok) {
                    console.log(`No recording found for phone: ${phone}`);
                    return '';
                }

                const data = await response.json();
                console.log('Recording response:', data);

                if (data.success && data.data) {
                    console.log('Recording found:', data.data);
                    console.log('Available fields:', Object.keys(data.data));

                    // Check for linked_id field (from active_call_recordings)
                    if (data.data.linked_id) {
                        console.log('linked_id found:', data.data.linked_id);
                        return data.data.linked_id;
                    } else if (data.data.uniqueid) {
                        // Fallback for backward compatibility
                        console.log('uniqueid found (fallback):', data.data.uniqueid);
                        return data.data.uniqueid;
                    } else {
                        console.log('No linked_id or uniqueid found in recording data');
                        return '';
                    }
                } else {
                    console.log('No recording data available');
                    return '';
                }
            } catch (error) {
                console.error('Error fetching recording:', error);
                return '';
            }
        }

        // Modify the existing getCustomerByPhone function to include voice call and recording
        async function getCustomerByPhone(phone) {
            resetProfileUI();
            showSwal("info", "Mencari...");

            console.log("Mencari PIC dengan nomor:", phone);

            let customer = await fetchCustomerData(phone);

            // Get recording data and set uniqueid to inicallid field
            // let recordingData = await getRecordingByPhone(phone);
            // if (recordingData && recordingData.uniqueid) {
            //     document.getElementById('inicallid').value = recordingData.uniqueid;
            //     console.log('Unique ID set to inicallid field:', recordingData.uniqueid);
            // } else {
            //     document.getElementById('inicallid').value = '';
            //     console.log('No recording found, inicallid field cleared');
            // }

            // Always open voice call window first
            openVoiceCall(phone);

            // Validasi lebih ketat: pastikan ada data dan memiliki id atau name
            if (!customer || !customer.data || !customer.data.id || !customer.data.name) {
                resetProfileUI();
                showSwal("warning", "Nomor telepon tidak ditemukan!");
                // Tampilkan tombol Add dan sembunyikan tombol Edit
                document.getElementById("addCustomerButton").style.display = "block";
                document.getElementById("editCustomerButton").style.display = "none";

                // Isi nomor telepon di form Add
                document.getElementById("AddCustomer_HP").value = phone;

                // Buka modal Add secara otomatis
                $('#addCustomerBC').modal('show');

                // Reset history ticket
                await resetTicketHistory();
                return;
            }

            let userData = customer.data;

            console.log('Customer data received:', userData);
            // console.log('Customer ID (chat_ticket_user_id):', userData.ticket_user.id);

            showSwal("success", "User ditemukan!");

            // Update profile data
            document.getElementById("Profile_Nama").textContent = userData.name || "Tidak Ada Nama";
            document.getElementById("Profile_NomorTelepon").textContent = userData.phone || "-";
            document.getElementById("Profile_Email").textContent = userData.email || "-";
            document.getElementById("Profile_Address").textContent = userData.address || "-";

            // document.getElementById("nama_perusahaan").textContent = userData.ticket_user.name || "-";
            // document.getElementById("email_perusahaan").textContent = userData.ticket_user.email || "-";
            // document.getElementById("phone_perusahaan").textContent = userData.ticket_user.phone || "-";

            document.getElementById('hidden_full_name').value = userData.name || "";
            document.getElementById('hidden_contact_number').value = userData.phone || "";
            document.getElementById('hidden_email').value = userData.email|| "";

            // document.getElementById('ticket_user_id').value = userData.ticket_user.id || "";

            // Sembunyikan tombol Add dan tampilkan tombol Edit
            document.getElementById("addCustomerButton").style.display = "none";
            document.getElementById("editCustomerButton").style.display = "block";

            // Isi form edit dengan data user
            document.getElementById("EditCustomer_Id").value = userData.id || "";
            document.getElementById("EditCustomer_Name").value = userData.name || "";
            document.getElementById("EditCustomer_HP").value = userData.phone || "";
            document.getElementById("EditCustomer_Email").value = userData.email || "";
            document.getElementById("EditCustomer_Address").value = userData.address || "";

            // Load history ticket berdasarkan nomor telepon
            // await loadTicketHistoryByPhone(phone);

            // Trigger Infomedia history search
            if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                console.log('Triggering Infomedia history search for:', phone);
                window.InfomedHistory.searchFromParent(phone);
            } else {
                console.warn('InfomedHistory not available yet, retrying...');
                // Retry after a short delay if the component hasn't loaded yet
                setTimeout(() => {
                    if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                        console.log('Retry: Triggering Infomedia history search for:', phone);
                        window.InfomedHistory.searchFromParent(phone);
                    } else {
                        console.error('InfomedHistory still not available');
                    }
                }, 500);
            }
        }

        async function fetchCustomerData(phone) {
            try {
                console.log(`Fetching data for phone: ${phone}`);
                let response = await fetch(`/ticketing/ticket/customer/find/by-phone?phone=${phone}`);

                console.log(`Response status: ${response.status}`);
                if (!response.ok) throw new Error("Server error");

                let data = await response.json();
                console.log("Response dari server:", data);
                return data;
            } catch (error) {
                console.error("Error fetching customer data:", error);
                showSwal("error", "Terjadi kesalahan saat mengambil data!");
                return null;
            }
        }

        function generateTicketNumber() {
            const now = new Date();
            const year = now.getFullYear().toString().slice(-2);
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');

            return `TKT${year}${month}${day}${hours}${minutes}${seconds}${random}`;
        }

         // Tambahkan fungsi ini untuk menampilkan kartu detail
        // Kode baru dengan parameter articleId
        function showArticleDetail(title, content, fileUrl, articleId) {
            const detailCard = document.getElementById('article-detail-card');
            const articleTitle = document.getElementById('article-title');
            const articleContent = document.getElementById('article-content');
            const articleFile = document.getElementById('article-file');
            const articleIdField = document.getElementById('article-id-field'); // Dapatkan elemen hidden field

            // Isi konten kartu dengan data dari artikel yang diklik
            articleTitle.textContent = title;
            articleContent.innerHTML = content;

            // Tampilkan atau sembunyikan link dokumen
            if (fileUrl && fileUrl !== 'null' && fileUrl !== '') {
                articleFile.href = fileUrl;
                articleFile.classList.remove('hidden');
            } else {
                articleFile.classList.add('hidden');
            }

            // Isi hidden field dengan ID artikel yang dipilih
            if (articleIdField) {
                articleIdField.value = articleId;
            }

            // Tampilkan kartu dengan animasi slide dari kanan
            detailCard.classList.remove('translate-x-full');
        }

        // Tambahkan fungsi ini untuk menyembunyikan kartu detail
        function hideArticleDetail() {
            const detailCard = document.getElementById('article-detail-card');
            // Geser kartu keluar dari layar
            detailCard.classList.add('translate-x-full');
        }



        document.getElementById('jenis_complaint_id').addEventListener('change', async function() {
            const selectedOption = this.options[this.selectedIndex];
            // Ambil ID dari value
            const chatTicketCategoryTypeId = selectedOption.value;
            const articlesContainer = document.getElementById('articles-container-id');

            articlesContainer.innerHTML = '';

            if (!chatTicketCategoryTypeId) {
                articlesContainer.innerHTML = '<p class="text-gray-400">Pilih sub-kategori untuk melihat artikel terkait.</p>';
                return;
            }

            try {
                // Gunakan ID untuk fetch artikel
                const response = await fetch(`/ticketing/ticket/articles?chat_ticket_category_type_id=${chatTicketCategoryTypeId}`);
                const data = await response.json();

                if (data.length > 0) {
                    data.forEach(article => {
                        const articleElement = document.createElement('div');
                        articleElement.classList.add('article-item', 'p-4', 'bg-gray-800', 'rounded-lg', 'shadow', 'mb-4', 'cursor-pointer', 'transition-all', 'duration-200', 'hover:bg-gray-700');

                        // Menambahkan atribut onclick untuk memanggil fungsi showArticleDetail
                        // Kode baru dengan tambahan article.id
                        articleElement.setAttribute('onclick', `showArticleDetail('${article.title}', \`${article.content.replace(/`/g, '\\`')}\`, '${article.FileDocument}', '${article.id}')`);

                        articleElement.innerHTML = `
                            <h3 class="text-lg font-semibold text-white">${article.title}</h3>
                            <p class="text-gray-400 text-sm mt-1">Klik untuk melihat detail</p>
                        `;
                        articlesContainer.appendChild(articleElement);
                    });
                } else {
                    articlesContainer.innerHTML = '<p class="text-gray-400">Tidak ada artikel terkait yang ditemukan.</p>';
                }
            } catch (error) {
                console.error('Error fetching articles:', error);
                articlesContainer.innerHTML = '<p class="text-red-500">Gagal memuat artikel.</p>';
            }
        });

        function resetProfileUI() {
            document.getElementById("Profile_Nama").textContent = "-";
            document.getElementById("Profile_NomorTelepon").textContent = "-";
            document.getElementById("Profile_Email").textContent = "-";
            document.getElementById("Profile_Address").textContent = "-";
        }

        // Fungsi untuk reset history ticket
        async function resetTicketHistory() {
            const historyList = document.getElementById('history-ticket-list');
            if (historyList) {
                historyList.innerHTML = '<li class="text-center text-gray-400 py-4">Tidak ada history ticket</li>';
            }
        }

        // Fungsi untuk load history ticket berdasarkan nomor telepon
        async function loadTicketHistoryByPhone(phone) {
            try {
                console.log(`Loading ticket history for phone: ${phone}`);

                // Menggunakan endpoint baru dengan flaging = 1
                const response = await fetch('/chat/v3/ticket/result/by-phone', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        phone: phone,
                        // flaging: 1, // Inbound tickets
                        limit: 50
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('History ticket response:', data);

                if (data.success && data.data.length > 0) {
                    console.log(`Found ${data.data.length} tickets for phone ${phone}`);
                    displayTicketHistory(data.data);
                } else {
                    console.log(`No tickets found for phone ${phone}`);
                    await resetTicketHistory();
                }
            } catch (error) {
                console.error('Error loading ticket history:', error);
                await resetTicketHistory();
            }
        }

        // Fungsi untuk menampilkan history ticket
        function displayTicketHistory(tickets) {
            const historyList = document.getElementById('history-ticket-list');
            if (!historyList) return;

            historyList.innerHTML = '';

            if (tickets.length === 0) {
                const noDataItem = document.createElement('div');
                noDataItem.className = 'text-center text-gray-400 py-8';
                noDataItem.innerHTML = `
                    <div class="flex flex-col items-center">
                        <i class="fas fa-ticket-alt text-4xl text-gray-600 mb-3"></i>
                        <p class="text-lg">Tidak ada history ticket</p>
                        <p class="text-sm text-gray-500">Belum ada ticket yang dibuat untuk perusahaan ini</p>
                    </div>
                `;
                historyList.appendChild(noDataItem);
                return;
            }

            tickets.forEach(ticket => {
                const ticketItem = document.createElement('div');
                ticketItem.className = 'ticket-card mb-3 p-4 bg-gray-800/70 rounded-lg border border-gray-700 hover:bg-gray-700/70 transition-all duration-200 cursor-pointer group';
                ticketItem.setAttribute('onclick', `openTicketDetailModal(${ticket.id})`);

                // Format tanggal
                const createdDate = new Date(ticket.created_at);
                const formattedDate = createdDate.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Status badge styling
                let statusClass = 'bg-gray-500';
                let statusText = ticket.status || 'Unknown';

                switch (ticket.status?.toLowerCase()) {
                    case 'open':
                        statusClass = 'bg-green-500';
                        break;
                    case 'closed':
                        statusClass = 'bg-red-500';
                        break;
                    case 'pending':
                        statusClass = 'bg-blue-500';
                        break;
                    case 'progress':
                        statusClass = 'bg-yellow-500';
                        break;
                }

                ticketItem.innerHTML = `
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center group-hover:bg-blue-500/30 transition-colors">
                                <i class="fas fa-ticket-alt text-blue-400"></i>
                            </div>
                            <div>
                                <h5 class="text-white font-semibold text-sm mb-1">${ticket.ticket_number || 'N/A'}</h5>
                                <p class="text-gray-400 text-xs">${ticket.genesisnumber || 'No Data Number'}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full ${statusClass} text-white">
                                ${statusText}
                            </span>
                            <p class="text-gray-400 text-xs mt-1">${formattedDate}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center">
                                <i class="fas fa-tag mr-1"></i>
                                ${ticket.category || 'No Category'}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                ${ticket.priority || 'No Priority'}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-flag mr-1"></i>
                                ${ticket.flaging_label || 'Unknown'}
                            </span>
                        </div>
                        <div class="flex items-center text-blue-400 group-hover:text-blue-300">
                            <i class="fas fa-eye mr-1"></i>
                            View Details
                        </div>
                    </div>
                `;

                historyList.appendChild(ticketItem);
            });
        }

        // Fungsi untuk membuka modal detail ticket
        async function openTicketDetailModal(ticketId) {
            console.log('Opening ticket detail modal for ID:', ticketId);

            try {
                // Reset form
                document.getElementById('ticket-detail-id').value = ticketId;
                // document.getElementById('detail-interaction-number').value = '';
                document.getElementById('detail-status').value = '';
                document.getElementById('detail-note').value = '';

                // Load ticket details first
                const ticket = await loadTicketDetails(ticketId);

                // Jika status ticket sudah close, disable form detail
                const ticketStatus = String(ticket?.status || '').toLowerCase();
                if (ticketStatus === 'close') {
                    disableTicketDetailForm('Tiket sudah Close. Tidak dapat menambah interaksi.');
                }

                // Show modal using jQuery or vanilla JS
                const modalElement = document.getElementById('ticketDetailModal');
                if (modalElement) {
                    // Use jQuery if available, otherwise use vanilla JS
                    if (typeof $ !== 'undefined' && $.fn.modal) {
                        $('#ticketDetailModal').modal('show');
                    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        // Fallback to vanilla JS Bootstrap
                        const modal = new bootstrap.Modal(modalElement, {
                            backdrop: true,
                            keyboard: true,
                            focus: true
                        });
                        modal.show();
                    } else {
                        // Fallback to manual show
                        modalElement.style.display = 'block';
                        modalElement.classList.add('show');
                        modalElement.setAttribute('aria-hidden', 'false');
                        document.body.classList.add('modal-open');

                        // Add backdrop
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        backdrop.id = 'ticketDetailModalBackdrop';
                        document.body.appendChild(backdrop);
                    }
                } else {
                    throw new Error('Modal element not found');
                }

            } catch (error) {
                console.error('Error opening ticket detail modal:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load ticket details'
                });
            }
        }

        // Fungsi untuk memuat detail ticket
        async function loadTicketDetails(ticketId) {
            try {
                const response = await fetch(`/chat/v3/ticket/ticket-detail/${ticketId}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    const ticket = data.data;

                    // Update modal header
                    const modalTicketNumber = document.getElementById('modal-ticket-number');
                    const modalTicketNumberValue = document.getElementById('modal-ticket-number-value');
                    const modalTicketStatus = document.getElementById('modal-ticket-status');
                    const modalTicketPriority = document.getElementById('modal-ticket-priority');
                    const modalTicketCreated = document.getElementById('modal-ticket-created');
                    const modalTicketSubject = document.getElementById('modal-ticket-subject');
                    const modalTicketDescription = document.getElementById('modal-ticket-description');
                    const modalTicketCategory = document.getElementById('modal-ticket-category');
                    const modalTicketSubcategory = document.getElementById('modal-ticket-subcategory');

                    if (modalTicketNumber) modalTicketNumber.textContent = `Ticket #${ticket.ticket_number}`;
                    if (modalTicketNumberValue) modalTicketNumberValue.textContent = ticket.ticket_number || '-';
                    if (modalTicketStatus) modalTicketStatus.textContent = ticket.status || '-';
                    if (modalTicketPriority) modalTicketPriority.textContent = ticket.priority || '-';
                    if (modalTicketCreated) modalTicketCreated.textContent = ticket.created_at ? new Date(ticket.created_at).toLocaleString('id-ID') : '-';
                    if (modalTicketSubject) modalTicketSubject.textContent = ticket.genesisnumber || '-';
                    if (modalTicketDescription) modalTicketDescription.innerHTML = `<p class="text-gray-300">${ticket.user_data ? `Perusahaan: ${ticket.user_data.name} (${ticket.user_data.phone})` : 'No customer data'}</p>`;
                    if (modalTicketCategory) modalTicketCategory.textContent = ticket.category || '-';
                    if (modalTicketSubcategory) modalTicketSubcategory.textContent = ticket.subcategory || '-';

                    // Set current layer (as string)
                    const currentLayer = String(ticket.ticket_position || '1');
                    document.getElementById('ticket-current-layer').value = currentLayer;

                    // Update modal header layer display
                    const modalTicketLayer = document.getElementById('modal-ticket-layer');
                    if (modalTicketLayer) modalTicketLayer.textContent = `Layer ${currentLayer}`;

                    updateEscalationUI(currentLayer);

                    // Check permission
                    await checkUserPermissionAndUpdateForm(ticketId);

                    // Load timeline
                    await loadTicketTimeline(ticketId);

                    // Load payload data
                    await loadPayloadData(ticket);

                    return ticket;
                } else {
                    throw new Error(data.message || 'Failed to load ticket details');
                }
            } catch (error) {
                console.error('Error loading ticket details:', error);
                const timelineElement = document.getElementById('ticket-timeline');
                if (timelineElement) {
                    timelineElement.innerHTML = '<p class="text-gray-400 text-center py-4">Failed to load ticket details</p>';
                }
            }

            return null;
        }

        // Function to update escalation UI based on current layer
        function updateEscalationUI(currentLayer) {
            const escalationLabel = document.getElementById('detail-escalation-label');
            const escalationDescription = document.getElementById('detail-escalation-description');
            const escalationCheckbox = document.getElementById('detail-escalation-checkbox');
            const currentLayerDisplay = document.getElementById('detail-current-layer-display');

            // Reset checkbox
            if (escalationCheckbox) escalationCheckbox.checked = false;

            // Convert to string for consistent comparison
            const layerStr = String(currentLayer);

            // Update current layer display
            if (currentLayerDisplay) currentLayerDisplay.textContent = `Layer ${layerStr}`;

            switch(layerStr) {
                case '1':
                    if (escalationLabel) escalationLabel.textContent = 'Eskalasi ke Layer 2';
                    if (escalationDescription) escalationDescription.textContent = 'Centang untuk eskalasi ke Layer 2';
                    break;
                case '2':
                    if (escalationLabel) escalationLabel.textContent = 'Eskalasi ke Layer 3';
                    if (escalationDescription) escalationDescription.textContent = 'Centang untuk eskalasi ke Layer 3';
                    break;
                case '3':
                    if (escalationLabel) escalationLabel.textContent = 'Kembali ke Layer 1';
                    if (escalationDescription) escalationDescription.textContent = 'Centang untuk kembali ke Layer 1';
                    break;
                default:
                    if (escalationLabel) escalationLabel.textContent = 'Eskalasi ke Layer 2';
                    if (escalationDescription) escalationDescription.textContent = 'Centang untuk eskalasi ke Layer 2';
            }
        }

        // Function to format user type
        function formatUserType(userType) {
            if (userType === null || userType === undefined || userType === '') {
                return 'Layer 1';
            }
            switch (userType) {
                case 'l2':
                    return 'Layer 2';
                case 'l3':
                    return 'Layer 3';
                default:
                    return 'Layer 1';
            }
        }

        // Function to check user permission and update form
        async function checkUserPermissionAndUpdateForm(ticketId) {
            try {
                const currentUser = window.currentAgent;
                if (!currentUser || !currentUser.id) {
                    disableTicketDetailForm('User agent tidak ditemukan');
                    return;
                }

                const response = await fetch('/chat/v3/ticket/ticket-detail/check-permission', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        ticket_id: ticketId,
                        user_agent_id: currentUser.user_agent?.id || currentUser.id
                    })
                });

                const permissionResp = await response.json();

                if (!permissionResp.success || !permissionResp.can_add_detail) {
                    // Jika tiket Closed atau user L2/L3 mencoba akses tiket yang bukan posisinya
                    const message = permissionResp.ticket_status?.toLowerCase() === 'closed'
                        ? 'Tiket sudah Closed. Tidak dapat menambah interaksi.'
                        : 'Anda tidak memiliki permission untuk menambah detail pada ticket ini.';
                    disableTicketDetailForm(message);
                } else {
                    // AKTIFKAN form, tapi kirim parameter isStatusDisabled
                    enableTicketDetailForm(permissionResp.is_status_disabled);

                    // Tambahkan pesan info jika dropdown di-disable
                    if (permissionResp.is_status_disabled) {
                        showPermissionInfo('Anda hanya dapat menambah interaksi. Perubahan status dikunci karena tiket berada di Layer Atas.');
                    }
                }
            } catch (error) {
                console.error('Error checking permission:', error);
                disableTicketDetailForm('Gagal mengecek permission');
            }
        }

        // Function to disable ticket detail form
        function disableTicketDetailForm(message) {
            const form = document.getElementById('addTicketDetailForm');
            if (!form) return;

            const submitBtn = form.querySelector('button[type="submit"]');
            const textarea = document.getElementById('detail-note');
            const statusSelect = document.getElementById('detail-status');
            const escalationCheckbox = document.getElementById('detail-escalation-checkbox');

            // Disable all inputs
            if (textarea) textarea.disabled = true;
            if (statusSelect) statusSelect.disabled = true;
            if (escalationCheckbox) escalationCheckbox.disabled = true;
            if (submitBtn) submitBtn.disabled = true;

            // Add placeholder for textarea
            if (textarea) {
                textarea.placeholder = message;
                textarea.value = '';
            }

            // Add class for styling
            form.classList.add('form-disabled');

            // Add or update info message
            let infoDiv = document.getElementById('permission-info');
            if (!infoDiv) {
                infoDiv = document.createElement('div');
                infoDiv.id = 'permission-info';
                infoDiv.className = 'alert alert-warning mb-3 p-3 rounded bg-yellow-500/10 border border-yellow-500/30 text-yellow-400';
                form.insertBefore(infoDiv, form.firstChild);
            }
            infoDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i>${message}`;
        }

        // Function to enable ticket detail form
        function enableTicketDetailForm(isStatusDisabled = false) {
            const form = document.getElementById('addTicketDetailForm');
            if (!form) return;

            const submitBtn = form.querySelector('button[type="submit"]');
            const textarea = document.getElementById('detail-note');
            const statusSelect = document.getElementById('detail-status');
            const escalationCheckbox = document.getElementById('detail-escalation-checkbox');

            // Textarea dan Submit selalu aktif jika masuk fungsi ini
            if (textarea) textarea.disabled = false;
            if (submitBtn) submitBtn.disabled = false;

            // LOGIKA KHUSUS STATUS & ESKALASI
            if (isStatusDisabled) {
                if (statusSelect) statusSelect.disabled = true;
                if (escalationCheckbox) {
                    escalationCheckbox.disabled = true;
                    escalationCheckbox.checked = false; // Pastikan tidak tercentang
                }
            } else {
                if (statusSelect) statusSelect.disabled = false;
                if (escalationCheckbox) escalationCheckbox.disabled = false;
            }

            if (textarea) textarea.placeholder = 'Add your note here...';
            form.classList.remove('form-disabled');

            // Hapus info message lama jika ada (agar tidak double)
            const infoDiv = document.getElementById('permission-info');
            if (infoDiv && !isStatusDisabled) {
                infoDiv.remove();
            }
        }

        function showPermissionInfo(message) {
            const form = document.getElementById('addTicketDetailForm');
            let infoDiv = document.getElementById('permission-info');
            if (!infoDiv) {
                infoDiv = document.createElement('div');
                infoDiv.id = 'permission-info';
                infoDiv.className = 'alert alert-info mb-3 p-3 rounded bg-blue-500/10 border border-blue-500/30 text-blue-400';
                form.insertBefore(infoDiv, form.firstChild);
            }
            infoDiv.innerHTML = `<i class="fas fa-info-circle me-2"></i>${message}`;
        }

        // Helper to get payload value safely in JS
        function getPayloadValue(ticket, field) {
            let displayValue = '-';

            // 1. Cek extra_data
            let extra = ticket.extra_data;
            if (typeof extra === 'string') {
                try {
                    extra = JSON.parse(extra);
                } catch (e) {}
            }

            if (extra && typeof extra === 'object' && extra[field] !== undefined) {
                displayValue = extra[field];
            } else {
                // 2. Cek payload
                let p = ticket.payload;
                if (typeof p === 'string') {
                    try {
                        p = JSON.parse(p);
                    } catch (e) {}
                }

                if (Array.isArray(p)) {
                    const item = p.find(x => x.field_name === field);
                    if (item) {
                        const specialFields = ['customer_category', 'enquiry_type', 'enquiry_detail', 'problem', 'escalation_unit'];
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

            // Handle attachment field
            if (field === 'attachment' && displayValue !== '-' && displayValue !== null && displayValue !== '') {
                const cleanPath = displayValue.toString().replace(/^\//, '');
                const url = `/storage/${cleanPath}`;
                return `
                    <a href="${url}" target="_blank" class="inline-flex items-center text-blue-400 hover:text-blue-300 underline font-semibold">
                        <i class="fas fa-paperclip mr-1"></i>
                        Download
                    </a>
                `;
            }

            return displayValue;
        }

        // Function to get payload headers from payload data
        function getPayloadHeaders(ticket) {
            const headers = {};

            // Parse payload
            let payload = ticket.payload;
            if (typeof payload === 'string') {
                try {
                    payload = JSON.parse(payload);
                } catch (e) {
                    return headers;
                }
            }

            if (payload && Array.isArray(payload) && payload.length > 0) {
                // Format baru: array of objects dengan field_name dan label
                if (payload[0].field_name) {
                    payload.forEach(item => {
                        if (item.field_name && item.label) {
                            headers[item.field_name] = item.label;
                        }
                    });
                }
            } else if (payload && typeof payload === 'object') {
                // Format lama: object dengan keys
                Object.keys(payload).forEach(key => {
                    headers[key] = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                });
            }

            // Add extra_data fields
            if (ticket.extra_data) {
                let extra = ticket.extra_data;
                if (typeof extra === 'string') {
                    try {
                        extra = JSON.parse(extra);
                    } catch (e) {}
                }
                if (extra && typeof extra === 'object' && extra.name) {
                    headers['name'] = 'Nama Perusahaan';
                }
            }

            return headers;
        }

        // Function to load and display payload data
        async function loadPayloadData(ticket) {
            const payloadContainer = document.getElementById('ticket-payload-container');
            if (!payloadContainer) return;

            const headers = getPayloadHeaders(ticket);

            if (Object.keys(headers).length === 0) {
                payloadContainer.innerHTML = '<p class="text-gray-400 text-center py-4">Tidak ada data payload</p>';
                return;
            }

            let payloadHtml = '<div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 max-h-96 overflow-y-auto pr-1">';

            Object.keys(headers).forEach(fieldName => {
                const label = headers[fieldName];
                const value = getPayloadValue(ticket, fieldName);

                payloadHtml += `
                    <div class="flex justify-between items-center py-1 border-b border-gray-700 last:border-0 hover:bg-gray-700/30 px-2 rounded transition-colors">
                        <span class="text-gray-400 text-sm w-1/2 pr-2 truncate" title="${label}">${label}:</span>
                        <span class="text-white font-medium text-sm w-1/2 text-end break-words">
                            ${value}
                        </span>
                    </div>
                `;
            });

            payloadHtml += '</div>';
            payloadContainer.innerHTML = payloadHtml;
        }

        // Fungsi untuk memuat timeline ticket
        async function loadTicketTimeline(ticketId) {
            try {
                const response = await fetch(`/chat/v3/ticket/ticket-timeline/${ticketId}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                const timelineContainer = document.getElementById('ticket-timeline');

                if (!timelineContainer) {
                    console.error('Timeline container not found');
                    return;
                }

                if (data.success && data.data.length > 0) {
                    timelineContainer.innerHTML = '';

                    // Sort data by created_at
                    const sortedData = data.data.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

                    sortedData.forEach((detail, index) => {
                        const timelineItem = document.createElement('div');
                        const positionClass = index % 2 === 0 ? 'even' : 'odd';
                        timelineItem.className = `timeline-item relative flex flex-col items-center ${positionClass}`;

                        const createdDate = new Date(detail.created_at);
                        const formattedDate = createdDate.toLocaleString('id-ID');
                        const agentName = detail.user_agent?.user_name || detail.user_agent?.username || 'Unknown Agent';

                        // Get channel info
                        let channelIcon = '';
                        let channelName = '';
                        if (detail.channel) {
                            channelName = detail.channel.name || 'Ticket Detail';
                            // Gunakan icon_src yang sudah di-generate oleh Laravel
                            if (detail.channel.icon_src) {
                                channelIcon = `<img src="${detail.channel.icon_src}" alt="${channelName}" class="w-8 h-8 rounded-full object-cover">`;
                            } else {
                                // Fallback ke icon berdasarkan code channel
                                let iconClass = 'fas fa-comment text-gray-400';
                                switch (detail.channel.code) {
                                    case 'fb':
                                        iconClass = 'fab fa-facebook text-blue-500';
                                        break;
                                    case 'ig':
                                        iconClass = 'fab fa-instagram text-pink-500';
                                        break;
                                    case 'telegram':
                                        iconClass = 'fab fa-telegram text-blue-400';
                                        break;
                                    case 'whatsapp':
                                        iconClass = 'fab fa-whatsapp text-green-500';
                                        break;
                                    case 'qiscus-whatsapp':
                                        iconClass = 'fab fa-whatsapp text-green-500';
                                        break;
                                    default:
                                        iconClass = 'fas fa-comment text-gray-400';
                                }
                                channelIcon = `<i class="${iconClass}"></i>`;
                            }
                        } else {
                            channelIcon = '<i class="fas fa-comment text-gray-400"></i>';
                        }

                        // Get layer transition info based on ref_id
                        let layerTransitionInfo = '';
                        if (detail.ref_id) {
                            // Find the previous detail to get the from layer
                            const previousDetail = sortedData.find(prev => prev.id == detail.ref_id);
                            if (previousDetail) {
                                const fromLayer = previousDetail.layer || 1;
                                const toLayer = detail.layer || 1;
                                if (fromLayer !== toLayer) {
                                    layerTransitionInfo = `<div class="layer-transition text-yellow-400">
                                        <i class="fas fa-arrow-right mr-1"></i>Layer ${fromLayer} → Layer ${toLayer}
                                    </div>`;
                                } else {
                                    layerTransitionInfo = `<div class="layer-transition text-gray-400">
                                        <i class="fas fa-circle mr-1"></i>Layer ${toLayer}
                                    </div>`;
                                }
                            }
                        } else {
                            // First detail, no ref_id
                            const currentLayer = detail.layer || 1;
                            layerTransitionInfo = `<div class="layer-transition text-green-400">
                                <i class="fas fa-play mr-1"></i>Start Layer ${currentLayer}
                            </div>`;
                        }

                        // Prepare layer transition text for onclick
                        let layerTransitionText = '';
                        if (detail.ref_id) {
                            const previousDetail = sortedData.find(prev => prev.id == detail.ref_id);
                            if (previousDetail) {
                                const fromLayer = previousDetail.layer || 1;
                                const toLayer = detail.layer || 1;
                                if (fromLayer !== toLayer) {
                                    layerTransitionText = `Layer ${fromLayer} → Layer ${toLayer}`;
                                } else {
                                    layerTransitionText = `Layer ${toLayer}`;
                                }
                            }
                        } else {
                            const currentLayer = detail.layer || 1;
                            layerTransitionText = `Start Layer ${currentLayer}`;
                        }

                        timelineItem.innerHTML = `
                            <!-- Timeline Icon -->
                            <div class="timeline-icon relative z-10 flex items-center justify-center w-16 h-16 rounded-full cursor-pointer transition-all duration-300 group"
                                 onclick="showTimelineDetail(${index}, '${channelName || 'Ticket Detail'}', '${formattedDate}', '${agentName}', \`${detail.note || 'Tidak ada catatan'}\`, '${detail.status || ''}', '${detail.layer || ''}', '${layerTransitionText}')"
                                 title="Klik untuk melihat detail">
                                <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center group-hover:bg-gray-600 transition-colors">
                                    ${channelIcon || '<i class="fas fa-comment text-gray-400"></i>'}
                                </div>
                                ${layerTransitionInfo}
                            </div>
                        `;

                        timelineContainer.appendChild(timelineItem);
                    });
                } else {
                    timelineContainer.innerHTML = '<p class="text-gray-400 text-center py-4">No timeline data available</p>';
                }
            } catch (error) {
                console.error('Error loading ticket timeline:', error);
                const timelineElement = document.getElementById('ticket-timeline');
                if (timelineElement) {
                    timelineElement.innerHTML = '<p class="text-gray-400 text-center py-4">Failed to load timeline</p>';
                }
            }
        }

        // Event listener untuk form add ticket detail
        document.addEventListener('DOMContentLoaded', function() {
            const addDetailForm = document.getElementById('addTicketDetailForm');
            if (addDetailForm) {
                addDetailForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const ticketId = document.getElementById('ticket-detail-id').value;
                    // const interactionNumber = document.getElementById('detail-interaction-number').value;
                    const status = document.getElementById('detail-status').value;
                    const note = document.getElementById('detail-note').value;
                    const isEscalated = document.getElementById('detail-escalation-checkbox')?.checked || false;
                    const currentLayer = String(document.getElementById('ticket-current-layer')?.value || '1');

                    if (!note.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: 'Note is required'
                        });
                        return;
                    }

                    // Calculate new layer based on escalation (as string)
                    let newLayer = currentLayer;
                    if (isEscalated) {
                        if (currentLayer === '1') {
                            newLayer = '2';
                        } else if (currentLayer === '2') {
                            newLayer = '3';
                        } else if (currentLayer === '3') {
                            newLayer = '1';
                        }
                    }

                    // Get GenesisNumber from recording data
                    let genesisnumber = '';

                    // Get phone number from URL parameter
                    const urlParams = new URLSearchParams(window.location.search);
                    const phone = urlParams.get('phone') || '';
                    const waParam = urlParams.get('wa');
                    const isWaCall = typeof waParam === 'string' && waParam.toLowerCase() === 'true';

                    console.log('Phone from URL:', phone);

                    if (phone) {
                        console.log('Phone found, fetching recording data...');
                        // Fetch recording data and get uniqueid
                        const uniqueid = await getRecordingByPhone(phone);
                        console.log('UniqueID received:', uniqueid);

                        if (uniqueid && uniqueid !== '') {
                            genesisnumber = uniqueid;
                            console.log('GenesisNumber set from recording:', genesisnumber);
                        } else {
                            console.log('No uniqueid found, showing warning dialog');
                            // Show warning but continue with submission
                            const result = await Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: 'Recording ID tidak ditemukan untuk nomor telepon ini. Ticket detail akan tetap dibuat tanpa GenesisNumber.',
                                confirmButtonText: 'Lanjutkan',
                                showCancelButton: true,
                                cancelButtonText: 'Batal'
                            });

                            // If user cancelled, stop execution
                            if (result.isDismissed) {
                                console.log('User cancelled submission');
                                return;
                            }

                            console.log('User confirmed, proceeding without GenesisNumber');
                        }
                    } else {
                        console.log('No phone parameter found, proceeding without GenesisNumber');
                    }

                    console.log('Final GenesisNumber value:', genesisnumber);

                    try {
                        const requestData = {
                            ticket_id: ticketId,
                            // interaction_number: interactionNumber,
                            flaging: isWaCall ? 7 : 1,
                            channel_id: 15,
                            status: status,
                            note: note,
                            genesisnumber: genesisnumber,
                            layer: newLayer,
                            escalation: isEscalated
                        };

                        console.log('Sending request data:', requestData);

                        const response = await fetch('/chat/v3/ticket/ticket-detail/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: JSON.stringify(requestData)
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Build success message
                            let successMessage = 'Ticket detail added successfully';
                            if (isEscalated) {
                                successMessage = `Ticket detail added and escalated to Layer ${newLayer}`;
                            }
                            if (status && data.ticket_updated?.status) {
                                successMessage += `. Status updated to: ${data.ticket_updated.status}`;
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: successMessage,
                                timer: 3000,
                                showConfirmButton: false
                            });

                            // Reset form
                            addDetailForm.reset();
                            document.getElementById('ticket-detail-id').value = ticketId;

                            // Update current layer and status from server response
                            if (data.ticket_updated) {
                                if (data.ticket_updated.ticket_position) {
                                    const updatedLayer = String(data.ticket_updated.ticket_position);
                                    document.getElementById('ticket-current-layer').value = updatedLayer;
                                    updateEscalationUI(updatedLayer);

                                    // Update modal header layer display
                                    const modalTicketLayer = document.getElementById('modal-ticket-layer');
                                    if (modalTicketLayer) {
                                        modalTicketLayer.textContent = `Layer ${updatedLayer}`;
                                    }
                                }

                                // Update modal header status display
                                if (data.ticket_updated.status) {
                                    const modalTicketStatus = document.getElementById('modal-ticket-status');
                                    if (modalTicketStatus) {
                                        modalTicketStatus.textContent = data.ticket_updated.status;
                                    }
                                }
                            }

                            // Reload ticket details (including permission check)
                            await loadTicketDetails(ticketId);

                            // Reload timeline
                            await loadTicketTimeline(ticketId);

                            // Reload history ticket list jika ada phone
                            const urlParams = new URLSearchParams(window.location.search);
                            const phone = urlParams.get('phone') || '';
                            if (phone) {
                                await loadTicketHistoryByPhone(phone);
                            }
                        } else {
                            throw new Error(data.message || 'Failed to add ticket detail');
                        }
                    } catch (error) {
                        console.error('Error adding ticket detail:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add ticket detail'
                        });
                    }
                });
            }
        });

        // Fungsi untuk menutup modal
        function closeTicketDetailModal() {
            const modalElement = document.getElementById('ticketDetailModal');
            if (modalElement) {
                if (typeof $ !== 'undefined' && $.fn.modal) {
                    $('#ticketDetailModal').modal('hide');
                } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                } else {
                    // Manual close
                    modalElement.style.display = 'none';
                    modalElement.classList.remove('show');
                    modalElement.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('modal-open');

                    // Remove backdrop
                    const backdrop = document.getElementById('ticketDetailModalBackdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                }
            }
        }

        // Event listener untuk tombol close modal
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-close') || e.target.getAttribute('data-bs-dismiss') === 'modal') {
                closeTicketDetailModal();
            }
        });

        // Function to show timeline detail in div below journey
        function showTimelineDetail(index, channelName, formattedDate, agentName, note, status, layer, layerTransition) {
            const detailDisplay = document.getElementById('timeline-detail-display');
            const detailTitle = document.getElementById('detail-title');
            const detailContent = document.getElementById('detail-content');

            if (!detailDisplay || !detailTitle || !detailContent) return;

            // Function to truncate long text and add line breaks
            function formatLongText(text, maxLength = 100) {
                if (!text) return 'Tidak ada catatan';

                // Clean the text from any HTML tags
                const cleanText = text.replace(/<[^>]*>/g, '');

                // If text is longer than maxLength, break it into chunks
                if (cleanText.length > maxLength) {
                    const words = cleanText.split(' ');
                    let result = '';
                    let currentLine = '';

                    for (let word of words) {
                        if ((currentLine + word).length > maxLength && currentLine.length > 0) {
                            result += currentLine.trim() + '\n';
                            currentLine = word + ' ';
                        } else {
                            currentLine += word + ' ';
                        }
                    }

                    if (currentLine.trim().length > 0) {
                        result += currentLine.trim();
                    }

                    return result;
                }

                return cleanText;
            }

            // Update detail content
            detailContent.innerHTML = `
                <div class="space-y-3">
                    <!-- Channel Info -->
                    <div class="flex items-center justify-between">
                        <span class="text-white font-semibold text-sm break-words">${channelName}</span>
                        <span class="text-xs text-gray-400 break-words">${formattedDate}</span>
                    </div>

                <!-- Agent Info -->
                    <div class="flex items-center">
                    <i class="fas fa-user text-gray-400 text-xs mr-2"></i>
                        <span class="text-xs text-gray-300 break-words">${agentName}</span>
                </div>

                    <!-- Layer Transition Info -->
                    ${layerTransition ? `
                    <div class="flex items-center">
                        <i class="fas fa-layer-group text-blue-400 text-xs mr-2"></i>
                        <span class="text-xs text-blue-300 break-words">${layerTransition}</span>
                </div>
                    ` : ''}


                    <!-- Status Info -->
                    ${status ? `
                    <div class="flex items-center">
                        <i class="fas fa-flag text-blue-400 text-xs mr-2"></i>
                        <span class="text-xs text-blue-300 break-words">Status: ${status}</span>
                    </div>
                    ` : ''}

                    <!-- Content -->
                    <div class="text-white text-sm leading-relaxed bg-gray-700 p-3 rounded content-text">
                        ${formatLongText(note)}
                    </div>
                    </div>
                `;

            // Show detail display
            detailDisplay.classList.remove('hidden');

            // Scroll to detail display
            detailDisplay.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            // Remove active class from all icons
            const allIcons = document.querySelectorAll('#ticket-timeline .timeline-icon');
            allIcons.forEach(icon => icon.classList.remove('active'));

            // Add active class to clicked icon
            const timelineItems = document.querySelectorAll('#ticket-timeline .timeline-item');
            const targetItem = timelineItems[index];
            if (targetItem) {
                const iconDiv = targetItem.querySelector('.timeline-icon');
                if (iconDiv) {
                    iconDiv.classList.add('active');
                }
            }
        }

        // Function to close timeline detail display
        function closeTimelineDetailDisplay() {
            const detailDisplay = document.getElementById('timeline-detail-display');
            if (detailDisplay) {
                detailDisplay.classList.add('hidden');
            }

            // Remove active class from all icons
            const allIcons = document.querySelectorAll('#ticket-timeline .timeline-icon');
            allIcons.forEach(icon => icon.classList.remove('active'));
        }

        // Function to close detail display (alias for compatibility)
        function closeDetailDisplay() {
            closeTimelineDetailDisplay();
        }

        // Add event listener for close button
        document.addEventListener('DOMContentLoaded', function() {
            const closeBtn = document.getElementById('closeDetailDisplay');
            if (closeBtn) {
                closeBtn.addEventListener('click', closeDetailDisplay);
            }
        });

        // Add event listener to close timeline details when clicking outside
        document.addEventListener('click', function(event) {
            const timelineContainer = document.getElementById('ticket-timeline');
            const detailDisplay = document.getElementById('timeline-detail-display');
            if (timelineContainer && !timelineContainer.contains(event.target) &&
                detailDisplay && !detailDisplay.contains(event.target)) {
                closeTimelineDetailDisplay();
            }
        });

        function showSwal(type, message) {
            let iconType = type;
            Swal.fire({
                icon: iconType,
                title: message,
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Add event listener for category change
        // document.getElementById('Form_Ticket_Kategori').addEventListener('change', async function() {
        //     const selectedOption = this.options[this.selectedIndex];
        //     const categoryId = selectedOption.getAttribute('data-id');
        //     const categoryName = selectedOption.value;

        //     const subKategoriSelect = document.getElementById('Form_Ticket_SubKategori');

        //     subKategoriSelect.innerHTML = '<option value="">Select</option>';

        //     if (!categoryId) {
        //         console.log('No category selected');
        //         return;
        //     }

        //     try {
        //         const response = await fetch(`/chat_ticket_dropdown/${categoryId}/category-type`);
        //         const data = await response.json();

        //         if (data.status && data.data) {
        //             data.data.forEach(subCategory => {
        //                 const option = document.createElement('option');
        //                 option.value = subCategory.name;
        //                 option.textContent = subCategory.name;
        //                 option.dataset.id = subCategory.id;
        //                 subKategoriSelect.appendChild(option);
        //             });
        //         } else {
        //             console.log('No subcategories found');
        //         }
        //     } catch (error) {
        //         console.error('Error fetching subcategories:', error);
        //         showSwal('error', 'Failed to load subcategories');
        //     }
        // });

        // Add event listener for Edit button
        document.getElementById('Btn_EditCustomer').addEventListener('click', function() {
            const userId = document.getElementById('ticket_user_id').value;
            if (userId) {
                // Form sudah terisi oleh getCustomerByPhone
                // Tidak perlu mengisi ulang
            }
        });



        // Add event listener for Add form submission
        $(document).on('click', '#SimpanCustomerModal', function(e) {
            e.preventDefault();
            console.log('Add button clicked');

            const formData = {
                name: document.getElementById('AddCustomer_Name').value,
                phone: document.getElementById('AddCustomer_HP').value,
                email: document.getElementById('AddCustomer_Email').value,
                address: document.getElementById('AddCustomer_Address').value,
                // perusahaan_name: document.getElementById('AddCustomer_NamaPerusahaan').value,
                // perusahaan_email: document.getElementById('AddCustomer_EmailPerusahaan').value,
                // perusahaan_phone: document.getElementById('AddCustomer_PhonePerusahaan').value,
                // perusahaan_address: document.getElementById('AddCustomer_AlamatPerusahaan').value,
                // chat_ticket_user_id : document.getElementById('chat_ticket_user_id').value,

            };

            console.log('Form data:', formData);

            // Validasi form
            if (!formData.name || !formData.email || !formData.address) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Harap isi semua field yang wajib diisi!',
                });
                return;
            }

            // Validasi format email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Format email tidak valid!',
                });
                return;
            }

            // Kirim data ke server untuk create
            $.ajax({
                url: '/ticketing/ticket/customer/add2',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(data) {
                    console.log('Server response:', data);
                    if (data.success) {


                        const ChannelUser = data.data.channel_user;

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data PIC berhasil ditambahkan!',
                        }).then(() => {
                            // Tutup modal
                            $('#addCustomerBC').modal('hide');
                            // Refresh data profil
                            // getCustomerByPhone(formData.phone);
                            // Update profile data
                            document.getElementById("Profile_Nama").textContent = formData.name || "Tidak Ada Nama";
                            document.getElementById("Profile_NomorTelepon").textContent = formData.phone || "-";
                            document.getElementById("Profile_Email").textContent = formData.email || "-";
                            document.getElementById("Profile_Address").textContent = formData.address || "-";

                            // document.getElementById("nama_perusahaan").textContent = TicketUser.name || "-";
                            // document.getElementById("email_perusahaan").textContent = TicketUser.email || "-";
                            // document.getElementById("phone_perusahaan").textContent = TicketUser.phone || "-";


                            // document.getElementById('ticket_user_id').value = TicketUser.id || "";

                            document.getElementById('hidden_full_name').value = formData.name || "";
                            document.getElementById('hidden_contact_number').value = formData.phone || "";
                            document.getElementById('hidden_email').value = formData.email || "";

                            // Sembunyikan tombol Add dan tampilkan tombol Edit
                            document.getElementById("addCustomerButton").style.display = "none";
                            document.getElementById("editCustomerButton").style.display = "block";

                            // Isi form edit dengan data user
                            document.getElementById("EditCustomer_Id").value = ChannelUser.id || "";
                            document.getElementById("EditCustomer_Name").value = ChannelUser.name || "";
                            document.getElementById("EditCustomer_HP").value = ChannelUser.phone || "";
                            document.getElementById("EditCustomer_Email").value = ChannelUser.email || "";
                            document.getElementById("EditCustomer_Address").value = ChannelUser.address || "";

                            // Trigger Infomedia history search
                            if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                console.log('Triggering Infomedia history search for:', formData.phone);
                                window.InfomedHistory.searchFromParent(formData.phone);
                            } else {
                                console.warn('InfomedHistory not available yet, retrying...');
                                // Retry after a short delay if the component hasn't loaded yet
                                setTimeout(() => {
                                    if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                        console.log('Retry: Triggering Infomedia history search for:', formData.phone);
                                        window.InfomedHistory.searchFromParent(formData.phone);
                                    } else {
                                        console.error('InfomedHistory still not available');
                                    }
                                }, 500);
                            }

                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menambahkan data perusahaan! ' + (data.message || ''),
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);

                    let errorMessage = 'Terjadi kesalahan saat menambahkan data!';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            // Tampilkan pesan error validasi
                            errorMessage = Object.values(response.errors).join('\n');
                        } else if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage,
                    });
                }
            });
        });

        $(document).on('click', '#SimpanCustomerModalPerusahaan', function(e) {
            e.preventDefault();
            console.log('Add button clicked');

            const formData = {
                name: document.getElementById('AddCustomer_NamePerusahaan').value,
                phone: document.getElementById('AddCustomer_PhonePerusahaan').value,
                email: document.getElementById('AddCustomer_EmailPerusahaan').value,
                address: document.getElementById('AddCustomer_AddressPerusahaan').value,
                // perusahaan_name: document.getElementById('AddCustomer_NamaPerusahaan').value,
                // perusahaan_email: document.getElementById('AddCustomer_EmailPerusahaan').value,
                // perusahaan_phone: document.getElementById('AddCustomer_PhonePerusahaan').value,
                // perusahaan_address: document.getElementById('AddCustomer_AlamatPerusahaan').value,
                // chat_ticket_user_id : document.getElementById('chat_ticket_user_id').value,

            };

            console.log('Form data:', formData);

            // Validasi form
            if (!formData.name || !formData.email || !formData.address) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Harap isi semua field yang wajib diisi!',
                });
                return;
            }

            // Validasi format email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Format email tidak valid!',
                });
                return;
            }

            // Kirim data ke server untuk create
            $.ajax({
                url: '/ticketing/ticket/customer/add',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(data) {
                    console.log('Server response:', data);
                    if (data.success) {


                        const TicketUser = data.data;

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data perusahaan berhasil ditambahkan!',
                        }).then(() => {
                            // Tutup modal
                            $('#addCustomerPerusahaan').modal('hide');
                            // Refresh data profil
                            // getCustomerByPhone(formData.phone);
                            // Update profile data
                            document.getElementById("nama_perusahaan").textContent = formData.name || "Tidak Ada Nama";
                            document.getElementById("phone_perusahaan").textContent = formData.phone || "-";
                            document.getElementById("email_perusahaan").textContent = formData.email || "-";
                            // document.getElementById("Profile_Address").textContent = formData.address || "-";

                            // document.getElementById("nama_perusahaan").textContent = TicketUser.name || "-";
                            // document.getElementById("email_perusahaan").textContent = TicketUser.email || "-";
                            // document.getElementById("phone_perusahaan").textContent = TicketUser.phone || "-";


                            document.getElementById('ticket_user_id').value = TicketUser.id || "";

                            // document.getElementById('hidden_full_name').value = formData.name || "";
                            // document.getElementById('hidden_contact_number').value = formData.phone || "";
                            // document.getElementById('hidden_email').value = formData.email || "";

                            // Sembunyikan tombol Add dan tampilkan tombol Edit
                            document.getElementById("addPerusahaanButton").style.display = "none";
                            document.getElementById("editPerusahaanButton").style.display = "block";

                            // Isi form edit dengan data user
                            document.getElementById("EditCustomer_IdPerusahaan").value = TicketUser.id || "";
                            document.getElementById("EditCustomer_NamePerusahaan").value = TicketUser.name || "";
                            document.getElementById("EditCustomer_PhonePerusahaan").value = TicketUser.phone || "";
                            document.getElementById("EditCustomer_EmailPerusahaan").value = TicketUser.email || "";
                            document.getElementById("EditCustomer_AddressPerusahaan").value = TicketUser.address || "";

                            // Trigger Infomedia history search
                            if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                console.log('Triggering Infomedia history search for:', formData.phone);
                                window.InfomedHistory.searchFromParent(formData.phone);
                            } else {
                                console.warn('InfomedHistory not available yet, retrying...');
                                // Retry after a short delay if the component hasn't loaded yet
                                setTimeout(() => {
                                    if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                        console.log('Retry: Triggering Infomedia history search for:', formData.phone);
                                        window.InfomedHistory.searchFromParent(formData.phone);
                                    } else {
                                        console.error('InfomedHistory still not available');
                                    }
                                }, 500);
                            }

                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menambahkan data perusahaan! ' + (data.message || ''),
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);

                    let errorMessage = 'Terjadi kesalahan saat menambahkan data!';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            // Tampilkan pesan error validasi
                            errorMessage = Object.values(response.errors).join('\n');
                        } else if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage,
                    });
                }
            });
        });

        // Add event listener for Edit form submission
        $(document).on('click', '#EditCustomerModal', function(e) {
            e.preventDefault();
            console.log('Edit button clicked');

            const formData = {
                id: document.getElementById('EditCustomer_Id').value,
                name: document.getElementById('EditCustomer_Name').value,
                phone: document.getElementById('EditCustomer_HP').value,
                email: document.getElementById('EditCustomer_Email').value,
                address: document.getElementById('EditCustomer_Address').value,
                company_id: window.currentAgent.company_id
            };

            console.log('Edit form data:', formData);

            // Validasi form
            if (!formData.id || !formData.name || !formData.email || !formData.address) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Harap isi semua field yang wajib diisi!',
                });
                return;
            }

            // Validasi format email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Format email tidak valid!',
                });
                return;
            }

            // Kirim data ke server untuk update
            $.ajax({
                url: '/ticketing/ticket/customer/update2',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(data) {
                    console.log('Server response:', data);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data PIC berhasil diperbarui!',
                        }).then(() => {
                            // Tutup modal
                            $('#editCustomerBC').modal('hide');
                            // Refresh data profil
                            // getCustomerByPhone(formData.phone);
                            document.getElementById("Profile_Nama").textContent = formData.name || "Tidak Ada Nama";
                            document.getElementById("Profile_NomorTelepon").textContent = formData.phone || "-";
                            document.getElementById("Profile_Email").textContent = formData.email || "-";
                            document.getElementById("Profile_Address").textContent = formData.address || "-";

                            // document.getElementById('ticket_user_id').value = formData.id || "";

                            document.getElementById('hidden_full_name').value = formData.name || "";
                            document.getElementById('hidden_contact_number').value = formData.phone || "";
                            document.getElementById('hidden_email').value = formData.email || "";

                            // Sembunyikan tombol Add dan tampilkan tombol Edit
                            // document.getElementById("addCustomerButton").style.display = "none";
                            // document.getElementById("editCustomerButton").style.display = "block";

                            // Isi form edit dengan data user
                            document.getElementById("EditCustomer_Id").value = formData.id || "";
                            document.getElementById("EditCustomer_Name").value = formData.name || "";
                            document.getElementById("EditCustomer_HP").value = formData.phone || "";
                            document.getElementById("EditCustomer_Email").value = formData.email || "";
                            document.getElementById("EditCustomer_Address").value = formData.address || "";

                            // Trigger Infomedia history search
                            if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                console.log('Triggering Infomedia history search for:', formData.phone);
                                window.InfomedHistory.searchFromParent(formData.phone);
                            } else {
                                console.warn('InfomedHistory not available yet, retrying...');
                                // Retry after a short delay if the component hasn't loaded yet
                                setTimeout(() => {
                                    if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                        console.log('Retry: Triggering Infomedia history search for:', formData.phone);
                                        window.InfomedHistory.searchFromParent(formData.phone);
                                    } else {
                                        console.error('InfomedHistory still not available');
                                    }
                                }, 500);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memperbarui data perusahaan! ' + (data.message || ''),
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);

                    let errorMessage = 'Terjadi kesalahan saat memperbarui data!';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            // Tampilkan pesan error validasi
                            errorMessage = Object.values(response.errors).join('\n');
                        } else if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage,
                    });
                }
            });
        });

        $(document).on('click', '#EditCustomerModalPerusahaan', function(e) {
            e.preventDefault();
            console.log('Edit button clicked');

            const formData = {
                id: document.getElementById('EditCustomer_IdPerusahaan').value,
                name: document.getElementById('EditCustomer_NamePerusahaan').value,
                phone: document.getElementById('EditCustomer_PhonePerusahaan').value,
                email: document.getElementById('EditCustomer_EmailPerusahaan').value,
                address: document.getElementById('EditCustomer_AddressPerusahaan').value,
                company_id: window.currentAgent.company_id
            };

            console.log('Edit form data:', formData);

            // Validasi form
            if (!formData.id || !formData.name || !formData.email || !formData.address) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Harap isi semua field yang wajib diisi!',
                });
                return;
            }

            // Validasi format email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Format email tidak valid!',
                });
                return;
            }

            // Kirim data ke server untuk update
            $.ajax({
                url: '/ticketing/ticket/customer/update',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(data) {
                    console.log('Server response:', data);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data perusahaan berhasil diperbarui!',
                        }).then(() => {
                            // Tutup modal
                            $('#editCustomerPerusahaan').modal('hide');
                            // Refresh data profil
                            // getCustomerByPhone(formData.phone);
                            document.getElementById("nama_perusahaan").textContent = formData.name || "Tidak Ada Nama";
                            document.getElementById("phone_perusahaan").textContent = formData.phone || "-";
                            document.getElementById("email_perusahaan").textContent = formData.email || "-";
                            // document.getElementById("Profile_Address").textContent = formData.address || "-";

                            document.getElementById('ticket_user_id').value = formData.id || "";


                            // Isi form edit dengan data user
                            document.getElementById("EditCustomer_IdPerusahaan").value = formData.id || "";
                            document.getElementById("EditCustomer_NamePerusahaan").value = formData.name || "";
                            document.getElementById("EditCustomer_PhonePerusahaan").value = formData.phone || "";
                            document.getElementById("EditCustomer_EmailPerusahaan").value = formData.email || "";
                            document.getElementById("EditCustomer_AddressPerusahaan").value = formData.address || "";

                            // Trigger Infomedia history search
                            if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                console.log('Triggering Infomedia history search for:', formData.phone);
                                window.InfomedHistory.searchFromParent(formData.phone);
                            } else {
                                console.warn('InfomedHistory not available yet, retrying...');
                                // Retry after a short delay if the component hasn't loaded yet
                                setTimeout(() => {
                                    if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                        console.log('Retry: Triggering Infomedia history search for:', formData.phone);
                                        window.InfomedHistory.searchFromParent(formData.phone);
                                    } else {
                                        console.error('InfomedHistory still not available');
                                    }
                                }, 500);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memperbarui data perusahaan! ' + (data.message || ''),
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);

                    let errorMessage = 'Terjadi kesalahan saat memperbarui data!';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            // Tampilkan pesan error validasi
                            errorMessage = Object.values(response.errors).join('\n');
                        } else if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage,
                    });
                }
            });
        });
    </script>

    <x-slot name="modal">
        <div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTicketModalLabel">Create Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 0 !important;">
                        <iframe src="" frameborder="0" width="100%" height="620px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/libs/emojionearea/dist/emojionearea.min.css" media="screen">
        <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Custom Styles for Ticket Cards and Timeline -->
        <style>
            .ticket-card {
                transition: background-color 0.3s ease;
                border-left: 4px solid transparent;
            }

            .ticket-card:hover {
                border-left-color: #3b82f6;
            }

            .timeline-container {
                position: relative;
                padding: 0;
                overflow: visible;
            }

            /* Garis horizontal di tengah - dipertebal dan 1 warna */
            .timeline-container::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 4px;
                background: #3b82f6;
                transform: translateY(-50%);
                z-index: 1;
            }

            .timeline-item {
                position: relative;
                flex-shrink: 0;
                min-width: 120px;
                display: flex;
                flex-direction: column;
                align-items: center;
                z-index: 2;
            }

            /* Icon di atas garis (index genap) - jarak lebih jauh */
            .timeline-item.even .timeline-icon {
                margin-top: 10px;
                margin-bottom: 130px;
            }

            /* Icon di bawah garis (index ganjil) - jarak lebih jauh */
            .timeline-item.odd .timeline-icon {
                margin-top: 120px;
                margin-bottom: 30px;
            }

            .timeline-icon {
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                background: #1f2937;
                border: 3px solid #374151;
            }

            .timeline-icon:hover {
                transform: scale(1.1);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                border-color: #3b82f6;
            }

            .timeline-icon.active {
                border-color: #3b82f6 !important;
                background-color: #1e40af !important;
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
                transform: scale(1.1);
            }

            /* Layer transition info styling */
            .timeline-icon .layer-transition {
                position: absolute;
                bottom: -25px;
                left: 50%;
                transform: translateX(-50%);
                white-space: nowrap;
                font-size: 10px;
                padding: 2px 6px;
                border-radius: 4px;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(4px);
                z-index: 20;
            }

            .timeline-icon:hover .layer-transition {
                background: rgba(0, 0, 0, 0.9);
            }


            /* Custom scrollbar for horizontal timeline */
            #ticket-timeline::-webkit-scrollbar {
                height: 6px;
            }

            #ticket-timeline::-webkit-scrollbar-track {
                background: #1f2937;
                border-radius: 3px;
            }

            #ticket-timeline::-webkit-scrollbar-thumb {
                background: #374151;
                border-radius: 3px;
            }

            #ticket-timeline::-webkit-scrollbar-thumb:hover {
                background: #4b5563;
            }

            /* Form disabled styling */
            .form-disabled {
                opacity: 0.6;
                pointer-events: none;
            }

            .form-disabled textarea,
            .form-disabled input,
            .form-disabled select {
                background-color: #1f2937 !important;
                color: #6b7280 !important;
                cursor: not-allowed;
            }

            .alert-warning {
                background-color: rgba(234, 179, 8, 0.1);
                border: 1px solid rgba(234, 179, 8, 0.3);
                color: #fbbf24;
                padding: 0.75rem 1rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
            }

        </style>
    </x-slot>
    <x-slot name="modal">
        <div class="modal fade" id="listTemplateChat" tabindex="-1" aria-labelledby="listTemplateChatLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="addModuleModalLabel"> List Template Chat </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Template</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formatted_chat_templates as $i => $formatted_chat_template)
                            <tr>
                                <td>{{ $formatted_chat_template['title'] }}</td>
                                <td id="template-{{ $i }}">{{ $formatted_chat_template['text'] }}</td>
                                <td><button type="button" class="btn btn-primary btn-sm m-1 chooseTemplate" data-template-id="template-{{ $i }}">Gunakan</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addCustomerBC" aria-labelledby="addCustomerBCLabel">
            <div class="modal-dialog">
                <div class="modal-content bg-gray-700 border-0">
                    <div class="modal-header">
                        <h5 class="modal-tittle text-white" id="addModuleModalLabel"> Add PIC </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card bg-gray-900 border-0 rounded-0" id="addCustomerBCCard">
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-md-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input bg-gray-800 border-0"
                                            type="checkbox"
                                            id="PerusahaanSudahAda">
                                        <label class="form-check-label text-white" for="PerusahaanSudahAda">
                                            Perusahaan sudah ada
                                        </label>
                                    </div>
                                </div> --}}
                                {{-- <input type="hidden" id="chat_ticket_user_id"> --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nama/PIC <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="AddCustomer_Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nomor
                                            Telepon<span
                                            class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="AddCustomer_HP">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="AddCustomer_Email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Alamat <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="AddCustomer_Address">
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 d-none" id="searchCustomerDiv">
                                    <div class="mb-3">
                                        <label class="form-label">Cari Perusahaan</label>
                                        <input type="text"
                                        id="SearchCustomer"
                                        class="form-control !bg-gray-800 text-white border-0 cursor-pointer hover:bg-gray-700 transition"
                                        placeholder="Klik untuk cari perusahaan"
                                        readonly
                                        data-bs-toggle="modal"
                                        data-bs-target="#findCustomerModal">
                                    </div>
                                </div> --}}
                                {{-- <div id="perusahaanFields">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control !bg-gray-800 text-white border-0"
                                                id="AddCustomer_NamaPerusahaan">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control !bg-gray-800 text-white border-0"
                                                id="AddCustomer_EmailPerusahaan">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">No. Telepon Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control !bg-gray-800 text-white border-0"
                                                id="AddCustomer_PhonePerusahaan">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control !bg-gray-800 text-white border-0"
                                                id="AddCustomer_AlamatPerusahaan">
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                            <div class="row" id="buttonAddCustomerBC">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary w-sm"
                                        id="SimpanCustomerModal">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addCustomerPerusahaan" aria-labelledby="addCustomerBCLabel">
            <div class="modal-dialog">
                <div class="modal-content bg-gray-700 border-0">
                    <div class="modal-header">
                        <h5 class="modal-tittle text-white" id="addModuleModalLabel"> Add Perusahaan </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card bg-gray-900 border-0 rounded-0" id="addCustomerBCCard">
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-md-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input bg-gray-800 border-0"
                                            type="checkbox"
                                            id="PerusahaanSudahAda">
                                        <label class="form-check-label text-white" for="PerusahaanSudahAda">
                                            Perusahaan sudah ada
                                        </label>
                                    </div>
                                </div> --}}
                                {{-- <input type="hidden" id="chat_ticket_user_id"> --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nama Perusahaan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="AddCustomer_NamePerusahaan">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nomor
                                            Telepon<span
                                            class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="AddCustomer_PhonePerusahaan">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="AddCustomer_EmailPerusahaan">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Alamat <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="AddCustomer_AddressPerusahaan">
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 d-none" id="searchCustomerDiv">
                                    <div class="mb-3">
                                        <label class="form-label">Cari Perusahaan</label>
                                        <input type="text"
                                        id="SearchCustomer"
                                        class="form-control !bg-gray-800 text-white border-0 cursor-pointer hover:bg-gray-700 transition"
                                        placeholder="Klik untuk cari perusahaan"
                                        readonly
                                        data-bs-toggle="modal"
                                        data-bs-target="#findCustomerModal">
                                    </div>
                                </div> --}}
                                {{-- <div id="perusahaanFields">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control !bg-gray-800 text-white border-0"
                                                id="AddCustomer_NamaPerusahaan">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control !bg-gray-800 text-white border-0"
                                                id="AddCustomer_EmailPerusahaan">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">No. Telepon Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control !bg-gray-800 text-white border-0"
                                                id="AddCustomer_PhonePerusahaan">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control !bg-gray-800 text-white border-0"
                                                id="AddCustomer_AlamatPerusahaan">
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                            <div class="row" id="buttonAddCustomerBC">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary w-sm"
                                        id="SimpanCustomerModalPerusahaan">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editCustomerBC"
            tabindex="-1" aria-labelledby="editCustomerBCLabel">
            <div class="modal-dialog">
                <div class="modal-content bg-gray-700 border-0">
                    <div class="modal-header">
                        <h5 class="modal-tittle text-white" id="addModuleModalLabel"> Edit PIC </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card  bg-gray-900 rounded-0 border-0" id="editCustomerBCCard">
                        <div class="card-body">
                            <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_Id" style="display: none;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nama/PIC <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nomor
                                            Telepon</label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_HP">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_Email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Alamat <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_Address">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="buttonAddCustomerBC">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary w-sm"
                                        id="EditCustomerModal">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editCustomerPerusahaan"
            tabindex="-1" aria-labelledby="editCustomerBCLabel">
            <div class="modal-dialog">
                <div class="modal-content bg-gray-700 border-0">
                    <div class="modal-header">
                        <h5 class="modal-tittle text-white" id="addModuleModalLabel"> Edit Perusahaan </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card  bg-gray-900 rounded-0 border-0" id="editCustomerBCCard">
                        <div class="card-body">
                            <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_IdPerusahaan" style="display: none;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nama Perusahaan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_NamePerusahaan">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nomor
                                            Telepon</label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_PhonePerusahaan">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_EmailPerusahaan">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Alamat <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" id="EditCustomer_AddressPerusahaan">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="buttonAddCustomerPerusahaan">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary w-sm"
                                        id="EditCustomerModalPerusahaan">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addOtherChannel"
            tabindex="-1" aria-labelledby="addOtherChannelLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="addModuleModalLabel"> Add Channel </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card" id="DivObjectPerusahaan">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-name-input" class="form-label">Nama Channel<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="Add_Channel_Name"
                                            placeholder="Nama Channel">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-name-input" class="form-label">Value Channel</label>
                                        <input type="text" class="form-control" id="Add_Channel_Value"
                                            placeholder="Value Channel">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary w-sm"
                                    id="SimpanChannel">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editOtherChannel"
            tabindex="-1" aria-labelledby="editOtherChannelLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="editModuleModalLabel"> Edit Channel </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card" id="DivObjectPerusahaan">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control" id="Edit_Channel_ID"
                                        placeholder="Nama Channel">
                                    <div class="mb-3">
                                        <label for="editcontact-name-input" class="form-label">Nama Channel<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="Edit_Channel_Name"
                                            placeholder="Nama Channel">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editcontact-name-input" class="form-label">Value Channel</label>
                                        <input type="text" class="form-control" id="Edit_Channel_Value"
                                            placeholder="Value Channel">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary w-sm" id="EditChannel">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Detail Modal -->
        <div class="modal fade" id="ticketDetailModal" tabindex="-1" aria-labelledby="ticketDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-gray-900 border-0">
                    <div class="modal-header bg-gray-800 border-0">
                        <h5 class="modal-title text-white flex items-center" id="ticketDetailModalLabel">
                            <i class="fas fa-ticket-alt mr-2 text-blue-400"></i>
                            <span id="modal-ticket-number">Ticket Details</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <!-- Ticket Info Header -->
                        <div class="bg-gray-800 p-4 border-b border-gray-700">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                                <div>
                                    <label class="text-gray-400 text-sm">Ticket Number</label>
                                    <p class="text-white font-semibold" id="modal-ticket-number-value">-</p>
                                </div>
                                <div>
                                    <label class="text-gray-400 text-sm">Status</label>
                                    <p class="text-white font-semibold" id="modal-ticket-status">-</p>
                                </div>
                                <div>
                                    <label class="text-gray-400 text-sm">Priority</label>
                                    <p class="text-white font-semibold" id="modal-ticket-priority">-</p>
                                </div>
                                <div>
                                    <label class="text-gray-400 text-sm">Current Layer</label>
                                    <p class="text-blue-400 font-semibold" id="modal-ticket-layer">Layer 1</p>
                                </div>
                                <div>
                                    <label class="text-gray-400 text-sm">Created</label>
                                    <p class="text-white font-semibold" id="modal-ticket-created">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Content -->
                        <div class="p-4">
                            <div class="mb-4">
                                <label class="text-gray-400 text-sm">DataNumber</label>
                                <p class="text-white font-semibold text-lg" id="modal-ticket-subject">-</p>
                            </div>

                            <div class="mb-4">
                                <label class="text-gray-400 text-sm">Description</label>
                                <div class="bg-gray-800 p-3 rounded-lg" id="modal-ticket-description">
                                    <p class="text-gray-300">-</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="text-gray-400 text-sm">Category</label>
                                    <p class="text-white" id="modal-ticket-category">-</p>
                                </div>
                                <div>
                                    <label class="text-gray-400 text-sm">Sub Category</label>
                                    <p class="text-white" id="modal-ticket-subcategory">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Data Payload -->
                        <div class="border-t border-gray-700">
                            <div class="p-4">
                                <h6 class="text-white mb-3 flex items-center border-b border-gray-600 pb-2 font-semibold">
                                    <i class="fas fa-database text-purple-500 mr-2"></i>
                                    Detail Data Payload
                                </h6>
                                <div id="ticket-payload-container" class="bg-gray-700/50 p-4 rounded-xl">
                                    <p class="text-gray-400 text-center py-4">Memuat data payload...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Journey Timeline -->
                        <div class="border-t border-gray-700">
                            <div class="p-4">
                                <h6 class="text-white font-semibold mb-4 flex items-center">
                                    <i class="fas fa-route mr-2 text-blue-400"></i>
                                    Ticket Journey Timeline
                                </h6>

                                <!-- Timeline Container -->
                                <div class="timeline-container relative">
                                    <div id="ticket-timeline" class="flex overflow-x-auto space-x-4 relative overflow-y-hidden">
                                        <!-- Timeline items will be loaded here -->
                                    </div>
                                </div>

                                <!-- Timeline Detail Display -->
                                <div id="timeline-detail-display" class="mt-6 p-4 bg-gray-800 rounded-lg border border-gray-700 hidden">
                                    <div class="flex items-center justify-between mb-3">
                                        <h6 class="text-white font-semibold text-sm" id="detail-title">Timeline Detail</h6>
                                        <button onclick="closeTimelineDetailDisplay()" class="text-gray-400 hover:text-white transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div id="detail-content">
                                        <!-- Detail content will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Detail Form -->
                        <div class="border-t border-gray-700 p-4 bg-gray-800/50">
                            <h6 class="text-white font-semibold mb-3">Add Ticket Detail</h6>
                            <form id="addTicketDetailForm">
                                <input type="hidden" id="ticket-detail-id" name="ticket_id">
                                <input type="hidden" id="ticket-current-layer" name="current_layer" value="1">

                                <!-- Escalation Checkbox -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input bg-gray-700 focus:bg-gray-600 hover:bg-gray-600"
                                               type="checkbox"
                                               id="detail-escalation-checkbox"
                                               name="escalation">
                                        <label class="form-check-label flex items-center text-blue-400 font-medium" for="detail-escalation-checkbox">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span id="detail-escalation-label">Eskalasi ke Layer 2</span>
                                        </label>
                                    </div>
                                    <small class="text-gray-400" id="detail-escalation-description">Centang untuk eskalasi ke layer berikutnya</small>
                                    <div class="mt-1">
                                        <span class="text-xs text-gray-400">Current Layer: </span>
                                        <span class="text-xs font-semibold text-blue-400" id="detail-current-layer-display">Layer 1</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                                    <div>
                                        <label class="form-label text-white text-sm">Status</label>
                                        <select class="form-select bg-gray-700 disabled:bg-gray-700 text-white border-0" id="detail-status">
                                            <option value="" selected>Select Ticket Status</option>
                                            @foreach ($chat_ticket_statuses as $chat_ticket_status)
                                                <option value="{{ $chat_ticket_status->name }}">{{ $chat_ticket_status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label text-white text-sm">Note</label>
                                    <textarea class="form-control bg-gray-700 text-white border-0 focus:bg-gray-700 focus:text-white" id="detail-note" rows="3" placeholder="Add your note here..." required></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus mr-1"></i>
                                        Add Detail
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="js">
        <script>

        </script>
    </x-slot>


    <x-slot name="js">
        <script src="https://cdn.jsdelivr.net/npm/socket.io-client@4.5.3/dist/socket.io.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
        <script src="https://unpkg.com/javascript-time-ago@2.5.9/bundle/javascript-time-ago.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/libs/emojionearea/dist/emojionearea.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/upload.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/libs/localforage/localforage.js"></script>
        <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
        <script>
            (function() {
                window.companyId = '{!! addslashes(current_agent()->company_id) !!}';
                window.currentAgent = JSON.parse('{!! addslashes(json_encode(current_agent())) !!}');
                window.currentAgent.company_id = window.companyId;
                window.listUrls = {
                    baseUrl: '{!! addslashes(url("/")) !!}/',
                    chatHistory: '{!! addslashes(route("chat.history", ["header_id" => ":header_id"])) !!}',
                    userHistory: '{!! addslashes(route("chat.user_histories", ["channel_user_id" => ":channel_user_id"])) !!}',
                    blastHistory: '{!! addslashes(route("chat.user_blast_histories", ["channel_user_id" => ":channel_user_id"])) !!}',
                    allUsers: '{!! addslashes(route("chat.users")) !!}',
                    createTicketUrl: '{!! addslashes(htmlspecialchars_decode(urldecode(get_config("feature.extra.ticket.url", current_agent()->company_id)))) !!}',
                    chatEnd: '{!! addslashes(route("chat.close", ["chat_header" => ":header_id"])) !!}',
                    chatEndWithTicket: '{!! addslashes(route("chat.close-with-ticket", ["chat_header" => ":header_id"])) !!}',
                    chatGetHeader: '{!! addslashes(route("chat.headers")) !!}',
                    chatGetBodies: '{!! addslashes(route("chat.bodies")) !!}',
                    ticketGetByCategory: '{!! addslashes(route("chat_ticket_dropdown.getbycategory", ":variable")) !!}',
                    ticketGetByCategoryType: '{!! addslashes(route("chat_ticket_dropdown.getbycategorytype", ":variable")) !!}',
                    ticketGetByCategoryDetail: '{!! addslashes(route("chat_ticket_dropdown.getbycategorydetail", ":variable")) !!}',
                    syncHeader: '{!! addslashes(route("chat.sync_headers")) !!}',
                    syncHeaderHistory: '{!! addslashes(route("chat.sync_headers.history")) !!}',
                    syncBodies: '{!! addslashes(route("chat.sync_bodies")) !!}',
                    syncBodiesHistory: '{!! addslashes(route("chat.sync_bodies.history")) !!}',
                    syncAllUsers: '{!! addslashes(route("chat.sync_users")) !!}',
                };
            })();
        </script>

        {{-- <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/localforage.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/functions.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/events.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/chat.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/search.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/ticket.js"></script> --}}


        {{-- <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/indexDB.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/http.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/chat.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/message.js"></script> --}}
        {{-- <script type="text/javascript" src="{{ url('/') }}/assets/js/ticketing/tickets.js"></script> --}}

        {{-- <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/socket.js"></script>

        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/instance.js"></script> --}}

        <script>
            // Define socketHandlerGlobal function to prevent ReferenceError
            function socketHandlerGlobal(chat_id, datas) {
                if (typeof ChatSocket !== 'undefined') {
                    new ChatSocket().init(chat_id, datas);
                }
            }
        </script>
        {{-- <script type="text/javascript" src="{{ url('/') }}/assets/js/ticketing/scripts.js"></script> --}}
        {{-- <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/ticket.js"></script> --}}
        <script type="text/javascript" src="{{ url('/') }}/assets/js/ticket-form.js"></script>
        {{-- <script type="text/javascript" src="{{ url('/') }}/assets/js/history-infomed.js"></script> --}}
        <script>
            window.InfomedHistory = {
                searchFromParent: function() {}
            };
        </script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/voice-call.js"></script>

        <!-- New Add Customer Form Event Listeners -->
        <script>

            // Find Customer Modal Functions
            let currentFindPICPage = 1;
            let currentFindPICKeyword = '';

            // Search customers function
            function searchPIC(page = 1, keyword = '') {
                currentFindPICPage = page;
                currentFindPICKeyword = keyword;

                // Show loading
                document.getElementById('findPICLoading').style.display = 'block';
                document.getElementById('findPICResults').style.display = 'none';
                document.getElementById('findPICPagination').style.display = 'none';

                fetch(`/ticketing/ticket/customer/pic?page=${page}&keyword=${encodeURIComponent(keyword)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Hide loading
                    document.getElementById('findPICLoading').style.display = 'none';
                    document.getElementById('findPICResults').style.display = 'block';

                    if (data.success && data.data.customers.length > 0) {
                        renderFindPICResults(data.data.customers);
                        renderFindPICPagination(data.data.pagination);
                    } else {
                        document.getElementById('findPICTableBody').innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center text-gray-400">
                                    No customers found
                                </td>
                            </tr>
                        `;
                        document.getElementById('findPICPagination').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error searching PIC:', error);
                    document.getElementById('findPICLoading').style.display = 'none';
                    document.getElementById('findPICTableBody').innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                Error loading PIC. Please try again.
                            </td>
                        </tr>
                    `;
                });
            }

            // Render customer results
            // function renderFindPICResults(customers) {
            //     const tbody = document.getElementById('findPICTableBody');
            //     tbody.innerHTML = '';

            //     customers.forEach(customer => {
            //         const row = document.createElement('tr');
            //         row.innerHTML = `
            //             <td class="text-white">${customer.name || '-'}</td>
            //             <td class="text-white">${customer.email || '-'}</td>
            //             <td class="text-white">${customer.phone || '-'}</td>
            //             <td class="text-center">
            //                 <button class="btn btn-sm btn-primary" onclick="selectFoundPIC(${customer.id}, '${customer.name}', '${customer.email || ''}', '${customer.phone || ''}', '${customer.address || ''}')">
            //                     <i class="fa fa-check mr-1"></i> Select
            //                 </button>
            //             </td>
            //         `;
            //         tbody.appendChild(row);
            //     });
            // }
            function renderFindPICResults(customers) {
                const tbody = document.getElementById('findPICTableBody');
                tbody.innerHTML = '';

                customers.forEach((customer, index) => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td class="text-white">${customer.name || '-'}</td>
                        <td class="text-white">${customer.email || '-'}</td>
                        <td class="text-white">${customer.phone || '-'}</td>
                        <td class="text-center">
                            <button
                                class="btn btn-sm btn-primary btn-select-pic"
                                data-index="${index}">
                                <i class="fa fa-check mr-1"></i> Select
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });

                // simpan data ke memory (AMAN)
                window.__PIC_DATA__ = customers;

                document.querySelectorAll('.btn-select-pic').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const customer = window.__PIC_DATA__[this.dataset.index];

                        selectFoundPIC(
                            customer.id,
                            customer.name,
                            customer.email,
                            customer.phone,
                            customer.address
                        );
                    });
                });
            }

            // Render pagination
            function renderFindPICPagination(pagination) {
                const paginationList = document.getElementById('findPICPaginationList');
                const paginationInfo = document.getElementById('findPICPaginationInfo');

                if (pagination.last_page <= 1) {
                    document.getElementById('findPICPagination').style.display = 'none';
                    return;
                }

                document.getElementById('findPICPagination').style.display = 'block';
                paginationList.innerHTML = '';

                // Previous button
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${pagination.current_page === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `
                    <a class="page-link bg-gray-800 text-white border-gray-700" href="#" onclick="searchPIC(${pagination.current_page - 1}, currentFindPICKeyword); return false;">
                        Previous
                    </a>
                `;
                paginationList.appendChild(prevLi);

                // Page numbers
                for (let i = 1; i <= pagination.last_page; i++) {
                    // Show first, last, current, and pages around current
                    if (i === 1 || i === pagination.last_page || Math.abs(i - pagination.current_page) <= 1) {
                        const li = document.createElement('li');
                        li.className = `page-item ${i === pagination.current_page ? 'active' : ''}`;
                        li.innerHTML = `
                            <a class="page-link bg-gray-800 text-white border-gray-700 ${i === pagination.current_page ? 'bg-primary' : ''}"
                            href="#"
                            onclick="searchPIC(${i}, currentFindPICKeyword); return false;">
                                ${i}
                            </a>
                        `;
                        paginationList.appendChild(li);
                    } else if (i === 2 || i === pagination.last_page - 1) {
                        // Add ellipsis
                        const li = document.createElement('li');
                        li.className = 'page-item disabled';
                        li.innerHTML = `<span class="page-link bg-gray-800 text-white border-gray-700">...</span>`;
                        paginationList.appendChild(li);
                    }
                }

                // Next button
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}`;
                nextLi.innerHTML = `
                    <a class="page-link bg-gray-800 text-white border-gray-700" href="#" onclick="searchPIC(${pagination.current_page + 1}, currentFindPICKeyword); return false;">
                        Next
                    </a>
                `;
                paginationList.appendChild(nextLi);

                // Pagination info
                paginationInfo.innerHTML = `
                    Showing ${pagination.from || 0} to ${pagination.to || 0} of ${pagination.total} PIC
                `;
            }

            // Select found customer
            function selectFoundPIC(id, name, email, phone, address) {
                // Fill profile data
                document.getElementById("Profile_Nama").textContent = name || "Tidak Ada Nama";
                document.getElementById("Profile_NomorTelepon").textContent = phone || "-";
                document.getElementById("Profile_Email").textContent = email || "-";
                document.getElementById("Profile_Address").textContent = address || "-";
                // document.getElementById('ticket_user_id').value = id || "";

                document.getElementById('hidden_full_name').value = name || "";
                document.getElementById('hidden_contact_number').value = phone || "";
                document.getElementById('hidden_email').value = email || "";

                // Fill edit form
                document.getElementById("EditCustomer_Id").value = id || "";
                document.getElementById("EditCustomer_Name").value = name || "";
                document.getElementById("EditCustomer_HP").value = phone || "";
                document.getElementById("EditCustomer_Email").value = email || "";
                document.getElementById("EditCustomer_Address").value = address || "";

                // Update button visibility
                document.getElementById("addCustomerButton").style.display = "none";
                document.getElementById("editCustomerButton").style.display = "block";

                // Fetch and render channels
                // if (id) {
                //     fetchAndRenderChannels(id);
                // }

                // Fill history ticket list
                // if (phone) {
                //     // fillHistoryTicketList(phone);
                //     loadTicketHistoryByPhone(phone);
                //     // Trigger Infomedia history search
                //     if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                //         console.log('Triggering Infomedia history search for:', phone);
                //         window.InfomedHistory.searchFromParent(phone);
                //     } else {
                //         console.warn('InfomedHistory not available yet, retrying...');
                //         // Retry after a short delay if the component hasn't loaded yet
                //         setTimeout(() => {
                //             if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                //                 console.log('Retry: Triggering Infomedia history search for:', phone);
                //                 window.InfomedHistory.searchFromParent(phone);
                //             } else {
                //                 console.error('InfomedHistory still not available');
                //             }
                //         }, 500);
                //     }
                // }

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('findPICModal'));
                if (modal) {
                    modal.hide();
                }

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'PIC Selected',
                    text: `${name} has been selected successfully!`,
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            // Event listeners for Find Customer modal
            document.addEventListener('DOMContentLoaded', function() {
                // Search button click
                const findPICSearchBtn = document.getElementById('findPICSearchBtn');
                if (findPICSearchBtn) {
                    findPICSearchBtn.addEventListener('click', function() {
                        const keyword = document.getElementById('findPICSearchInput').value.trim();
                        searchPIC(1, keyword);
                    });
                }

                // Search on Enter key
                const findPICSearchInput = document.getElementById('findPICSearchInput');
                if (findPICSearchInput) {
                    findPICSearchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            const keyword = this.value.trim();
                            searchPIC(1, keyword);
                        }
                    });

                    // Real-time search (optional - searches as user types)
                    let searchTimeout;
                    findPICSearchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        const keyword = this.value.trim();

                        if (keyword.length >= 3 || keyword.length === 0) {
                            searchTimeout = setTimeout(() => {
                                searchPIC(1, keyword);
                            }, 500);
                        }
                    });
                }

                // Load initial data when modal is opened
                const findPICModal = document.getElementById('findPICModal');
                if (findPICModal) {
                    findPICModal.addEventListener('shown.bs.modal', function() {
                        // Load all customers initially
                        searchPIC(1, '');
                        // Focus search input
                        document.getElementById('findPICSearchInput').focus();
                    });

                    // Clear search when modal is closed
                    findPICModal.addEventListener('hidden.bs.modal', function() {
                        document.getElementById('findPICSearchInput').value = '';
                        document.getElementById('findPICTableBody').innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center text-gray-400">
                                    Enter search keyword to find PIC
                                </td>
                            </tr>
                        `;
                        document.getElementById('findPICPagination').style.display = 'none';
                    });
                }
            });
        </script>

        <!-- New Add Customer Form Event Listeners -->
        <script>

            // Find Customer Modal Functions
            let findCustomerMode = 'profile'; // default
            let currentFindCustomerPage = 1;
            let currentFindCustomerKeyword = '';

            // Search customers function
            function searchCustomers(page = 1, keyword = '') {
                currentFindCustomerPage = page;
                currentFindCustomerKeyword = keyword;

                // Show loading
                document.getElementById('findCustomerLoading').style.display = 'block';
                document.getElementById('findCustomerResults').style.display = 'none';
                document.getElementById('findCustomerPagination').style.display = 'none';

                fetch(`/ticketing/ticket/customer/search?page=${page}&keyword=${encodeURIComponent(keyword)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Hide loading
                    document.getElementById('findCustomerLoading').style.display = 'none';
                    document.getElementById('findCustomerResults').style.display = 'block';

                    if (data.success && data.data.customers.length > 0) {
                        renderFindCustomerResults(data.data.customers);
                        renderFindCustomerPagination(data.data.pagination);
                    } else {
                        document.getElementById('findCustomerTableBody').innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center text-gray-400">
                                    No Perusahaan found
                                </td>
                            </tr>
                        `;
                        document.getElementById('findCustomerPagination').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error searching customers:', error);
                    document.getElementById('findCustomerLoading').style.display = 'none';
                    document.getElementById('findCustomerTableBody').innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                Error loading Perusahaan. Please try again.
                            </td>
                        </tr>
                    `;
                });
            }

            // document.getElementById('PerusahaanSudahAda').addEventListener('change', function () {
            //     const perusahaanFields = document.getElementById('perusahaanFields');
            //     const searchCustomerDiv = document.getElementById('searchCustomerDiv');

            //     if (this.checked) {
            //         perusahaanFields.style.display = 'none';
            //         searchCustomerDiv.classList.remove('d-none');

            //         findCustomerMode = 'chat'; // 🔥 MODE CHAT
            //         perusahaanFields.querySelectorAll('input').forEach(i => i.value = '');
            //     } else {
            //         perusahaanFields.style.display = 'block';
            //         searchCustomerDiv.classList.add('d-none');

            //         findCustomerMode = 'profile'; // 🔁 MODE PROFILE
            //         document.getElementById('chat_ticket_user_id').value = '';
            //         document.getElementById('SearchCustomer').value = '';
            //     }
            // });

            // Render customer results
            function renderFindCustomerResults(customers) {
                const tbody = document.getElementById('findCustomerTableBody');
                tbody.innerHTML = '';

                customers.forEach(customer => {
                    const selectBtn =
                        findCustomerMode === 'chat'
                            ? `selectCustomerForChat(${customer.id}, '${customer.name}')`
                            : `selectFoundCustomer(${customer.id}, '${customer.name}', '${customer.email || ''}', '${customer.phone || ''}', '${customer.address || ''}')`;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="text-white">${customer.name || '-'}</td>
                        <td class="text-white">${customer.email || '-'}</td>
                        <td class="text-white">${customer.phone || '-'}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary"
                                onclick="${selectBtn}">
                                <i class="fa fa-check mr-1"></i> Select
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }

            function selectCustomerForChat(id, name) {
                // Isi hidden field
                document.getElementById('chat_ticket_user_id').value = id;

                // Isi input search perusahaan
                const searchInput = document.getElementById('SearchCustomer');
                if (searchInput) {
                    searchInput.value = name;
                }

                // Tutup modal FIND
                const findModalEl = document.getElementById('findCustomerModal');
                const findModal = bootstrap.Modal.getInstance(findModalEl);
                if (findModal) {
                    findModal.hide();
                }

                // 🔥 BUKA LAGI MODAL ADD (SETELAH FIND TERTUTUP)
                setTimeout(() => {
                    const addModalEl = document.getElementById('addCustomerBC');
                    const addModal = bootstrap.Modal.getOrCreateInstance(addModalEl);
                    addModal.show();
                }, 300); // delay kecil agar animasi bootstrap aman

                // Notifikasi (optional)
                Swal.fire({
                    icon: 'success',
                    title: 'Perusahaan Dipilih',
                    text: name,
                    timer: 1200,
                    showConfirmButton: false
                });
            }



            // Render pagination
            function renderFindCustomerPagination(pagination) {
                const paginationList = document.getElementById('findCustomerPaginationList');
                const paginationInfo = document.getElementById('findCustomerPaginationInfo');

                if (pagination.last_page <= 1) {
                    document.getElementById('findCustomerPagination').style.display = 'none';
                    return;
                }

                document.getElementById('findCustomerPagination').style.display = 'block';
                paginationList.innerHTML = '';

                // Previous button
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${pagination.current_page === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `
                    <a class="page-link bg-gray-800 text-white border-gray-700" href="#" onclick="searchCustomers(${pagination.current_page - 1}, currentFindCustomerKeyword); return false;">
                        Previous
                    </a>
                `;
                paginationList.appendChild(prevLi);

                // Page numbers
                for (let i = 1; i <= pagination.last_page; i++) {
                    // Show first, last, current, and pages around current
                    if (i === 1 || i === pagination.last_page || Math.abs(i - pagination.current_page) <= 1) {
                        const li = document.createElement('li');
                        li.className = `page-item ${i === pagination.current_page ? 'active' : ''}`;
                        li.innerHTML = `
                            <a class="page-link bg-gray-800 text-white border-gray-700 ${i === pagination.current_page ? 'bg-primary' : ''}"
                            href="#"
                            onclick="searchCustomers(${i}, currentFindCustomerKeyword); return false;">
                                ${i}
                            </a>
                        `;
                        paginationList.appendChild(li);
                    } else if (i === 2 || i === pagination.last_page - 1) {
                        // Add ellipsis
                        const li = document.createElement('li');
                        li.className = 'page-item disabled';
                        li.innerHTML = `<span class="page-link bg-gray-800 text-white border-gray-700">...</span>`;
                        paginationList.appendChild(li);
                    }
                }

                // Next button
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}`;
                nextLi.innerHTML = `
                    <a class="page-link bg-gray-800 text-white border-gray-700" href="#" onclick="searchCustomers(${pagination.current_page + 1}, currentFindCustomerKeyword); return false;">
                        Next
                    </a>
                `;
                paginationList.appendChild(nextLi);

                // Pagination info
                paginationInfo.innerHTML = `
                    Showing ${pagination.from || 0} to ${pagination.to || 0} of ${pagination.total} Perusahaan
                `;
            }

            function selectFoundCustomer(id, name, email, phone, address) {
                // Fill profile data
                document.getElementById("nama_perusahaan").textContent = name || "Tidak Ada Nama";
                document.getElementById("phone_perusahaan").textContent = phone || "-";
                document.getElementById("email_perusahaan").textContent = email || "-";
                // document.getElementById("Profile_Address").textContent = address || "-";
                document.getElementById('ticket_user_id').value = id || "";

                // document.getElementById('hidden_full_name').value = name || "";
                // document.getElementById('hidden_contact_number').value = phone || "";
                // document.getElementById('hidden_email').value = email || "";

                // Fill edit form
                document.getElementById("EditCustomer_IdPerusahaan").value = id || "";
                document.getElementById("EditCustomer_NamePerusahaan").value = name || "";
                document.getElementById("EditCustomer_PhonePerusahaan").value = phone || "";
                document.getElementById("EditCustomer_EmailPerusahaan").value = email || "";
                document.getElementById("EditCustomer_AddressPerusahaan").value = address || "";

                // Update button visibility
                document.getElementById("addPerusahaanButton").style.display = "none";
                document.getElementById("editPerusahaanButton").style.display = "block";

                // Fetch and render channels
                // if (id) {
                //     fetchAndRenderChannels(id);
                // }

                // Fill history ticket list
                if (phone) {
                    // fillHistoryTicketList(phone);
                    loadTicketHistoryByPhone(phone);
                    // Trigger Infomedia history search
                    if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                        console.log('Triggering Infomedia history search for:', phone);
                        window.InfomedHistory.searchFromParent(phone);
                    } else {
                        console.warn('InfomedHistory not available yet, retrying...');
                        // Retry after a short delay if the component hasn't loaded yet
                        setTimeout(() => {
                            if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                console.log('Retry: Triggering Infomedia history search for:', phone);
                                window.InfomedHistory.searchFromParent(phone);
                            } else {
                                console.error('InfomedHistory still not available');
                            }
                        }, 500);
                    }
                }

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('findCustomerModal'));
                if (modal) {
                    modal.hide();
                }

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Perusahaan Selected',
                    text: `${name} has been selected successfully!`,
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            // Event listeners for Find Customer modal
            document.addEventListener('DOMContentLoaded', function() {
                // Search button click
                const findCustomerSearchBtn = document.getElementById('findCustomerSearchBtn');
                if (findCustomerSearchBtn) {
                    findCustomerSearchBtn.addEventListener('click', function() {
                        const keyword = document.getElementById('findCustomerSearchInput').value.trim();
                        searchCustomers(1, keyword);
                    });
                }

                // Search on Enter key
                const findCustomerSearchInput = document.getElementById('findCustomerSearchInput');
                if (findCustomerSearchInput) {
                    findCustomerSearchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            const keyword = this.value.trim();
                            searchCustomers(1, keyword);
                        }
                    });

                    // Real-time search (optional - searches as user types)
                    let searchTimeout;
                    findCustomerSearchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        const keyword = this.value.trim();

                        if (keyword.length >= 3 || keyword.length === 0) {
                            searchTimeout = setTimeout(() => {
                                searchCustomers(1, keyword);
                            }, 500);
                        }
                    });
                }

                // Load initial data when modal is opened
                const findCustomerModal = document.getElementById('findCustomerModal');
                if (findCustomerModal) {
                    findCustomerModal.addEventListener('shown.bs.modal', function() {
                        // Load all customers initially
                        searchCustomers(1, '');
                        // Focus search input
                        document.getElementById('findCustomerSearchInput').focus();
                    });

                    // Clear search when modal is closed
                    findCustomerModal.addEventListener('hidden.bs.modal', function() {
                        document.getElementById('findCustomerSearchInput').value = '';
                        document.getElementById('findCustomerTableBody').innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center text-gray-400">
                                    Enter search keyword to find Perusahaan
                                </td>
                            </tr>
                        `;
                        document.getElementById('findCustomerPagination').style.display = 'none';
                    });
                }
            });


            async function storeCallThreads(phone) {
                try {
                    const response = await fetch('/threads', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            Flaging: 0,
                            phone: phone,
                        })
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Alert',
                            text: result.message || 'Terjadi kesalahan saat menyimpan thread.'
                        });
                        return null;
                    }

                    // ✅ Ambil ID dari response
                    const threadId = result?.data?.id || result?.id || null;

                    if (!threadId) {
                        console.warn('Thread ID tidak ditemukan di response');
                        return null;
                    }

                    // ✅ Set ke hidden input
                    const threadInput = document.getElementById('thread_id');
                    if (threadInput) {
                        threadInput.value = threadId;
                    }

                    return threadId;

                } catch (error) {
                    console.error('Error storing thread:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Terjadi error pada proses request.'
                    });

                    return null;
                }
            }


            document.addEventListener('DOMContentLoaded', function () {
                const kbTabTrigger = document.querySelector('a[href="#related-articles"]');
                kbTabTrigger?.addEventListener('shown.bs.tab', function () {
                    window.ticketingAiKbInstance?.refreshForCurrentContext();
                });
            });

        </script>

    </x-slot>
</x-dashonic-horizontal-layout>
