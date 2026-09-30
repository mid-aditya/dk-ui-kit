<x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
    with-header="{{ request()->get('with-header') ?? 1 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">


    <style>
        ::marker {
            display: none !important;
            color: #fff;
        }

        .font-poppins {
            /* font-family: 'Poppins', sans-serif; */
            font-family: 'Nunito', sans-serif;
        }

        .custom-swal {
            width: 350px !important;
            height: auto !important;
            min-height: 50px !important;
            padding: 10px 15px !important;
            font-size: 12px !important;
            overflow: hidden !important;
        }

        .custom-swal .swal2-title {
            font-size: 14px !important;
            margin-bottom: 5px !important;
        }

        .custom-swal .swal2-content {
            font-size: 12px !important;
        }

        .custom-swal .swal2-icon {
            width: 30px !important;
            height: 30px !important;
            margin: 5px auto !important;
        }

        .chat-open {
            background-color: rgba(3, 142, 220, .075);
            border-color: transparent;
        }

        a.nav-link-custom {
            padding-right: 0.3rem !important;
            padding-left: 1rem !important;
        }

        .emojionearea-editor {
            overflow-y: hidden;
        }

        .overflow-x-auto::-webkit-scrollbar {
            width: 12px;
            height: 12px;
            background: transparent;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #FF8C00;
            border-radius: 6px;
            border: 3px solid transparent;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        .overflow-x-auto {
            scrollbar-color: #FF8C00 transparent;
            scrollbar-width: thin;
        }

        /* Chat list styling */
        .chat-list li {
            background: #1F2937;
            border: 1px solid #374151;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .chat-list li:hover {
            background: #374151;
        }

        .chat-list li.active {
            background: #374151;
            border-color: #4B5563;
        }

        .chat-list li a {
            color: #E5E7EB;
            padding: 0.75rem;
        }

        .chat-list li .text-truncate {
            color: #9CA3AF;
        }

        /* Chat input styling */
        .chat-input-section {
            background: #1F2937;
            border-top: 1px solid #374151;
        }

        .chat-input-section textarea {
            background: #374151 !important;
            border: 1px solid #4B5563 !important;
            color: #E5E7EB !important;
        }

        .chat-input-section textarea:focus {
            background: #374151 !important;
            border-color: #FF8C00 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25) !important;
        }

        /* Button styling */
        .btn-primary {
            background: #FF8C00 !important;
            border-color: #FF8C00 !important;
        }

        .btn-primary:hover {
            background: #E67E00 !important;
            border-color: #E67E00 !important;
        }

        .btn-outline-secondary {
            color: #E5E7EB !important;
            border-color: #4B5563 !important;
        }

        .btn-outline-secondary:hover {
            background: #374151 !important;
            border-color: #4B5563 !important;
        }

        /* Form controls */
        .form-control,
        .form-select {
            background: #374151 !important;
            border: 1px solid #4B5563 !important;
            color: #E5E7EB !important;
        }

        .form-control:focus,
        .form-select:focus {
            background: #374151 !important;
            border-color: #FF8C00 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25) !important;
        }

        /* Nav tabs */
        .nav-tabs-custom {
            background: #1F2937 !important;
            border-bottom: 1px solid #374151 !important;
        }

        .nav-tabs-custom .nav-link {
            color: #9CA3AF !important;
        }

        .nav-tabs-custom .nav-link.active {
            color: #E5E7EB !important;
            background: #374151 !important;
            border-color: #4B5563 !important;
        }

        /* Card styling */
        .card {
            background: #1F2937 !important;
            border: 1px solid #374151;
        }

        .card-header {
            background: #374151 !important;
            border-bottom: 1px solid #4B5563 !important;
        }

        .card-title {
            color: #E5E7EB !important;
        }

        /* Modal styling */
        .modal-content {
            background: #1F2937 !important;
            border: 1px solid #374151 !important;
        }

        .modal-header {
            background: #374151 !important;
            border-bottom: 1px solid #4B5563 !important;
        }

        .modal-title {
            color: #E5E7EB !important;
        }

        .modal-footer {
            background: #374151 !important;
            border-top: 1px solid #4B5563 !important;
        }

        /* Table styling */
        .table {
            color: #E5E7EB !important;
        }

        .table-bordered {
            border-color: #4B5563 !important;
        }

        .table thead th {
            background: #374151 !important;
            border-color: #4B5563 !important;
        }

        .table tbody td {
            border-color: #4B5563 !important;
        }

        /* Dropdown styling */
        .dropdown-menu {
            background: #1F2937 !important;
            border: 1px solid #374151 !important;
        }

        .dropdown-item {
            color: #E5E7EB !important;
        }

        .dropdown-item:hover {
            background: #374151 !important;
        }

        /* Alert styling */
        .alert-info {
            background: #374151 !important;
            border-color: #4B5563 !important;
            color: #E5E7EB !important;
        }

        #btn-show-meta-session::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: white;
            z-index: 1;
            /* Agar berada di bawah garis hijau saat hover */
        }

        /* Underline hijau hanya saat hover */
        #btn-show-meta-session::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 2px;
            background-color: #22c55e;
            /* Tailwind green-500 */
            transition: width 0.3s ease-in-out;
            z-index: 2;
            /* Di atas underline putih */
        }

        #btn-show-meta-session:hover::after {
            width: 100%;
        }

        #btn-show-meta-session .svg-icon {
            color: white;
            transition: color 0.3s ease-in-out;
        }

        /* Saat hover, ubah warna ke green-500 */
        #btn-show-meta-session:hover .svg-icon {
            color: #22c55e;
            /* Tailwind green-500 */
        }

        /* Custom scrollbar for textarea */
        #chat-input-text::-webkit-scrollbar {
            width: 6px;
            background: transparent;
        }

        #chat-input-text::-webkit-scrollbar-thumb {
            background: #FF8C00;
            border-radius: 3px;
        }

        #chat-input-text::-webkit-scrollbar-track {
            background: transparent;
        }

        #chat-input-text {
            scrollbar-width: thin;
            scrollbar-color: #FF8C00 transparent;
        }

        .chat-conversation,
        .session-conversation {
            flex-grow: 1 !important;
            height: 100% !important;
            min-height: 0 !important;
            overflow-y: auto !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box;
            display: block;
        }

        .user-chat .card.bg-gray-900.border-0.mb-0.h-full.flex.flex-col {
            height: 100% !important;
            display: flex;
            flex-direction: column;
        }

        .session-list-item:hover,
        .session-list-a.session-open {
            background: #232b3b !important;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .session-conversation {
            flex-grow: 1 !important;
            height: 100% !important;
            min-height: 0 !important;
            overflow-y: auto !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box;
            display: block;
        }

        .row.h-[calc(100vh-3rem)].overflow-hidden {
            height: calc(100vh - 3rem) !important;
            min-height: 0 !important;
            display: flex;
            flex-wrap: nowrap;
            overflow: hidden;
        }

        .col-lg-5.h-full,
        .user-chat,
        .user-chat .card.bg-gray-900.border-0.mb-0.h-full.flex.flex-col {
            height: 100% !important;
            min-height: 0 !important;
            display: flex;
            flex-direction: column;
        }

        .chat-conversation,
        .session-conversation {
            height: 100% !important;
            min-height: 0 !important;
            flex-grow: 1 !important;
            overflow-y: auto !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box;
            display: block;
        }

        .session-conversation {
            max-height: calc(100vh - 180px); /* 180px = header + footer, sesuaikan jika perlu */
            overflow-y: auto;
            min-height: 200px;
        }
        #session-footer {
            min-height: 60px;
            padding-bottom: 10px;
        }

        /* For Webkit browsers */
        .modal-dialog-scrollable::-webkit-scrollbar,
        .modal-content::-webkit-scrollbar,
        .modal-body::-webkit-scrollbar {
            width: 8px;
            background: transparent !important;
        }

        .modal-dialog-scrollable::-webkit-scrollbar-thumb,
        .modal-content::-webkit-scrollbar-thumb,
        .modal-body::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2); /* or transparent if you want no thumb at all */
            border-radius: 4px;
        }

        /* For Firefox */
        .modal-dialog-scrollable,
        .modal-content,
        .modal-body {
            scrollbar-color: transparent transparent !important;
            scrollbar-width: thin;
        }

        /* WhatsApp-style preview bubble for template preview */
        #templatePreview {
            background: #ece5dd !important;
            border-radius: 18px;
            padding: 32px 0 32px 0 !important;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
        }

        #selectedTemplatePreview {
            background: transparent !important;
            border: none;
            box-shadow: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        /* Chat bubble (outgoing) */
        .preview-chat-bubble, .preview-chat-bubble-body {
            background: #d9fdd3;
            border-radius: 12px 0px 12px 12px;
            padding: 16px 20px 8px 20px;
            margin-bottom: 8px;
            max-width: 350px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            font-family: 'Segoe UI', 'Poppins', Arial, sans-serif;
            font-size: 15px;
            color: #e5e7eb !important; /* Tailwind gray-200 */
            position: relative;
        }
        .preview-chat-bubble-body {
            border-radius: 12px 0px 12px 12px;
            margin-top: 0;
        }
        .preview-card-title, .preview-card-link, .preview-card-url, .preview-chat-timestamp, .preview-chat-bubble, .preview-chat-bubble-body, .preview-card-body, .preview-card {
            color: #e5e7eb !important;
        }

        /* Card carousel container */
        .preview-card-carousel {
            display: flex;
            gap: 12px;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        /* Card style */
        .preview-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 0;
            width: 240px;
            min-width: 220px;
            max-width: 260px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        .preview-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
        .preview-card-body {
            padding: 12px 16px 10px 16px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .preview-card-title {
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 2px;
            color: #222;
        }
        .preview-card-link {
            color: #0b57d0;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            margin-top: 4px;
        }
        .preview-card-link:hover {
            text-decoration: underline;
        }
        .preview-card-url {
            color: #3b4a54;
            font-size: 13px;
            word-break: break-all;
        }
        /* Timestamp style */
        .preview-chat-timestamp {
            font-size: 12px;
            color: #7a7a7a;
            text-align: right;
            margin-top: 4px;
        }
        #defaultPreview {
            background : #d9fdd3;
        }
        #defaultOutboundPreview {
            background : #d9fdd3;
        }
        #outboundTemplatePreview {
            background: #ece5dd !important;
            border-radius: 18px;
            padding: 32px 0 32px 0 !important;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
        }

        #selectedOutboundTemplatePreview {
            background: transparent !important;
            border: none;
            box-shadow: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .whatsapp-preview {
            border-radius: 12px;
            background-color: #f0ece8;
            color: #111;
            max-width: 480px;
            margin: auto;
            padding: 16px;
        }

        /* Timeline styling untuk Chat V3 Ticket Detail Modal */
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
        #chatv3-ticket-timeline::-webkit-scrollbar {
            height: 6px;
        }

        #chatv3-ticket-timeline::-webkit-scrollbar-track {
            background: #1f2937;
            border-radius: 3px;
        }

        #chatv3-ticket-timeline::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 3px;
        }

        #chatv3-ticket-timeline::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }

        /* Form disabled styling */
        #chatv3-addTicketDetailForm.form-disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        #chatv3-addTicketDetailForm.form-disabled textarea,
        #chatv3-addTicketDetailForm.form-disabled input,
        #chatv3-addTicketDetailForm.form-disabled select {
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

        /* Styling untuk blast item yang bisa di-klik */
        .blast-item-clickable {
            transition: all 0.2s ease;
        }

        .blast-item-clickable:hover {
            background-color: #374151 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .blast-item-clickable.selected-blast {
            background-color: #1e3a5f !important;
            border: 2px solid #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
</style>

    </style>
    <!-- Header Section -->
    <div class="row h-[calc(100vh-3rem)] overflow-hidden">
        <div class="col-lg-3 px-1 h-full">
            <div class="card p-2 bg-gray-900 border-0 h-full flex flex-col">
                <div id="chat" class="flex flex-col h-full">
                    <ul class="nav nav-tabs-custom bg-gray-800 rounded-top nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#left-chat" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Chat</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#left-users" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">All Users</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-2 text-muted flex-grow overflow-hidden">
                        <div class="tab-pane active h-full flex flex-col" id="left-chat" role="tabpanel">
                            <div class="mb-2 mt-2">
                                <input type="text"
                                    class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800" name="search"
                                    onkeyup="onSearchHeader(this)" placeholder="Search">
                            </div>
                            <ul class="nav nav-tabs-custom bg-gray-700 rounded-top nav-justified" role="tablist"
                                id="sampleTabs">
                                <li class="nav-item">
                                    <a class="nav-link nav-link-custom active" data-bs-toggle="tab" href="#" role="tab"
                                        onclick="openChatTab('served')" data-chat-status="3">
                                        <center><i class="mdi mdi-24px mdi-account-arrow-left-outline"></i></center>
                                        Served (<span id="served-count">0</span>)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nav-link-custom" data-bs-toggle="tab" href="#" role="tab"
                                        onclick="openChatTab('chatbot')" data-chat-status="5">
                                        <center><i class="mdi mdi-24px mdi-robot"></i></center>
                                        Chatbot (<span id="chatbot-count">0</span>)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nav-link-custom" data-bs-toggle="tab" href="#" role="tab"
                                        onclick="openChatTab('resolved')" data-chat-status="4">
                                        <center><i class="mdi mdi-24px mdi-account-check-outline"></i></center>
                                        Resolved (<span id="resolved-count">0</span>)
                                    </a>
                                </li>
                            </ul>
                            <!-- Tambahkan ini untuk daftar sesi bot (hanya akan diisi saat tab chatbot aktif) -->
                            <ul class="session-list" id="session-list" style="margin-top: 10px;"></ul>
                            <div class="chat-message-list flex-grow overflow-y-auto" id="chat-message-list"
                                data-current-tab="served" data-simplebar>
                                <div>
                                    <ul class="list-unstyled chat-list" id="chat-list">
                                        <!-- Served chats will be loaded here -->
                                    </ul>
                                    <ul class="list-unstyled chat-list" id="chat-list-resolved" style="display: none;">
                                        <!-- Resolved chats will be loaded here -->
                                    </ul>
                                    <ul class="list-unstyled chat-list" id="chat-list-chatbot" style="display: none;">
                                        <!-- Chatbot sessions will be loaded here -->
                                    </ul>
                                    <div id="loader"></div>
                                    <textarea name="json_headers" id="json_headers" cols="30" rows="10"
                                        class="d-none">[]</textarea>
                                </div>
                            </div>

                            <div class="alert alert-info text-center mt-3" id="alert-loading" style="display: none;">
                                <h5>Importing chat</h5>
                            </div>
                        </div>
                        <div class="tab-pane h-full flex flex-col" id="left-users" role="tabpanel">
                            <div class="mb-2 mt-2">
                                <input type="text"
                                    class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                    name="search-user" id="search-user" onkeyup="cariUser(this)" placeholder="Search">
                            </div>
                            <div class="overflow-y-auto flex-grow">
                                <ul class="list-unstyled chat-list" id="placeAllUsers">
                                </ul>
                            </div>
                            <textarea name="json_users" id="json_users" cols="30" rows="10" class="d-none"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 px-1 h-full">
            <div class="w-100 user-chat h-full">
                <div class="card bg-gray-900 border-0 mb-0 h-full flex flex-col">
                    <div class="p-2 border-bottom">
                        <div class="row">
                            <div class="col-xl-6 col-8">
                                <div class="d-flex align-items-center" id="header-datas">
                                    <!-- use avatar from user -->
                                    <div class="flex-shrink-0 avatar me-3 d-sm-block d-none">
                                        <img src="/assets/images/icons/user.png" alt=""
                                            class="img-thumbnail d-block rounded-circle">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="font-size-16 mb-1 text-white font-poppins"><a href="#"
                                                class="text-white"></a></h5>
                                        {{-- <p class="text-muted text-truncate mb-0"><i
                                                class="mdi mdi-circle text-success font-size-10 align-middle me-1"></i>Online
                                        </p> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-4 d-flex align-items-center justify-content-end">
                                {{-- <div id="CallOutbound" class="flex items-center justify-end mr-3" style="display: none;">
                                    <button type="button"
                                            class="font-size-24 text-gray-400 hover:text-white transition"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmCallModal">
                                        <i class="fa fa-phone-alt"></i>
                                    </button>
                                </div>

                                <div id="OutboundButton" class="flex items-center justify-end mr-3" style="display: none;">
                                    <button type="button" class="font-size-24 text-gray-400 hover:text-white transition" data-bs-toggle="modal" data-bs-target="#OutboundTemplateModal">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                </div> --}}

                                <!-- Modal Konfirmasi Panggil -->
                                <div class="modal fade" id="confirmCallModal" tabindex="-1" aria-labelledby="confirmCallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-lg shadow-lg">
                                        <div class="modal-header border-0 pb-3 mb-3 bg-gray-800">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center px-5 pb-5 pt-0">
                                        <div class="mb-4">
                                            <i class="fa fa-phone-alt text-green-500 text-4xl"></i>
                                        </div>
                                        <h5 class="modal-title mb-4 text-lg font-semibold" id="confirmCallModalLabel">Yakin ingin menelpon?</h5>

                                        <div class="text-left mb-4">
                                            <p class="text-white"><strong>Nama:</strong> <span id="callName">-</span></p>
                                            <p class="text-white"><strong>Nomor Telepon:</strong> <span id="callNumber">-</span></p>
                                        </div>

                                        <div class="d-flex justify-content-between gap-3">
                                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">
                                            Batal
                                            </button>
                                            <button type="button" id="callButton" class="btn btn-success w-100" onclick="handleMakeCall()">
                                            Panggil
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                {{-- Modal Outbound Template --}}
                                <div class="modal fade" id="OutboundTemplateModal" tabindex="-1" aria-labelledby="modalPilihTemplateLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                        <div class="modal-content bg-gray-900 text-white" style="overflow: auto;">
                                            <div class="modal-header border-bottom border-gray-700">
                                                <h5 class="modal-title font-poppins" id="modalPilihTemplateLabel">Choose Template To Start Outbound</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Notification Alert -->
                                                <div class="alert alert-warning mb-4" role="alert">
                                                    <p class="mb-0 font-poppins">To start the Call, Need The agreement from the Customer.</p>
                                                </div>

                                                <div class="flex flex-col mb-4">
                                                    <h5 class="text-white font-bold">Kirim ke :</h5>
                                                    <p>Nama : <span id="outbound-user-name"></p>
                                                    <p>Phone : <span id="outbound-user-phone"></p>
                                                </div>

                                                <!-- Dropdown Jenis -->
                                                <div class="mb-4">
                                                    <label class="form-label">SELECT CATEGORY</label>
                                                    <select id="selectOutboundTemplateCategory" class="form-select bg-gray-800 text-white border-gray-700">
                                                        <option value="all">All</option>
                                                        <option value="marketing">Marketing</option>
                                                        <option value="utility">Utility</option>
                                                        {{-- <option value="authentication">Authentication</option>
                                                        <option value="outbound">Outbound</option> --}}
                                                    </select>
                                                </div>

                                                <!-- Template Selection and Preview Layout -->
                                                <div class="row">
                                                    <!-- Template List -->
                                                    <div class="col-md-6">
                                                        <div id="templateLoader" class="text-center my-4" style="display: none;">
                                                            <div class="spinner-border text-light" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                            <div class="mt-2 text-white">Loading templates...</div>
                                                        </div>
                                                        <div id="templateListWrapper" style="display: none;">
                                                            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                                                                <div class="px-6 py-4">
                                                                    <h2 class="text-xl font-semibold text-white flex items-center">
                                                                        <i class="bx bx-table mr-2 text-blue-500"></i>
                                                                        Template List
                                                                    </h2>
                                                                </div>
                                                                <div class="overflow-x-auto">
                                                                    <table class="w-full" id="templatesTableTitle">
                                                                        <thead class="bg-gray-700">
                                                                            <tr>
                                                                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Template Name</th>
                                                                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                                                                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Language</th>
                                                                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="divide-y divide-gray-700" id="templatesListSelect">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Preview Section -->
                                                    <div class="col-md-6">
                                                        <div class="bg-gray-700 rounded-xl shadow-lg p-4 h-100">
                                                            <h2 class="text-xl font-semibold text-white mb-4">Preview</h2>
                                                            <div id="outboundTemplatePreview" class="bg-gray-700 p-3 rounded-lg" style="display: block;">
                                                                <div id="defaultOutboundPreview" class="p-3 rounded-lg w-50" style="margin-left: 225px; min-height: 100px;">
                                                                    <p class="mb-0 font-poppins text-gray-400">-</p>
                                                                </div>
                                                                <div id="selectedOutboundTemplatePreview" class="bg-gray-700 p-3 rounded-lg ml-32" style="display: none;">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="mt-4 d-flex justify-content-end gap-2">
                                                    <button id="btnSendSelectedTemplate" class="btn btn-success">Send Template</button>
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <button
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300"
                                    onclick="document.getElementById('whatsappModal').showModal()">
                                    Open WhatsApp Session
                                </button> --}}

                                <!-- Modal -->
                                {{-- <dialog id="whatsappModal" class="rounded-lg shadow-xl bg-white w-full max-w-md">
                                    <div class="p-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <h5 class="text-xl font-semibold text-gray-800">Active WhatsApp Session</h5>
                                            <button onclick="document.getElementById('whatsappModal').close()"
                                                class="text-gray-500 hover:text-gray-700">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-gray-600">Here you can manage your active WhatsApp sessions.
                                            </p>
                                            <!-- Add your content here, e.g., session details, forms, etc. -->
                                            <ul class="list-disc list-inside text-gray-700 mt-2">
                                                <li>Session ID: 12345</li>
                                                <li>Connected Device: Example Device</li>
                                                <li>Last Active: June 13, 2025</li>
                                            </ul>
                                        </div>
                                        <div class="flex justify-end space-x-2">
                                            <button onclick="document.getElementById('whatsappModal').close()"
                                                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-300">
                                                Close
                                            </button>
                                            <button
                                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </dialog> --}}

                                {{-- <ul class="list-inline user-chat-nav text-end mb-0"> --}}
                                    {{-- <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="uil uil-search"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                                                <form class="px-2">
                                                    <div>
                                                        <input type="text" class="form-control bg-light rounded"
                                                            placeholder="Search...">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li> --}}
                                    <!-- end li -->
                                    {{-- <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Profile</a>
                                                <a class="dropdown-item" href="#">Archive</a>
                                                <a class="dropdown-item" href="#">Muted</a>
                                                <a class="dropdown-item" href="#">Close Ticket</a>
                                            </div>
                                        </div>
                                    </li> --}}
                                    {{-- <li class="list-inline-item"> --}}
                                        {{-- <button class="btn nav-btn dropdown-toggle btn-light" type="button"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                                            aria-controls="offcanvasWithBothOptionsLabel">
                                            <i class="uil uil-angle-right-b font-size-24"></i>
                                        </button> --}}
                                        {{-- </li> --}}

                                    <!-- end li -->
                                <!-- end ul -->
                                <!-- end ul -->

                            </div>
                        </div>
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <div class="chat-conversation p-3" data-chat-id="123456789" data-simplebar>
                            <ul class="list-unstyled mb-0">
                                {{-- <li class="chat-day-title">
                                    <div class="title">Today</div>
                                </li> --}}

                            </ul>
                            <!-- end ul -->
                        </div>
                        <!-- Tambahkan area khusus untuk pesan bot (chatbot) -->
                        <div class="session-conversation p-3" data-simplebar style="display:none;"></div>

                        <!-- Chat Not Started Alert for Bot Sessions -->
                        <div id="bot-chat-not-started" class="alert alert-info text-center mt-3" style="display: none;">
                            <h5 class="text-white">Chat Belum Dimulai</h5>
                            <p class="text-gray-300">Silakan klik tombol di bawah untuk memulai chat.</p>
                            <button class="btn btn-success start-chat-btn">Mulai Chat</button>
                        </div>

                        <!-- Chat Started Container for Bot Sessions -->
                        <div id="bot-chat-started" style="display: none;">
                            <!-- Bot chat content will be here -->
                        </div>

                        <div class="chat-conversation p-3" data-chat-id="123456789" data-simplebar>
                            <ul class="list-unstyled mb-0">
                                {{-- <li class="chat-day-title">
                                    <div class="title">Today</div>
                                </li> --}}

                            </ul>
                            <!-- end ul -->
                        </div>
                        <!-- Tambahkan area khusus untuk pesan bot (chatbot) -->
                        <div class="session-conversation p-3" data-simplebar style="display:none;"></div>

                        <!-- Chat Not Started Alert -->
                        <div id="bot-chat-not-started" class="alert alert-info text-center" style="display: none;">
                            <h5>Chat Belum Dimulai</h5>
                            <p>Silakan klik tombol di bawah untuk memulai chat.</p>
                            <button class="btn btn-success start-chat-btn">Mulai Chat</button>
                        </div>

                        <!-- Chat Started Container -->
                        <div id="bot-chat-started" style="display: none;">
                            <!-- Existing chat content will be here -->
                        </div>
                    </div>
                    {{-- <div id="chat-not-started" class="alert alert-info text-center" style="display: none;">
                        <h5 class="text-red-400">Chat Belum Dimulai</h5>
                        <p>Silakan klik tombol di bawah untuk memulai chat.</p>
                        <button class="btn btn-success start-chat-btn mt-2">Start Chat</button>
                    </div> --}}
                    {{-- <div id="meta-session-end" class="alert alert-info text-center" style="display: none;">
                        <h5 class="text-red-400">Sesi Chat telah berakhir</h5>
                        <p>Silakan klik tombol di bawah untuk memulai chat menggunakan template.</p>
                        <button class="btn btn-success start-chat-btn mt-2">Mulai Chat</button>
                    </div> --}}

                    <!-- Modal Pilih Template -->
                    <div class="modal fade" id="modalPilihTemplate" tabindex="-1" aria-labelledby="modalPilihTemplateLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content bg-gray-900 text-white" style="overflow: auto;">
                                <div class="modal-header border-bottom border-gray-700">
                                    <h5 class="modal-title font-poppins" id="modalPilihTemplateLabel">Choose Template To Start a Session</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Notification Alert -->
                                    <div class="alert alert-warning mb-4" role="alert">
                                        <p class="mb-0 font-poppins">To start this session, you will be charged based on your communication category.</p>
                                    </div>

                                    <!-- Dropdown Template -->
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Template</label>
                                        <select id="selectTemplateType" class="form-select bg-gray-800 text-white border-gray-700">
                                            <option value="" selected disabled>-- Pilih Template --</option>
                                            <option value="hsm">Template HSM</option>
                                        </select>
                                    </div>

                                    <!-- Dropdown Jenis -->
                                    <div class="mb-4">
                                        <label class="form-label">Pilih Jenis</label>
                                        <select id="selectTemplateCategory" class="form-select bg-gray-800 text-white border-gray-700" disabled>
                                            <option value="all">All</option>
                                            <option value="marketing">Marketing</option>
                                            <option value="utility">Utility</option>
                                            <option value="authentication">Authentication</option>
                                            <option value="outbound">Outbound</option>
                                        </select>
                                    </div>

                                    <!-- Template Selection and Preview Layout -->
                                    <div class="row">
                                        <!-- Template List -->
                                        <div class="col-md-6">
                                            <div id="templateListWrapperDummy" style="display: none;">
                                                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                                                    <div class="px-6 py-4">
                                                        <h2 class="text-xl font-semibold text-white flex items-center">
                                                            <i class="bx bx-table mr-2 text-blue-500"></i>
                                                            Template List
                                                        </h2>
                                                    </div>
                                                    <div class="overflow-x-auto">
                                                        <table class="w-full" id="templatesTable">
                                                            <thead class="bg-gray-700">
                                                                <tr>
                                                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Template</th>
                                                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                                                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Language</th>
                                                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-700" id="templatesList">
                                                                <tr class="template-row" data-category="marketing">
                                                                    <td class="px-6 py-4">
                                                                        <div class="text-white font-medium">Shoe Sale Offer</div>
                                                                        <p class="text-gray-400 text-sm">ID: SS-001</p>
                                                                        <div class="mt-2 bg-gray-700 p-3 rounded-lg text-sm text-gray-300">
                                                                            Get 20% off on blue sneakers! Shop now.
                                                                        </div>
                                                                    </td>
                                                                    <td class="px-6 py-4"><span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Marketing</span></td>
                                                                    <td class="px-6 py-4"><span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">English</span></td>
                                                                    <td class="px-6 py-4"><button class="btn btn-primary select-template-btn" data-template-id="SS-001">Select</button></td>
                                                                </tr>
                                                                <tr class="template-row" data-category="utility">
                                                                    <td class="px-6 py-4">
                                                                        <div class="text-white font-medium">Select Service Option</div>
                                                                        <p class="text-gray-400 text-sm">ID: OC-002</p>
                                                                        <div class="mt-2 bg-gray-700 p-3 rounded-lg text-sm text-gray-300">
                                                                            Selamat datang (username) di layanan contact center FII. Silakan pilih menu tujuan anda.
                                                                        </div>
                                                                    </td>
                                                                    <td class="px-6 py-4"><span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Utility</span></td>
                                                                    <td class="px-6 py-4"><span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Indonesia</span></td>
                                                                    <td class="px-6 py-4"><button class="btn btn-primary select-template-btn" data-template-id="OC-002">Select</button></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview Section -->
                                        <div class="col-md-6">
                                            <div class="bg-gray-700 rounded-xl shadow-lg p-4 h-100">
                                                <h2 class="text-xl font-semibold text-white mb-4">Preview</h2>
                                                <div id="templatePreview" class="bg-gray-700 p-3 rounded-lg" style="display: block;">
                                                    <div id="defaultPreview" class="p-3 rounded-lg w-50" style="margin-left: 225px; min-height: 100px;">
                                                        <p class="mb-0 font-poppins text-gray-400">-</p>
                                                    </div>
                                                    <div id="selectedTemplatePreview" class="bg-gray-700 p-3 rounded-lg" style="display: none;">
                                                        <div class="preview-chat-bubble" id="previewHeader"></div>
                                                        <div class="preview-chat-bubble-body">
                                                            <div class="preview-card-carousel">
                                                                <div id="previewBody" class="align-items-center"></div>
                                                            </div>
                                                            <div class="preview-chat-timestamp" id="previewTimestamp"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-4 d-flex justify-content-end gap-2">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div id="chat-not-started" class="text-center bg-gray-700 p-3 text-white rounded-t-xl" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <p class="mb-0 font-poppins">Chat belum dimulai. Silakan klik tombol untuk memulai chat.
                                </p>
                            </div>
                            <button
                                class="btn btn-success start-chat-btn text-gray-200 rounded-lg font-poppins bg-green-600" id="start-chat-btn-null">Start
                                Chat</button>
                        </div>
                    </div>
                    <div id="meta-session-end" class="text-center bg-gray-700 p-3 text-white rounded-t-xl" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <p class="mb-0 font-poppins">Active Session Expired! Sesi chat baru akan dimulai ketika pelanggan menghubungi kembali AHUlink</p>
                            </div>
                            {{-- <button
                                class="btn btn-danger start-chat-btn text-gray-200 rounded-lg font-poppins bg-red-600" id="start-template-hsm">Mulai</button> --}}
                        </div>
                    </div>
                    <div id="chat-started" style="display: none;">
                        <div id="chat-input-section" class="p-2 chat-input-section">
                            <div class="row">
                                <div class="col-auto">
                                    <form id="form-image" data-url="{{ route('chat.send.image') }}">
                                        <input type="file" id="fileElem" class="form-control" style="display: none;"
                                            onchange="handleFiles(this.files)">
                                        <label class="btn bg-gray-700 text-white btn-icon" for="fileElem">
                                            <i class="fas fa-image"></i>
                                        </label>
                                        @if ($formatted_can_chat_templates == true && count($formatted_chat_templates) > 0)
                                            <label class="btn bg-gray-700 text-white btn-icon" data-bs-toggle="modal"
                                                data-bs-target="#listTemplateChat">
                                                <i class="fas fa-comments"></i>
                                            </label>
                                        @endif
                                    </form>
                                </div>
                                <div class="col">
                                    <form action="{{ route('chat.send.text') }}" method="post" id="reply-msg">
                                        @csrf
                                        <div class="position-relative">
                                            <textarea
                                                class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                rows="1" id="chat-input-text" name="message"
                                                placeholder="Enter Message..."
                                                style="resize: none; min-height: 40px; max-height: 120px; overflow-y: auto;"></textarea>
                                            <div id="textarea-emoji"></div>
                                        </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary chat-send w-md">
                                        <span class="d-sm-inline-block me-2">Send</span>
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="p-2 chat-input-section">
                        <div class="row">
                            <div class="col-auto">
                                <form id="form-image" data-url="{{ route('chat.send.image') }}">
                                    <input type="file" id="fileElem" class="form-control" style="display: none;"
                                        onchange="handleFiles(this.files)">
                                    <label class="btn bg-gray-700 text-white btn-icon" for="fileElem">
                                        <i class="fas fa-image"></i>
                                    </label>
                                    @if ($formatted_can_chat_templates == true && count($formatted_chat_templates) > 0)
                                    <label class="btn bg-gray-700 text-white btn-icon" data-bs-toggle="modal"
                                        data-bs-target="#listTemplateChat">
                                        <i class="fas fa-comments"></i>
                                    </label>
                                    @endif
                                </form>
                            </div>
                            <div class="col">
                                <form action="{{ route('chat.send.text') }}" method="post" id="reply-msg">
                                    <div class="position-relative">
                                        <textarea class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            rows="1" id="chat-input-text" name="message" placeholder="Enter Message..."
                                            style="resize: none; min-height: 40px; max-height: 120px; overflow-y: auto;"></textarea>
                                        <div id="textarea-emoji"></div>
                                    </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary chat-send w-md">
                                    <span class="d-sm-inline-block me-2">Send</span>
                                    <i class="mdi mdi-send float-end"></i>
                                </button>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 px-1 h-full">
            <div class="card h-full bg-gray-900 border-0 flex flex-col">
                <div class="card-header bg-gray-700 border-0 py-2">
                    <h5 class="card-title mb-0 text-white">Properties</h5>
                </div>
                <div class="card-body flex-grow overflow-hidden p-2">
                    <div class="d-flex justify-content-between card-user-info" style="display: none !important;">
                        <div class="user-info  flex-grow-1"></div>

                        <button class="btn nav-btn dropdown-toggle btn-light" type="button" id="openOffcanvasInitChat"
                            onclick="openOffcanvasRight(this)" {{-- data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptionsLabel"
                            --}} style="height: 66px;border-radius: 0px;">
                            <i class="uil uil-angle-right-b font-size-24"></i>
                        </button>
                    </div>

                    <!-- Nav tabs -->
                    <ul class="nav rounded-top bg-gray-800 nav-tabs-custom nav-justified" role="tablist">
                        @if (get_config('msg.category.form', current_agent()->company_id) == '1')
                            <li class="nav-item" id="nav-item-profile-chat-ticket-22">
                                <a class="nav-link active" data-bs-toggle="tab" href="#messages6" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-sm-block">Profile</span>
                                </a>
                            </li>
                            <li class="nav-item" id="nav-item-end-chat-ticket-2">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages5" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-sm-block">End chat Ticket</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#navtabs2-history" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">History Ticket</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Knowledge-Base" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Knowledge Base</span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home2" role="tab">
                                    <span class="d-none d-sm-block">History</span>
                                </a>
                            </li>
                            @if (get_config("msg.category.history-blast", current_agent()->company_id) ?? 1 != 0)
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#navtabs2-history" role="tab">
                                        <span class="d-none d-sm-block">History Ticket</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item d-none" id="nav-item-end-chat">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages2" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">End chat</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                    <!-- Tab panes -->
                    <style>
                        /* Visible scrollbar for history ticket container */
                        #Div_CustomerHistory {
                            scrollbar-width: thin; /* Firefox */
                            scrollbar-color: #4B5563 #1F2937; /* thumb track */
                        }
                        #Div_CustomerHistory::-webkit-scrollbar {
                            width: 8px;
                        }
                        #Div_CustomerHistory::-webkit-scrollbar-track {
                            background: #1F2937;
                            border-radius: 4px;
                        }
                        #Div_CustomerHistory::-webkit-scrollbar-thumb {
                            background: #4B5563;
                            border-radius: 4px;
                        }
                        #Div_CustomerHistory::-webkit-scrollbar-thumb:hover {
                            background: #6B7280;
                        }
                    </style>
                    <div class="tab-content rounded-bottom overflow-y-auto h-full bg-gray-800 p-2 text-muted">
                        <div class="tab-pane h-full overflow-y-auto" id="navtabs2-history" role="tabpanel">
                            <div>
                                <div class="card bg-gray-800 border-0 rounded-0">
                                    <div class="card-body">

                                        <div id="Div_CustomerHistory" class="row h-[calc(100vh-12rem)] overflow-y-auto overflow-x-hidden">
                                            <div class="px-4">
                                                <ul class="list-unstyled chat-list"
                                                    id="history-ticket-list">

                                                    {{--<li class="active">
                                                        <a href="#" class="mt-0"
                                                            onclick="DirectHistory(20241015061907019)">
                                                            <div
                                                                class="d-flex align-items-start">
                                                                <div
                                                                    class="flex-shrink-0 user-img online align-self-center me-3">
                                                                    <div
                                                                        class="avatar-sm align-self-center bg-danger text-danger rounded-circle font-size-22 text-center">
                                                                        <i
                                                                            class="bx bx-phone-incoming text-light"></i>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="flex-grow-1 overflow-hidden">
                                                                    <h5
                                                                        class="text-truncate font-size-14 mb-1">
                                                                        20241015061907019
                                                                    </h5>
                                                                    <p
                                                                        class="text-truncate mb-0">
                                                                        Closed</p>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <div
                                                                        class="font-size-11">
                                                                        15 Okt 24 18:19:07
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li> --}}
                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end tab pane -->
                        <div class="tab-pane h-full overflow-y-auto" id="messages2" role="tabpanel">
                            <form id="formEndChat">
                                @csrf
                                @method('POST')
                                <h5>Note</h5>
                                <div class="form-group">
                                    <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                                </div>

                                <hr class="m-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5>Additional Info</h5>
                                    <button type="button" class="btn btn-sm btn-primary float-end"
                                        onclick="addNewCardAdditionalInfo()">
                                        <i class="uil uil-plus-square"></i>
                                    </button>
                                </div>
                                <div id="placeNewAdditional"></div>

                                <button type="submit" class="btn btn-sm btn-primary w-100 mt-2 chat-end">
                                    End Chat Now
                                </button>
                            </form>
                        </div><!-- end tab pane -->
                        <div class="tab-pane h-full overflow-y-auto" id="messages3" role="tabpanel">
                            <form id="formEndChatTicket">
                                @csrf
                                @method('POST')
                                <div class="form-group mb-2" id="channel_page">
                                    <select class="form-control" name="chat_ticket_status" id="chat_ticket_status">
                                        <option value="" selected>Select Ticket Status</option>
                                        @foreach ($chat_ticket_statuses as $chat_ticket_status)
                                            <option value="{{ $chat_ticket_status->id }}">
                                                {{ $chat_ticket_status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2" id="channel_page">
                                    <select class="form-control" name="chat_ticket_category" id="chat_ticket_category">
                                        <option value="" selected>Select Category</option>
                                        @foreach ($chat_ticket_categories as $chat_ticket_category)
                                            <option value="{{ $chat_ticket_category->id }}">
                                                {{ $chat_ticket_category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2" id="channel_page">
                                    <select class="form-control" name="chat_ticket_category_type"
                                        id="chat_ticket_category_type">
                                        <option value="">Select Category Type</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2" id="channel_page">
                                    <select class="form-control" name="chat_ticket_category_detail"
                                        id="chat_ticket_category_detail">
                                        <option value="">Select Category Detail</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2" id="channel_page">
                                    <select class="form-control" name="chat_ticket_category_problem"
                                        id="chat_ticket_category_problem">
                                        <option value="">Select Category Problem</option>
                                    </select>
                                </div>
                                <h5>Tag</h5>
                                <div class="form-group">
                                    <input type="text" id="chat_ticket_category_tags" name="chat_ticket_category_tags"
                                        value="" />
                                </div>
                                <h5>Note</h5>
                                <div class="form-group">
                                    <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary w-100 mt-2 chat-end-ticket">
                                    End Chat Now
                                </button>
                            </form>
                        </div><!-- end tab pane -->

                        {{-- TAB END CHAT TICKET --}}
                        <div class="tab-pane" id="messages5" role="tabpanel">
                            <div class="row">
                                <div class="col-12 h-[calc(100vh-12rem)] overflow-y-auto overflow-x-hidden" data-simplebar>
                                    <div class="card bg-gray-900 border-0">
                                        <div class="card-body">
                                            <!-- Button untuk membuka modal Blast History -->
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#blastHistoryModal" id="btn-open-blast-history">
                                                    <i class="fas fa-bullhorn me-1"></i>
                                                    View Blast History
                                                </button>
                                            </div>

                                            <!-- Indikator Blast Queue yang dipilih -->
                                            <div id="selected-blast-indicator" class="alert alert-info mb-3" style="display: none;">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <i class="fas fa-check-circle me-2"></i>
                                                        <strong>Blast Queue Selected:</strong>
                                                        <span id="selected-blast-schedule-display" class="ms-2"></span>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-light" onclick="clearSelectedBlastQueue()">
                                                        <i class="fas fa-times"></i> Clear
                                                    </button>
                                                </div>
                                            </div>

                                            <input type="hidden" id="inichatticketuser" name="chat_ticket_user_id">
                                            <input type="hidden" id="inichatheaderid" name="GenesisNumber">
                                            <input type="hidden" id="inichannelid" name="channel_id">
                                            <input type="hidden" id="inichatphone" name="phone">
                                            <input type="hidden" id="selected_blast_queues_id" name="blast_queues_id">
                                            <input type="hidden" id="selected_blast_schedule_name" value="">


                                            {{-- <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="workexperience-category-input">Category
                                                        <span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                        name="Form_Ticket_Kategori" id="Form_Ticket_Kategori">
                                                        <option value="" selected>Select Category</option>
                                                        @foreach ($chat_ticket_categories as $chat_ticket_category)
                                                            <option value="{{ $chat_ticket_category->name }}" data-id="{{ $chat_ticket_category->id }}">
                                                                {{ $chat_ticket_category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="workexperience-category-input">Sub Category
                                                        <span class="text-danger">*</span></label>
                                                    <select id="Form_Ticket_SubKategori"
                                                        class="form-select bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                        name="Form_Ticket_SubKategori" required>
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="col-12">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="contact-info-email-input"
                                                            class="form-label">Priority <span
                                                                class="text-danger">*</span></label>
                                                        <select
                                                            class="form-select bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                            id="Form_Ticket_Priority" required>
                                                            <option value="" selected>Select Ticket Priority</option>
                                                            @foreach ($chat_ticket_priorities as $chat_ticket_priority)
                                                                <option value="{{ $chat_ticket_priority->name }}">
                                                                    {{ $chat_ticket_priority->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="contact-info-email-input" class="form-label">Status
                                                        <span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                        name="Form_Ticket_Status" id="Form_Ticket_Status">
                                                        <option value="" selected>Select Ticket Status</option>
                                                        @foreach ($chat_ticket_statuses as $chat_ticket_status)
                                                            <option value="{{ $chat_ticket_status->name }}">
                                                                {{ $chat_ticket_status->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}

                                            <x-ticket-form />
                                            {{-- <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="contact-info-name" class="form-label">Agent Name
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control !bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                            placeholder="Enter Name" id="Form_Ticket_Agent_Name"
                                                            disabled="disabled" value="{{ current_agent()->name }}">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="contact-info-email-input" class="form-label">Status
                                                            <span class="text-danger">*</span></label>
                                                        <select
                                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                            name="Form_Ticket_Status" id="Form_Ticket_Status">
                                                            <option value="" selected>Select Ticket Status</option>
                                                            @foreach ($chat_ticket_statuses as $chat_ticket_status)
                                                                <option value="{{ $chat_ticket_status->name }}">
                                                                    {{ $chat_ticket_status->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    {{-- <div class="card bg-gray-900 border-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="workexperience-category-input">Subject
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                            id="Form_Ticket_Subject" placeholder="Subject" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="workexperience-category-input">Category
                                                            <span class="text-danger">*</span></label>
                                                        <select
                                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                            name="Form_Ticket_Kategori" id="Form_Ticket_Kategori">
                                                            <option value="" selected>Select Category</option>
                                                            @foreach ($chat_ticket_categories as $chat_ticket_category)
                                                                <option value="{{ $chat_ticket_category->id }}">
                                                                    {{ $chat_ticket_category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="workexperience-category-input">Sub Category
                                                            <span class="text-danger">*</span></label>
                                                        <select id="Form_Ticket_SubKategori"
                                                            class="form-select bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                            name="Form_Ticket_SubKategori" required>
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <textarea id="Ticket_Complaints" name="Ticket_Complaints"
                                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                            rows="10" placeholder="Pertanyaan..*" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <textarea id="Ticket_NoteAgent" name="Ticket_NoteAgent"
                                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                            rows="10" placeholder="Jawaban..*" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="file" name="files"
                                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800l"
                                                        id="file-bc" multiple>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <div class="text-end" id="buttonEndChat">
                                                    <a class="btn btn-soft-primary w-sm" id="buttonEndChatAction"><i
                                                            class="fa fa-save"></i>&nbsp;Save &amp; Closed</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane" id="Knowledge-Base" role="tabpanel">
                            <div class="row">
                                <div class="col-12 h-[calc(100vh-12rem)] overflow-y-auto overflow-x-hidden" data-simplebar>
                                    <x-ai-kb-chat
                                        component-id="chatV3AiKb"
                                        source-page="chat_v3"
                                        title="Knowledge Base"
                                        empty-state="Tulis pertanyaan di bawah untuk memulai percakapan baru dengan AHU AI."
                                    />
                                </div>
                            </div>
                        </div>

                        {{-- TAB PROFILE --}}
                        <div class="tab-pane fade show active h-full overflow-y-auto" id="messages6" role="tabpanel">
                            <div class="row h-full relative" id="main-content-container">
                                <div class="col-12 h-full overflow-y-auto">
                                    <div class="card bg-gray-900 w-100">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between p-2 m-2">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2"
                                                    style="width: 40px; height: 40px; overflow: hidden; border-radius: 50%;">
                                                    <img src="${message_pict}" alt="Profile Image" class="w-100 h-100"
                                                        id="Profile_Image" style="object-fit: cover;"
                                                        onerror="this.onerror=null; this.src='/assets/images/users/Profile.png';">
                                                </div>

                                                <div class="text-truncate">
                                                    <h6 class="mb-0 font-size-16 text-white text-truncate font-poppins"
                                                        id="Profile_Nama" style="max-width: 170px;">
                                                        Nama Pengguna
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <a class="btn btn-link text-white font-size-12 p-0 dropdown-toggle shadow-none"
                                                    href="#" role="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa fas fa-ellipsis-h"></i>
                                                </a>
                                                <ul class="dropdown-menu bg-gray-800 border-0 dropdown-menu-end">
                                                    <li id="addCustomerButton">
                                                        <a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#" id="Btn_AddCustomer" data-bs-toggle="modal"
                                                            data-bs-target="#addCustomerBC">Add</a>
                                                    </li>
                                                    <li id="addCustomerExistingButton">
                                                        <a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#"
                                                            id="Btn_AddCustomerExisting"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#addExistingCustomerBC">Add
                                                            Existing</a>
                                                    </li>
                                                    <li id="editCustomerButton">
                                                        <a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#" id="Btn_EditCustomer" data-bs-toggle="modal"
                                                            data-bs-target="#editCustomerBC">Edit</a>
                                                    </li>
                                                    <li id="switchProfileButton">
                                                        <a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#"
                                                            id="Btn_SwitchProfile"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#switchProfileBC">Switch Profile</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="card bg-gray-900">
                                            <div class="card-body">
                                                <div class="mt-2">
                                                    <ul class="nav bg-gray-700 nav-justified rounded-top nav-tabs-custom"
                                                        role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link active" data-bs-toggle="tab"
                                                                href="#navtabs2-home" role="tab" aria-selected="true">
                                                                <span class="d-block d-sm-none"><i
                                                                        class="fas fa-home"></i></span>
                                                                <span class="d-none d-sm-block">Profile</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                                href="#navtabs2-channel" role="tab"
                                                                aria-selected="false" tabindex="-1">
                                                                <span class="d-block d-sm-none"><i
                                                                        class="fas fa-home"></i></span>
                                                                <span class="d-none d-sm-block">Channel</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                                href="#blasts" role="tab"
                                                                aria-selected="false" tabindex="-1">
                                                                <span class="d-block d-sm-none"><i
                                                                        class="fas fa-home"></i></span>
                                                                <span class="d-none d-sm-block">History Blast</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="navtabs2-home" role="tabpanel">
                                                        <div class="card bg-gray-800 border-0 rounded-0">
                                                            <div class="card-body">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="pb-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <div
                                                                                class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                                <i class="fas fa-phone-alt"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <p
                                                                                    class="text-white mb-1 font-size-16 font-poppins">
                                                                                    No. Telepon</p>
                                                                                <h5 class="mb-0 font-size-14 text-gray-500 font-poppins"
                                                                                    id="Profile_NomorTelepon">
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li class="py-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <div
                                                                                class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                                <i class="far fa-envelope"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <p
                                                                                    class="text-white mb-1 font-size-16 font-poppins">
                                                                                    Email</p>
                                                                                <h5 class="mb-0 font-size-14 text-gray-500 font-poppins"
                                                                                    id="Profile_Email">
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li class="py-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <div
                                                                                class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                                <i class="fa fa-home"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <p
                                                                                    class="text-white mb-1 font-size-16 font-poppins">
                                                                                    Alamat</p>
                                                                                <h5 class="mb-0 font-size-14 text-gray-500 font-poppins"
                                                                                    id="Profile_Address">
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    {{-- <li class="py-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <div
                                                                                class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                                <i class="fa fa-network-wired"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <p class="text-white mb-1 font-size-16">
                                                                                    Channel</p>
                                                                                <h5 class="mb-0 font-size-14 text-gray-500"
                                                                                    id="#">
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                    </li> --}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="navtabs2-channel" role="tabpanel">
                                                        <div>
                                                            <div class="card bg-gray-800 border-0 rounded-0">
                                                                <div class="card-body">
                                                                    <div id="Div_CustomerChannel" class="row"
                                                                        style="height: 300px; overflow-x: auto;">

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="blasts" role="tabpanel" style="height: 300px; overflow-y: auto;">
                                                        <div id="history-blast-list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card bg-gray-900 border-0">

                                            <div class="m-2 align-items-center">
                                                <!-- Active Session for meta whatsapp -->

                                                {{-- <div id="wa-meta-session-box"
                                                    class="bg-green-400 rounded-md hover:bg-blue-700 text-white px-4 py-2 items-center justify-center text-center"
                                                    style="display: none;">
                                                    <p class="wa-meta-session-timer">--:--:--</p>
                                                </div> --}}

                                                <!-- Button untuk membuka modal -->
                                                {{-- <button id="btn-show-meta-session"
                                                    class="btn btn-info mb-2 bg-green-400 rounded-md hover:bg-green-700 text-center"
                                                    style="display: none;">
                                                    Lihat Sesi WhatsApp Meta
                                                </button> --}}
                                                <div id="btn-show-meta-session"
                                                    class="relative flex items-center justify-between pr-4 py-3 text-sm cursor-pointer font-size-16 text-white"
                                                    >
                                                    <span class="pl-0 ml-0 font-poppins">Active Session(s)</span>
                                                    <svg class="w-4 h-4 svg-icon" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </div>


                                                <!-- Modal Timer Session -->
                                                {{-- <div class="modal fade" id="modalMetaSession" tabindex="-1"
                                                    aria-labelledby="modalMetaSessionLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content bg-dark text-white">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalMetaSessionLabel">Sesi
                                                                    WhatsApp Meta</h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <p
                                                                    class="wa-meta-session-label text-sm text-gray-300 mb-2">
                                                                </p>
                                                                <p class="wa-meta-session-timer text-2xl font-bold">
                                                                    --:--:--</p>
                                                                <p class="text-sm mt-2">Sesi akan berakhir dalam waktu
                                                                    di atas sejak pesan terakhir dari customer.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}




                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="meta-session-cover" class="absolute top-0 left-0 w-full h-full z-40 bg-gray-800 text-white
                                        transform translate-x-full opacity-0 pointer-events-none
                                        transition-all duration-300 ease-in-out shadow-xl">
                                <div class="p-0">
                                    <div class="flex items-center border-b border-gray-700 px-4 py-3">
                                        <button id="btn-hide-meta-session" class="mr-3 focus:outline-none">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <h5 class="text-lg font-bold m-0 text-white font-poppins">Active Session</h5>
                                    </div>
                                    <div class="p-4">
                                        <p class="wa-meta-session-label text-sm text-gray-300 mb-2 font-poppins"></p>
                                        <p class="wa-meta-session-timer text-2xl font-bold font-poppins">--:--:--</p>
                                        <p class="text-sm mt-2 font-poppins">Sesi akan berakhir dalam waktu di atas
                                            sejak pesan terakhir dari customer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end tab content -->
                </div>
            </div>
        </div>
    </div>


    <?php /*
   <div class="d-lg-flex mb-4">
       <div class="chat-leftsidebar card">

           <div>
               <div class="tab-content">
                   <div class="tab-pane show active" id="chat">
                       <div class="chat-message-list" data-simplebar>
                           <div class="p-4">
                               <div>
                                   <h5 class="font-size-14 mb-3">Recent</h5>

                                   <ul class="list-unstyled chat-list">
                                   </ul>
                                   <!-- end ul -->
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

           </div>

       </div>
       <!-- end chat-leftsidebar -->

       <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
           <div id="drop-area">
               <div class="card">
                   <div class="p-3 border-bottom">
                       <div class="row">
                           <div class="col-xl-4 col-7">
                               <div class="d-flex align-items-center" id="header-datas">
                                   <div class="flex-shrink-0 avatar me-3 d-sm-block d-none">
                                       <img src="/assets/images/icons/user.png" alt=""
                                           class="img-thumbnail d-block rounded-circle">
                                   </div>
                                   <div class="flex-grow-1">
                                       <h5 class="font-size-14 mb-1 text-truncate"><a href="#"
                                               class="text-dark"></a></h5>
                                       {{-- <p class="text-muted text-truncate mb-0"><i class="mdi mdi-circle text-success font-size-10 align-middle me-1"></i>Online </p> --}}
                                   </div>
                               </div>
                           </div>
                           <div class="col-xl-8 col-5">
                               <ul class="list-inline user-chat-nav text-end mb-0">
                                   {{-- <li class="list-inline-item">
                                       <div class="dropdown">
                                           <button class="btn nav-btn dropdown-toggle" type="button"
                                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                               <i class="uil uil-search"></i>
                                           </button>
                                           <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                                               <form class="px-2">
                                                   <div>
                                                       <input type="text" class="form-control bg-light rounded"
                                                           placeholder="Search...">
                                                   </div>
                                               </form>
                                           </div>
                                       </div>
                                   </li> --}}
                                   <!-- end li -->
                                   {{-- <li class="list-inline-item">
                                       <div class="dropdown">
                                           <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                               <i class="uil uil-ellipsis-h"></i>
                                           </button>
                                           <div class="dropdown-menu dropdown-menu-end">
                                               <a class="dropdown-item" href="#">Profile</a>
                                               <a class="dropdown-item" href="#">Archive</a>
                                               <a class="dropdown-item" href="#">Muted</a>
                                               <a class="dropdown-item" href="#">Close Ticket</a>
                                           </div>
                                       </div>
                                   </li> --}}
                                   <li class="list-inline-item">
                                       <button class="btn nav-btn dropdown-toggle btn-light" type="button"
                                           data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                                           aria-controls="offcanvasWithBothOptionsLabel">
                                           <i class="uil uil-angle-right-b font-size-24"></i>
                                       </button>
                                   </li>

                                   <!-- end li -->
                               </ul>
                               <!-- end ul -->

                           </div>
                       </div>
                   </div>
                   <div>
                       <div class="chat-conversation p-3" data-chat-id="123456789" data-simplebar>
                           <ul class="list-unstyled mb-0">
                               {{-- <li class="chat-day-title">
                                   <div class="title">Today</div>
                               </li> --}}

                           </ul>
                           <!-- end ul -->
                       </div>
                   </div>
                   <div class="p-3 chat-input-section">
                       <div class="row">
                           <div class="col-auto">
                               <form id="form-image" data-url="{{ route('chat.send.image') }}">
                                   <input type="file" id="fileElem" class="form-control" style="display: none;"
                                       onchange="handleFiles(this.files)">
                                   <label class="btn btn-light btn-icon" for="fileElem">
                                       <i class="fas fa-image"></i>
                                   </label>
                               </form>
                           </div>
                           <div class="col">
                               <form action="{{ route('chat.send.text') }}" method="post" id="reply-msg">
                                   <div class="position-relative">
                                       <textarea class="form-control chat-input" rows="1" name="message" placeholder="Enter Message..."></textarea>
                                       <div id="textarea-emoji"></div>
                                   </div>
                               </form>
                           </div>
                           <div class="col-auto">
                               <button type="button" onclick="$('#reply-msg').submit()"
                                   class="btn btn-primary chat-send w-md">
                                   <span class="d-sm-inline-block me-2">Send</span>
                                   {{-- <i class="mdi mdi-send float-end"></i> --}}
                               </button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <button type="button" id="iframe-button" class="btn btn-primary d-none w-100">Testing Button</button>
   */
    ?>


    <!-- right offcanvas -->
    <div id="formEndChat-lama">
        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <form action="{{ route('chat.init') }}" id="formInit" method="post" onsubmit="submitFromInit(event)">
                @csrf
                @method('POST')
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Intialize Chat</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">

                    <div class="user-info"></div>
                    <input type="hidden" name="channel_user_id" id="channel_user_id">

                    <hr class="m-3">
                    {{-- <div class="form-group mb-2">
                        <select class="form-control" name="channel_id" id="channel_id"
                            onchange="formInit_onChangeChannel(this)">
                            <option value="">Select Channel</option>
                            @foreach ($channels as $channel)
                            <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group mb-2" id="channel_page" style="display: none;">
                        <select class="form-control" name="channel_page_id" id="channel_page_id">
                            <option value="">Select Channel Page</option>
                        </select>
                    </div>
                    <div class="form-group mb-2" id="channel_account" style="display: none;">
                        <select class="form-control" name="channel_account_id" id="channel_account_id"
                            onchange="formInit_onChangeChannelAccount(this)">
                            <option value="">Select Channel Account</option>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <textarea name="message" id="message" rows="5" class="form-control"></textarea>
                    </div> --}}
                </div>

                <div class="offcanvas-footer p-3">
                    <button type="submit" class="btn btn-sm btn-primary w-100 mt-2">Chat Now</button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const kbTabTrigger = document.querySelector('a[href="#Knowledge-Base"]');
                    kbTabTrigger?.addEventListener('shown.bs.tab', function () {
                        window.chatV3AiKbInstance?.refreshForCurrentContext();
                    });
                });
                document.addEventListener("DOMContentLoaded", function () {
                    const textarea = document.getElementById("chat-input-text");
                    const templateBox = document.createElement("div");
                    templateBox.classList.add("template-box", "position-absolute", "bg-gray-800", "text-white", "p-2", "rounded", "w-100");
                    templateBox.style.display = "none";
                    templateBox.style.maxHeight = "200px";
                    templateBox.style.overflowY = "auto";
                    templateBox.style.marginBottom = "5px";
                    textarea.parentNode.appendChild(templateBox);

                    const templateRows = Array.from(document.querySelectorAll("#listTemplateChat tbody tr")).map(row => ({
                        title: row.querySelector("td:first-child").textContent,
                        text: row.querySelector("td:nth-child(2)").textContent
                    }));

                    // Auto-resize function
                    function autoResize() {
                        textarea.style.height = '40px'; // Reset height
                        const newHeight = Math.min(textarea.scrollHeight, 120); // Max height 120px
                        textarea.style.height = newHeight + 'px';
                    }

                    // Handle template selection from modal
                    document.querySelectorAll('#listTemplateChat .chooseTemplate').forEach(template => {
                        template.addEventListener('click', function () {
                            const templateText = this.querySelector('td:nth-child(2)').textContent;
                            textarea.value = templateText;
                            autoResize();
                            $('#listTemplateChat').modal('hide');
                            textarea.focus();
                        });
                    });

                    textarea.addEventListener("keyup", function (event) {
                        const cursorPosition = textarea.selectionStart;
                        const text = textarea.value.substring(0, cursorPosition);

                        const titleMatch = text.match(/\/(\w+)$/);
                        if (titleMatch) {
                            const titleQuery = titleMatch[1].toLowerCase();
                            const filteredTemplates = templateRows.filter(row => row.title.toLowerCase().includes(titleQuery));

                            if (filteredTemplates.length > 0) {
                                templateBox.innerHTML = filteredTemplates.map(template =>
                                    `<div class='template-item p-1 cursor-pointer' data-value='${template.text}'>${template.title} | ${template.text}</div>`
                                ).join("\n");
                                templateBox.style.display = "block";
                                templateBox.style.left = `${textarea.offsetLeft}px`;
                                templateBox.style.bottom = `${textarea.offsetTop + textarea.offsetHeight + 5}px`;
                            } else {
                                templateBox.style.display = "none";
                            }
                        } else {
                            templateBox.style.display = "none";
                        }

                        autoResize();
                    });

                    templateBox.addEventListener("click", function (event) {
                        if (event.target.classList.contains("template-item")) {
                            const selectedTemplate = event.target.getAttribute("data-value");
                            textarea.value = textarea.value.replace(/\/\w+$/, '') + selectedTemplate;
                            templateBox.style.display = "none";
                            textarea.focus();
                            autoResize();
                        }
                    });

                    // Add event listener for Enter key
                    textarea.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            document.getElementById('reply-msg').submit();
                        }
                    });

                    // Initial resize
                    autoResize();
                });

                const channelPages = @json($channel_pages);
                const channelAccounts = @json($channel_accounts);

                const loader =
                    `<div class="auto-load text-center"><svg enable-background="new 0 0 0 0"height=60 id=L9 version=1.1 viewBox="0 0 100 100"x=0px xml:space=preserve xmlns=http://www.w3.org/2000/svg xmlns:xlink=http://www.w3.org/1999/xlink y=0px><path d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"fill=#000><animateTransform attributeName=transform attributeType=XML dur=1s from="0 50 50"repeatCount=indefinite to="360 50 50"type=rotate /></path></svg></div>`;

                function openOffcanvasRight(el) {
                    $('#offcanvasWithBothOptions').find('#channel_user_id').val($('#offcanvasWithBothOptions').attr(
                        'data-channel-user-id'));
                    formInit_onChangeChannel($('#offcanvasWithBothOptions').attr('data-channel-id'))
                    // $('#offcanvasWithBothOptions').find('#channel_user_id').val($(el).attr('data-channel-user-id'));
                    $('#offcanvasWithBothOptions').offcanvas('show');
                }

                function formInit_onChangeChannel(channel_id) {
                    // let channel_id = $(el).val();
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
                    // data.append("chat_header_id", form.attr('data-header-id'))
                    // console.log("chat_header_id", form.attr('data-header-id'));

                    // disabled the submit button
                    // $('button.chat-end').prop("disabled", true);

                    $.ajax({
                        type: "POST",
                        // enctype: 'multipart/form-data',
                        url: form.attr('action'),
                        data: form.serialize(),
                        // processData: false,
                        // contentType: false,
                        // cache: false,
                        // timeout: 800000,
                        success: function (data) {
                            // $("#output").text(data);
                            console.log("SUCCESS : ", data);
                            // openChatHeader(form.attr('data-header-id'))
                            // $(".chat-input-section").hide();

                            if (data.status) {
                                Swal.fire({
                                    title: 'Success',
                                    text: data.msg,
                                    icon: 'success',
                                    width: '150px', // Mengatur lebar modal
                                    customClass: {
                                        popup: 'small-swal' // Kelas CSS khusus untuk styling lebih lanjut
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


                            // $("#form textarea").val("");
                            // $("#form #placeNewAdditional input").val("");
                            // handleSocket(form.data('chat-id'), {type: "outbox", name: "You", message: form.find("textarea[name=message]").val()})
                        },
                        error: function (e) {
                            // $("#output").text(e.responseText);
                            console.log("ERROR : ", e);
                            // $("button.chat-end").prop("disabled", false);
                        }
                    }).done(() => {
                        getChatHeader(null, 1, false, true);
                        $('#offcanvasWithBothOptions').offcanvas('hide');
                        // $("#textarea-emoji").disable();
                        // $("button.chat-send").prop("disabled", true);
                        // $(".chat-input-section textarea").disable();
                        // $(".chat-input-section input").disable();
                    });
                }

                $('form#formInit').submit((e) => {
                    e.preventDefault();
                    let form = $('#formInit');
                    let data = new FormData(form[0]);
                    // data.append("chat_header_id", form.attr('data-header-id'))
                    // console.log("chat_header_id", form.attr('data-header-id'));

                    // disabled the submit button
                    $('button.chat-end').prop("disabled", true);

                    $.ajax({
                        type: "POST",
                        // enctype: 'multipart/form-data',
                        url: form.attr('action'),
                        data: form.serialize(),
                        // processData: false,
                        // contentType: false,
                        // cache: false,
                        // timeout: 800000,
                        success: function (data) {
                            // $("#output").text(data);
                            console.log("SUCCESS : ", data);
                            // openChatHeader(form.attr('data-header-id'))
                            // $(".chat-input-section").hide();

                            // $("#form textarea").val("");
                            // $("#form #placeNewAdditional input").val("");
                            // handleSocket(form.data('chat-id'), {type: "outbox", name: "You", message: form.find("textarea[name=message]").val()})
                        },
                        error: function (e) {
                            // $("#output").text(e.responseText);
                            console.log("ERROR : ", e);
                            // $("button.chat-end").prop("disabled", false);
                        }
                    }).done(() => {
                        getChatHeader(null, 1, false, true);
                        // $("#textarea-emoji").disable();
                        // $("button.chat-send").prop("disabled", true);
                        // $(".chat-input-section textarea").disable();
                        // $(".chat-input-section input").disable();
                    });
                });
            </script>
        </div>
    </div>
    <!-- End d-lg-flex  -->
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

    <!-- Ticket Detail Modal (Chat v3) -->
    <div class="modal fade" id="chatv3TicketDetailModal" tabindex="-1" aria-labelledby="chatv3TicketDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-gray-900 border-0">
                <div class="modal-header bg-gray-800 border-0">
                    <h5 class="modal-title text-white flex items-center" id="chatv3TicketDetailModalLabel">
                        <i class="fas fa-ticket-alt mr-2 text-blue-400"></i>
                        <span id="chatv3-modal-ticket-number">Ticket Details</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="bg-gray-800 p-4 border-b border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div>
                                <label class="text-gray-400 text-sm">Ticket Number</label>
                                <p class="text-white font-semibold" id="chatv3-modal-ticket-number-value">-</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">Status</label>
                                <p class="text-white font-semibold" id="chatv3-modal-ticket-status">-</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">Priority</label>
                                <p class="text-white font-semibold" id="chatv3-modal-ticket-priority">-</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">Current Layer</label>
                                <p class="text-blue-400 font-semibold" id="chatv3-modal-ticket-layer">Layer 1</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">Created</label>
                                <p class="text-white font-semibold" id="chatv3-modal-ticket-created">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="mb-4">
                            <label class="text-gray-400 text-sm">DataNumber</label>
                            <p class="text-white font-semibold text-lg" id="chatv3-modal-ticket-subject">-</p>
                        </div>
                        <div class="mb-4">
                            <label class="text-gray-400 text-sm">Description</label>
                            <div class="bg-gray-800 p-3 rounded-lg" id="chatv3-modal-ticket-description">
                                <p class="text-gray-300">-</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="text-gray-400 text-sm">Category</label>
                                <p class="text-white" id="chatv3-modal-ticket-category">-</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">Sub Category</label>
                                <p class="text-white" id="chatv3-modal-ticket-subcategory">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-700">
                        <div class="p-4">
                            <h6 class="text-white font-semibold mb-4 flex items-center">
                                <i class="fas fa-route mr-2 text-blue-400"></i>
                                Ticket Journey Timeline
                            </h6>
                            <div class="timeline-container relative">
                                <div id="chatv3-ticket-timeline" class="flex overflow-x-auto space-x-4 relative overflow-y-hidden"></div>

                            </div>
                            <div id="chatv3-timeline-detail-display" class="mt-3 p-3 bg-gray-800 rounded-lg border border-gray-700 hidden">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="text-white font-semibold text-sm m-0" id="chatv3-detail-title">Timeline Detail</h6>
                                    <button type="button" class="btn btn-sm btn-outline-light" onclick="chatv3CloseTimelineDetailDisplay()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div id="chatv3-detail-content">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 p-4 bg-gray-800/50">
                        <h6 class="text-white font-semibold mb-3">Add Ticket Detail</h6>
                        <form id="chatv3-addTicketDetailForm">
                            <input type="hidden" id="chatv3-ticket-detail-id" name="ticket_id">
                            <input type="hidden" id="chatv3-ticket-current-layer" name="current_layer" value="1">

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input bg-gray-700 focus:bg-gray-600 hover:bg-gray-600" type="checkbox" id="chatv3-detail-escalation-checkbox" name="escalation">
                                    <label class="form-check-label flex items-center text-blue-400 font-medium" for="chatv3-detail-escalation-checkbox">
                                        <span id="chatv3-detail-escalation-label">Eskalasi ke Layer 2</span>
                                    </label>
                                </div>
                                <small class="text-gray-400" id="chatv3-detail-escalation-description">Centang untuk eskalasi ke layer berikutnya</small>
                                <div class="mt-1">
                                    <span class="text-xs text-gray-400">Current Layer: </span>
                                    <span class="text-xs font-semibold text-blue-400" id="chatv3-detail-current-layer-display">Layer 1</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label class="form-label text-white text-sm">Status</label>
                                    <select class="form-select bg-gray-700 text-white border-0" id="chatv3-detail-status">
                                        <option value="" selected>Select Ticket Status</option>
                                        @foreach ($chat_ticket_statuses as $chat_ticket_status)
                                            <option value="{{ $chat_ticket_status->name }}">{{ $chat_ticket_status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-white text-sm">Note</label>
                                <textarea class="form-control bg-gray-700 text-white border-0 focus:bg-gray-700 focus:text-white" id="chatv3-detail-note" rows="3" placeholder="Add your note here..." required></textarea>
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
    <x-slot name="css">
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/libs/emojionearea/dist/emojionearea.min.css"
            media="screen">

        <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </x-slot>
    <x-slot name="modal">
        <div class="modal fade" id="listTemplateChat" tabindex="-1" aria-labelledby="listTemplateChatLabel">
            <div class="modal-dialog">
                <div class="modal-content bg-gray-800 border-0">
                    <div class="modal-header bg-gray-700 border-0">
                        <h5 class="modal-title text-white" id="listTemplateChatLabel">
                            <i class="fas fa-comments me-2"></i>List Template Chat
                        </h5>
                        <button type="button" class="btn btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="text-white border-0">Title</th>
                                        <th class="text-white border-0">Template</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formatted_chat_templates as $i => $formatted_chat_template)
                                        <tr class="border-bottom border-gray-700 chooseTemplate hover:bg-gray-700 transition-colors duration-200"
                                            style="cursor: pointer;" data-template-id="template-{{ $i }}">
                                            <td class="text-white align-middle">{{ $formatted_chat_template['title'] }}</td>
                                            <td class="text-white align-middle" id="template-{{ $i }}">
                                                {{ $formatted_chat_template['text'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addCustomerBC"
            aria-labelledby="addCustomerBCLabel">
            <div class="modal-dialog">
                <div class="modal-content bg-gray-700 border-0">
                    <div class="modal-header">
                        <h5 class="modal-tittle text-white" id="addModuleModalLabel"> Add Customer </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card bg-gray-900 border-0 rounded-0" id="addCustomerBCCard">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Cari Customer <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="search-customer"
                                            data-placeholder="Choose anything"></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nama/PIC <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            id="AddCustomer_Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nomor
                                            Telepon</label>
                                        <input type="text"
                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            id="AddCustomer_HP">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            id="AddCustomer_Email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Alamat <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            id="AddCustomer_Address">
                                    </div>
                                </div>
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
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editCustomerBC" tabindex="-1"
            aria-labelledby="editCustomerBCLabel">
            <div class="modal-dialog">
                <div class="modal-content bg-gray-700 border-0">
                    <div class="modal-header">
                        <h5 class="modal-tittle text-white" id="addModuleModalLabel"> Edit Customer </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card  bg-gray-900 rounded-0 border-0" id="editCustomerBCCard">
                        <div class="card-body">
                            <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                id="EditCustomer_Id" style="display: none;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nama/PIC <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            id="EditCustomer_Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Nomor
                                            Telepon</label>
                                        <input type="text"
                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            id="EditCustomer_HP">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            id="EditCustomer_Email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="addcontact-designation-input" class="form-label">Alamat <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                            id="EditCustomer_Address">
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
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addOtherChannel" tabindex="-1"
            aria-labelledby="addOtherChannelLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="addModuleModalLabel"> Add Channel </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <button type="button" class="btn btn-primary w-sm" id="SimpanChannel">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editOtherChannel" tabindex="-1"
            aria-labelledby="editOtherChannelLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="editModuleModalLabel"> Edit Channel </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

        <!-- Modal Blast History -->
        <div class="modal fade" id="blastHistoryModal" tabindex="-1" aria-labelledby="blastHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content bg-gray-900 border-0">
                    <div class="modal-header bg-gray-800 border-0">
                        <h5 class="modal-title text-white font-poppins" id="blastHistoryModalLabel">
                            <i class="fas fa-bullhorn me-2 text-blue-400"></i>
                            Blast History
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-gray-900 p-3">
                        <div id="history-blast-list-modal">
                            <div class="text-center text-gray-400 py-3">Loading blast history...</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-800 border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Add Existing Customer -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addExistingCustomerBC"
            tabindex="-1" aria-labelledby="addExistingCustomerBCLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-gray-700 border-0">
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="addExistingCustomerBCLabel">Add Existing Customer
                        </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card bg-gray-900 border-0 rounded-0" id="addExistingCustomerBCCard">
                        <div class="card-body">
                            <!-- Search Section -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="search-existing-customer" class="form-label text-white">Search
                                            Customer</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                id="search-existing-customer"
                                                placeholder="Search by name, email, or phone..."
                                                autocomplete="off">
                                            <button class="btn btn-primary" type="button"
                                                id="btn-search-existing">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loading Indicator -->
                            <div id="search-loading" class="text-center" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-white mt-2">Searching...</p>
                            </div>

                            <!-- Search Results -->
                            <div id="search-results" style="display: none;">
                                <div class="col-12">
                                    <h6 class="text-white mb-3">Search Results:</h6>
                                    <div id="customer-list-container" class="space-y-2">
                                        <!-- Customer list items will be inserted here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Random Customers (Initial Display) -->
                            <div id="random-customers" class="mt-3">
                                <h6 class="text-white mb-3">Recent Customers:</h6>
                                <div id="random-customers-list" class="space-y-2">
                                    <!-- Random customers will be loaded here -->
                                </div>
                            </div>

                            <!-- No Results Message -->
                            <div id="no-results" class="text-center" style="display: none;">
                                <div class="alert alert-info bg-gray-800 border-0 text-white">
                                    <i class="fas fa-info-circle"></i>
                                    No customers found. Try a different search term.
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-secondary w-sm"
                                        data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Switch Profile -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="switchProfileBC"
            tabindex="-1" aria-labelledby="switchProfileBCLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-gray-700 border-0">
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="switchProfileBCLabel">Switch Profile
                        </h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card bg-gray-900 border-0 rounded-0" id="switchProfileBCCard">
                        <div class="card-body">
                            <!-- Search Section -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="search-switch-profile" class="form-label text-white">Search
                                            Customer</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                                id="search-switch-profile"
                                                placeholder="Search by name, email, or phone..."
                                                autocomplete="off">
                                            <button class="btn btn-primary" type="button"
                                                id="btn-search-switch-profile">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loading Indicator -->
                            <div id="switch-profile-search-loading" class="text-center" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-white mt-2">Searching...</p>
                            </div>

                            <!-- Search Results -->
                            <div id="switch-profile-search-results" style="display: none;">
                                <div class="col-12">
                                    <h6 class="text-white mb-3">Search Results:</h6>
                                    <div id="switch-profile-customer-list-container" class="space-y-2">
                                        <!-- Customer list items will be inserted here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Random Customers (Initial Display) -->
                            <div id="switch-profile-random-customers" class="mt-3">
                                <h6 class="text-white mb-3">Recent Customers:</h6>
                                <div id="switch-profile-random-customers-list" class="space-y-2">
                                    <!-- Random customers will be loaded here -->
                                </div>
                            </div>

                            <!-- No Results Message -->
                            <div id="switch-profile-no-results" class="text-center" style="display: none;">
                                <div class="alert alert-info bg-gray-800 border-0 text-white">
                                    <i class="fas fa-info-circle"></i>
                                    No customers found. Try a different search term.
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-secondary w-sm"
                                        data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
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
            $(document).ready(function () {
                updateDateTime();
                setInterval(updateDateTime, 1000);
            });
        </script>

        <script src="{{ asset('assets/js/v3/lib/bot-interaction.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/socket.io-client@4.5.3/dist/socket.io.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
        <script src="https://unpkg.com/javascript-time-ago@2.5.9/bundle/javascript-time-ago.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/libs/emojionearea/dist/emojionearea.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/upload.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/libs/localforage/localforage.js"></script>
        <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
        <script>
            const companyId = "{{ current_agent()->company_id }}";
            var currentAgent = @json(current_agent());
            currentAgent.company_id = companyId;
            const listUrls = {
                baseUrl: "{{ url('/') }}/",
                chatHistory: "{{ route('chat.history', ['header_id' => ':header_id']) }}",
                userHistory: "{{ route('chat.user_histories', ['channel_user_id' => ':channel_user_id']) }}",
                blastHistory: "{{ route('chat.user_blast_histories', ['channel_user_id' => ':channel_user_id']) }}",
                allUsers: "{{ route('chat.users') }}",
                createTicketUrl: "{{ htmlspecialchars_decode(urldecode(get_config('feature.extra.ticket.url', current_agent()->company_id))) }}",
                chatEnd: "{{ route('chat.close', ['chat_header' => ':header_id']) }}",
                chatEndWithTicket: "{{ route('chat.close-with-ticket', ['chat_header' => ':header_id']) }}",
                chatGetHeader: "{{ route('chat.headers') }}",
                chatGetBodies: "{{ route('chat.bodies') }}",
                ticketGetByCategory: "{{ route('chat_ticket_dropdown.getbycategory', ':variable') }}",
                ticketGetByCategoryType: "{{ route('chat_ticket_dropdown.getbycategorytype', ':variable') }}",
                ticketGetByCategoryDetail: "{{ route('chat_ticket_dropdown.getbycategorydetail', ':variable') }}",
                syncHeader: "{{ route('chat.sync_headers') }}",
                syncHeaderHistory: "{{ route('chat.sync_headers.history') }}",
                syncBodies: "{{ route('chat.sync_bodies') }}",
                syncBodiesHistory: "{{ route('chat.sync_bodies.history') }}",
                syncAllUsers: "{{ route('chat.sync_users') }}",
            }
        </script>

        {{--
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/localforage.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/functions.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/events.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/chat.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/search.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/ticket.js"></script> --}}


        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/windowNotification.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/indexDB.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/http.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/chat.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/message.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/tickets.js"></script>

        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/socket.js"></script>

        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/lib/chatbot-message.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/instance.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v3/scripts.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/chat-v2/ticket.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/js/ticket-form.js"></script>

        <script>

            // Handle link customer directly
            $(document).on('click', '.link-customer-btn', function(e) {
                e.stopPropagation();
                const customerId = $(this).data('customer-id');
                const customerData = $(this).data('customer');
                const $btn = $(this);

                // Disable button to prevent double click
                $btn.prop('disabled', true);
                $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Linking...');

                // Get current channel_user_id from global variable or context
                if (typeof currentChannelUserId === 'undefined' || !currentChannelUserId) {
                    // Try to get from current chat context
                    const chatHeaderId = $('.chat-conversation').data('chat-id');
                    if (chatHeaderId) {
                        // You might need to get channel_user_id from chat header
                        // This depends on your current implementation
                        console.log('Need to get channel_user_id from chat context');
                        $btn.prop('disabled', false);
                        $btn.html('<i class="fas fa-link me-1"></i>Link Customer');
                        showSimpleNotification('Tidak dapat mendapatkan channel user ID', 'error');
                        return;
                    }
                }

                linkExistingCustomer(customerId, currentChannelUserId, $btn, customerData);
            });

            function linkExistingCustomer(chatTicketUserId, channelUserId, $btn, customerData) {
                $.ajax({
                    url: '/chat/v3/ticket/customer/link-existing',
                    method: 'POST',
                    data: {
                        chat_ticket_user_id: chatTicketUserId,
                        channel_user_id: channelUserId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Link response:', response);
                        if (response.success) {
                            // Show simple success notification
                            showSimpleNotification('Customer berhasil di-link', 'success');

                            $('#addCustomerButton').hide();
                            $('#addCustomerExistingButton').hide();
                            $('#editCustomerButton').show();
                            $('#switchProfileButton').show();

                            // Close modal
                            $('#addExistingCustomerBC').modal('hide');
                            $('#editCustomerBC').modal('hide');

                            // Refresh customer data to show updated information
                            if (typeof INSTANCE !== 'undefined' && INSTANCE.lib && INSTANCE.lib
                                .ticket) {
                                // Update chat_ticket_user data
                                INSTANCE.lib.ticket.var.chat_ticket_user = response.data;

                                // Refresh channels data and display
                                INSTANCE.lib.ticket.getChannel().then(() => {
                                    INSTANCE.lib.ticket.parseChannels();
                                });

                                // Refresh profile data
                                INSTANCE.lib.ticket.setPanelProfile();
                            }
                        } else {
                            // Reset button on error
                            if ($btn) {
                                $btn.prop('disabled', false);
                                $btn.html('<i class="fas fa-link me-1"></i>Link Customer');
                            }
                            // Show simple error notification
                            showSimpleNotification(response.message || 'Gagal link customer', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Link error:', xhr);
                        // Reset button on error
                        if ($btn) {
                            $btn.prop('disabled', false);
                            $btn.html('<i class="fas fa-link me-1"></i>Link Customer');
                        }
                        // Show simple error notification
                        showSimpleNotification('Gagal link customer', 'error');
                    }
                });
            }

            // Reset modal when closed
            $('#addExistingCustomerBC').on('hidden.bs.modal', function() {
                $('#search-existing-customer').val('');
                $('#search-results').hide();
                $('#no-results').hide();
                $('#selected-customer-info').hide();
                $('#btn-link-existing-customer').hide();
                $('#search-loading').hide();
                selectedCustomer = null;
                $('#customer-cards-container').empty();
            });
            // Load random customers when modal opens
            $('#addExistingCustomerBC').on('show.bs.modal', function() {
                loadRandomCustomers();
                $('#search-results').hide();
                $('#random-customers').show();
            });
            // Reset modal when closed
            $('#addExistingCustomerBC').on('hidden.bs.modal', function() {
                $('#search-existing-customer').val('');
                $('#search-results').hide();
                $('#random-customers').show();
                selectedCustomer = null;
                $('.customer-list-item').removeClass('border-primary');
                // Re-enable all link buttons
                $('.link-customer-btn').prop('disabled', false).html('<i class="fas fa-link me-1"></i>Link Customer');
            });
            // Set current channel user ID when opening modal
            $('#Btn_AddCustomerExisting').on('click', function() {
                // Get channel_user_id from current chat header
                if (typeof INSTANCE !== 'undefined' && INSTANCE.lib && INSTANCE.lib.chat && INSTANCE.lib.chat.var &&
                    INSTANCE.lib.chat.var.selected) {
                    currentChannelUserId = INSTANCE.lib.chat.var.selected.channel_user_id;
                    console.log('Current channel user ID:', currentChannelUserId);
                } else {
                    console.log('Warning: No active chat selected. Please open a chat first.');
                    showSimpleNotification('Silakan buka chat terlebih dahulu', 'error');
                    return false;
                }
            });
            // Simple notification function
            function showSimpleNotification(message, type) {
                type = type || 'info';
                const bgColor = type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600';
                const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';

                // Remove existing notification if any
                $('.simple-notification').remove();

                const notification = $(`
                    <div class="simple-notification fixed top-4 right-4 ${bgColor} text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2 min-w-[300px] max-w-md animate-slide-in">
                        <i class="fas ${icon} text-lg"></i>
                        <span class="flex-1">${message}</span>
                        <button class="ml-2 text-white hover:text-gray-200" onclick="$(this).closest('.simple-notification').fadeOut(300, function(){$(this).remove()})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);

                $('body').append(notification);

                // Auto remove after 3 seconds
                setTimeout(function() {
                    notification.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
            // Add Existing Customer functionality
            let selectedCustomer = null;
            let currentChannelUserId = null;

            // Search functionality
            $('#btn-search-existing').on('click', function() {
                const keyword = $('#search-existing-customer').val().trim();
                if (keyword.length < 2) {
                    showSimpleNotification('Masukkan minimal 2 karakter untuk mencari', 'error');
                    return;
                }
                searchExistingCustomers(keyword);
            });

            // Search on Enter key
            $('#search-existing-customer').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search-existing').click();
                }
            });
            function searchExistingCustomers(keyword) {
                // Show loading
                $('#search-loading').show();
                $('#search-results').hide();
                $('#no-results').hide();
                $('#random-customers').hide();

                $.ajax({
                    url: '/chat/v3/ticket/customer/search-existing',
                    method: 'POST',
                    data: {
                        keyword: keyword,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#search-loading').hide();

                        // Debug logging
                        console.log('Search response:', response);
                        console.log('Response success:', response.success);
                        console.log('Response data:', response.data);
                        console.log('Data length:', response.data ? response.data.length : 'no data');

                        if (response.success && response.data && response.data.length > 0) {
                            displaySearchResults(response.data);
                        } else {
                            console.log('No results found or invalid response');
                            $('#no-results').show();
                        }
                    },
                    error: function(xhr) {
                        $('#search-loading').hide();
                        console.error('Search error:', xhr);
                        showSimpleNotification('Gagal mencari customer', 'error');
                    }
                });
            }

            function displaySearchResults(customers) {
                const container = $('#customer-list-container');
                container.empty();

                // Hide random customers when showing search results
                $('#random-customers').hide();

                customers.forEach(function(customer) {
                    const listItem = createCustomerListItem(customer);
                    container.append(listItem);
                });

                $('#search-results').show();
            }

            function createCustomerListItem(customer) {
                const photo = customer.photo ? customer.photo : '/assets/images/icons/user.png';
                const address = customer.address ? customer.address.substring(0, 60) + (customer.address.length > 60 ? '...' : '') : 'No address';
                const isLinked = customer.is_linked || false;
                const linkedBadge = isLinked ?
                    '<span class="badge bg-success ms-2"><i class="fas fa-link me-1"></i>Linked</span>' : '';
                const borderClass = isLinked ? 'border-success' : 'border-gray-600';

                return $(`
                <div class="customer-list-item bg-gray-800 border ${borderClass} rounded-lg p-3 mb-2 hover:bg-gray-750 transition-colors cursor-pointer" data-customer-id="${customer.id}">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center flex-grow-1">
                            <img src="${photo}" alt="Customer Photo" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover; flex-shrink: 0;">
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="text-white mb-1 d-flex align-items-center">
                                    <span class="truncate">${customer.name || 'No Name'}</span>
                                    ${linkedBadge}
                                </h6>
                                <div class="d-flex flex-wrap gap-3 text-muted small">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-envelope me-1"></i>
                                        <span class="truncate" style="max-width: 200px;">${customer.email || 'No Email'}</span>
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-phone me-1"></i>
                                        <span>${customer.phone || 'No Phone'}</span>
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <span class="truncate" style="max-width: 200px;">${address}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <button class="btn btn-primary btn-sm link-customer-btn" data-customer-id="${customer.id}" data-customer='${JSON.stringify(customer).replace(/'/g, "&#39;")}'>
                                <i class="fas fa-link me-1"></i>Link Customer
                            </button>
                        </div>
                    </div>
                </div>
            `);
            }

            function loadRandomCustomers() {
                $.ajax({
                    url: '/chat/v3/ticket/customer/search-existing',
                    method: 'POST',
                    data: {
                        keyword: '',
                        random: true,
                        limit: 3,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && response.data && response.data.length > 0) {
                            const container = $('#random-customers-list');
                            container.empty();

                            response.data.forEach(function(customer) {
                                const listItem = createCustomerListItem(customer);
                                container.append(listItem);
                            });

                            $('#random-customers').show();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading random customers:', xhr);
                    }
                });
            }

            // Edit Customer functionality
            let selectedEditCustomer = null;

            // Load customer data when modal opens
            $('#editCustomerBC').on('show.bs.modal', function() {
                // Load data from INSTANCE.lib.ticket.var.chat_ticket_user if available
                if (typeof INSTANCE !== 'undefined' && INSTANCE.lib && INSTANCE.lib.ticket &&
                    INSTANCE.lib.ticket.var && INSTANCE.lib.ticket.var.chat_ticket_user) {
                    const customer = INSTANCE.lib.ticket.var.chat_ticket_user;
                    $('#EditCustomer_Id').val(customer.id || '');
                    $('#EditCustomer_Name').val(customer.name || '');
                    $('#EditCustomer_HP').val(customer.phone || '');
                    $('#EditCustomer_Email').val(customer.email || '');
                    $('#EditCustomer_Address').val(customer.address || '');
                } else {
                    // If no data available, clear the form
                    $('#EditCustomer_Id').val('');
                    $('#EditCustomer_Name').val('');
                    $('#EditCustomer_HP').val('');
                    $('#EditCustomer_Email').val('');
                    $('#EditCustomer_Address').val('');
                }
            });

            // Reset edit modal when closed
            $('#editCustomerBC').on('hidden.bs.modal', function() {
                selectedEditCustomer = null;
                // Note: Don't clear form fields here as they will be loaded again when modal opens
            });

            // Switch Profile functionality
            let selectedSwitchProfileCustomer = null;
            let switchProfileChannelUserId = null;

            // Set current channel user ID when opening modal
            $('#Btn_SwitchProfile').on('click', function() {
                // Get channel_user_id from current chat header
                if (typeof INSTANCE !== 'undefined' && INSTANCE.lib && INSTANCE.lib.chat && INSTANCE.lib.chat.var &&
                    INSTANCE.lib.chat.var.selected) {
                    switchProfileChannelUserId = INSTANCE.lib.chat.var.selected.channel_user_id;
                    console.log('Current channel user ID for switch profile:', switchProfileChannelUserId);
                } else {
                    console.log('Warning: No active chat selected. Please open a chat first.');
                    showSimpleNotification('Silakan buka chat terlebih dahulu', 'error');
                    return false;
                }
            });

            // Search functionality for switch profile
            $('#btn-search-switch-profile').on('click', function() {
                const keyword = $('#search-switch-profile').val().trim();
                if (keyword.length < 2) {
                    showSimpleNotification('Masukkan minimal 2 karakter untuk mencari', 'error');
                    return;
                }
                searchSwitchProfileCustomers(keyword);
            });

            // Search on Enter key for switch profile
            $('#search-switch-profile').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search-switch-profile').click();
                }
            });

            function searchSwitchProfileCustomers(keyword) {
                // Show loading
                $('#switch-profile-search-loading').show();
                $('#switch-profile-search-results').hide();
                $('#switch-profile-no-results').hide();
                $('#switch-profile-random-customers').hide();

                $.ajax({
                    url: '/chat/v3/ticket/customer/search-existing',
                    method: 'POST',
                    data: {
                        keyword: keyword,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#switch-profile-search-loading').hide();

                        // Debug logging
                        console.log('Switch profile search response:', response);

                        if (response.success && response.data && response.data.length > 0) {
                            displaySwitchProfileSearchResults(response.data);
                        } else {
                            console.log('No results found for switch profile');
                            $('#switch-profile-no-results').show();
                        }
                    },
                    error: function(xhr) {
                        $('#switch-profile-search-loading').hide();
                        console.error('Switch profile search error:', xhr);
                        showSimpleNotification('Gagal mencari customer', 'error');
                    }
                });
            }

            function displaySwitchProfileSearchResults(customers) {
                const container = $('#switch-profile-customer-list-container');
                container.empty();

                // Hide random customers when showing search results
                $('#switch-profile-random-customers').hide();

                customers.forEach(function(customer) {
                    const listItem = createSwitchProfileCustomerListItem(customer);
                    container.append(listItem);
                });

                $('#switch-profile-search-results').show();
            }

            function createSwitchProfileCustomerListItem(customer) {
                const photo = customer.photo ? customer.photo : '/assets/images/icons/user.png';
                const address = customer.address ? customer.address.substring(0, 60) + (customer.address.length > 60 ? '...' : '') : 'No address';
                const isLinked = customer.is_linked || false;
                const linkedBadge = isLinked ?
                    '<span class="badge bg-success ms-2"><i class="fas fa-link me-1"></i>Linked</span>' : '';
                const borderClass = isLinked ? 'border-success' : 'border-gray-600';

                return $(`
                <div class="customer-list-item bg-gray-800 border ${borderClass} rounded-lg p-3 mb-2 hover:bg-gray-750 transition-colors cursor-pointer" data-customer-id="${customer.id}">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center flex-grow-1">
                            <img src="${photo}" alt="Customer Photo" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover; flex-shrink: 0;">
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="text-white mb-1 d-flex align-items-center">
                                    <span class="truncate">${customer.name || 'No Name'}</span>
                                    ${linkedBadge}
                                </h6>
                                <div class="d-flex flex-wrap gap-3 text-muted small">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-envelope me-1"></i>
                                        <span class="truncate" style="max-width: 200px;">${customer.email || 'No Email'}</span>
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-phone me-1"></i>
                                        <span>${customer.phone || 'No Phone'}</span>
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <span class="truncate" style="max-width: 200px;">${address}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <button class="btn btn-primary btn-sm switch-profile-customer-btn" data-customer-id="${customer.id}" data-customer='${JSON.stringify(customer).replace(/'/g, "&#39;")}'>
                                <i class="fas fa-exchange-alt me-1"></i>Switch Profile
                            </button>
                        </div>
                    </div>
                </div>
            `);
            }

            function loadSwitchProfileRandomCustomers() {
                $.ajax({
                    url: '/chat/v3/ticket/customer/search-existing',
                    method: 'POST',
                    data: {
                        keyword: '',
                        random: true,
                        limit: 3,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && response.data && response.data.length > 0) {
                            const container = $('#switch-profile-random-customers-list');
                            container.empty();

                            response.data.forEach(function(customer) {
                                const listItem = createSwitchProfileCustomerListItem(customer);
                                container.append(listItem);
                            });

                            $('#switch-profile-random-customers').show();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading random customers for switch profile:', xhr);
                    }
                });
            }

            // Load random customers when modal opens
            $('#switchProfileBC').on('show.bs.modal', function() {
                loadSwitchProfileRandomCustomers();
                $('#switch-profile-search-results').hide();
                $('#switch-profile-random-customers').show();
            });

            // Reset modal when closed
            $('#switchProfileBC').on('hidden.bs.modal', function() {
                $('#search-switch-profile').val('');
                $('#switch-profile-search-results').hide();
                $('#switch-profile-random-customers').show();
                $('#switch-profile-no-results').hide();
                $('#switch-profile-search-loading').hide();
                selectedSwitchProfileCustomer = null;
                $('#switch-profile-customer-list-container').empty();
                // Re-enable all switch buttons
                $('.switch-profile-customer-btn').prop('disabled', false).html('<i class="fas fa-exchange-alt me-1"></i>Switch Profile');
            });

            // Handle switch profile customer selection
            $(document).on('click', '.switch-profile-customer-btn', function(e) {
                e.stopPropagation();
                const customerId = $(this).data('customer-id');
                const customerData = $(this).data('customer');
                const $btn = $(this);

                // Disable button to prevent double click
                $btn.prop('disabled', true);
                $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Switching...');

                // Get current channel_user_id from global variable or context
                if (typeof switchProfileChannelUserId === 'undefined' || !switchProfileChannelUserId) {
                    // Try to get from current chat context
                    if (typeof INSTANCE !== 'undefined' && INSTANCE.lib && INSTANCE.lib.chat && INSTANCE.lib.chat.var &&
                        INSTANCE.lib.chat.var.selected) {
                        switchProfileChannelUserId = INSTANCE.lib.chat.var.selected.channel_user_id;
                    } else {
                        console.log('Need to get channel_user_id from chat context');
                        $btn.prop('disabled', false);
                        $btn.html('<i class="fas fa-exchange-alt me-1"></i>Switch Profile');
                        showSimpleNotification('Tidak dapat mendapatkan channel user ID', 'error');
                        return;
                    }
                }

                switchProfileCustomer(customerId, switchProfileChannelUserId, $btn, customerData);
            });

            function switchProfileCustomer(chatTicketUserId, channelUserId, $btn, customerData) {
                $.ajax({
                    url: '/chat/v3/ticket/customer/link-existing',
                    method: 'POST',
                    data: {
                        chat_ticket_user_id: chatTicketUserId,
                        channel_user_id: channelUserId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Switch profile response:', response);
                        if (response.success) {
                            // Show simple success notification
                            showSimpleNotification('Profile berhasil di-switch', 'success');

                            // $('#addCustomerButton').hide();
                            // $('#addCustomerExistingButton').hide();
                            // $('#editCustomerButton').show();
                            // $('#switchProfileButton').show();

                            // Close modal
                            $('#switchProfileBC').modal('hide');

                            // Refresh customer data to show updated information
                            if (typeof INSTANCE !== 'undefined' && INSTANCE.lib && INSTANCE.lib
                                .ticket) {
                                // Update chat_ticket_user data
                                INSTANCE.lib.ticket.var.chat_ticket_user = response.data;

                                // Refresh channels data and display
                                INSTANCE.lib.ticket.getChannel().then(() => {
                                    INSTANCE.lib.ticket.parseChannels();
                                });

                                // Refresh profile data
                                INSTANCE.lib.ticket.setPanelProfile();
                            }
                        } else {
                            // Reset button on error
                            if ($btn) {
                                $btn.prop('disabled', false);
                                $btn.html('<i class="fas fa-exchange-alt me-1"></i>Switch Profile');
                            }
                            // Show simple error notification
                            showSimpleNotification(response.message || 'Gagal switch profile', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Switch profile error:', xhr);
                        // Reset button on error
                        if ($btn) {
                            $btn.prop('disabled', false);
                            $btn.html('<i class="fas fa-exchange-alt me-1"></i>Switch Profile');
                        }
                        // Show simple error notification
                        showSimpleNotification('Gagal switch profile', 'error');
                    }
                });
            }
            function loadSwitchProfileRandomCustomers() {
                $.ajax({
                    url: '/chat/v3/ticket/customer/search-existing',
                    method: 'POST',
                    data: {
                        keyword: '',
                        random: true,
                        limit: 3,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && response.data && response.data.length > 0) {
                            const container = $('#switch-profile-random-customers-list');
                            container.empty();

                            response.data.forEach(function(customer) {
                                const listItem = createSwitchProfileCustomerListItem(customer);
                                container.append(listItem);
                            });

                            $('#switch-profile-random-customers').show();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading random customers for switch profile:', xhr);
                    }
                });
            }




            // Open ticket detail modal from history list in Chat V3
            function DirectHistory(ticketId) {
                openTicketDetailModal(ticketId);
            }

            async function openTicketDetailModal(ticketId) {
                try {
                    document.getElementById('chatv3-ticket-detail-id').value = ticketId;
                    await chatv3LoadTicketDetails(ticketId);
                    await chatv3LoadTicketTimeline(ticketId);
                    await chatv3CheckPermissionAndUpdateForm(ticketId);

                    const modalElement = document.getElementById('chatv3TicketDetailModal');
                    if (typeof $ !== 'undefined' && $.fn.modal) {
                        $('#chatv3TicketDetailModal').modal('show');
                    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        const modal = new bootstrap.Modal(modalElement, { backdrop: true, keyboard: true, focus: true });
                        modal.show();
                    } else {
                        modalElement.style.display = 'block';
                        modalElement.classList.add('show');
                        modalElement.setAttribute('aria-hidden', 'false');
                        document.body.classList.add('modal-open');
                    }
                } catch (e) {
                    console.error('Failed to open ticket modal', e);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal membuka detail ticket' });
                }
            }

            async function chatv3LoadTicketDetails(ticketId) {
                const res = await fetch(`/chat/v3/ticket/ticket-detail/${ticketId}`);
                if (!res.ok) throw new Error('Failed to fetch ticket detail');
                const data = await res.json();
                if (!data.success) throw new Error(data.message || 'Invalid response');
                const t = data.data;
                const byId = (id) => document.getElementById(id);
                if (byId('chatv3-modal-ticket-number')) byId('chatv3-modal-ticket-number').textContent = `Ticket #${t.ticket_number}`;
                if (byId('chatv3-modal-ticket-number-value')) byId('chatv3-modal-ticket-number-value').textContent = t.ticket_number || '-';
                if (byId('chatv3-modal-ticket-status')) byId('chatv3-modal-ticket-status').textContent = t.status || '-';
                if (byId('chatv3-modal-ticket-priority')) byId('chatv3-modal-ticket-priority').textContent = t.priority || '-';
                if (byId('chatv3-modal-ticket-created')) byId('chatv3-modal-ticket-created').textContent = t.created_at ? new Date(t.created_at).toLocaleString('id-ID') : '-';
                if (byId('chatv3-modal-ticket-subject')) byId('chatv3-modal-ticket-subject').textContent = t.genesisnumber || '-';
                if (byId('chatv3-modal-ticket-description')) byId('chatv3-modal-ticket-description').innerHTML = `<p class="text-gray-300">${t.user_data ? `Customer: ${t.user_data.name} (${t.user_data.phone})` : 'No customer data'}</p>`;
                if (byId('chatv3-modal-ticket-category')) byId('chatv3-modal-ticket-category').textContent = t.category || '-';
                if (byId('chatv3-modal-ticket-subcategory')) byId('chatv3-modal-ticket-subcategory').textContent = t.subcategory || '-';
                const currentLayer = String(t.ticket_position || '1');
                if (byId('chatv3-ticket-current-layer')) byId('chatv3-ticket-current-layer').value = currentLayer;
                if (byId('chatv3-modal-ticket-layer')) byId('chatv3-modal-ticket-layer').textContent = `Layer ${currentLayer}`;
                // Update escalation UI text
                const label = byId('chatv3-detail-escalation-label');
                const currentDisplay = byId('chatv3-detail-current-layer-display');
                if (currentDisplay) currentDisplay.textContent = `Layer ${currentLayer}`;
                if (label) {
                    label.textContent = currentLayer === '1' ? 'Eskalasi ke Layer 2' : (currentLayer === '2' ? 'Eskalasi ke Layer 3' : 'Kembali ke Layer 1');
                }
            }

            async function chatv3LoadTicketTimeline(ticketId) {
                const res = await fetch(`/chat/v3/ticket/ticket-timeline/${ticketId}`);
                const container = document.getElementById('chatv3-ticket-timeline');
                if (!res.ok) {
                    container.innerHTML = '<p class="text-gray-400 text-center py-4">Failed to load timeline</p>';
                    return;
                }
                const data = await res.json();
                if (!data.success || !data.data.length) {
                    container.innerHTML = '<p class="text-gray-400 text-center py-4">No timeline data available</p>';
                    return;
                }
                const sorted = data.data.sort((a,b)=> new Date(a.created_at) - new Date(b.created_at));
                container.innerHTML = '';
                sorted.forEach((detail, idx) => {
                    const created = new Date(detail.created_at).toLocaleString('id-ID');
                    const div = document.createElement('div');
                    div.className = `timeline-item relative flex flex-col items-center ${idx % 2 === 0 ? 'even' : 'odd'}`;
                    let channelName = detail.channel?.name || 'Ticket Detail';
                    let channelIcon = '<i class="fas fa-comment text-gray-400"></i>';
                    if (detail.channel?.icon_src) {
                        channelIcon = `<img src="${detail.channel.icon_src}" alt="${channelName}" class="w-8 h-8 rounded-full object-cover">`;
                    }
                    const agentName = detail.user_agent?.user_name || detail.user_agent?.username || 'Unknown Agent';
                    const layerText = detail.layer ? `Layer ${detail.layer}` : '';
                    let layerTransitionInfo = '';
                    if (detail.ref_id) {
                        const prevDetail = sorted.find(d => d.id == detail.ref_id);
                        if (prevDetail) {
                            const fromLayer = prevDetail.layer || 1;
                            const toLayer = detail.layer || 1;
                            if (fromLayer !== toLayer) {
                                layerTransitionInfo = `<div class="layer-transition text-yellow-400"><i class="fas fa-arrow-right mr-1"></i>Layer ${fromLayer} → Layer ${toLayer}</div>`;
                            } else {
                                layerTransitionInfo = `<div class="layer-transition text-gray-400"><i class="fas fa-circle mr-1"></i>Layer ${toLayer}</div>`;
                            }
                        }
                    } else {
                        layerTransitionInfo = `<div class="layer-transition text-green-400"><i class="fas fa-play mr-1"></i>Start Layer ${detail.layer || 1}</div>`;
                    }
                    let layerTransitionForClick = '';
                    if (detail.ref_id) {
                        const prevDetail = sorted.find(d => d.id == detail.ref_id);
                        if (prevDetail) {
                            const fromLayer = prevDetail.layer || 1;
                            const toLayer = detail.layer || 1;
                            if (fromLayer !== toLayer) {
                                layerTransitionForClick = `Layer ${fromLayer} → Layer ${toLayer}`;
                            } else {
                                layerTransitionForClick = `Layer ${toLayer}`;
                            }
                        }
                    } else {
                        layerTransitionForClick = `Start Layer ${detail.layer || 1}`;
                    }
                    div.innerHTML = `
                        <div class=\"timeline-icon relative z-10 flex items-center justify-center w-16 h-16 rounded-full cursor-pointer\"
                            onclick=\"chatv3ShowTimelineDetail(${idx}, '${channelName.replace(/"/g, '&quot;')}', '${created}', '${agentName.replace(/"/g, '&quot;')}', \`${(detail.note || '').replace(/`/g, '\\`')}\`, '${detail.status || ''}', '${layerTransitionForClick}')\" title=\"Klik untuk melihat detail\">
                           <div class=\"w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center\">${channelIcon}</div>
                           ${layerTransitionInfo}
                       </div>
                   `;
                    container.appendChild(div);
                });
            }

            function chatv3ShowTimelineDetail(index, channelName, formattedDate, agentName, note, status, layerTransition) {
                const display = document.getElementById('chatv3-timeline-detail-display');
                const content = document.getElementById('chatv3-detail-content');
                const title = document.getElementById('chatv3-detail-title');
                if (!display || !content || !title) return;
                title.textContent = 'Timeline Detail';
                function escHtml(s){ return String(s||'').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
                function formatLongText(text, maxLength = 100) {
                    if (!text) return 'Tidak ada catatan';
                    const cleanText = text.replace(/<[^>]*>/g, '');
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
                const safeNote = escHtml(note).replace(/\n/g,'<br>');
                content.innerHTML = `
                    <div class="space-y-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-white fw-semibold text-sm break-words">${escHtml(channelName)}</span>
                            <span class="text-xs text-gray-400 break-words">${escHtml(formattedDate)}</span>
                        </div>
                        <div class="text-xs text-gray-300 d-flex align-items-center"><i class="fas fa-user text-xs me-1"></i>${escHtml(agentName)}</div>
                        ${layerTransition ? `<div class="d-flex align-items-center"><i class="fas fa-layer-group text-blue-400 text-xs me-1"></i><span class="text-xs text-blue-300 break-words">${escHtml(layerTransition)}</span></div>` : ''}
                        ${status ? `<div class="d-flex align-items-center"><i class="fas fa-flag text-blue-400 text-xs me-1"></i><span class="text-xs text-blue-300 break-words">Status: ${escHtml(status)}</span></div>` : ''}
                        <div class="text-white text-sm leading-relaxed bg-gray-700 p-3 rounded content-text">${safeNote || 'Tidak ada catatan'}</div>
                    </div>
                `;
                display.classList.remove('hidden');
                display.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                const allIcons = document.querySelectorAll('#chatv3-ticket-timeline .timeline-icon');
                allIcons.forEach(icon => icon.classList.remove('active'));
                const timelineItems = document.querySelectorAll('#chatv3-ticket-timeline .timeline-item');
                const targetItem = timelineItems[index];
                if (targetItem) {
                    const iconDiv = targetItem.querySelector('.timeline-icon');
                    if (iconDiv) iconDiv.classList.add('active');
                }
            }

            function chatv3CloseTimelineDetailDisplay() {
                const display = document.getElementById('chatv3-timeline-detail-display');
                if (display) display.classList.add('hidden');
                const allIcons = document.querySelectorAll('#chatv3-ticket-timeline .timeline-icon');
                allIcons.forEach(icon => icon.classList.remove('active'));
            }

            async function chatv3CheckPermissionAndUpdateForm(ticketId) {
                try {
                    const currentUser = window.currentAgent;
                    const form = document.getElementById('chatv3-addTicketDetailForm');
                    if (!form || !currentUser) return;
                    const resp = await fetch('/chat/v3/ticket/ticket-detail/check-permission', {
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
                    const data = await resp.json();
                    if (!data.success || !data.can_add_detail) {
                        const formattedUserType = data.formatted_user_type || 'Layer 1';
                        chatv3DisableTicketDetailForm(`Anda tidak memiliki permission. Ticket position: ${data.ticket_position}, User type: ${formattedUserType}`);
                    } else {
                        chatv3EnableTicketDetailForm();
                    }
                } catch (e) {
                    console.error('Permission check failed', e);
                    chatv3DisableTicketDetailForm('Gagal mengecek permission');
                }
            }

            function chatv3DisableTicketDetailForm(message) {
                const form = document.getElementById('chatv3-addTicketDetailForm');
                if (!form) return;
                const status = document.getElementById('chatv3-detail-status');
                const note = document.getElementById('chatv3-detail-note');
                const esc = document.getElementById('chatv3-detail-escalation-checkbox');
                const submitBtn = form.querySelector('button[type="submit"]');
                if (status) status.disabled = true;
                if (note) { note.disabled = true; note.placeholder = message || 'Permission denied'; note.value = ''; }
                if (esc) esc.disabled = true;
                if (submitBtn) submitBtn.disabled = true;
                form.classList.add('form-disabled');
                let info = document.getElementById('chatv3-permission-info');
                if (!info) {
                    info = document.createElement('div');
                    info.id = 'chatv3-permission-info';
                    info.className = 'alert alert-warning mb-3 p-2 rounded bg-yellow-500/10 border border-yellow-500/30 text-yellow-400';
                    form.insertBefore(info, form.firstChild);
                }
                info.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>${message || 'Permission denied'}`;
            }

            function chatv3EnableTicketDetailForm() {
                const form = document.getElementById('chatv3-addTicketDetailForm');
                if (!form) return;
                const status = document.getElementById('chatv3-detail-status');
                const note = document.getElementById('chatv3-detail-note');
                const esc = document.getElementById('chatv3-detail-escalation-checkbox');
                const submitBtn = form.querySelector('button[type="submit"]');
                if (status) status.disabled = false;
                if (note) { note.disabled = false; note.placeholder = 'Add your note here...'; }
                if (esc) esc.disabled = false;
                if (submitBtn) submitBtn.disabled = false;
                form.classList.remove('form-disabled');
                const info = document.getElementById('chatv3-permission-info');
                if (info) info.remove();
            }

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('chatv3-addTicketDetailForm');
                if (!form) return;
                form.addEventListener('submit', async function(e){
                    e.preventDefault();
                    const ticketId = document.getElementById('chatv3-ticket-detail-id').value;
                    const status = document.getElementById('chatv3-detail-status').value;
                    const note = document.getElementById('chatv3-detail-note').value;
                    const channelId = document.getElementById('inichannelid').value;
                    const genesisnumber = document.getElementById('inichatheaderid').value;
                    const currentLayer = String(document.getElementById('chatv3-ticket-current-layer').value || '1');
                    const isEscalated = document.getElementById('chatv3-detail-escalation-checkbox')?.checked || false;
                    let newLayer = currentLayer;
                    if (isEscalated) {
                        if (currentLayer === '1') newLayer = '2';
                        else if (currentLayer === '2') newLayer = '3';
                        else if (currentLayer === '3') newLayer = '1';
                    }
                    try {
                        // Langkah 1: Tutup chat terlebih dahulu
                        if (genesisnumber) {
                            const closeResp = await fetch(`/chat/${genesisnumber}/close`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                }
                            });
                            const closeData = await closeResp.json();
                            if (!closeData.success) {
                                throw new Error(closeData.msg || 'Failed to close chat');
                            }
                        }

                        // Langkah 2: Tambah ticket detail setelah chat berhasil ditutup
                        const resp = await fetch('/chat/v3/ticket/ticket-detail/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: JSON.stringify({
                                ticket_id: ticketId,
                                flaging: 3,
                                channel_id: channelId,
                                status: status,
                                genesisnumber: genesisnumber,
                                note: note,
                                layer: newLayer,
                                escalation: isEscalated,
                            })
                        });
                        const data = await resp.json();
                        if (!data.success) throw new Error(data.message || 'Failed to add ticket detail');
                        Swal.fire({ icon: 'success', title: 'Success', text: 'Ticket detail added', timer: 2000, showConfirmButton: false });
                        await chatv3LoadTicketDetails(ticketId);
                        await chatv3LoadTicketTimeline(ticketId);
                        await chatv3CheckPermissionAndUpdateForm(ticketId)
                    } catch (err) {
                        console.error(err);
                        Swal.fire({ icon: 'error', title: 'Error', text: err.message || 'Gagal menambah ticket detail' });
                    }
                });
            });

            // Event listener untuk modal Blast History
            $('#blastHistoryModal').on('show.bs.modal', async function (e) {
                // Ambil phone dari user yang sedang aktif
                const phone = $('#inichatphone').val();

                if (!phone) {
                    $('#history-blast-list-modal').html('<div class="text-center text-red-400 py-3">Phone number tidak ditemukan</div>');
                    return;
                }

                // Panggil function khusus untuk modal (hanya status 2, tampilkan nama blast_schedule dan flag saja)
                await fetchBlastHistoryForModal(phone, '#history-blast-list-modal');

                // Tampilkan indikator jika sudah ada blast queue yang dipilih
                const selectedId = $('#selected_blast_queues_id').val();
                const savedScheduleName = $('#selected_blast_schedule_name').val();
                if (selectedId && savedScheduleName) {
                    $('#selected-blast-schedule-display').text(savedScheduleName);
                    $('#selected-blast-indicator').show();
                }
            });

            // Tampilkan indikator saat tab messages5 dibuka jika sudah ada blast queue yang dipilih
            $('a[href="#messages5"]').on('shown.bs.tab', function() {
                const selectedId = $('#selected_blast_queues_id').val();
                const savedScheduleName = $('#selected_blast_schedule_name').val();
                if (selectedId && savedScheduleName) {
                    $('#selected-blast-schedule-display').text(savedScheduleName);
                    $('#selected-blast-indicator').show();
                }
            });
        </script>

    </x-slot>
</x-dashonic-horizontal-layout>

<script>
    // Add this script after your existing scripts
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('chat-input-text');
        const form = document.getElementById('reply-msg');

        // Set initial height
        textarea.style.height = '40px';

        // Auto-resize function
        function autoResize() {
            textarea.style.height = '40px'; // Reset height
            const newHeight = Math.min(textarea.scrollHeight, 120); // Max height 120px
            textarea.style.height = newHeight + 'px';
        }

        // Add event listeners
        textarea.addEventListener('input', autoResize);

        // Handle Enter key press
        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault(); // Prevent default Enter behavior
                if (textarea.value.trim() !== '') { // Only submit if there's content
                    form.submit();
                }
            }
        });

        // Initial resize
        autoResize();
    });
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
