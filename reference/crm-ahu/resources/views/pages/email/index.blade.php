<x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
    with-header="{{ request()->get('with-header') ?? 0 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">
    <div class="mt-2 relative h-[calc(100vh-1rem)] overflow-hidden">
        <!-- Main Card Layout -->
        <div class="flex gap-2 h-[calc(100vh-1rem)]">
            <!-- Main Card - Email Interface -->
            <div class="flex-1 min-w-0">
                <div class="bg-gray-800 rounded-lg p-6 h-full flex flex-col">
                    <!-- Email List View -->
                    <div id="email-list-view" class="flex-1 flex flex-col h-[calc(100vh-12rem)] overflow-y-auto">
                        <!-- Gmail Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <h1 class="text-2xl font-bold text-white flex items-center">
                                        <i class="bx bx-envelope text-blue-500 mr-3 text-4xl"></i>
                                        Inbox
                                    </h1>
                                    <span class="text-sm text-gray-400">({{ $emails->total() }})</span>

                                    @if (isset($emailSetting))
                                        <div class="flex items-center space-x-2 text-xs text-green-400">
                                            <i class="bx bx-check-circle"></i>
                                            <span>Email Setting: {{ $emailSetting->protocol }} -
                                                {{ $emailSetting->host }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Fetch Email Button -->
                                <!-- <div class="flex items-center space-x-2">
                <button onclick="fetchIncomingEmails()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center space-x-2">
                    <i class="bx bx-refresh"></i>
                    <span>Ambil Email Masuk</span>
                </button>
                <button onclick="scheduleEmailFetch()"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center space-x-2">
                    <i class="bx bx-time"></i>
                    <span>Jadwalkan</span>
                </button>
            </div> -->
                            </div>

                            <div class="flex items-center space-x-4">
                                <!-- Search Bar -->
                                <form method="get" class="w-full max-w-md" id="email-search-form">
                                    <div class="relative">
                                        <input type="text" name="q" value="{{ request('q') }}"
                                            id="email-search-input" placeholder="Search mail..."
                                            class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-400 rounded-full pl-10 pr-12 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <span class="absolute left-3 top-2.5 text-gray-400">
                                            <i class="bx bx-search text-sm"></i>
                                        </span>
                                        <div class="absolute right-2 top-1.5 flex items-center space-x-1">
                                            <button type="button"
                                                class="p-1 rounded-full hover:bg-gray-600 text-gray-400 hover:text-white"
                                                title="Search options">
                                                <i class="bx bx-tune text-xs"></i>
                                            </button>
                                            <button type="submit"
                                                class="p-1 rounded-full hover:bg-gray-600 text-gray-400 hover:text-white">
                                                <i class="bx bx-search text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="bg-gray-800 rounded-lg mb-4">
                            <div class="flex items-center justify-between px-4 py-3">
                                <div class="flex items-center space-x-2 flex-wrap gap-2">
                                    <a href="{{ route('email.index', ['status' => 'all']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ !request('status') || request('status') == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Semua
                                    </a>
                                    <a href="{{ route('email.index', ['status' => 'unread']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request('status') == 'unread' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Belum Dibaca
                                    </a>
                                    <a href="{{ route('email.index', ['status' => 'read']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request('status') == 'read' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Sudah Dibaca
                                    </a>
                                    <a href="{{ route('email.index', ['status' => 'replied']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request('status') == 'replied' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Sudah Di-reply
                                    </a>
                                    <a href="{{ route('email.index', ['status' => 'Terima Kasih']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request('status') == 'Terima Kasih' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Terima Kasih
                                    </a>
                                    <a href="{{ route('email.index', ['status' => 'Salah Sambung']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request('status') == 'Salah Sambung' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Salah Sambung
                                    </a>
                                    <a href="{{ route('email.index', ['status' => 'Spam']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request('status') == 'Spam' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Spam
                                    </a>
                                    <a href="{{ route('email.index', ['status' => 'draft']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request('status') == 'draft' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Draft
                                    </a>
                                    <a href="{{ route('email.index', ['status' => 'Close']) }}"
                                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request('status') == 'Close' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                                        Close
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Gmail Email List -->
                        <div class="bg-gray-800 rounded-lg flex-1 h-[calc(100vh-1rem)] overflow-y-auto"
                            id="email-list-container">
                            @forelse ($emails as $item)
                                <div class="email-item flex items-center px-3 py-2 border-b border-gray-700 hover:bg-gray-750 cursor-pointer {{ !$item->is_draft && $item->status === 'unread' ? 'bg-gray-900' : 'bg-gray-800' }}"
                                    data-email-id="{{ $item->id }}" onclick="viewEmail({{ $item->id }})"
                                    data-email-subject="{{ $item->email_subject ?? '(No Subject)' }}"
                                    data-email-from="{{ $item->email_from ?? 'Unknown Sender' }}"
                                    data-email-to="{{ $item->email_to ?? '' }}"
                                    data-email-genesis="{{ $item->chat_header_id ?? '' }}"
                                    data-email-cc="{{ $item->email_cc ?? '' }}"
                                    data-email-bcc="{{ $item->email_bcc ?? '' }}"
                                    data-email-date="{{ optional($item->email_sent_date ?? $item->created_at)->timezone(config('app.timezone'))->format('F j, Y \a\t g:i A') }}"
                                    data-email-body-html="{{ htmlspecialchars($item->email_body_html ?? '') }}"
                                    data-email-body-text="{{ e(strip_tags($item->email_body_text ?? ($item->email_body_html ?? ''))) }}"
                                    data-email-attachments="{{ $item->attachments ? $item->attachments->count() : 0 }}"
                                    data-email-location-attachment="{{ optional($item->attachments->first())->id ?? '' }}"
                                    data-email-ref-id="{{ $item->ref_id ?? '' }}"
                                    data-email-status="{{ $item->is_draft ? 'draft' : $item->status ?? 'unread' }}"
                                    data-ticket-no="{{ $item->ticket_no ?? '' }}"
                                    data-agent-name="{{ $item->agent ? $item->agent->name : '' }}">

                                    <!-- Email Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-col">
                                            <!-- First Row: Sender and Date -->
                                            <div class="flex items-center justify-between mb-1">
                                                <div class="flex items-center space-x-2">
                                                    <!-- Sender Name -->
                                                    <div class="font-medium text-white truncate max-w-xs">
                                                        @php
                                                            $from = $item->email_from ?? 'Unknown Sender';
                                                            // Extract name from email format "Name <email@domain.com>"
                                                            if (preg_match('/^(.+?)\s*<(.+?)>$/', $from, $matches)) {
                                                                $senderName = trim($matches[1], '"');
                                                                $senderEmail = $matches[2];
                                                            } else {
                                                                $senderName = $from;
                                                                $senderEmail = $from;
                                                            }
                                                        @endphp
                                                        <span
                                                            class="text-white {{ $item->status === 'unread' ? 'font-bold' : '' }}">{{ $senderName }}</span>
                                                        <span
                                                            class="text-gray-400 text-xs">({{ $senderEmail }})</span>
                                                    </div>
                                                </div>

                                                <!-- Date and Flags -->
                                                <div class="flex flex-col items-end space-y-1">
                                                    <div class="text-xs text-gray-400 whitespace-nowrap">
                                                        @php
                                                            $date = $item->email_sent_date ?? $item->created_at;
                                                            $timezone_date = optional($date)->timezone(
                                                                config('app.timezone'),
                                                            );
                                                            $is_today = $timezone_date
                                                                ? $timezone_date->isToday()
                                                                : false;
                                                            $is_this_year = $timezone_date
                                                                ? $timezone_date->isCurrentYear()
                                                                : false;
                                                        @endphp
                                                        @if ($is_today)
                                                            {{ $timezone_date->format('g:i A') }}
                                                        @elseif($is_this_year)
                                                            {{ $timezone_date->format('M j') }}
                                                        @else
                                                            {{ $timezone_date->format('n/j/y') }}
                                                        @endif
                                                    </div>
                                                    <div class="flex items-center space-x-1 flex-wrap justify-end">
                                                        @if ($item->attachments && $item->attachments->count() > 0)
                                                            <div class="flex items-center space-x-1">
                                                                <i class="bx bx-paperclip text-gray-400 text-xs"></i>
                                                                <span
                                                                    class="text-gray-400 text-xs">{{ $item->attachments->count() }}</span>
                                                            </div>
                                                        @endif
                                                        @if ($item->is_draft)
                                                            <span
                                                                class="px-2 py-0.5 rounded text-xs font-medium bg-yellow-600 text-yellow-100">
                                                                Draft
                                                            </span>
                                                        @elseif ($item->status && in_array($item->status, ['Terima Kasih', 'Salah Sambung', 'Spam']))
                                                            @php
                                                                $statusLabels = [
                                                                    'Terima Kasih' => [
                                                                        'label' => 'Terima Kasih',
                                                                        'class' => 'bg-green-600 text-green-100',
                                                                    ],
                                                                    'Salah Sambung' => [
                                                                        'label' => 'Salah Sambung',
                                                                        'class' => 'bg-yellow-600 text-yellow-100',
                                                                    ],
                                                                    'Spam' => [
                                                                        'label' => 'Spam',
                                                                        'class' => 'bg-red-600 text-red-100',
                                                                    ],
                                                                ];
                                                                $statusInfo = $statusLabels[$item->status] ?? [
                                                                    'label' => $item->status,
                                                                    'class' => 'bg-gray-600 text-gray-100',
                                                                ];
                                                            @endphp
                                                            <span
                                                                class="px-2 py-0.5 rounded text-xs font-medium {{ $statusInfo['class'] }}">
                                                                {{ $statusInfo['label'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Second Row: Subject -->
                                            <div class="mb-1">
                                                <span
                                                    class="font-semibold text-white text-sm {{ $item->status === 'unread' ? 'font-bold' : '' }}">
                                                    {{ Str::limit($item->email_subject ?? '(No Subject)', 60) }}
                                                </span>
                                            </div>

                                            <!-- Third Row: Preview -->
                                            <div class="text-gray-400 text-sm line-clamp-2 mb-1">
                                                @php
                                                    $preview = strip_tags(
                                                        $item->email_body_text ?? ($item->email_body_html ?? ''),
                                                    );
                                                    $preview = Str::limit($preview, 200);
                                                @endphp
                                                {{ $preview }}
                                            </div>

                                            <!-- Fourth Row: Additional Info & Flags -->
                                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                                @if ($item->ticket_no)
                                                    <span class="bg-blue-900 text-blue-300 px-2 py-1 rounded">
                                                        <i class="bx bx-ticket mr-1"></i>{{ $item->ticket_no }}
                                                    </span>
                                                @endif
                                                @if ($item->agent)
                                                    <span class="bg-green-900 text-green-300 px-2 py-1 rounded">
                                                        <i class="bx bx-user mr-1"></i>{{ $item->agent->name }}
                                                    </span>
                                                @endif
                                                @if ($item->status === 'replied')
                                                    <span
                                                        class="bg-purple-700 text-purple-100 px-2 py-1 rounded flex items-center gap-1">
                                                        <i class="bx bx-mail-send mr-1"></i> Sudah di-reply
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @empty
                                <div class="p-16 text-center">
                                    <i class="bx bx-envelope text-8xl text-gray-600 mb-6"></i>
                                    <div class="text-2xl text-gray-400 mb-3">Your inbox is empty</div>
                                    <div class="text-gray-500">Congratulations, you're all caught up!</div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if ($emails->count() > 0)
                            <div class="p-4 border-t border-gray-800 bg-gray-800 rounded-lg"
                                id="pagination-container">
                                <div class="flex items-center justify-between">
                                    <!-- Pagination Info -->
                                    <div class="flex items-center space-x-3 text-sm text-gray-400">
                                        <span class="pagination-info">
                                            {{ $emails->firstItem() }}-{{ $emails->lastItem() }} of
                                            {{ $emails->total() }}
                                        </span>
                                    </div>

                                    <!-- Pagination Controls -->
                                    <div class="flex items-center space-x-2" id="pagination-controls">
                                        <!-- Previous Button -->
                                        <button id="prev-btn"
                                            class="p-2 rounded hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                            onclick="loadPreviousPage()"
                                            {{ $emails->currentPage() <= 1 ? 'disabled' : '' }}>
                                            <i class="bx bx-chevron-left text-lg"></i>
                                        </button>

                                        <!-- Page Numbers -->
                                        <div class="flex items-center space-x-1" id="page-numbers">
                                            @php
                                                $currentPage = $emails->currentPage();
                                                $lastPage = $emails->lastPage();
                                                $start = max(1, $currentPage - 2);
                                                $end = min($lastPage, $currentPage + 2);
                                            @endphp

                                            @if ($start > 1)
                                                <button class="p-2 rounded hover:bg-gray-700 text-sm transition-colors"
                                                    onclick="loadPage(1)">1</button>
                                                @if ($start > 2)
                                                    <span class="text-gray-500 px-2">...</span>
                                                @endif
                                            @endif

                                            @for ($i = $start; $i <= $end; $i++)
                                                <button
                                                    class="p-2 rounded text-sm transition-colors {{ $i == $currentPage ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 text-gray-400' }}"
                                                    onclick="loadPage({{ $i }})"
                                                    data-page="{{ $i }}">
                                                    {{ $i }}
                                                </button>
                                            @endfor

                                            @if ($end < $lastPage)
                                                @if ($end < $lastPage - 1)
                                                    <span class="text-gray-500 px-2">...</span>
                                                @endif
                                                <button class="p-2 rounded hover:bg-gray-700 text-sm transition-colors"
                                                    onclick="loadPage({{ $lastPage }})"
                                                    data-page="{{ $lastPage }}">{{ $lastPage }}</button>
                                            @endif
                                        </div>

                                        <!-- Next Button -->
                                        <button id="next-btn"
                                            class="p-2 rounded hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                            onclick="loadNextPage()"
                                            {{ $emails->currentPage() >= $emails->lastPage() ? 'disabled' : '' }}>
                                            <i class="bx bx-chevron-right text-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Email Compose View removed - now using separate page -->

                    <!-- Email Detail View -->
                    <div id="email-detail-view"
                        class="hidden flex-1 flex flex-col h-[calc(100vh-1rem)] overflow-y-auto">
                        <!-- Back Button and Header -->
                        <div class="flex items-start justify-between gap-4 mb-6">
                            <div class="flex items-start space-x-4 min-w-0 flex-1">
                                <button id="back-to-list"
                                    class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800 flex-shrink-0">
                                    <i class="bx bx-arrow-back text-xl"></i>
                                </button>
                                <h2 id="detail-subject"
                                    class="text-2xl font-bold text-white whitespace-normal break-words min-w-0"></h2>
                            </div>
                            <!-- Archive Dropdown -->
                            <div class="relative" id="archive-dropdown-container">
                                <button id="archive-btn"
                                    class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800 flex items-center space-x-1"
                                    title="Archive">
                                    <i class="bx bx-archive"></i>
                                    <i class="bx bx-chevron-down text-xs"></i>
                                </button>
                                <div id="archive-dropdown"
                                    class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg z-50 border border-gray-700">
                                    <button
                                        class="archive-option w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-t-lg"
                                        data-status="terima_kasih">
                                        <i class="bx bx-check-circle mr-2"></i>Terima Kasih
                                    </button>
                                    <button
                                        class="archive-option w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700"
                                        data-status="salah_sambung">
                                        <i class="bx bx-x-circle mr-2"></i>Salah Sambung
                                    </button>
                                    <button
                                        class="archive-option w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-b-lg"
                                        data-status="spam">
                                        <i class="bx bx-error-circle mr-2"></i>Spam
                                    </button>
                                    <button
                                        class="archive-option w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-b-lg"
                                        data-status="close">
                                        <i class="bx bx-error-circle mr-2"></i>Close
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Email Content -->
                        <div class="bg-gray-800 rounded-lg p-6 flex-1 overflow-y-auto">
                            <!-- Email Meta -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-start space-x-4">
                                    <div id="detail-sender-avatar"
                                        class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span id="detail-sender" class="text-white font-semibold"></span>
                                        </div>
                                        <div class="text-sm text-gray-400">
                                            <div>to <span id="detail-recipient"></span></div>
                                            <div id="detail-cc-container" class="hidden">cc: <span
                                                    id="detail-cc"></span></div>
                                            <div id="detail-bcc-container" class="hidden">bcc: <span
                                                    id="detail-bcc"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span id="detail-date" class="text-sm text-gray-400"></span>
                                </div>


                            </div>

                            <!-- Email Body -->
                            <div id="detail-body" class="prose prose-invert prose-blue max-w-none text-gray-300">
                            </div>

                            <!-- Location Attachment -->
                            <div id="detail-location-attachment" class="mt-3 max-w-xl"></div>

                            <!-- Additional Info -->
                            <div id="detail-additional-info" class="mt-4 flex items-center space-x-3"></div>

                            <!-- Attachments Section -->
                            <div id="detail-attachments" class="mt-6 hidden">
                                <div class="border-t border-gray-700 pt-6">
                                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                        <i class="bx bx-paperclip mr-2"></i>
                                        Attachments
                                    </h3>
                                    <div id="detail-attachments-list" class="space-y-3">
                                        <!-- Attachments will be populated here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Replies and Forwards Section -->
                            <div id="replies-forwards-section" class="mt-8 hidden">
                                <div class="border-t border-gray-700 pt-6">
                                    <!-- <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
          <i class="bx bx-message-dots mr-2"></i>
          Replies & Forwards
         </h3> -->

                                    <!-- Replies -->
                                    <div id="replies-container" class="mb-6">
                                        <!-- <h4 class="text-md font-medium text-gray-300 mb-3 flex items-center">
           <i class="bx bx-reply mr-2"></i>
           Replies
          </h4> -->
                                        <div id="replies-list" class="space-y-4">
                                            <!-- Replies will be populated here -->
                                        </div>
                                    </div>

                                    <!-- Forwards -->
                                    <div id="forwards-container" class="mb-6">
                                        <!-- <h4 class="text-md font-medium text-gray-300 mb-3 flex items-center">
           <i class="bx bx-share mr-2"></i>
           Forwards
          </h4> -->
                                        <div id="forwards-list" class="space-y-4">
                                            <!-- Forwards will be populated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reply Actions -->
                            <div class="mt-6 pt-6 border-t border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <button id="reply-btn"
                                        class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                        <i class="bx bx-reply"></i>
                                        <span>Reply</span>
                                    </button>
                                    <button id="forward-btn"
                                        class="flex items-center space-x-2 text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
                                        <i class="bx bx-share"></i>
                                        <span>Forward</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Card - Fixed width (Ticket Form) -->
            <div id="side-card" class="w-[400px] flex-shrink-0 transition-all duration-300 ease-in-out hidden">
                <div class="bg-gray-800 rounded-lg p-3 h-full flex flex-col overflow-y-auto">
                    <!-- Tabs -->
                    <div class="flex w-full mb-4 border-b border-gray-700">
                        <button id="tab-profile"
                            class="flex-1 text-center py-2 text-white font-semibold border-b-2 border-blue-400 focus:outline-none transition-all
							hover:bg-gray-700 hover:text-blue-400 hover:border-blue-400 bg-gray-700 text-blue-400"
                            onclick="showTab('profile')">
                            Profile
                        </button>
                        <button id="tab-endchat"
                            class="flex-1 text-center py-2 text-white font-semibold border-b-2 border-transparent focus:outline-none transition-all
							hover:bg-gray-700 hover:text-blue-400 hover:border-blue-400"
                            onclick="showTab('endchat')">
                            End Chat Ticket
                        </button>
                        <button id="tab-history"
                            class="flex-1 text-center py-2 text-white font-semibold border-b-2 border-transparent focus:outline-none transition-all
							hover:bg-gray-700 hover:text-blue-400 hover:border-blue-400"
                            onclick="showTab('history')">
                            History
                        </button>
                        <button id="tab-kb"
                            class="flex-1 text-center py-2 text-white font-semibold border-b-2 border-transparent focus:outline-none transition-all
							hover:bg-gray-700 hover:text-blue-400 hover:border-blue-400"
                            onclick="showTab('kb')">
                            Knowledge Base
                        </button>
                    </div>
                    <!-- Tab Contents -->
                    <div class="flex-1 w-full">
                        <div id="tab-content-profile" class="tab-content">
                            <!-- Konten Profile -->
                            <div class="text-gray-300">
                                <div id="profile-placeholder" class="flex flex-col h-full">
                                    <!-- Profile Header Placeholder -->
                                    <div class="bg-gray-800 rounded-lg p-2 mb-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="/assets/images/icons/user.png" alt="Avatar"
                                                    class="rounded-circle img-thumbnail"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                <div>
                                                    <div id="namaUser" class="fw-semibold text-white">Nama Pengguna
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <a class="btn btn-link text-white font-size-12 p-0 dropdown-toggle shadow-none group"
                                                    href="#" role="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i
                                                        class="fa fas fa-ellipsis-h group-hover:text-blue-400 transition-colors"></i>
                                                </a>
                                                <ul
                                                    class="dropdown-menu bg-gray-900 border-0 dropdown-menu-end rounded-lg shadow-lg">
                                                    <li id="addCustomerButton">
                                                        <a class="dropdown-item text-white hover:bg-gray-700"
                                                            href="#" id="Btn_AddCustomer"
                                                            data-bs-toggle="modal" data-bs-target="#addCustomerBC">
                                                            <i class="fa fa-plus-circle mr-2 text-blue-400"></i> Add
                                                            PIC
                                                        </a>
                                                    </li>
                                                    {{-- <li>
                                                        <a class="dropdown-item text-white hover:bg-gray-700" href="#" id="Btn_FindPIC" data-bs-toggle="modal" data-bs-target="#findPICModal">
                                                            <i class="fa fa-search mr-2 text-green-400"></i> Find PIC
                                                        </a>
                                                    </li> --}}
                                                    <li id="editCustomerButton" style="display: none;">
                                                        <a class="dropdown-item text-white hover:bg-gray-700"
                                                            href="#" id="Btn_EditCustomer"
                                                            data-bs-toggle="modal" data-bs-target="#editCustomerBC">
                                                            <i class="fa fa-edit mr-2 text-blue-400"></i> Edit PIC
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            {{-- <div class="dropdown">
                                                <a class="btn btn-link text-dark p-0 dropdown-toggle shadow-none"
                                                    href="#" role="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end bg-gray-800">
                                                    <li><a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#" onclick="triggerAddUser()">Add</a></li>
                                                    <li><a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#" onclick="triggerAddExisting()">Add
                                                            Existing</a></li>
                                                    <li><a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#" onclick="triggerEditUser()">Edit</a></li>
                                                </ul>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <!-- Tabs Placeholder -->
                                    {{-- <div class="bg-gray-800 rounded-lg mb-4">
                                        <div class="mt-2">
                                            <ul class="nav nav-tabs nav-justified nav-tabs-custom" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" data-bs-toggle="tab"
                                                        href="#navtabs2-home" role="tab" aria-selected="true">
                                                        <span class="d-block d-sm-none"><i
                                                                class="fas fa-home"></i></span>
                                                        <span class="d-none d-sm-block">Channel</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#navtabs2-channel"
                                                        role="tab" aria-selected="false" tabindex="-1">
                                                        <span class="d-block d-sm-none"><i
                                                                class="fas fa-home"></i></span>
                                                        <span class="d-none d-sm-block">Other Channel</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> --}}

                                    <!-- Profile Content Placeholder -->
                                    <div class="bg-gray-800 rounded-lg flex-1 overflow-y-auto">
                                        <div
                                            class="card bg-gray-800 border-0 overflow-y-auto overflow-x-hidden h-[calc(100vh-12rem)]">
                                            <div class="card-body">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="pb-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                <i class="fa fa-home"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-white mb-1 font-size-13 opacity-70">
                                                                    Alamat</p>
                                                                <h5 id="alamatUser"
                                                                    class="mb-0 text-white font-size-14">-</h5>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="py-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                <i class="fas fa-phone-alt"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-white mb-1 font-size-13 opacity-70">No.
                                                                    Telepon</p>
                                                                <h5 id="noTelpUser"
                                                                    class="mb-0 text-white font-size-14">-</h5>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="py-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                <i class="far fa-envelope"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-white mb-1 font-size-13 opacity-70">
                                                                    Email</p>
                                                                <h5 id="emailUser"
                                                                    class="mb-0 text-white font-size-14">-</h5>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <ul class="list-unstyled mb-0 space-y-4 py-5">
                                                    <li class="pb-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                <i class="fas fa-university text-blue-400"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-white mb-1 font-size-13 opacity-70">Nama
                                                                    Perusahaan</p>
                                                                <h5 class="mb-0 text-white font-size-14"
                                                                    id="nama_perusahaan"></h5>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a class="btn btn-link text-white font-size-12 p-0 dropdown-toggle shadow-none group"
                                                                    href="#" role="button"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i
                                                                        class="fa fas fa-ellipsis-h group-hover:text-blue-400 transition-colors"></i>
                                                                </a>
                                                                <ul
                                                                    class="dropdown-menu bg-gray-900 border-0 dropdown-menu-end rounded-lg shadow-lg">
                                                                    <li id="addPerusahaanButton">
                                                                        <a class="dropdown-item text-white hover:bg-gray-700"
                                                                            href="#"
                                                                            id="Btn_AddCustomerPerusahaan"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addCustomerPerusahaan">
                                                                            <i
                                                                                class="fa fa-plus-circle mr-2 text-blue-400"></i>
                                                                            Add Perusahaan
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item text-white hover:bg-gray-700"
                                                                            href="#" id="Btn_FindCustomer"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#findCustomerModal">
                                                                            <i
                                                                                class="fa fa-search mr-2 text-green-400"></i>
                                                                            Find Perusahaan
                                                                        </a>
                                                                    </li>
                                                                    <li id="editPerusahaanButton"
                                                                        style="display: none;">
                                                                        <a class="dropdown-item text-white hover:bg-gray-700"
                                                                            href="#"
                                                                            id="Btn_EditCustomerPerusahaan"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editCustomerPerusahaan">
                                                                            <i
                                                                                class="fa fa-edit mr-2 text-blue-400"></i>
                                                                            Edit Perusahaan
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="py-2">
                                                        <div
                                                            class="d-flex align-items-center transform transition-all hover:translate-x-1">
                                                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                <i class="far fa-envelope text-blue-400"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-white mb-1 font-size-13 opacity-70">
                                                                    Email</p>
                                                                <h5 class="mb-0 text-white font-size-14"
                                                                    id="email_perusahaan"></h5>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="py-2">
                                                        <div
                                                            class="d-flex align-items-center transform transition-all hover:translate-x-1">
                                                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                <i class="fas fa-phone-alt text-blue-400"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-white mb-1 font-size-13 opacity-70">No.
                                                                    Telepon</p>
                                                                <h5 class="mb-0 text-white font-size-14"
                                                                    id="phone_perusahaan"></h5>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Content -->
                                <div id="profile-content" class="hidden flex flex-col h-full">
                                    <!-- Profile Header -->
                                    <div class="bg-gray-800 rounded-lg p-2 mb-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <img id="profile-avatar" src="/assets/images/users/avatar-1.jpg"
                                                    alt="Avatar" class="rounded-circle img-thumbnail"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                <div>
                                                    <div id="profile-name" class="fw-semibold text-white">-</div>
                                                </div>
                                            </div>
                                            {{-- <div class="dropdown">
                                                <a class="btn btn-link text-dark p-0 dropdown-toggle shadow-none"
                                                    href="#" role="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end bg-gray-800">
                                                    <li><a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#" onclick="triggerAddUser()">Add</a></li>
                                                    <li><a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#" onclick="triggerAddExisting()">Add
                                                            Existing</a></li>
                                                    <li><a class="dropdown-item text-white hover:bg-gray-900 font-poppins"
                                                            href="#" onclick="triggerEditUser()">Edit</a></li>
                                                </ul>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <!-- Tabs -->
                                    <div class="bg-gray-800 rounded-lg mb-4">
                                        <div class="mt-2">
                                            <ul class="nav nav-tabs nav-justified nav-tabs-custom" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" data-bs-toggle="tab"
                                                        href="#navtabs2-home" role="tab" aria-selected="true">
                                                        <span class="d-block d-sm-none"><i
                                                                class="fas fa-home"></i></span>
                                                        <span class="d-none d-sm-block">Channel</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#navtabs2-channel"
                                                        role="tab" aria-selected="false" tabindex="-1">
                                                        <span class="d-block d-sm-none"><i
                                                                class="fas fa-home"></i></span>
                                                        <span class="d-none d-sm-block">Other Channel</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Tab Content -->
                                    <div class="tab-content">
                                        <!-- Channel Tab Content -->
                                        <div class="tab-pane active" id="navtabs2-home" role="tabpanel">
                                            <div class="bg-gray-800 rounded-lg flex-1 overflow-y-auto">
                                                <div
                                                    class="card bg-gray-800 border-0 overflow-y-auto overflow-x-hidden h-[calc(100vh-32rem)]">
                                                    <div class="card-body">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="pb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                        <i class="fa fa-home"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-1 font-size-13">Alamat
                                                                        </p>
                                                                        <h5 class="mb-0 text-white font-size-14"
                                                                            id="profile-address">-</h5>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="py-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                        <i class="fas fa-phone-alt"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-1 font-size-13">No.
                                                                            Telepon</p>
                                                                        <h5 class="mb-0 text-white font-size-14"
                                                                            id="profile-phone">-</h5>
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
                                                                        <p class="text-muted mb-1 font-size-13">Email
                                                                        </p>
                                                                        <h5 class="mb-0 text-white font-size-14"
                                                                            id="profile-email-detail">-</h5>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="py-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                        <i class="fab fa-facebook"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-1 font-size-13">
                                                                            Facebook</p>
                                                                        <h5 class="mb-0 text-white font-size-14"
                                                                            id="profile-facebook">-</h5>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="py-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                        <i class="fab fa-instagram"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-1 font-size-13">
                                                                            Instagram</p>
                                                                        <h5 class="mb-0 text-white font-size-14"
                                                                            id="profile-instagram">-</h5>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="py-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="font-size-20 text-primary flex-shrink-0 me-3">
                                                                        <i class="fab fa-twitter"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-1 font-size-13">X</p>
                                                                        <h5 class="mb-0 text-white font-size-14"
                                                                            id="profile-twitter">-</h5>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Other Channel Tab Content -->
                                        <div class="tab-pane" id="navtabs2-channel" role="tabpanel">
                                            <div class="bg-gray-800 rounded-lg flex-1 overflow-y-auto">
                                                <div
                                                    class="card bg-gray-800 border-0 overflow-y-auto overflow-x-hidden h-[calc(100vh-32rem)]">
                                                    <div class="card-body">
                                                        <div id="linked-channels-list" class="space-y-3">
                                                            <div class="text-center text-gray-400 text-sm py-8">
                                                                <i
                                                                    class="bx bx-message-square-dots text-4xl mb-3 block"></i>
                                                                <p>Tidak ada channel terhubung.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-content-endchat" class="tab-content hidden">
                            <input type="hidden" id="genesisEmail" value="">
                            <input type="hidden" id="userIdEmail" value="">
                            <input type="hidden" id="hidden_full_name" name="hidden_full_name">
                            <input type="hidden" id="hidden_contact_number" name="hidden_contact_number">
                            <input type="hidden" id="hidden_email" name="hidden_email">
                            <!-- x-ticket-form diletakkan di tab End Chat Ticket -->
                            <x-ticket-form />
                        </div>
                        <div id="tab-content-history" class="tab-content hidden">
                            <!-- Konten History -->
                            <div class="text-gray-300 h-full flex flex-col">
                                <!-- Loading State -->
                                <div id="history-loading"
                                    class="flex flex-col items-center justify-center h-full py-8">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mb-2">
                                    </div>
                                    <p class="text-sm text-gray-400">Memuat riwayat tiket...</p>
                                </div>

                                <!-- Empty State -->
                                <div id="history-empty"
                                    class="flex flex-col items-center justify-center h-full py-8 hidden">
                                    <i class="bx bx-history text-6xl text-blue-500 mb-2"></i>
                                    <p class="text-lg font-semibold">Riwayat Tiket</p>
                                    <p class="text-sm text-gray-400">Tidak ada riwayat tiket untuk customer ini.</p>
                                </div>

                                <!-- Error State -->
                                <div id="history-error"
                                    class="flex flex-col items-center justify-center h-full py-8 hidden">
                                    <i class="bx bx-error text-6xl text-red-500 mb-2"></i>
                                    <p class="text-lg font-semibold text-red-400">Error</p>
                                    <p class="text-sm text-gray-400">Silahkan pilih entitas terlebih dahulu</p>
                                </div>

                                <!-- Ticket Cards Container -->
                                <ul id="history-tickets" class="flex-1 overflow-y-auto p-3 hidden list-unstyled">
                                    <!-- Ticket cards will be dynamically inserted here -->
                                </ul>
                            </div>
                        </div>
                        <div id="tab-content-kb" class="tab-content hidden h-full">
                            <x-ai-kb-chat
                                component-id="emailAiKb"
                                source-page="email"
                                title="Knowledge Base"
                                empty-state="Tulis pertanyaan di bawah untuk memulai percakapan baru dengan AHU AI."
                            />
                        </div>
                    </div>
                </div>
                <script>
                    function showTab(tab) {
                        const tabs = ['profile', 'endchat', 'history', 'kb'];
                        tabs.forEach(function(name) {
                            const content = document.getElementById('tab-content-' + name);
                            const btn = document.getElementById('tab-' + name);
                            if (content) content.classList.add('hidden');
                            if (btn) btn.classList.remove('border-blue-400', 'text-blue-400', 'bg-gray-700');
                        });
                        const targetContent = document.getElementById('tab-content-' + tab);
                        const targetBtn = document.getElementById('tab-' + tab);
                        if (targetContent) targetContent.classList.remove('hidden');
                        if (targetBtn) targetBtn.classList.add('border-blue-400', 'text-blue-400', 'bg-gray-700');

                        // Load ticket history when history tab is clicked
                        if (tab === 'history') {
                            loadTicketHistory();
                        }

                        if (tab === 'kb' && window.emailAiKbInstance) {
                            window.emailAiKbInstance.refreshForCurrentContext();
                        }
                    }

                    // Function to get email profile using customer search
                    function getEmailProfile(email) {
                        // Show placeholder instead of loading
                        document.getElementById('profile-placeholder').classList.remove('hidden');
                        document.getElementById('profile-content').classList.add('hidden');

                        // If profile helper isn't available, keep placeholder and return
                        if (typeof showProfilePlaceholder !== 'function') {
                            return;
                        }

                        // Use search customer to get profile data
                        fetch('/email/search-customer', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    email: email
                                })
                            })
                            .then(response => {
                                const contentType = response.headers.get('content-type') || '';
                                if (!response.ok || !contentType.includes('application/json')) {
                                    return {
                                        success: false
                                    };
                                }
                                return response.json();
                            })
                            .then(res => {
                                if (res.success && res.data && res.data.user) {

                                    showNotification('Customer/PIC ditemukan.', 'success');

                                    const user = res.data.user;

                                    const formattedData = {
                                        user: {
                                            id: user.id,
                                            name: user.name || 'Unknown User',
                                            email: user.email || email,
                                            phone: user.phone || '-',
                                            address: user.address || '-',
                                            avatar: '/assets/images/users/avatar-1.jpg'
                                        },
                                        linked_channels: res.data.linked_channels || []
                                    };

                                    displayProfile(formattedData);


                                    // Optional: set ke form ticket
                                    setCustomerForTicket(user.id, user.name, user.email);

                                } else {
                                    showProfilePlaceholder();
                                    showNotification('Customer/PIC tidak ditemukan.');
                                }
                            })
                            // .catch(error => {
                            //     console.error('Error:', error);
                            //     showProfilePlaceholder();
                            // });

                            .catch(error => {
                                console.error('Error:', error);
                                showProfilePlaceholder();
                            });
                    }

                    function showProfilePlaceholder() {
                        const placeholder = document.getElementById('profile-placeholder');
                        const content = document.getElementById('profile-content');
                        if (placeholder) {
                            placeholder.classList.remove('hidden');
                        }
                        if (content) {
                            content.classList.add('hidden');
                        }
                    }

                    // Function to set customer data for ticket form
                    function setCustomerForTicket(userId, userName, userEmail) {
                        // Set hidden fields untuk ticket form
                        document.getElementById('inichatticketuser').value = userId;
                        document.getElementById('ticket_user_id').value = userId;

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Selected',
                            text: `Customer ${userName} (${userEmail}) telah dipilih untuk ticket form`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }

                    // Function to add new customer
                    function triggerAddUser() {
                        Swal.fire({
                            title: 'Tambah Customer Baru',
                            html: `
								<div class="text-left">
									<div class="mb-3">
										<label class="form-label">Nama</label>
										<input type="text" id="new-customer-name" class="form-control" placeholder="Masukkan nama customer">
									</div>
									<div class="mb-3">
										<label class="form-label">Email</label>
										<input type="email" id="new-customer-email" class="form-control" placeholder="Masukkan email customer">
									</div>
									<div class="mb-3">
										<label class="form-label">Phone</label>
										<input type="text" id="new-customer-phone" class="form-control" placeholder="Masukkan nomor telepon">
									</div>
									<div class="mb-3">
										<label class="form-label">Address</label>
										<textarea id="new-customer-address" class="form-control" placeholder="Masukkan alamat customer"></textarea>
									</div>
								</div>
							`,
                            showCancelButton: true,
                            confirmButtonText: 'Tambah Customer',
                            cancelButtonText: 'Batal',
                            preConfirm: () => {
                                const name = document.getElementById('new-customer-name').value;
                                const email = document.getElementById('new-customer-email').value;
                                const phone = document.getElementById('new-customer-phone').value;
                                const address = document.getElementById('new-customer-address').value;

                                if (!name || !email) {
                                    Swal.showValidationMessage('Nama dan email harus diisi');
                                    return false;
                                }

                                return {
                                    name,
                                    email,
                                    phone,
                                    address
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                addNewCustomer(result.value);
                            }
                        });
                    }

                    // Function to add new customer via API
                    function addNewCustomer(customerData) {
                        fetch('/email/add-customer', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(customerData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Set customer data untuk ticket form
                                    setCustomerForTicket(data.data.id, data.data.name, data.data.email);

                                    // Update profile display
                                    const formattedData = {
                                        user: {
                                            id: data.data.id, // Important: Include the ID for ticket history
                                            name: data.data.name,
                                            email: data.data.email,
                                            phone: data.data.phone || '-',
                                            address: data.data.address || '-',
                                            facebook: '-',
                                            instagram: '-',
                                            twitter: '-',
                                            avatar: '/assets/images/users/avatar-1.jpg'
                                        },
                                        linked_channels: []
                                    };
                                    displayProfile(formattedData);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message || 'Gagal menambah customer'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat menambah customer'
                                });
                            });
                    }

                    // Function to display profile
                    function displayProfile(data) {
                        // if (!data || !data.user) {
                        //     showProfilePlaceholder();
                        //     return;
                        // }

                        document.getElementById("addCustomerButton").style.display = "none";
                        document.getElementById("editCustomerButton").style.display = "block";

                        const user = data.user;

                        // Isi data profile
                        document.getElementById('namaUser').textContent = user.name || '-';
                        document.getElementById('emailUser').textContent = user.email || '-';
                        document.getElementById('noTelpUser').textContent = user.phone || '-';
                        document.getElementById('alamatUser').textContent = user.address || '-';
                        // document.getElementById('userIdEmail').value = user.id || '-';

                        document.getElementById('hidden_full_name').value = user.name || "";
                        document.getElementById('hidden_contact_number').value = user.phone || "";
                        document.getElementById('hidden_email').value = user.email || "";

                        document.getElementById("EditCustomer_Id").value = user.id || "";
                        document.getElementById("EditCustomer_Name").value = user.name || "";
                        document.getElementById("EditCustomer_HP").value = user.phone || "";
                        document.getElementById("EditCustomer_Email").value = user.email || "";
                        document.getElementById("EditCustomer_Address").value = user.address || "";

                        // Avatar (optional)
                        const avatarEl = document.getElementById('profile-avatar');
                        if (avatarEl) {
                            avatarEl.src = user.avatar || '/assets/images/users/avatar-1.jpg';
                        }

                        // Tampilkan profile, sembunyikan placeholder
                        document.getElementById('profile-placeholder').classList.add('hidden');
                        document.getElementById('profile-content').classList.remove('hidden');
                    }



                    // Function to update linked channels
                    function updateLinkedChannels(channels) {
                        const channelsList = document.getElementById('linked-channels-list');

                        if (channels.length === 0) {
                            channelsList.innerHTML = `
								<div class="text-center text-gray-400 text-sm py-8">
									<i class="bx bx-message-square-dots text-4xl mb-3 block"></i>
									<p>Tidak ada channel terhubung.</p>
								</div>
							`;
                        } else {
                            channelsList.innerHTML = channels.map(channel => `
								<div class="flex items-center space-x-3 bg-gray-700 rounded-lg p-3 hover:bg-gray-600 transition-colors">
									<div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center flex-shrink-0">
										${channel.icon ? `<img src="${channel.icon}" class="w-6 h-6 rounded-full" onerror="this.style.display='none'"/>` : '<i class="bx bx-message text-sm text-white"></i>'}
									</div>
									<div class="flex-1 min-w-0">
										<div class="text-white text-sm font-semibold truncate">${channel.channel || 'Unknown Channel'}</div>
										<div class="text-gray-300 text-xs truncate">${channel.text || 'No description'}</div>
									</div>
									<div class="flex-shrink-0">
										<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500 text-white">
											Active
										</span>
									</div>
								</div>
							`).join('');
                        }
                    }


                    // Function to reset profile
                    function resetProfile() {
                        // Hide profile content and show placeholder
                        document.getElementById('profile-content').classList.add('hidden');
                        document.getElementById('profile-placeholder').classList.remove('hidden');

                        // Reset active tab to profile
                        switchTab('profile');
                    }

                    // Function to show notifications
                    function showNotification(message, type = 'info') {
                        // Create notification element
                        const notification = document.createElement('div');
                        notification.className =
                            `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;

                        // Set colors based on type
                        const colors = {
                            success: 'bg-green-600 text-white',
                            error: 'bg-red-600 text-white',
                            warning: 'bg-yellow-600 text-white',
                            info: 'bg-blue-600 text-white'
                        };

                        notification.className += ` ${colors[type] || colors.info}`;
                        notification.innerHTML = `
						<div class="flex items-center">
							<i class="bx ${type === 'success' ? 'bx-check-circle' : type === 'error' ? 'bx-error-circle' : type === 'warning' ? 'bx-error' : 'bx-info-circle'} mr-2"></i>
							<span>${message}</span>
						</div>
					`;

                        // Add to page
                        document.body.appendChild(notification);

                        // Animate in
                        setTimeout(() => {
                            notification.classList.remove('translate-x-full');
                        }, 100);

                        // Auto remove after 3 seconds
                        setTimeout(() => {
                            notification.classList.add('translate-x-full');
                            setTimeout(() => {
                                if (notification.parentNode) {
                                    notification.parentNode.removeChild(notification);
                                }
                            }, 300);
                        }, 3000);
                    }

                    // Global function to toggle forward sections
                    function toggleForwardSection(type) {
                        const section = document.getElementById(`forward${type.charAt(0).toUpperCase() + type.slice(1)}Section`);
                        const button = event.target;

                        if (section.style.display === 'block') {
                            section.style.display = 'none';
                            button.classList.remove('active');
                        } else {
                            section.style.display = 'block';
                            button.classList.add('active');
                        }
                    }

                    // Global function to add forward email tag
                    function addForwardEmailTag(email, type) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        // Extract email from "Name <email@domain.com>" format if needed
                        let emailToValidate = email;
                        if (email.includes('<') && email.includes('>')) {
                            const match = email.match(/<(.+?)>/);
                            if (match) {
                                emailToValidate = match[1];
                            }
                        }

                        if (!emailRegex.test(emailToValidate)) {
                            showValidation(`forward${type.charAt(0).toUpperCase() + type.slice(1)}`, 'Format email tidak valid');
                            return false;
                        }

                        const existingTags = getForwardEmailTags(type);
                        if (existingTags.includes(emailToValidate)) {
                            showValidation(`forward${type.charAt(0).toUpperCase() + type.slice(1)}`, 'Email sudah ada dalam daftar');
                            return false;
                        }

                        const container = document.getElementById(`forward-${type}-tags`);
                        const tag = document.createElement('div');
                        tag.className = 'forward-email-tag';
                        tag.innerHTML = `
						${emailToValidate}
						<span class="remove" onclick="removeForwardEmailTag('${emailToValidate}', '${type}')">×</span>
					`;
                        container.insertBefore(tag, document.getElementById(`forward-${type}-input`));
                        hideValidation(`forward${type.charAt(0).toUpperCase() + type.slice(1)}`);
                        return true;
                    }

                    // Global function to remove forward email tag
                    function removeForwardEmailTag(email, type) {
                        const tags = document.querySelectorAll(`#forward-${type}-tags .forward-email-tag`);
                        tags.forEach(tag => {
                            if (tag.textContent.replace('×', '').trim() === email) {
                                tag.remove();
                            }
                        });
                    }

                    // Global function to get forward email tags
                    function getForwardEmailTags(type) {
                        const tags = document.querySelectorAll(`#forward-${type}-tags .forward-email-tag`);
                        return Array.from(tags).map(tag => tag.textContent.replace('×', '').trim());
                    }

                    // Global function to show validation
                    function showValidation(type, message) {
                        const validation = document.getElementById(`${type}Validation`);
                        if (validation) {
                            validation.textContent = message;
                            validation.style.display = 'block';
                        }
                    }

                    // Global function to hide validation
                    function hideValidation(type) {
                        const validation = document.getElementById(`${type}Validation`);
                        if (validation) {
                            validation.textContent = '';
                            validation.style.display = 'none';
                        }
                    }

                    // Make functions globally available
                    window.toggleForwardSection = toggleForwardSection;
                    window.addForwardEmailTag = addForwardEmailTag;
                    window.removeForwardEmailTag = removeForwardEmailTag;
                    window.getForwardEmailTags = getForwardEmailTags;
                    window.showValidation = showValidation;
                    window.hideValidation = hideValidation;

                    // Set default tab and initialize pagination
                    document.addEventListener('DOMContentLoaded', function() {
                        showTab('profile');
                        if (typeof loadPage === 'function') {
                            initializePagination();
                        }
                        initializeWysiwygEditor();
                        initializeModalWysiwygEditors();

                        // Ensure pagination functions are available globally
                        if (typeof loadPage === 'function') {
                            window.loadPage = loadPage;
                            window.loadPreviousPage = loadPreviousPage;
                            window.loadNextPage = loadNextPage;
                            window.loadEmailsPage = loadEmailsPage;
                        }
                    });

                    // Initialize pagination system
                    function initializePagination() {
                        // Initialize pagination state
                        window.currentPage = @json($emails->currentPage());
                        window.totalPages = @json($emails->lastPage());
                        window.isLoading = false;

                        // Ensure functions are available globally
                        window.loadPage = loadPage;
                        window.loadPreviousPage = loadPreviousPage;
                        window.loadNextPage = loadNextPage;
                        window.loadEmailsPage = loadEmailsPage;

                        // Attach pagination listeners
                        attachPaginationListeners();

                        // Attach keyboard navigation
                        attachKeyboardNavigation();

                        // Handle responsive pagination
                        handleResponsivePagination();

                        // Update pagination UI
                        updatePaginationUI();
                    }

                    // Function to attach keyboard navigation
                    function attachKeyboardNavigation() {
                        // Ensure functions are available globally
                        window.loadPage = loadPage;
                        window.loadPreviousPage = loadPreviousPage;
                        window.loadNextPage = loadNextPage;
                        window.loadEmailsPage = loadEmailsPage;

                        document.addEventListener('keydown', function(e) {
                            // Only handle if not in input/textarea
                            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                                return;
                            }

                            // Left arrow - previous page
                            if (e.key === 'ArrowLeft' && window.currentPage > 1 && !window.isLoading) {
                                e.preventDefault();
                                window.loadPreviousPage();
                            }

                            // Right arrow - next page
                            if (e.key === 'ArrowRight' && window.currentPage < window.totalPages && !window.isLoading) {
                                e.preventDefault();
                                window.loadNextPage();
                            }

                            // Home - first page
                            if (e.key === 'Home' && window.currentPage > 1 && !window.isLoading) {
                                e.preventDefault();
                                window.loadPage(1);
                            }

                            // End - last page
                            if (e.key === 'End' && window.currentPage < window.totalPages && !window.isLoading) {
                                e.preventDefault();
                                window.loadPage(window.totalPages);
                            }
                        });
                    }

                    // Function to handle responsive pagination
                    function handleResponsivePagination() {
                        // Ensure functions are available globally
                        window.loadPage = loadPage;
                        window.loadPreviousPage = loadPreviousPage;
                        window.loadNextPage = loadNextPage;
                        window.loadEmailsPage = loadEmailsPage;

                        const paginationContainer = document.getElementById('pagination-container');
                        if (!paginationContainer) return;

                        const pageNumbers = document.getElementById('page-numbers');
                        if (!pageNumbers) return;

                        // Check if screen is small
                        const isSmallScreen = window.innerWidth < 768;

                        if (isSmallScreen) {
                            // Hide page numbers on small screens, show only prev/next
                            pageNumbers.style.display = 'none';
                        } else {
                            // Show page numbers on larger screens
                            pageNumbers.style.display = 'flex';
                        }
                    }

                    // Attach resize listener for responsive pagination
                    window.addEventListener('resize', handleResponsivePagination);

                    // Initialize WYSIWYG editors for modals
                    function initializeModalWysiwygEditors() {
                        // Reply modal editor
                        const replyEditor = document.getElementById('reply-body-editor');
                        if (replyEditor) {
                            replyEditor.addEventListener('input', function() {
                                document.getElementById('reply-body').value = this.innerHTML;
                            });
                        }

                        // Forward modal editor
                        const forwardEditor = document.getElementById('forward-body-editor');
                        if (forwardEditor) {
                            forwardEditor.addEventListener('input', function() {
                                document.getElementById('forward-body').value = this.innerHTML;
                            });
                        }
                    }

                    // Global variable to store current chat_ticket_user_id
                    window.currentChatTicketUserId = null;

                    // Function to load ticket history
                    function loadTicketHistory() {
                        // Get chat_ticket_user_id from current profile data
                        let chatTicketUserId = document.getElementById('userIdEmail').value;

                        if (!chatTicketUserId) {
                            showHistoryError('Tidak ada Perusahaan yang dipilih. Silakan pilih Perusahaan terlebih dahulu.');
                            return;
                        }

                        // Show loading state
                        showHistoryLoading();

                        fetch('/chat/v3/ticket/result/by-id', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    user_id: chatTicketUserId
                                })
                            })
                            .then(response => response.json())
                            .then(response => {
                                if (response.success) {
                                    if (response.data && response.data.length > 0) {
                                        displayTicketHistory(response.data);
                                    } else {
                                        showHistoryEmpty();
                                    }
                                } else {
                                    showHistoryError(response.message || 'Gagal memuat riwayat tiket');
                                }
                            })
                            .catch(error => {
                                console.error('Error loading ticket history:', error);
                                showHistoryError('Terjadi kesalahan saat memuat riwayat tiket');
                            });
                    }

                    // Function to show loading state
                    function showHistoryLoading() {
                        document.getElementById('history-loading').classList.remove('hidden');
                        document.getElementById('history-empty').classList.add('hidden');
                        document.getElementById('history-error').classList.add('hidden');
                        document.getElementById('history-tickets').classList.add('hidden');
                    }

                    // Function to show empty state
                    function showHistoryEmpty() {
                        document.getElementById('history-loading').classList.add('hidden');
                        document.getElementById('history-empty').classList.remove('hidden');
                        document.getElementById('history-error').classList.add('hidden');
                        document.getElementById('history-tickets').classList.add('hidden');
                    }

                    // Function to show error state
                    function showHistoryError(message) {
                        document.getElementById('history-loading').classList.add('hidden');
                        document.getElementById('history-empty').classList.add('hidden');
                        document.getElementById('history-error').classList.remove('hidden');
                        document.getElementById('history-tickets').classList.add('hidden');

                        // Update error message
                        const errorMessage = document.querySelector('#history-error p:last-child');
                        if (errorMessage) {
                            errorMessage.textContent = message;
                        }
                    }

                    // Function to display ticket history
                    function displayTicketHistory(tickets) {
                        const container = document.getElementById('history-tickets');

                        container.innerHTML = '';

                        tickets.forEach(ticket => {
                            const ticketCard = createTicketCard(ticket);
                            container.appendChild(ticketCard);
                        });

                        document.getElementById('history-loading').classList.add('hidden');
                        document.getElementById('history-empty').classList.add('hidden');
                        document.getElementById('history-error').classList.add('hidden');
                        document.getElementById('history-tickets').classList.remove('hidden');
                    }


                    // Function to create ticket card
                    function createTicketCard(ticket) {
                        const card = document.createElement('div');
                        card.className =
                            'ticket-card mb-3 p-4 bg-gray-800/70 rounded-lg border border-gray-700 ' +
                            'hover:bg-gray-700/70 transition-all duration-200 cursor-pointer group';

                        card.id = `ticket-item-${ticket.id}`;
                        card.setAttribute('onclick', `openTicketDetailModal(${ticket.id})`);

                        // ===============================
                        // FORMAT DATE
                        // ===============================
                        const formatDate = (dateString) => {
                            if (!dateString) return '-';
                            const date = new Date(dateString);
                            if (isNaN(date.getTime())) return dateString;

                            return date.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        };

                        // ===============================
                        // STATUS BADGE
                        // ===============================
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

                        // ===============================
                        // HTML CONTENT
                        // ===============================
                        card.innerHTML = `
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center
                                                group-hover:bg-blue-500/30 transition-colors">
                                        <i class="fas fa-ticket-alt text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-white font-semibold text-sm mb-1">
                                            ${ticket.ticket_number || 'N/A'}
                                        </h5>
                                        <p class="text-gray-400 text-xs">
                                            ${ticket.genesisnumber || 'No Data Number'}
                                        </p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded-full ${statusClass} text-white">
                                        ${statusText}
                                    </span>
                                    <p class="text-gray-400 text-xs mt-1">
                                        ${formatDate(ticket.created_at)}
                                    </p>
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

                        return card;
                    }



                    // Function to get status badge
                    function getStatusBadge(status) {
                        const statusMap = {
                            'Open': 'bg-green-900 text-green-200',
                            'Closed': 'bg-gray-900 text-gray-200',
                            'Pending': 'bg-yellow-900 text-yellow-200',
                            'In Progress': 'bg-blue-900 text-blue-200',
                            'Resolved': 'bg-purple-900 text-purple-200'
                        };

                        const statusClass = statusMap[status] || 'bg-gray-900 text-gray-200';
                        return `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${statusClass}">${status || 'Unknown'}</span>`;
                    }

                    // Function to format numbers
                    function formatNumber(num) {
                        return new Intl.NumberFormat('id-ID').format(num);
                    }

                    // Function to handle ticket update
                    function updateTicket(ticketId) {
                        // You can implement ticket update functionality here
                        // For now, show a notification
                        showNotification(`Update ticket #${ticketId} - Functionality to be implemented`, 'info');
                        console.log('Update ticket:', ticketId);
                    }

                    // Function to handle ticket detail view
                    function viewTicketDetail(ticketId) {
                        // You can implement ticket detail view functionality here
                        // For now, show a notification
                        showNotification(`View detail ticket #${ticketId} - Functionality to be implemented`, 'info');
                        console.log('View ticket detail:', ticketId);
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
                            await loadTicketDetails(ticketId);

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
                                if (modalTicketCreated) modalTicketCreated.textContent = ticket.created_at ? new Date(ticket
                                    .created_at).toLocaleString('id-ID') : '-';
                                if (modalTicketSubject) modalTicketSubject.textContent = ticket.genesisnumber || '-';
                                if (modalTicketDescription) modalTicketDescription.innerHTML =
                                    `<p class="text-gray-300">${ticket.user_data ? `Perusahaan: ${ticket.user_data.name} (${ticket.user_data.phone})` : 'No customer data'}</p>`;
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
                            } else {
                                throw new Error(data.message || 'Failed to load ticket details');
                            }
                        } catch (error) {
                            console.error('Error loading ticket details:', error);
                            const timelineElement = document.getElementById('ticket-timeline');
                            if (timelineElement) {
                                timelineElement.innerHTML =
                                    '<p class="text-gray-400 text-center py-4">Failed to load ticket details</p>';
                            }
                        }
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

                        switch (layerStr) {
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
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                },
                                body: JSON.stringify({
                                    ticket_id: ticketId,
                                    user_agent_id: currentUser.user_agent?.id || currentUser.id
                                })
                            });

                            const permissionResp = await response.json();

                            if (!permissionResp.success || !permissionResp.can_add_detail) {
                                // Jika tiket Closed atau user L2/L3 mencoba akses tiket yang bukan posisinya
                                const message = permissionResp.ticket_status?.toLowerCase() === 'closed' ?
                                    'Tiket sudah Closed. Tidak dapat menambah interaksi.' :
                                    'Anda tidak memiliki permission untuk menambah detail pada ticket ini.';
                                disableTicketDetailForm(message);
                            } else {
                                // AKTIFKAN form, tapi kirim parameter isStatusDisabled
                                enableTicketDetailForm(permissionResp.is_status_disabled);

                                // Tambahkan pesan info jika dropdown di-disable
                                if (permissionResp.is_status_disabled) {
                                    showPermissionInfo(
                                        'Anda hanya dapat menambah interaksi. Perubahan status dikunci karena tiket berada di Layer Atas.'
                                    );
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
                            infoDiv.className =
                                'alert alert-warning mb-3 p-3 rounded bg-yellow-500/10 border border-yellow-500/30 text-yellow-400';
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
                            infoDiv.className =
                                'alert alert-info mb-3 p-3 rounded bg-blue-500/10 border border-blue-500/30 text-blue-400';
                            form.insertBefore(infoDiv, form.firstChild);
                        }
                        infoDiv.innerHTML = `<i class="fas fa-info-circle me-2"></i>${message}`;
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
                                    timelineItem.className =
                                        `timeline-item relative flex flex-col items-center ${positionClass}`;

                                    const createdDate = new Date(detail.created_at);
                                    const formattedDate = createdDate.toLocaleString('id-ID');
                                    const agentName = detail.user_agent?.user_name || detail.user_agent?.username ||
                                        'Unknown Agent';

                                    // Get channel info
                                    let channelIcon = '';
                                    let channelName = '';
                                    if (detail.channel) {
                                        channelName = detail.channel.name || 'Ticket Detail';
                                        // Gunakan icon_src yang sudah di-generate oleh Laravel
                                        if (detail.channel.icon_src) {
                                            channelIcon =
                                                `<img src="${detail.channel.icon_src}" alt="${channelName}" class="w-8 h-8 rounded-full object-cover">`;
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
                                timelineContainer.innerHTML =
                                    '<p class="text-gray-400 text-center py-4">No timeline data available</p>';
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
                                const isEscalated = document.getElementById('detail-escalation-checkbox')
                                    ?.checked || false;
                                const currentLayer = String(document.getElementById('ticket-current-layer')
                                    ?.value || '1');

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
                                const genesisnumber = document.getElementById('genesisEmail').value;

                                // Get phone number from URL parameter
                                // const urlParams = new URLSearchParams(window.location.search);
                                // const phone = urlParams.get('phone') || '';

                                // console.log('Phone from URL:', phone);

                                // if (phone) {
                                //     console.log('Phone found, fetching recording data...');
                                //     // Fetch recording data and get linkedid
                                //     const linkedid = await getRecordingByPhone(phone);
                                //     console.log('LinkedID received:', linkedid);

                                //     if (linkedid && linkedid !== '') {
                                //         genesisnumber = linkedid;
                                //         console.log('GenesisNumber set from recording:', genesisnumber);
                                //     } else {
                                //         console.log('No linkedid found, showing warning dialog');
                                //         // Show warning but continue with submission
                                //         const result = await Swal.fire({
                                //             icon: 'warning',
                                //             title: 'Peringatan',
                                //             text: 'Recording ID tidak ditemukan untuk nomor telepon ini. Ticket detail akan tetap dibuat tanpa GenesisNumber.',
                                //             confirmButtonText: 'Lanjutkan',
                                //             showCancelButton: true,
                                //             cancelButtonText: 'Batal'
                                //         });

                                //         // If user cancelled, stop execution
                                //         if (result.isDismissed) {
                                //             console.log('User cancelled submission');
                                //             return;
                                //         }

                                //         console.log('User confirmed, proceeding without GenesisNumber');
                                //     }
                                // } else {
                                //     console.log('No phone parameter found, proceeding without GenesisNumber');
                                // }

                                // console.log('Final GenesisNumber value:', genesisnumber);

                                try {
                                    const requestData = {
                                        ticket_id: ticketId,
                                        // interaction_number: interactionNumber,
                                        flaging: 4,
                                        channel_id: 17,
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
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute('content'),
                                        },
                                        body: JSON.stringify(requestData)
                                    });

                                    const data = await response.json();

                                    if (data.success) {
                                        // Build success message
                                        let successMessage = 'Ticket detail added successfully';
                                        if (isEscalated) {
                                            successMessage =
                                                `Ticket detail added and escalated to Layer ${newLayer}`;
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
                                                document.getElementById('ticket-current-layer').value =
                                                    updatedLayer;
                                                updateEscalationUI(updatedLayer);

                                                // Update modal header layer display
                                                const modalTicketLayer = document.getElementById(
                                                    'modal-ticket-layer');
                                                if (modalTicketLayer) {
                                                    modalTicketLayer.textContent = `Layer ${updatedLayer}`;
                                                }
                                            }

                                            // Update modal header status display
                                            if (data.ticket_updated.status) {
                                                const modalTicketStatus = document.getElementById(
                                                    'modal-ticket-status');
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
                        detailDisplay.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });

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
                </script>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="sending-indicator"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-gray-800 rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
            <span class="text-white">Mengirim email...</span>
        </div>
    </div>

    <!-- Reply Modal -->
    <div id="reply-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <i class="bx bx-reply text-blue-500 text-2xl"></i>
                    <h3 class="text-xl font-semibold text-white">Reply Email</h3>
                </div>
                <button id="close-reply-modal"
                    class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-700">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Original Email Preview -->
                <div class="bg-gray-700 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold text-white">Original Message</h4>
                        <span id="original-date" class="text-sm text-gray-400"></span>
                    </div>
                    <div class="text-sm text-gray-300">
                        <div class="mb-2">
                            <span class="text-gray-400">From:</span> <span id="original-from"></span>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-400">Subject:</span> <span id="original-subject"></span>
                        </div>
                        <div class="border-t border-gray-600 pt-3 mt-3">
                            <div id="original-body"
                                class="prose prose-invert prose-blue max-w-none text-gray-300 text-sm"></div>
                        </div>
                    </div>
                </div>

                <!-- Reply Form -->
                <form id="reply-form-modal">
                    @csrf
                    <input type="hidden" id="reply-email-id" name="email_id">
                    <input type="hidden" id="reply-draft-id" name="draft_id">

                    <!-- To Field (Read-only) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">To</label>
                        <input type="text" id="reply-to" name="to" readonly
                            class="w-full bg-gray-600 border border-gray-500 text-gray-300 rounded-lg px-3 py-2 cursor-not-allowed">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Template</label>
                        <select id="reply-template"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih template...</option>
                            @foreach ($templates ?? [] as $template)
                                <option value="{{ $template->id }}" data-subject="{{ e($template->subject ?? '') }}"
                                    data-body-html="{{ htmlspecialchars($template->body_html ?? '', ENT_QUOTES, 'UTF-8') }}">
                                    {{ $template->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
                        <input type="text" id="reply-subject" name="subject"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Message Body -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                        <div class="wysiwyg-container">
                            <!-- WYSIWYG Toolbar -->
                            <div class="wysiwyg-toolbar">
                                <button type="button" class="wysiwyg-btn" onclick="formatText('bold')"
                                    title="Bold">
                                    <i class="bx bx-bold"></i>
                                </button>
                                <button type="button" class="wysiwyg-btn" onclick="formatText('italic')"
                                    title="Italic">
                                    <i class="bx bx-italic"></i>
                                </button>
                                <button type="button" class="wysiwyg-btn" onclick="formatText('underline')"
                                    title="Underline">
                                    <i class="bx bx-underline"></i>
                                </button>
                                <div class="h-5 w-px bg-gray-600 mx-1"></div>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatText('insertUnorderedList')" title="Bullet List">
                                    <i class="bx bx-list-ul"></i>
                                </button>
                                <button type="button" class="wysiwyg-btn" onclick="formatText('insertOrderedList')"
                                    title="Numbered List">
                                    <i class="bx bx-list-ol"></i>
                                </button>
                                <div class="h-5 w-px bg-gray-600 mx-1"></div>
                                <button type="button" class="wysiwyg-btn" onclick="insertLink()"
                                    title="Insert Link">
                                    <i class="bx bx-link"></i>
                                </button>
                                <button type="button" class="wysiwyg-btn" onclick="formatText('removeFormat')"
                                    title="Remove Formatting">
                                    <i class="bx bx-eraser"></i>
                                </button>
                            </div>

                            <!-- WYSIWYG Editor -->
                            <div id="reply-body-editor" class="wysiwyg-editor" contenteditable="true"
                                placeholder="Type your reply message here..."></div>

                            <!-- Hidden textarea for form submission -->
                            <textarea id="reply-body" name="body" style="display: none;"></textarea>
                        </div>
                    </div>

                    <!-- Attachments Section -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Attachments</label>
                        <div class="flex items-center space-x-3">
                            <input type="file" id="reply-file-input" name="attachments[]" multiple class="hidden"
                                accept="*/*">
                            <button type="button" id="reply-attach-btn"
                                class="flex items-center space-x-2 text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
                                <i class="bx bx-paperclip"></i>
                                <span>Attach Files</span>
                            </button>
                            <span id="reply-file-count" class="text-sm text-gray-400 hidden"></span>
                        </div>

                        <!-- Attachments List -->
                        <div id="reply-attachments-container" class="mt-3 hidden">
                            <div id="reply-attachments-list" class="space-y-2">
                                <!-- Attachments will be listed here -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-between p-6 border-t border-gray-700">
                <div class="flex items-center space-x-3">
                    <button type="button" id="save-reply-draft"
                        class="text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
                        <i class="bx bx-save mr-2"></i>Save Draft
                    </button>
                </div>
                <div class="flex items-center space-x-3">
                    <button type="button" id="cancel-reply"
                        class="text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
                        Cancel
                    </button>
                    <button type="button" id="send-reply"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium flex items-center space-x-2">
                        <i class="bx bx-send text-lg"></i>
                        <span>Send Reply</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Forward Modal -->
    <div id="forward-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <i class="bx bx-share text-green-500 text-2xl"></i>
                    <h3 class="text-xl font-semibold text-white">Forward Email</h3>
                </div>
                <button id="close-forward-modal"
                    class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-700">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Original Email Preview -->
                <div class="bg-gray-700 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold text-white">Original Message</h4>
                        <span id="forward-original-date" class="text-sm text-gray-400"></span>
                    </div>
                    <div class="text-sm text-gray-300">
                        <div class="mb-2">
                            <span class="text-gray-400">From:</span> <span id="forward-original-from"></span>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-400">To:</span> <span id="forward-original-to"></span>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-400">Subject:</span> <span id="forward-original-subject"></span>
                        </div>
                        <div class="border-t border-gray-600 pt-3 mt-3">
                            <div id="forward-original-body"
                                class="prose prose-invert prose-blue max-w-none text-gray-300 text-sm"></div>
                        </div>
                    </div>
                </div>

                <!-- Forward Form -->
                <form id="forward-form-modal">
                    @csrf
                    <input type="hidden" id="forward-email-id" name="email_id">

                    <!-- To Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">To</label>
                        <div class="email-input-container">
                            <div class="forward-email-tags" id="forward-to-tags">
                                <input type="text" id="forward-to-input" name="to"
                                    class="forward-email-input" placeholder="Enter email addresses...">
                            </div>
                            <div id="forwardToValidation" class="validation-message"></div>
                        </div>
                    </div>

                    <!-- CC Field -->
                    <div class="mb-4">
                        <button type="button" class="toggle-btn" onclick="toggleForwardSection('cc')">CC</button>
                        <div id="forwardCcSection" class="cc-section" style="display: none;">
                            <label class="block text-sm font-medium text-gray-300 mb-2">CC</label>
                            <div class="email-input-container">
                                <div class="forward-email-tags" id="forward-cc-tags">
                                    <input type="text" id="forward-cc-input" name="cc"
                                        class="forward-email-input" placeholder="Enter CC email addresses...">
                                </div>
                                <div id="forwardCcValidation" class="validation-message"></div>
                            </div>
                        </div>
                    </div>

                    <!-- BCC Field -->
                    <div class="mb-4">
                        <button type="button" class="toggle-btn" onclick="toggleForwardSection('bcc')">BCC</button>
                        <div id="forwardBccSection" class="bcc-section" style="display: none;">
                            <label class="block text-sm font-medium text-gray-300 mb-2">BCC</label>
                            <div class="email-input-container">
                                <div class="forward-email-tags" id="forward-bcc-tags">
                                    <input type="text" id="forward-bcc-input" name="bcc"
                                        class="forward-email-input" placeholder="Enter BCC email addresses...">
                                </div>
                                <div id="forwardBccValidation" class="validation-message"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Template</label>
                        <select id="forward-template"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih template...</option>
                            @foreach ($templates ?? [] as $template)
                                <option value="{{ $template->id }}" data-subject="{{ e($template->subject ?? '') }}"
                                    data-body-html="{{ htmlspecialchars($template->body_html ?? '', ENT_QUOTES, 'UTF-8') }}">
                                    {{ $template->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
                        <input type="text" id="forward-subject" name="subject"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Message Body -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                        <div class="wysiwyg-container">
                            <!-- WYSIWYG Toolbar -->
                            <div class="wysiwyg-toolbar">
                                <button type="button" class="wysiwyg-btn" onclick="formatText('bold')"
                                    title="Bold">
                                    <i class="bx bx-bold"></i>
                                </button>
                                <button type="button" class="wysiwyg-btn" onclick="formatText('italic')"
                                    title="Italic">
                                    <i class="bx bx-italic"></i>
                                </button>
                                <button type="button" class="wysiwyg-btn" onclick="formatText('underline')"
                                    title="Underline">
                                    <i class="bx bx-underline"></i>
                                </button>
                                <div class="h-5 w-px bg-gray-600 mx-1"></div>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatText('insertUnorderedList')" title="Bullet List">
                                    <i class="bx bx-list-ul"></i>
                                </button>
                                <button type="button" class="wysiwyg-btn" onclick="formatText('insertOrderedList')"
                                    title="Numbered List">
                                    <i class="bx bx-list-ol"></i>
                                </button>
                                <div class="h-5 w-px bg-gray-600 mx-1"></div>
                                <button type="button" class="wysiwyg-btn" onclick="insertLink()"
                                    title="Insert Link">
                                    <i class="bx bx-link"></i>
                                </button>
                                <button type="button" class="wysiwyg-btn" onclick="formatText('removeFormat')"
                                    title="Remove Formatting">
                                    <i class="bx bx-eraser"></i>
                                </button>
                            </div>

                            <!-- WYSIWYG Editor -->
                            <div id="forward-body-editor" class="wysiwyg-editor" contenteditable="true"
                                placeholder="Type your forward message here..."></div>

                            <!-- Hidden textarea for form submission -->
                            <textarea id="forward-body" name="body" style="display: none;"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-between p-6 border-t border-gray-700">
                <div class="flex items-center space-x-3">
                    <button type="button" id="save-forward-draft"
                        class="text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
                        <i class="bx bx-save mr-2"></i>Save Draft
                    </button>
                </div>
                <div class="flex items-center space-x-3">
                    <button type="button" id="cancel-forward"
                        class="text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
                        Cancel
                    </button>
                    <button type="button" id="send-forward"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium flex items-center space-x-2">
                        <i class="bx bx-share text-lg"></i>
                        <span>Send Forward</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addCustomerBC"
        aria-labelledby="addCustomerBCLabel">
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
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="AddCustomer_Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="addcontact-designation-input" class="form-label">Nomor
                                        Telepon<span class="text-danger">*</span></label>
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

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addCustomerPerusahaan"
        aria-labelledby="addCustomerBCLabel">
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
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="AddCustomer_NamePerusahaan">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="addcontact-designation-input" class="form-label">Nomor
                                        Telepon<span class="text-danger"></span></label>
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="AddCustomer_PhonePerusahaan">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="addcontact-designation-input" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="AddCustomer_EmailPerusahaan">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="addcontact-designation-input" class="form-label">Alamat <span
                                            class="text-danger"></span></label>
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="AddCustomer_AddressPerusahaan">
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

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editCustomerBC" tabindex="-1"
        aria-labelledby="editCustomerBCLabel">
        <div class="modal-dialog">
            <div class="modal-content bg-gray-700 border-0">
                <div class="modal-header">
                    <h5 class="modal-tittle text-white" id="addModuleModalLabel"> Edit PIC </h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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
                        <input type="text" class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                            id="EditCustomer_IdPerusahaan" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="addcontact-designation-input" class="form-label">Nama Perusahaan <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="EditCustomer_NamePerusahaan">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="addcontact-designation-input" class="form-label">Nomor
                                        Telepon</label>
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="EditCustomer_PhonePerusahaan">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="addcontact-designation-input" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="EditCustomer_EmailPerusahaan">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="addcontact-designation-input" class="form-label">Alamat <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control bg-gray-800 text-white border-0 focus:bg-gray-800"
                                        id="EditCustomer_AddressPerusahaan">
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

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="findCustomerModal"
        tabindex="-1" aria-labelledby="findCustomerModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-gray-700 border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="findCustomerModalLabel">
                        <i class="fa fa-search mr-2"></i> Find Perusahaan
                    </h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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
                        <div id="findCustomerResults" class="table-responsive"
                            style="max-height: 400px; overflow-y: auto;">
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

    <div class="modal fade" id="ticketDetailModal" tabindex="-1" aria-labelledby="ticketDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-gray-900 border-0">
                <div class="modal-header bg-gray-800 border-0">
                    <h5 class="modal-title text-white flex items-center" id="ticketDetailModalLabel">
                        <i class="fas fa-ticket-alt mr-2 text-blue-400"></i>
                        <span id="modal-ticket-number">Ticket Details</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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

                    <!-- Journey Timeline -->
                    <div class="border-t border-gray-700">
                        <div class="p-4">
                            <h6 class="text-white font-semibold mb-4 flex items-center">
                                <i class="fas fa-route mr-2 text-blue-400"></i>
                                Ticket Journey Timeline
                            </h6>

                            <!-- Timeline Container -->
                            <div class="timeline-container relative">
                                <div id="ticket-timeline"
                                    class="flex overflow-x-auto space-x-4 relative overflow-y-hidden">
                                    <!-- Timeline items will be loaded here -->
                                </div>
                            </div>

                            <!-- Timeline Detail Display -->
                            <div id="timeline-detail-display"
                                class="mt-6 p-4 bg-gray-800 rounded-lg border border-gray-700 hidden">
                                <div class="flex items-center justify-between mb-3">
                                    <h6 class="text-white font-semibold text-sm" id="detail-title">Timeline Detail
                                    </h6>
                                    <button onclick="closeTimelineDetailDisplay()"
                                        class="text-gray-400 hover:text-white transition-colors">
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
                                        type="checkbox" id="detail-escalation-checkbox" name="escalation">
                                    <label class="form-check-label flex items-center text-blue-400 font-medium"
                                        for="detail-escalation-checkbox">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span id="detail-escalation-label">Eskalasi ke Layer 2</span>
                                    </label>
                                </div>
                                <small class="text-gray-400" id="detail-escalation-description">Centang untuk
                                    eskalasi ke layer berikutnya</small>
                                <div class="mt-1">
                                    <span class="text-xs text-gray-400">Current Layer: </span>
                                    <span class="text-xs font-semibold text-blue-400"
                                        id="detail-current-layer-display">Layer 1</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label class="form-label text-white text-sm">Status</label>
                                    <select class="form-select bg-gray-700 disabled:bg-gray-700 text-white border-0"
                                        id="detail-status">
                                        <option value="" selected>Select Ticket Status</option>
                                        @foreach ($chat_ticket_statuses as $chat_ticket_status)
                                            <option value="{{ $chat_ticket_status->name }}">
                                                {{ $chat_ticket_status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-white text-sm">Note</label>
                                <textarea class="form-control bg-gray-700 text-white border-0 focus:bg-gray-700 focus:text-white" id="detail-note"
                                    rows="3" placeholder="Add your note here..." required></textarea>
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
        <style>
            /* Prose styling for email content */
            .prose-blue a {
                color: #60A5FA;
            }

            .prose-blue a:hover {
                color: #93C5FD;
            }

            /* Email Tags Styles */
            .email-input-container {
                position: relative;
            }

            .email-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                min-height: 45px;
                padding: 10px;
                border: 2px solid #4b5563;
                border-radius: 12px;
                background: #374151;
                align-items: center;
                transition: all 0.3s ease;
            }

            .email-tags:focus-within {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .email-tag {
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                color: white;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 8px;
                animation: fadeIn 0.3s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.8);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            /* Pagination Styles */
            #pagination-container {
                position: sticky;
                bottom: 0;
                z-index: 10;
            }

            #pagination-controls {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            #page-numbers {
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }

            /* Responsive Pagination */
            @media (max-width: 768px) {
                #pagination-container {
                    padding: 0.75rem;
                }

                #pagination-controls {
                    flex-direction: column;
                    gap: 0.75rem;
                }

                .pagination-info {
                    font-size: 0.75rem;
                }

                #page-numbers {
                    display: none !important;
                }
            }

            @media (max-width: 480px) {
                #pagination-container {
                    padding: 0.5rem;
                }

                #pagination-controls {
                    flex-direction: column;
                    gap: 0.5rem;
                }

                #prev-btn,
                #next-btn {
                    width: 100%;
                    justify-content: center;
                }
            }

            /* Loading States */
            .pagination-loading {
                opacity: 0.6;
                pointer-events: none;
            }

            /* Button Hover Effects */
            #prev-btn:hover:not(:disabled),
            #next-btn:hover:not(:disabled) {
                background-color: #374151;
                transform: translateY(-1px);
            }

            #page-numbers button:hover:not(:disabled) {
                background-color: #374151;
                transform: translateY(-1px);
            }

            .email-tag .remove {
                cursor: pointer;
                width: 16px;
                height: 16px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                transition: background 0.2s ease;
            }

            .email-tag .remove:hover {
                background: rgba(255, 255, 255, 0.5);
            }

            .email-input {
                border: none;
                outline: none;
                background: transparent;
                flex: 1;
                min-width: 200px;
                font-size: 14px;
                padding: 5px;
                color: white;
            }

            .email-input::placeholder {
                color: #9ca3af;
            }

            /* Toggle Section Styles */
            .toggle-section {
                display: flex;
                gap: 15px;
                margin-bottom: 20px;
            }

            .toggle-btn {
                background: linear-gradient(135deg, #6b7280, #9ca3af);
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 20px;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            .toggle-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }

            .toggle-btn.active {
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            }

            .cc-section,
            .bcc-section {
                display: none;
                animation: slideDown 0.3s ease;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* WYSIWYG Editor Styles */
            .wysiwyg-container {
                border: 2px solid #4b5563;
                border-radius: 12px;
                overflow: hidden;
                background: #1f2937;
                transition: border-color 0.3s ease;
            }

            .wysiwyg-container:focus-within {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .wysiwyg-toolbar {
                background: linear-gradient(135deg, #374151, #4b5563);
                border-bottom: 1px solid #4b5563;
                padding: 12px;
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .wysiwyg-btn {
                background: #1f2937;
                border: 1px solid #4b5563;
                border-radius: 6px;
                width: 32px;
                height: 32px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                transition: all 0.2s ease;
                color: #d1d5db;
            }

            .wysiwyg-btn:hover {
                background: #374151;
                border-color: #6b7280;
                transform: translateY(-1px);
            }

            .wysiwyg-btn.active {
                background: #3b82f6;
                color: white;
                border-color: #3b82f6;
            }

            .wysiwyg-editor {
                min-height: 300px;
                padding: 20px;
                font-size: 14px;
                line-height: 1.6;
                outline: none;
                background: #1f2937;
                color: white;
            }

            .wysiwyg-editor:empty:before {
                content: attr(placeholder);
                color: #9ca3af;
                font-style: italic;
            }

            /* List styling */
            .wysiwyg-editor ul {
                list-style-type: disc;
                margin-left: 20px;
                margin-bottom: 10px;
            }

            .wysiwyg-editor ol {
                list-style-type: decimal;
                margin-left: 20px;
                margin-bottom: 10px;
            }

            .wysiwyg-editor li {
                margin-bottom: 5px;
            }

            .wysiwyg-editor ul ul {
                list-style-type: circle;
            }

            .wysiwyg-editor ul ul ul {
                list-style-type: square;
            }

            /* Validation Message Styles */
            .validation-message {
                color: #ef4444;
                font-size: 12px;
                margin-top: 5px;
                display: none;
            }

            /* Attachment Styles */
            .attachment-item {
                background: #374151;
                border: 1px solid #4b5563;
                border-radius: 8px;
                padding: 12px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 8px;
            }

            .attachment-info {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .attachment-icon {
                width: 32px;
                height: 32px;
                background: #3b82f6;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 14px;
            }

            .attachment-details h6 {
                color: white;
                font-size: 14px;
                margin: 0;
            }

            .attachment-details p {
                color: #9ca3af;
                font-size: 12px;
                margin: 0;
            }

            .attachment-remove {
                background: #ef4444;
                color: white;
                border: none;
                border-radius: 4px;
                width: 24px;
                height: 24px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                transition: background 0.2s ease;
            }

            .attachment-remove:hover {
                background: #dc2626;
            }

            /* Modal Styles */
            .modal-backdrop {
                backdrop-filter: blur(4px);
            }

            .modal-content {
                animation: modalSlideIn 0.3s ease-out;
            }

            @keyframes modalSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(-20px) scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            /* Email Tags for Forward Modal */
            .forward-email-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                min-height: 45px;
                padding: 10px;
                border: 2px solid #4b5563;
                border-radius: 12px;
                background: #374151;
                align-items: center;
                transition: all 0.3s ease;
            }

            .forward-email-tags:focus-within {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .forward-email-tag {
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                color: white;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 8px;
                animation: fadeIn 0.3s ease;
            }

            .forward-email-tag .remove {
                cursor: pointer;
                width: 16px;
                height: 16px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                transition: background 0.2s ease;
            }

            .forward-email-tag .remove:hover {
                background: rgba(255, 255, 255, 0.5);
            }

            .forward-email-input {
                border: none;
                outline: none;
                background: transparent;
                flex: 1;
                min-width: 200px;
                font-size: 14px;
                padding: 5px;
                color: white;
            }

            .forward-email-input::placeholder {
                color: #9ca3af;
            }
        </style>

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
            /* .form-disabled {
                opacity: 0.6;
                pointer-events: none;
            }

            .form-disabled textarea,
            .form-disabled input,
            .form-disabled select {
                background-color: #1f2937 !important;
                color: #6b7280 !important;
                cursor: not-allowed;
            } */

            .alert-warning {
                background-color: rgba(234, 179, 8, 0.1);
                border: 1px solid rgba(234, 179, 8, 0.3);
                color: #fbbf24;
                padding: 0.75rem 1rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
            }

            .pagination .page-link {
                background-color: #1f2937 !important;
                /* gray-800 */
                color: #ffffff !important;
                border-color: #374151 !important;
                /* gray-700 */
            }

            /* Hover tetap dark */
            .pagination .page-link:hover {
                background-color: #374151 !important;
                /* gray-700 */
                color: #ffffff !important;
            }

            /* Active page */
            .pagination .page-item.active .page-link {
                background-color: #0d6efd !important;
                /* primary */
                border-color: #0d6efd !important;
                color: #ffffff !important;
            }

            /* ✅ DISABLED tetap DARK (Prev, Next, dan "...") */
            .pagination .page-item.disabled .page-link,
            .pagination .page-item.disabled span {
                background-color: #111827 !important;
                /* gray-900 */
                color: #9ca3af !important;
                /* gray-400 */
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
    </x-slot>

    <x-slot name="js">
        <script type="text/javascript" src="{{ url('/') }}/assets/js/ticket-form.js"></script>
        <script>
            (function() {
                window.companyId = '{!! addslashes(current_agent()->company_id) !!}';
                window.currentAgent = JSON.parse('{!! addslashes(json_encode(current_agent())) !!}');
                window.currentAgent.company_id = window.companyId;
            })();
        </script>

        <script>
            // Email storage arrays
            let emails = {
                to: [],
                cc: [],
                bcc: []
            };

            // File attachments array
            let attachments = [];
            let replyAttachments = [];

            // Email validation regex
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Initialize compose form functionality
            function initializeComposeForm() {
                // Initialize WYSIWYG editor
                const editor = document.getElementById('body-main');
                if (editor) {
                    editor.addEventListener('focus', function() {
                        if (editor.innerHTML === '') {
                            editor.innerHTML = '';
                        }
                    });

                    editor.addEventListener('blur', function() {
                        if (editor.innerHTML === '' || editor.innerHTML === '<br>') {
                            editor.innerHTML = '';
                        }
                    });
                }

                // Initialize email input handlers
                ['to-main', 'cc-main', 'bcc-main'].forEach(inputId => {
                    const input = document.getElementById(inputId);
                    if (input) {
                        const type = inputId.replace('-main', '');

                        input.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter' || e.key === ',' || e.key === ';') {
                                e.preventDefault();
                                const email = this.value.trim();
                                if (email && addEmailTag(email, type)) {
                                    this.value = '';
                                }
                            }
                        });

                        input.addEventListener('blur', function() {
                            const email = this.value.trim();
                            if (email && addEmailTag(email, type)) {
                                this.value = '';
                            }
                        });
                    }
                });

                // Initialize file attachment handler
                const attachBtn = document.getElementById('attach-file-main');
                const fileInput = document.getElementById('file-input');

                if (attachBtn && fileInput) {
                    attachBtn.addEventListener('click', function() {
                        fileInput.click();
                    });

                    fileInput.addEventListener('change', function(e) {
                        handleFileAttachments(e.target.files);
                    });
                }
            }

            // Initialize WYSIWYG toolbar
            function initializeWysiwygToolbar() {
                const editor = document.getElementById('body-main');
                if (!editor) return;

                // Add event listeners for toolbar buttons
                const toolbarButtons = document.querySelectorAll('.wysiwyg-btn');
                toolbarButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const command = this.getAttribute('onclick');
                        if (command) {
                            // Extract command from onclick attribute
                            const match = command.match(/formatText\('([^']+)'\)/);
                            if (match) {
                                formatText(match[1]);
                            }
                        }
                    });
                });

                // Update button states based on selection
                editor.addEventListener('keyup', updateToolbarState);
                editor.addEventListener('mouseup', updateToolbarState);
                editor.addEventListener('focus', updateToolbarState);
            }

            // Update toolbar button states
            function updateToolbarState() {
                const editor = document.getElementById('body-main');
                if (!editor) return;

                // Update bold button
                const boldBtn = document.querySelector('.wysiwyg-btn[onclick*="bold"]');
                if (boldBtn) {
                    boldBtn.classList.toggle('active', document.queryCommandState('bold'));
                }

                // Update italic button
                const italicBtn = document.querySelector('.wysiwyg-btn[onclick*="italic"]');
                if (italicBtn) {
                    italicBtn.classList.toggle('active', document.queryCommandState('italic'));
                }

                // Update underline button
                const underlineBtn = document.querySelector('.wysiwyg-btn[onclick*="underline"]');
                if (underlineBtn) {
                    underlineBtn.classList.toggle('active', document.queryCommandState('underline'));
                }
            }

            // Focus email input
            function focusInput(inputId) {
                document.getElementById(inputId).focus();
            }

            // Toggle CC/BCC sections
            function toggleSection(type) {
                const section = document.getElementById(type.replace('-main', 'Section'));
                const button = event.target;

                if (section.style.display === 'block') {
                    section.style.display = 'none';
                    button.classList.remove('active');
                } else {
                    section.style.display = 'block';
                    button.classList.add('active');
                }
            }

            // Add email tag
            function addEmailTag(email, type) {
                if (!emailRegex.test(email)) {
                    showValidation(type, 'Format email tidak valid');
                    return false;
                }

                if (emails[type].includes(email)) {
                    showValidation(type, 'Email sudah ada dalam daftar');
                    return false;
                }

                emails[type].push(email);
                const container = document.getElementById(type + '-main').parentNode;
                const tag = document.createElement('div');
                tag.className = 'email-tag';
                tag.innerHTML = `
					${email}
					<span class="remove" onclick="removeEmailTag('${email}', '${type}')">×</span>
				`;
                container.insertBefore(tag, document.getElementById(type + '-main'));
                hideValidation(type);
                return true;
            }

            // Remove email tag
            function removeEmailTag(email, type) {
                emails[type] = emails[type].filter(e => e !== email);
                event.target.parentNode.remove();
            }

            // Show validation message
            function showValidation(type, message) {
                const validation = document.getElementById(type + 'Validation');
                if (validation) {
                    validation.textContent = message;
                    validation.style.display = 'block';
                }
            }

            // Hide validation message
            function hideValidation(type) {
                const validation = document.getElementById(type + 'Validation');
                if (validation) {
                    validation.style.display = 'none';
                }
            }

            // Handle file attachments
            function handleFileAttachments(files) {
                Array.from(files).forEach(file => {
                    // Check file size (max 10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File terlalu besar. Maksimal 10MB per file.');
                        return;
                    }

                    // Add to attachments array
                    attachments.push(file);

                    // Show attachment in UI
                    showAttachment(file);
                });

                // Show attachments container
                const container = document.getElementById('attachments-container');
                if (container) {
                    container.classList.remove('hidden');
                }
            }

            // Show attachment in UI
            function showAttachment(file) {
                const attachmentsList = document.getElementById('attachments-list');
                if (!attachmentsList) return;

                const attachmentItem = document.createElement('div');
                attachmentItem.className = 'attachment-item';

                // Get file icon based on type
                const fileIcon = getFileIcon(file.type);

                attachmentItem.innerHTML = `
					<div class="attachment-info">
						<div class="attachment-icon">
							<i class="${fileIcon}"></i>
						</div>
						<div class="attachment-details">
							<h6>${file.name}</h6>
							<p>${formatFileSize(file.size)}</p>
						</div>
					</div>
					<button class="attachment-remove" onclick="removeAttachment('${file.name}')">
						<i class="bx bx-x"></i>
					</button>
				`;

                attachmentsList.appendChild(attachmentItem);
            }

            // Get file icon based on type
            function getFileIcon(type) {
                if (type.startsWith('image/')) return 'bx bx-image';
                if (type.startsWith('video/')) return 'bx bx-video';
                if (type.startsWith('audio/')) return 'bx bx-music';
                if (type.includes('pdf')) return 'bx bx-file-blank';
                if (type.includes('word')) return 'bx bx-file-doc';
                if (type.includes('excel') || type.includes('spreadsheet')) return 'bx bx-file';
                if (type.includes('powerpoint') || type.includes('presentation')) return 'bx bx-slideshow';
                if (type.includes('zip') || type.includes('rar')) return 'bx bx-archive';
                return 'bx bx-file';
            }

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Remove attachment
            function removeAttachment(fileName) {
                // Remove from attachments array
                attachments = attachments.filter(file => file.name !== fileName);

                // Remove from UI
                const attachmentItems = document.querySelectorAll('.attachment-item');
                attachmentItems.forEach(item => {
                    if (item.querySelector('h6').textContent === fileName) {
                        item.remove();
                    }
                });

                // Hide attachments container if no attachments
                if (attachments.length === 0) {
                    const container = document.getElementById('attachments-container');
                    if (container) {
                        container.classList.add('hidden');
                    }
                }
            }

            // WYSIWYG functions
            function formatText(command, value = null) {
                const editor = document.getElementById('body-main');

                // Modern approach for formatting
                if (command === 'bold') {
                    document.execCommand('bold', false, null);
                } else if (command === 'italic') {
                    document.execCommand('italic', false, null);
                } else if (command === 'underline') {
                    document.execCommand('underline', false, null);
                } else if (command === 'strikeThrough') {
                    document.execCommand('strikeThrough', false, null);
                } else if (command === 'insertUnorderedList') {
                    // Create bullet list
                    document.execCommand('insertUnorderedList', false, null);
                } else if (command === 'insertOrderedList') {
                    // Create numbered list
                    document.execCommand('insertOrderedList', false, null);
                } else if (command === 'justifyLeft') {
                    document.execCommand('justifyLeft', false, null);
                } else if (command === 'justifyCenter') {
                    document.execCommand('justifyCenter', false, null);
                } else if (command === 'justifyRight') {
                    document.execCommand('justifyRight', false, null);
                } else if (command === 'removeFormat') {
                    document.execCommand('removeFormat', false, null);
                }

                editor.focus();
                // Trigger input event to update form data
                editor.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            }

            function insertLink() {
                const url = prompt('Masukkan URL:');
                if (url) {
                    document.execCommand('createLink', false, url);
                    document.getElementById('body-main').focus();
                    // Trigger input event to update form data
                    document.getElementById('body-main').dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
            }

            // Initialize WYSIWYG editor
            function initializeWysiwygEditor() {
                const wysiwygEditor = document.getElementById('body-main');
                if (wysiwygEditor) {
                    // Add input event listener
                    wysiwygEditor.addEventListener('input', function() {
                        // Update the hidden textarea with HTML content
                        const bodyTextarea = document.getElementById('body');
                        if (bodyTextarea) {
                            bodyTextarea.value = this.innerHTML;
                        }
                    });

                    // Handle paste events
                    wysiwygEditor.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
                        document.execCommand('insertText', false, text);
                    });

                    // Handle focus events
                    wysiwygEditor.addEventListener('focus', function() {
                        this.classList.add('focused');
                    });

                    wysiwygEditor.addEventListener('blur', function() {
                        this.classList.remove('focused');
                    });

                    // Initialize toolbar
                    initializeWysiwygToolbar();
                }
            }

            // Initialize WYSIWYG toolbar
            function initializeWysiwygToolbar() {
                // Add click event listeners to toolbar buttons
                const toolbarButtons = document.querySelectorAll('.wysiwyg-btn');
                toolbarButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Update button states after formatting
                        setTimeout(updateWysiwygToolbar, 100);
                    });
                });

                // Update button states on selection change
                document.addEventListener('selectionchange', function() {
                    updateWysiwygToolbar();
                });
            }

            // Update WYSIWYG toolbar button states
            function updateWysiwygToolbar() {
                const boldBtn = document.querySelector('.wysiwyg-btn[onclick*="bold"]');
                const italicBtn = document.querySelector('.wysiwyg-btn[onclick*="italic"]');
                const underlineBtn = document.querySelector('.wysiwyg-btn[onclick*="underline"]');

                if (boldBtn) {
                    boldBtn.classList.toggle('active', document.queryCommandState('bold'));
                }
                if (italicBtn) {
                    italicBtn.classList.toggle('active', document.queryCommandState('italic'));
                }
                if (underlineBtn) {
                    underlineBtn.classList.toggle('active', document.queryCommandState('underline'));
                }
            }

            // Save draft
            function saveDraft() {
                const draftData = {
                    to: emails.to,
                    cc: emails.cc,
                    bcc: emails.bcc,
                    subject: document.getElementById('subject-main').value.trim(),
                    message: document.getElementById('body-main').innerHTML.trim(),
                    attachments: attachments.map(file => ({
                        name: file.name,
                        size: file.size,
                        type: file.type
                    })),
                    saved: new Date().toISOString()
                };

                // Save to localStorage
                localStorage.setItem('email_draft', JSON.stringify(draftData));

                // Show success message
                showNotification('Draft berhasil disimpan!', 'success');
            }

            // Load draft
            function loadDraft() {
                const draftData = localStorage.getItem('email_draft');
                if (draftData) {
                    try {
                        const draft = JSON.parse(draftData);

                        // Load email addresses
                        emails = {
                            to: draft.to || [],
                            cc: draft.cc || [],
                            bcc: draft.bcc || []
                        };

                        // Load subject
                        document.getElementById('subject-main').value = draft.subject || '';

                        // Load message
                        document.getElementById('body-main').innerHTML = draft.message || '';

                        // Load email tags
                        ['to', 'cc', 'bcc'].forEach(type => {
                            emails[type].forEach(email => {
                                addEmailTag(email, type);
                            });
                        });

                        // Show success message
                        showNotification('Draft berhasil dimuat!', 'success');
                    } catch (error) {
                        console.error('Error loading draft:', error);
                    }
                }
            }

            // Reset compose form
            function resetComposeForm() {
                // Clear email arrays
                emails = {
                    to: [],
                    cc: [],
                    bcc: []
                };
                attachments = [];

                // Clear email tags
                ['to-main', 'cc-main', 'bcc-main'].forEach(inputId => {
                    const type = inputId.replace('-main', '');
                    const container = document.getElementById(inputId).parentNode;
                    const tags = container.querySelectorAll('.email-tag');
                    tags.forEach(tag => tag.remove());
                    document.getElementById(inputId).value = '';
                    hideValidation(type);
                });

                // Clear other fields
                document.getElementById('subject-main').value = '';
                document.getElementById('body-main').innerHTML = '';

                // Hide CC/BCC sections
                document.getElementById('ccSection').style.display = 'none';
                document.getElementById('bccSection').style.display = 'none';
                document.querySelectorAll('.toggle-btn').forEach(btn => btn.classList.remove('active'));

                // Clear attachments
                const attachmentsList = document.getElementById('attachments-list');
                if (attachmentsList) {
                    attachmentsList.innerHTML = '';
                }
                const attachmentsContainer = document.getElementById('attachments-container');
                if (attachmentsContainer) {
                    attachmentsContainer.classList.add('hidden');
                }
            }

            // Function to mark email as read
            function markEmailAsRead(emailId) {
                fetch(`/email/${emailId}/mark-read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                document.querySelector('input[name="_token"]')?.value || ''
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the email item visual state
                            const emailItem = document.querySelector(`[data-email-id="${emailId}"]`);
                            if (emailItem) {
                                // Update background color from gray-900 to gray-800
                                emailItem.classList.remove('bg-gray-900');
                                emailItem.classList.add('bg-gray-800');
                                emailItem.dataset.emailStatus = 'read';

                                // Update sender name font weight
                                const senderName = emailItem.querySelector('.font-medium .text-white');
                                if (senderName) {
                                    senderName.classList.remove('font-bold');
                                }

                                // Update subject font weight
                                const subject = emailItem.querySelector('.font-semibold');
                                if (subject) {
                                    subject.classList.remove('font-bold');
                                }

                                // Update data attribute
                                emailItem.setAttribute('data-email-status', 'read');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error marking email as read:', error);
                    });
            }

            // Function to get attachment URL with proper formatting
            // Uses the downloadAttachment route for proper file download with extension
            function getAttachmentUrl(attachment) {
                // Use downloadAttachment route for consistent download handling with magic bytes detection
                return '/email/attachment/' + attachment.id + '/download';
            }

            // Function to update email updated_at
            function updateEmailUpdatedAt(emailId) {
                fetch(`/email/${emailId}/update-read-time`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                document.querySelector('input[name="_token"]')?.value || ''
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Silently update, no notification needed
                    })
                    .catch(error => {
                        console.error('Error updating read time:', error);
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const emailItems = document.querySelectorAll('.email-item');
                const emailListView = document.getElementById('email-list-view');
                const emailDetailView = document.getElementById('email-detail-view');
                const emailComposeView = document.getElementById('email-compose-view');
                const backBtn = document.getElementById('back-to-list');
                const backFromComposeBtn = document.getElementById('back-to-list-from-compose');
                // Compose button removed - now using separate page
                const composeBtn = null; // Set to null since compose is on separate page

                // Attach initial email item listeners
                attachEmailItemListeners();

                // Attach reply/forward button listeners
                attachReplyForwardListeners();

                // Initialize template selectors
                initializeTemplateSelectors();

                // Attach mark as replied button listener

                // Attach status filter listener
                // Attach live search listener
                attachEmailSearchListener();

                // Back to email list from detail view
                if (backBtn) {
                    backBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        emailDetailView.classList.add('hidden');
                        emailListView.classList.remove('hidden');

                        // Hide side card when going back to email list
                        const sideCard = document.getElementById('side-card');
                        if (sideCard) {
                            sideCard.classList.add('hidden');
                        }

                        resetProfile();
                    });
                }

                // Back to email list from compose view
                if (backFromComposeBtn) {
                    backFromComposeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        emailComposeView.classList.add('hidden');
                        emailListView.classList.remove('hidden');

                        // Hide side card when going back to email list
                        const sideCard = document.getElementById('side-card');
                        if (sideCard) {
                            sideCard.classList.add('hidden');
                        }

                        resetProfile();
                    });
                }

                // Open compose view
                if (composeBtn) {
                    composeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        emailListView.classList.add('hidden');
                        emailDetailView.classList.add('hidden');
                        emailComposeView.classList.remove('hidden');

                        // Hide side card when opening compose view
                        const sideCard = document.getElementById('side-card');
                        if (sideCard) {
                            sideCard.classList.add('hidden');
                        }
                    });
                }

                // Select all checkbox functionality
                const selectAllCheckbox = document.getElementById('select-all');
                const emailCheckboxes = document.querySelectorAll('.email-checkbox');

                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', function() {
                        emailCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                    });
                }

                // Individual checkbox change
                emailCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allChecked = Array.from(emailCheckboxes).every(cb => cb.checked);
                        const someChecked = Array.from(emailCheckboxes).some(cb => cb.checked);

                        if (selectAllCheckbox) {
                            selectAllCheckbox.checked = allChecked;
                            selectAllCheckbox.indeterminate = someChecked && !allChecked;
                        }
                    });
                });

                // Email Compose Form Functionality (Main Form)
                const emailFormMain = document.getElementById('email-compose-form-main');
                const clearFormBtnMain = document.getElementById('clear-form-main');
                const sendingIndicator = document.getElementById('sending-indicator');
                const sendEmailBtnMain = document.getElementById('send-email-main');

                // Clear form
                if (clearFormBtnMain && emailFormMain) {
                    clearFormBtnMain.addEventListener('click', function() {
                        if (confirm('Apakah Anda yakin ingin menghapus semua isian form?')) {
                            resetComposeForm();
                        }
                    });
                }

                // Save draft button
                const saveDraftBtn = document.getElementById('save-draft-btn');
                if (saveDraftBtn) {
                    saveDraftBtn.addEventListener('click', function() {
                        saveDraft();
                    });
                }

                // Initialize compose form when compose view is opened
                if (composeBtn) {
                    composeBtn.addEventListener('click', function() {
                        // Initialize compose form functionality
                        setTimeout(() => {
                            initializeComposeForm();
                            initializeWysiwygToolbar();
                        }, 100);
                    });
                }

                // Send email
                if (emailFormMain) {
                    emailFormMain.addEventListener('submit', async function(e) {
                        e.preventDefault();

                        // Show loading indicator
                        if (sendingIndicator) {
                            sendingIndicator.classList.remove('hidden');
                        }
                        if (sendEmailBtnMain) {
                            sendEmailBtnMain.disabled = true;
                            sendEmailBtnMain.innerHTML =
                                '<i class="bx bx-loader-alt animate-spin mr-2"></i>Sending...';
                        }

                        try {
                            // Validate required fields
                            if (emails.to.length === 0) {
                                showValidation('to', 'Minimal harus ada satu penerima');
                                return;
                            }

                            const subject = document.getElementById('subject-main').value.trim();
                            if (!subject) {
                                alert('Subjek email tidak boleh kosong');
                                return;
                            }

                            // Update hidden textarea before sending
                            const wysiwygEditor = document.getElementById('body-main');
                            const bodyTextarea = document.getElementById('body');
                            if (wysiwygEditor && bodyTextarea) {
                                bodyTextarea.value = wysiwygEditor.innerHTML;
                            }

                            const message = bodyTextarea ? bodyTextarea.value.trim() : document
                                .getElementById('body-main').innerHTML.trim();
                            if (!message || message === '<br>') {
                                alert('Pesan email tidak boleh kosong');
                                return;
                            }

                            const formData = new FormData();

                            // Add email addresses
                            formData.append('to', emails.to.join(','));
                            if (emails.cc.length > 0) {
                                formData.append('cc', emails.cc.join(','));
                            }
                            if (emails.bcc.length > 0) {
                                formData.append('bcc', emails.bcc.join(','));
                            }

                            // Add subject and message
                            formData.append('subject', subject);
                            formData.append('body', message);

                            // Add attachments
                            attachments.forEach((file, index) => {
                                formData.append(`attachments[${index}]`, file);
                            });

                            // Add CSRF token
                            formData.append('_token', document.querySelector('input[name="_token"]').value);

                            const response = await fetch('{{ route('email.send') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }

                            const result = await response.json();

                            if (result.success) {
                                // Show success message
                                showNotification('Email berhasil dikirim!', 'success');

                                // Clear form
                                resetComposeForm();

                                // Go back to email list
                                setTimeout(() => {
                                    if (emailComposeView) {
                                        emailComposeView.classList.add('hidden');
                                    }
                                    if (emailListView) {
                                        emailListView.classList.remove('hidden');
                                    }
                                    window.location.reload();
                                }, 1500);
                            } else {
                                // Show error message
                                let errorMessage = result.message || 'Gagal mengirim email';
                                if (result.errors) {
                                    const errorList = Object.values(result.errors).flat();
                                    errorMessage = errorList.join(', ');
                                }
                                showNotification(errorMessage, 'error');
                            }
                        } catch (error) {
                            console.error('Error sending email:', error);
                            showNotification('Terjadi kesalahan saat mengirim email: ' + error.message,
                                'error');
                        } finally {
                            // Hide loading indicator
                            if (sendingIndicator) {
                                sendingIndicator.classList.add('hidden');
                            }
                            if (sendEmailBtnMain) {
                                sendEmailBtnMain.disabled = false;
                                sendEmailBtnMain.innerHTML = '<i class="bx bx-send mr-2"></i>Send';
                            }
                        }
                    });
                }


                // Notification function
                function showNotification(message, type = 'info') {
                    // Create notification element
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${
						type === 'success' ? 'bg-green-600' :
						type === 'error' ? 'bg-red-600' :
						'bg-blue-600'
					} text-white`;

                    notification.innerHTML = `
						<div class="flex items-center space-x-2">
							<i class="bx ${
								type === 'success' ? 'bx-check-circle' :
								type === 'error' ? 'bx-error-circle' :
								'bx-info-circle'
							} text-lg"></i>
							<span>${message}</span>
						</div>
					`;

                    document.body.appendChild(notification);

                    // Remove notification after 5 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
                }


                // Function to mark email as replied
                function markEmailAsReplied(emailId) {
                    fetch(`/email/${emailId}/mark-replied`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                        'content') ||
                                    document.querySelector('input[name="_token"]')?.value || ''
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update the email item visual state
                                const emailItem = document.querySelector(`[data-email-id="${emailId}"]`);
                                if (emailItem) {
                                    // Remove unread styling
                                    emailItem.classList.remove('bg-gray-900');

                                    // Update status indicator to replied (green)
                                    const statusIndicator = emailItem.querySelector('.w-2.h-2');
                                    if (statusIndicator) {
                                        statusIndicator.className =
                                            'w-2 h-2 bg-green-500 rounded-full flex-shrink-0';
                                        statusIndicator.title = 'Sudah di-reply';
                                    }

                                    // Update sender name font weight
                                    const senderName = emailItem.querySelector('.font-medium .text-white');
                                    if (senderName) {
                                        senderName.classList.remove('font-bold');
                                    }

                                    // Update data attribute
                                    emailItem.setAttribute('data-email-status', 'replied');

                                    // Show success message
                                    showNotification(data.message, 'success');
                                }
                            } else {
                                showNotification(data.message || 'Gagal menandai email sebagai replied', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error marking email as replied:', error);
                            showNotification('Terjadi kesalahan saat menandai email', 'error');
                        });
                }

                // Function to load email attachments
                function loadEmailAttachments(emailId, container) {
                    fetch(`/email/${emailId}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                        'content') ||
                                    document.querySelector('input[name="_token"]')?.value || ''
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Email data:', data); // Debug log
                            if (data.success && data.email) {
                                container.innerHTML = '';

                                const attachments = Array.isArray(data.email.attachments) ? data.email.attachments :
                                    [];
                                attachments.forEach(attachment => {
                                    const attachmentItem = document.createElement('div');
                                    attachmentItem.className =
                                        'flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-700';

                                    attachmentItem.innerHTML = `
									<div class="flex items-center space-x-3">
										<div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
											<i class="bx bx-paperclip text-white text-lg"></i>
										</div>
										<div>
											<h6 class="text-white font-medium">${attachment.filename || 'Unknown File'}</h6>
											<p class="text-gray-400 text-sm">${attachment.filetype || 'Unknown Type'}</p>
										</div>
									</div>
									<div class="flex items-center space-x-2">
										<a href="${getAttachmentUrl(attachment)}"
										   target="_blank"
										   class="text-blue-400 hover:text-blue-300 p-2 rounded-lg hover:bg-gray-700"
										   title="View ${attachment.filename}">
											<i class="bx bx-show text-lg"></i>
										</a>
									</div>
								`;

                                    container.appendChild(attachmentItem);
                                });

                                // Get location_attachment with fallback, prioritize fullpath from first attachment
                                let locationUrl = '';
                                if (attachments.length > 0 && attachments[0].fullpath) {
                                    locationUrl = attachments[0].fullpath;
                                } else {
                                    locationUrl = data.email.location_attachment || '';
                                }

                                // Transform URL: convert http to https
                                if (locationUrl && locationUrl.startsWith('http://')) {
                                    locationUrl = locationUrl.replace('http://', 'https://');
                                }

                                if (!attachments.length && locationUrl) {
                                    const fileName = locationUrl.split('/').pop() || 'Attachment';
                                    const attachmentItem = document.createElement('div');
                                    attachmentItem.className =
                                        'flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-700';

                                    attachmentItem.innerHTML = `
										<div class="flex items-center space-x-3">
											<div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
												<i class="bx bx-link text-white text-lg"></i>
											</div>
											<div>
												<h6 class="text-white font-medium">${fileName}</h6>
												<p class="text-gray-400 text-sm">External Attachment</p>
											</div>
										</div>
										<div class="flex items-center space-x-2">
											<a href="${locationUrl}" target="_blank"
											   class="text-blue-400 hover:text-blue-300 p-2 rounded-lg hover:bg-gray-700"
											   title="View ${fileName}">
												<i class="bx bx-show text-lg"></i>
											</a>
										</div>
									`;
                                    container.appendChild(attachmentItem);
                                }
                            } else {
                                container.innerHTML = '<p class="text-gray-400 text-sm">No attachments found</p>';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading attachments:', error);
                            container.innerHTML = '<p class="text-red-400 text-sm">Error loading attachments</p>';
                        });
                }

                // Function to format file size
                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }

                // WYSIWYG Functions
                function formatText(command, value = null) {
                    document.execCommand(command, false, value);
                    updateWysiwygToolbar();
                }

                function insertLink() {
                    const url = prompt('Enter URL:');
                    if (url) {
                        formatText('createLink', url);
                    }
                }

                function insertImage() {
                    const url = prompt('Enter image URL:');
                    if (url) {
                        formatText('insertImage', url);
                    }
                }

                function showColorPicker(type) {
                    const color = prompt('Enter color (e.g., #ff0000 or red):');
                    if (color) {
                        formatText(type, color);
                    }
                }

                function updateWysiwygToolbar() {
                    // Update toolbar button states based on current selection
                    const toolbarButtons = document.querySelectorAll('.wysiwyg-btn');
                    toolbarButtons.forEach(button => {
                        const command = button.getAttribute('onclick');
                        if (command && command.includes('formatText')) {
                            const cmd = command.match(/formatText\('([^']+)'\)/);
                            if (cmd) {
                                const isActive = document.queryCommandState(cmd[1]);
                                button.classList.toggle('active', isActive);
                            }
                        }
                    });
                }

                // Auto-save draft functionality (optional)
                if (emailFormMain) {
                    let draftTimeout;
                    const formInputs = emailFormMain.querySelectorAll('input, textarea');
                    formInputs.forEach(input => {
                        input.addEventListener('input', function() {
                            clearTimeout(draftTimeout);
                            draftTimeout = setTimeout(() => {
                                // Auto-save draft logic here
                                console.log('Auto-saving draft...');
                            }, 2000);
                        });
                    });
                }

                // AJAX Pagination System - Global Functions
                window.currentPage = @json($emails->currentPage());
                window.totalPages = @json($emails->lastPage());
                window.totalEmails = @json($emails->total());
                window.emailsPerPage = @json($emails->perPage());
                window.isLoading = false;

                // Function to load specific page
                function loadPage(page) {
                    // Validate page number
                    if (page < 1 || page > window.totalPages) {
                        console.warn('Invalid page number:', page, 'Total pages:', window.totalPages);
                        return;
                    }

                    // Prevent duplicate requests
                    if (page === window.currentPage || window.isLoading) {
                        console.log('Skipping page load - already on page or loading:', page, 'Current:', window
                            .currentPage, 'Loading:', window.isLoading);
                        return;
                    }

                    console.log('Loading page:', page, 'from current page:', window.currentPage);
                    const url = `{{ route('email.index') }}?page=${page}`;
                    window.loadEmailsPage(url, page);
                }

                // Function to load previous page
                function loadPreviousPage() {
                    if (window.currentPage > 1 && !window.isLoading) {
                        loadPage(window.currentPage - 1);
                    }
                }

                // Function to load next page
                function loadNextPage() {
                    if (window.currentPage < window.totalPages && !window.isLoading) {
                        loadPage(window.currentPage + 1);
                    }
                }

                // Function to load emails page via AJAX
                function loadEmailsPage(url, targetPage = null) {
                    if (window.isLoading) {
                        console.log('Already loading, skipping request');
                        return;
                    }

                    window.isLoading = true;

                    // Get containers
                    const emailListContainer = document.getElementById('email-list-container');
                    const paginationContainer = document.getElementById('pagination-container');

                    if (!emailListContainer) {
                        console.error('Email list container not found');
                        window.isLoading = false;
                        return;
                    }

                    // Store original content for error recovery
                    const originalContent = emailListContainer.innerHTML;
                    const originalPagination = paginationContainer ? paginationContainer.innerHTML : '';

                    // Show loading state
                    emailListContainer.innerHTML = `
						<div class="flex items-center justify-center h-32">
							<div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
							<span class="ml-2 text-gray-400">Loading page ${targetPage || window.currentPage + 1}...</span>
						</div>
					`;

                    // Show loading state in pagination
                    if (paginationContainer) {
                        const paginationControls = paginationContainer.querySelector('#pagination-controls');
                        if (paginationControls) {
                            paginationControls.innerHTML = `
								<div class="flex items-center space-x-2">
									<div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
									<span class="text-sm text-gray-400">Loading...</span>
								</div>
							`;
                        }
                    }

                    // Disable pagination buttons
                    disablePaginationButtons(true);

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                        'content') ||
                                    document.querySelector('input[name="_token"]')?.value || ''
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.text();
                        })
                        .then(html => {
                            // Create a temporary div to parse the response
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = html;

                            // Extract email list and pagination
                            const newEmailList = tempDiv.querySelector('#email-list-container');
                            const newPagination = tempDiv.querySelector('#pagination-container');

                            // Update email list
                            if (newEmailList) {
                                emailListContainer.innerHTML = newEmailList.innerHTML;
                            }

                            // Update pagination
                            if (newPagination && paginationContainer) {
                                paginationContainer.innerHTML = newPagination.innerHTML;
                            }

                            // Update current page
                            if (targetPage) {
                                window.currentPage = targetPage;
                            }

                            // Ensure functions are available globally
                            window.loadPage = loadPage;
                            window.loadPreviousPage = loadPreviousPage;
                            window.loadNextPage = loadNextPage;
                            window.loadEmailsPage = loadEmailsPage;

                            // Re-attach event listeners
                            attachEmailItemListeners();
                            attachPaginationListeners();

                            // Reset profile when switching pages
                            resetProfile();

                            // Update pagination UI
                            updatePaginationUI();
                        })
                        .catch(error => {
                            console.error('Error loading emails:', error);

                            // Restore original content on error
                            emailListContainer.innerHTML = originalContent;
                            if (paginationContainer) {
                                paginationContainer.innerHTML = originalPagination;
                            }

                            // Ensure functions are available globally
                            window.loadPage = loadPage;
                            window.loadPreviousPage = loadPreviousPage;
                            window.loadNextPage = loadNextPage;
                            window.loadEmailsPage = loadEmailsPage;

                            // Re-attach listeners after error
                            attachEmailItemListeners();
                            attachPaginationListeners();

                            // Show error notification
                            showNotification('Error loading emails. Please try again.', 'error');
                        })
                        .finally(() => {
                            window.isLoading = false;
                            disablePaginationButtons(false);
                        });
                }

                // Make functions globally available
                window.loadPage = loadPage;
                window.loadPreviousPage = loadPreviousPage;
                window.loadNextPage = loadNextPage;
                window.loadEmailsPage = loadEmailsPage;

                // Function to disable/enable pagination buttons
                function disablePaginationButtons(disable) {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    const prevBtn = document.getElementById('prev-btn');
                    const nextBtn = document.getElementById('next-btn');
                    const pageButtons = document.querySelectorAll('[onclick^="loadPage"]');

                    if (prevBtn) {
                        prevBtn.disabled = disable || window.currentPage <= 1;
                        prevBtn.classList.toggle('opacity-50', disable || window.currentPage <= 1);
                        prevBtn.classList.toggle('cursor-not-allowed', disable || window.currentPage <= 1);
                    }

                    if (nextBtn) {
                        nextBtn.disabled = disable || window.currentPage >= window.totalPages;
                        nextBtn.classList.toggle('opacity-50', disable || window.currentPage >= window.totalPages);
                        nextBtn.classList.toggle('cursor-not-allowed', disable || window.currentPage >= window
                            .totalPages);
                    }

                    pageButtons.forEach(btn => {
                        btn.disabled = disable;
                        btn.classList.toggle('opacity-50', disable);
                        btn.classList.toggle('cursor-not-allowed', disable);
                    });
                }

                // Function to update pagination UI
                function updatePaginationUI() {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    const prevBtn = document.getElementById('prev-btn');
                    const nextBtn = document.getElementById('next-btn');
                    const pageButtons = document.querySelectorAll('[onclick^="loadPage"]');

                    // Update previous button
                    if (prevBtn) {
                        const isDisabled = window.currentPage <= 1;
                        prevBtn.disabled = isDisabled;
                        prevBtn.classList.toggle('opacity-50', isDisabled);
                        prevBtn.classList.toggle('cursor-not-allowed', isDisabled);
                    }

                    // Update next button
                    if (nextBtn) {
                        const isDisabled = window.currentPage >= window.totalPages;
                        nextBtn.disabled = isDisabled;
                        nextBtn.classList.toggle('opacity-50', isDisabled);
                        nextBtn.classList.toggle('cursor-not-allowed', isDisabled);
                    }

                    // Update page number buttons
                    pageButtons.forEach(btn => {
                        const pageNumber = parseInt(btn.getAttribute('data-page') || btn.getAttribute('onclick')
                            .match(/loadPage\((\d+)\)/)?.[1]);
                        if (pageNumber) {
                            const isCurrentPage = pageNumber === window.currentPage;
                            btn.classList.toggle('bg-blue-600', isCurrentPage);
                            btn.classList.toggle('text-white', isCurrentPage);
                            btn.classList.toggle('hover:bg-gray-700', !isCurrentPage);
                            btn.classList.toggle('text-gray-400', !isCurrentPage);
                        }
                    });

                    // Update pagination info
                    updatePaginationInfo();
                }

                // Function to update pagination info
                function updatePaginationInfo() {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    const paginationInfo = document.querySelector('.pagination-info');
                    if (paginationInfo && window.currentPage && window.totalPages) {
                        // Calculate items per page (assuming 10 items per page)
                        const itemsPerPage = 10;
                        const startItem = (window.currentPage - 1) * itemsPerPage + 1;
                        const endItem = Math.min(window.currentPage * itemsPerPage, window.totalPages * itemsPerPage);
                        const totalItems = window.totalPages * itemsPerPage;

                        paginationInfo.textContent = `${startItem}-${endItem} of ${totalItems}`;
                    }
                }

                // Function to attach pagination event listeners
                function attachPaginationListeners() {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    // Remove existing listeners to prevent duplicates
                    const prevBtn = document.getElementById('prev-btn');
                    const nextBtn = document.getElementById('next-btn');
                    const pageButtons = document.querySelectorAll('[onclick^="loadPage"]');

                    // Previous button
                    if (prevBtn) {
                        prevBtn.onclick = (e) => {
                            e.preventDefault();
                            window.loadPreviousPage();
                        };
                    }

                    // Next button
                    if (nextBtn) {
                        nextBtn.onclick = (e) => {
                            e.preventDefault();
                            window.loadNextPage();
                        };
                    }

                    // Page number buttons
                    pageButtons.forEach(btn => {
                        const pageNumber = btn.getAttribute('onclick').match(/loadPage\((\d+)\)/)?.[1];
                        if (pageNumber) {
                            btn.onclick = (e) => {
                                e.preventDefault();
                                window.loadPage(parseInt(pageNumber));
                            };
                        }
                    });
                }

                // Function to reset profile when switching pages
                function resetProfile() {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    // Clear email detail view
                    const emailDetailView = document.getElementById('email-detail-view');
                    if (emailDetailView) {
                        emailDetailView.classList.add('hidden');
                    }

                    // Show email list view
                    const emailListView = document.getElementById('email-list-view');
                    if (emailListView) {
                        emailListView.classList.remove('hidden');
                    }

                    // Clear any selected email
                    document.querySelectorAll('.email-item').forEach(item => {
                        item.classList.remove('bg-blue-900', 'border-blue-500');
                        item.classList.add('bg-gray-800', 'border-gray-700');
                    });

                    // Reset current email ID
                    window.currentEmailId = null;
                }

                // Function to attach event listeners to email items
                function attachEmailItemListeners() {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    const emailItems = document.querySelectorAll('.email-item');
                    emailItems.forEach(item => {
                        // Skip if onclick already exists (from inline onclick)
                        if (item.getAttribute('onclick')) {
                            return;
                        }

                        item.addEventListener('click', function(e) {
                            // Don't open if clicking on checkboxes, buttons, links, or badges
                            if (e.target.matches('input[type="checkbox"]') ||
                                e.target.closest('button') ||
                                e.target.closest('a') ||
                                e.target.closest('.hover\\:bg-gray-600') ||
                                e.target.closest('span[class*="bg-"]')) {
                                e.preventDefault();
                                e.stopPropagation();
                                return;
                            }

                            // Get email data
                            const emailId = this.dataset.emailId;
                            const subject = this.dataset.emailSubject;
                            const sender = this.dataset.emailFrom;
                            const to = this.dataset.emailTo;
                            const cc = this.dataset.emailCc;
                            const bcc = this.dataset.emailBcc;
                            const date = this.dataset.emailDate;
                            const bodyHtml = this.dataset.emailBodyHtml;
                            const bodyText = this.dataset.emailBodyText;
                            const attachmentsCount = this.dataset.emailAttachments;

                            // Store current email ID for reply/forward actions
                            window.currentEmailId = emailId;

                            // Mark email as read and update updated_at
                            const emailStatus = this.dataset.emailStatus;
                            if (emailStatus === 'unread') {
                                markEmailAsRead(emailId);
                            }
                            // Always update updated_at when email is opened
                            updateEmailUpdatedAt(emailId);

                            // Populate detail view
                            document.getElementById('detail-subject').textContent = subject;
                            document.getElementById('detail-sender').textContent = sender;
                            document.getElementById('detail-to').textContent = to || 'me';
                            document.getElementById('detail-date').textContent = date;

                            // Show/hide CC and BCC
                            const ccContainer = document.getElementById('detail-cc-container');
                            const bccContainer = document.getElementById('detail-bcc-container');

                            if (cc) {
                                document.getElementById('detail-cc').textContent = cc;
                                ccContainer.classList.remove('hidden');
                            } else {
                                ccContainer.classList.add('hidden');
                            }

                            if (bcc) {
                                document.getElementById('detail-bcc').textContent = bcc;
                                bccContainer.classList.remove('hidden');
                            } else {
                                bccContainer.classList.add('hidden');
                            }

                            // Set avatar
                            const avatar = document.getElementById('detail-sender-avatar');
                            avatar.textContent = sender.charAt(0).toUpperCase();

                            // Set email body
                            const emailBody = document.getElementById('detail-body');
                            if (bodyHtml) {
                                // Use HTML content for proper rendering
                                emailBody.innerHTML = bodyHtml;
                            } else if (bodyText) {
                                // Use text content if HTML is not available
                                emailBody.innerHTML = bodyText;
                            } else {
                                emailBody.innerHTML = 'No content available';
                            }

                            let locationAttachment = this.dataset.emailLocationAttachment || '';
                            const locationDate = date || '';

                            // Transform URL: convert http to https
                            if (locationAttachment && locationAttachment.startsWith('http://')) {
                                locationAttachment = locationAttachment.replace('http://', 'https://');
                            }

                            const locationContainer = document.getElementById(
                                'detail-location-attachment');
                            if (locationContainer) {
                                if (locationAttachment) {
                                    locationContainer.innerHTML = `
										<div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-700">
											<div class="flex items-center space-x-3">
												<div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
													<i class="bx bx-link text-white text-lg"></i>
												</div>
												<div>
													<h6 class="text-white font-medium">${locationDate || 'Attachment'}</h6>
													<p class="text-gray-400 text-sm">LocationAttachment</p>
												</div>
											</div>
											<div class="flex items-center space-x-2">
												<a href="/email/attachment/${locationAttachment}/download" target="_blank"
												   class="text-blue-400 hover:text-blue-300 p-2 rounded-lg hover:bg-gray-700"
												   title="Download Attachment">
													<i class="bx bx-download text-lg"></i>
												</a>
											</div>
										</div>
									`;
                                } else {
                                    locationContainer.innerHTML = '';
                                }
                            }

                            // Handle attachments
                            const attachmentsSection = document.getElementById('detail-attachments');
                            const attachmentsList = document.getElementById('detail-attachments-list');

                            if ((attachmentsCount && parseInt(attachmentsCount) > 0) ||
                                locationAttachment) {
                                // Show attachments section
                                attachmentsSection.classList.remove('hidden');

                                // Load attachments via AJAX
                                loadEmailAttachments(emailId, attachmentsList);
                            } else {
                                // Hide attachments section
                                attachmentsSection.classList.add('hidden');
                                attachmentsList.innerHTML = '';
                            }

                            // Load profile for the sender
                            if (sender) {
                                // Extract email from "Name <email@domain.com>" format
                                let email = sender;
                                if (sender.includes('<') && sender.includes('>')) {
                                    const match = sender.match(/<(.+?)>/);
                                    if (match) {
                                        email = match[1];
                                    }
                                }

                                // Switch to profile tab and load profile
                                showTab('profile');

                                // Auto get profile and find customer
                                getEmailProfileAndFindCustomer(email);
                            }

                            // Load replies and forwards
                            loadRepliesAndForwards(emailId);


                            // Switch views
                            emailListView.classList.add('hidden');
                            emailDetailView.classList.remove('hidden');

                            // Show side card when email is opened
                            const sideCard = document.getElementById('side-card');
                            if (sideCard) {
                                sideCard.classList.remove('hidden');
                            }
                        });
                    });
                }

                // Function to load replies and forwards
                function loadRepliesAndForwards(emailId) {
                    // Ensure functions are available globally
                    if (typeof loadPage === 'function') {
                        window.loadPage = loadPage;
                        window.loadPreviousPage = loadPreviousPage;
                        window.loadNextPage = loadNextPage;
                        window.loadEmailsPage = loadEmailsPage;
                    }

                    fetch(`/email/${emailId}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            // Check if response is JSON
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            } else {
                                // If not JSON, it might be an error page
                                throw new Error('Response is not JSON. Status: ' + response.status +
                                    ', Content-Type: ' + contentType);
                            }
                        })
                        .then(data => {
                            if (data.success) {
                                displayReplies(data.replies || []);
                                displayForwards(data.forwards || []);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading replies and forwards:', error);
                            // Don't show error to user, just log it
                        });
                }
                window.loadRepliesAndForwards = loadRepliesAndForwards;

                // Function to display replies
                function displayReplies(replies) {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    const repliesList = document.getElementById('replies-list');
                    const repliesContainer = document.getElementById('replies-container');

                    if (!repliesList || !repliesContainer) {
                        console.error('Replies elements not found');
                        return;
                    }

                    if (replies.length === 0) {
                        repliesContainer.classList.add('hidden');
                    } else {
                        repliesContainer.classList.remove('hidden');
                        repliesList.innerHTML = '';

                        replies.forEach(reply => {
                            const replyElement = createReplyForwardElement(reply, 'reply');
                            repliesList.appendChild(replyElement);
                        });
                        attachReplyCollapseListeners(repliesList);
                    }

                    // Show/hide the entire section based on whether there are any replies or forwards
                    updateRepliesForwardsSection();
                }

                // Function to display forwards
                function displayForwards(forwards) {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    const forwardsList = document.getElementById('forwards-list');
                    const forwardsContainer = document.getElementById('forwards-container');

                    if (!forwardsList || !forwardsContainer) {
                        console.error('Forwards elements not found');
                        return;
                    }

                    if (forwards.length === 0) {
                        forwardsContainer.classList.add('hidden');
                    } else {
                        forwardsContainer.classList.remove('hidden');
                        forwardsList.innerHTML = '';

                        forwards.forEach(forward => {
                            const forwardElement = createReplyForwardElement(forward, 'forward');
                            forwardsList.appendChild(forwardElement);
                        });
                        attachReplyCollapseListeners(forwardsList);
                    }

                    // Show/hide the entire section based on whether there are any replies or forwards
                    updateRepliesForwardsSection();
                }

                // Function to update replies/forwards section visibility
                function updateRepliesForwardsSection() {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    const repliesContainer = document.getElementById('replies-container');
                    const forwardsContainer = document.getElementById('forwards-container');
                    const repliesForwardsSection = document.getElementById('replies-forwards-section');

                    if (!repliesContainer || !forwardsContainer || !repliesForwardsSection) {
                        console.error('Replies/forwards section elements not found');
                        return;
                    }

                    const hasReplies = !repliesContainer.classList.contains('hidden');
                    const hasForwards = !forwardsContainer.classList.contains('hidden');

                    if (hasReplies || hasForwards) {
                        repliesForwardsSection.classList.remove('hidden');
                    } else {
                        repliesForwardsSection.classList.add('hidden');
                    }
                }

                // Function to create reply/forward element
                function createReplyForwardElement(item, type) {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    const element = document.createElement('div');
                    element.className = 'bg-gray-800 p-2 rounded';

                    const icon = type === 'reply' ? 'bx-reply' : 'bx-share';
                    const typeText = type === 'reply' ? 'Reply' : 'Forward';
                    const agentName = item.agent ? item.agent.name : 'Unknown Agent';
                    const agentEmail = item.agent ? item.agent.email : '';
                    const date = new Date(item.email_sent_date).toLocaleString();
                    const attachments = Array.isArray(item.attachments) ? item.attachments : [];

                    element.innerHTML = `
						<div class="flex items-start justify-between mb-3">
							<div class="flex items-center space-x-3">
								<div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
									<i class="bx ${icon}"></i>
								</div>
								<div>
									<div class="text-white font-medium">${typeText} by ${agentName}</div>
									<div class="text-sm text-gray-400">${agentEmail}</div>
								</div>
							</div>
							<div class="flex items-center space-x-2 text-sm text-gray-400">
								<span>${date}</span>
								<button type="button"
									class="reply-toggle text-gray-300 hover:text-white p-1 rounded hover:bg-gray-700"
									aria-expanded="false"
									title="Toggle">
									<i class="bx bx-chevron-down text-lg transition-transform"></i>
								</button>
							</div>
						</div>
						<div class="reply-content hidden">
							<div class="mb-3">
								<div class="text-sm text-gray-300 mb-1">
									<strong>To:</strong> ${item.email_to}
								</div>
								${item.email_cc ? `<div class="text-sm text-gray-300 mb-1"><strong>CC:</strong> ${item.email_cc}</div>` : ''}
								${item.email_bcc ? `<div class="text-sm text-gray-300 mb-1"><strong>BCC:</strong> ${item.email_bcc}</div>` : ''}
							</div>
							<div class="text-sm text-gray-300">
								<strong>Subject:</strong> ${item.email_subject}
							</div>
							<div class="mt-3 p-3 bg-gray-800 rounded border-l-4 border-blue-500">
								<div class="text-gray-300 text-sm">
									<pre class="whitespace-pre-wrap font-mono text-sm">${item.email_body_text || (item.email_body_html ? item.email_body_html.replace(/<[^>]*>/g, '') : 'No content available')}</pre>
								</div>
							</div>
							${attachments.length ? `
                                                                                								<div class="mt-4">
                                                                                									<div class="text-sm text-gray-300 mb-2"><strong>Attachments:</strong></div>
                                                                                									<div class="space-y-2">
                                                                                										${attachments.map(att => `
											<div class="flex items-center justify-between p-2 bg-gray-900 rounded border border-gray-700">
												<div class="flex items-center space-x-2">
													<i class="bx bx-paperclip text-gray-400"></i>
													<span class="text-sm text-gray-200">${att.filename || 'Attachment'}</span>
												</div>
												<div class="flex items-center space-x-2">
													<a href="${getAttachmentUrl(att)}" target="_blank" class="text-blue-400 hover:text-blue-300 text-xs">View</a>
												</div>
											</div>
										`).join('')}
                                                                                									</div>
                                                                                								</div>
                                                                                							` : ''}
						</div>
					`;

                    return element;
                }

                function attachReplyCollapseListeners(container) {
                    if (!container) return;
                    container.querySelectorAll('.reply-toggle').forEach(toggle => {
                        toggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            const wrapper = this.closest('.bg-gray-800');
                            if (!wrapper) return;
                            const content = wrapper.querySelector('.reply-content');
                            if (!content) return;
                            const isHidden = content.classList.contains('hidden');
                            content.classList.toggle('hidden', !isHidden);
                            this.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                            const icon = this.querySelector('i');
                            if (icon) {
                                icon.classList.toggle('rotate-180', isHidden);
                            }
                        });
                    });
                }

                // Function to attach reply/forward button listeners
                function attachReplyForwardListeners() {
                    // Ensure functions are available globally
                    window.loadPage = loadPage;
                    window.loadPreviousPage = loadPreviousPage;
                    window.loadNextPage = loadNextPage;
                    window.loadEmailsPage = loadEmailsPage;

                    // Reply button
                    const replyBtn = document.getElementById('reply-btn');
                    if (replyBtn) {
                        replyBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            if (window.currentEmailId) {
                                openReplyModal();
                            } else {
                                showNotification('Tidak ada email yang dipilih', 'error');
                            }
                        });
                    }

                    // Reply All button
                    const replyAllBtn = document.getElementById('reply-all-btn');
                    if (replyAllBtn) {
                        replyAllBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            if (window.currentEmailId) {
                                // For now, same as reply - can be enhanced later
                                openReplyModal();
                            } else {
                                showNotification('Tidak ada email yang dipilih', 'error');
                            }
                        });
                    }

                    // Forward button
                    const forwardBtn = document.getElementById('forward-btn');
                    if (forwardBtn) {
                        forwardBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            if (window.currentEmailId) {
                                openForwardModal();
                            } else {
                                showNotification('Tidak ada email yang dipilih', 'error');
                            }
                        });
                    }


                    // Modal close buttons
                    const closeReplyModal = document.getElementById('close-reply-modal');
                    const closeForwardModal = document.getElementById('close-forward-modal');
                    const cancelReply = document.getElementById('cancel-reply');
                    const cancelForward = document.getElementById('cancel-forward');

                    if (closeReplyModal) {
                        closeReplyModal.addEventListener('click', closeReplyModalHandler);
                    }
                    if (closeForwardModal) {
                        closeForwardModal.addEventListener('click', closeForwardModalHandler);
                    }
                    if (cancelReply) {
                        cancelReply.addEventListener('click', closeReplyModalHandler);
                    }
                    if (cancelForward) {
                        cancelForward.addEventListener('click', closeForwardModalHandler);
                    }

                    // Send buttons
                    const sendReply = document.getElementById('send-reply');
                    const sendForward = document.getElementById('send-forward');

                    if (sendReply) {
                        sendReply.addEventListener('click', handleReplySubmit);
                    }
                    if (sendForward) {
                        sendForward.addEventListener('click', handleForwardSubmit);
                    }

                    // Save draft buttons
                    const saveReplyDraft = document.getElementById('save-reply-draft');
                    const saveForwardDraft = document.getElementById('save-forward-draft');

                    if (saveReplyDraft) {
                        saveReplyDraft.addEventListener('click', saveReplyDraftHandler);
                    }
                    if (saveForwardDraft) {
                        saveForwardDraft.addEventListener('click', saveForwardDraftHandler);
                    }

                    // Forward email input handlers
                    ['to', 'cc', 'bcc'].forEach(type => {
                        const input = document.getElementById(`forward-${type}-input`);
                        if (input) {
                            input.addEventListener('keydown', function(e) {
                                if (e.key === 'Enter' || e.key === ',' || e.key === ';') {
                                    e.preventDefault();
                                    const email = this.value.trim();
                                    if (email && addForwardEmailTag(email, type)) {
                                        this.value = '';
                                    }
                                }
                            });

                            input.addEventListener('blur', function() {
                                const email = this.value.trim();
                                if (email && addForwardEmailTag(email, type)) {
                                    this.value = '';
                                }
                            });
                        }
                    });
                }



                // Function to attach email search (live, no refresh)
                function attachEmailSearchListener() {
                    const form = document.getElementById('email-search-form');
                    const input = document.getElementById('email-search-input');
                    if (!input) return;

                    // Prevent default submit (avoid full refresh)
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            performEmailSearch(input.value);
                        });
                    }

                    let searchDebounce;
                    input.addEventListener('input', function() {
                        clearTimeout(searchDebounce);
                        const q = this.value || '';
                        searchDebounce = setTimeout(() => performEmailSearch(q), 400);
                    });
                }

                // Execute AJAX search and update list
                function performEmailSearch(query) {
                    // Build URL preserving status filter and page = 1
                    const params = new URLSearchParams(window.location.search);
                    if (query) {
                        params.set('q', query);
                    } else {
                        params.delete('q');
                    }
                    params.set('page', '1');

                    const baseUrl = window.location.pathname;
                    const url = `${baseUrl}?${params.toString()}`;
                    // Use existing pagination loader to replace list via AJAX
                    window.loadEmailsPage(url, 1);
                }


                // Function to open reply modal
                function openReplyModal() {
                    if (!window.currentEmailId) {
                        showNotification('Tidak ada email yang dipilih', 'error');
                        return;
                    }

                    // Get current email data
                    const emailItem = document.querySelector(`[data-email-id="${window.currentEmailId}"]`);
                    if (!emailItem) {
                        showNotification('Data email tidak ditemukan', 'error');
                        return;
                    }

                    // Populate modal with email data
                    const subject = emailItem.dataset.emailSubject;
                    const sender = emailItem.dataset.emailFrom;
                    const date = emailItem.dataset.emailDate;
                    const bodyHtml = emailItem.dataset.emailBodyHtml;
                    const bodyText = emailItem.dataset.emailBodyText;

                    // Set original email info
                    document.getElementById('original-subject').textContent = subject || '(No Subject)';
                    document.getElementById('original-from').textContent = sender || 'Unknown Sender';
                    document.getElementById('original-date').textContent = date || '';

                    // Set original body
                    const originalBody = document.getElementById('original-body');
                    if (bodyText) {
                        // Use text content to avoid HTML rendering
                        originalBody.innerHTML = '<pre class="whitespace-pre-wrap text-gray-300 font-mono text-sm">' +
                            bodyText + '</pre>';
                    } else if (bodyHtml) {
                        // Strip HTML tags and show as plain text
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = bodyHtml;
                        const plainText = tempDiv.textContent || tempDiv.innerText || '';
                        originalBody.innerHTML = '<pre class="whitespace-pre-wrap text-gray-300 font-mono text-sm">' +
                            plainText + '</pre>';
                    } else {
                        originalBody.innerHTML =
                            '<pre class="whitespace-pre-wrap text-gray-300 font-mono text-sm">No content available</pre>';
                    }

                    // Set reply form data
                    const replyTargetId = (window.currentEmailStatus === 'draft' && window.currentEmailRefId) ?
                        window.currentEmailRefId :
                        window.currentEmailId;
                    document.getElementById('reply-email-id').value = replyTargetId;

                    // Extract email address from "Name <email@domain.com>" format
                    let emailAddress = sender || '';
                    if (sender && sender.includes('<') && sender.includes('>')) {
                        const match = sender.match(/<(.+?)>/);
                        if (match) {
                            emailAddress = match[1];
                        }
                    }

                    document.getElementById('reply-to').value = emailAddress;
                    document.getElementById('reply-subject').value = 'Re: ' + (subject || '(No Subject)');
                    document.getElementById('reply-body-editor').innerHTML = '';
                    document.getElementById('reply-draft-id').value = '';
                    const replyTemplate = document.getElementById('reply-template');
                    if (replyTemplate) replyTemplate.value = '';

                    // Show modal
                    document.getElementById('reply-modal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';

                    // Initialize reply modal functionality
                    initializeReplyModal();

                    const draftQuery = (window.currentEmailStatus === 'draft') ?
                        `draft_id=${window.currentEmailId}` :
                        `ref_id=${window.currentEmailId}`;
                    fetch(`/email/draft?${draftQuery}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.draft) {
                                document.getElementById('reply-draft-id').value = data.draft.id;
                                if (data.draft.email_subject) {
                                    document.getElementById('reply-subject').value = data.draft.email_subject;
                                }
                                if (data.draft.email_body_html) {
                                    document.getElementById('reply-body-editor').innerHTML = data.draft
                                        .email_body_html;
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error loading draft:', error);
                        });
                }

                // Function to initialize reply modal functionality
                function initializeReplyModal() {
                    // Initialize WYSIWYG editor for reply
                    initializeReplyWysiwygEditor();

                    // Initialize file attachment for reply
                    initializeReplyFileAttachment();
                }

                function initializeTemplateSelectors() {
                    applyTemplateSelection('reply-template', 'reply-subject', 'reply-body-editor', 'reply-body');
                    applyTemplateSelection('forward-template', 'forward-subject', 'forward-body-editor',
                        'forward-body');
                }

                function applyTemplateSelection(selectId, subjectId, editorId, hiddenId) {
                    const templateSelect = document.getElementById(selectId);
                    if (!templateSelect) return;

                    templateSelect.addEventListener('change', function() {
                        const selected = this.options[this.selectedIndex];
                        if (!selected) return;

                        const subject = selected.dataset.subject || '';
                        const bodyHtml = decodeTemplateHtml(selected.dataset.bodyHtml || '');

                        const subjectInput = document.getElementById(subjectId);
                        if (subjectInput) {
                            subjectInput.value = subject ? subject : '';
                        }

                        const editor = document.getElementById(editorId);
                        const hidden = document.getElementById(hiddenId);
                        if (editor) {
                            editor.innerHTML = bodyHtml ? bodyHtml : '';
                        }
                        if (hidden) {
                            hidden.value = bodyHtml ? bodyHtml : '';
                        }
                    });
                }

                function decodeTemplateHtml(encoded) {
                    const textarea = document.createElement('textarea');
                    textarea.innerHTML = encoded;
                    return textarea.value;
                }

                // Function to initialize WYSIWYG editor for reply
                function initializeReplyWysiwygEditor() {
                    const replyEditor = document.getElementById('reply-body-editor');
                    if (replyEditor) {
                        replyEditor.addEventListener('input', function() {
                            document.getElementById('reply-body').value = this.innerHTML;
                        });
                    }
                }

                // Function to initialize file attachment for reply
                function initializeReplyFileAttachment() {
                    const attachBtn = document.getElementById('reply-attach-btn');
                    const fileInput = document.getElementById('reply-file-input');

                    if (attachBtn && fileInput) {
                        attachBtn.addEventListener('click', function() {
                            fileInput.click();
                        });

                        fileInput.addEventListener('change', function(e) {
                            handleReplyFileAttachments(e.target.files);
                        });
                    }
                }

                // Function to handle reply file attachments
                function handleReplyFileAttachments(files) {
                    Array.from(files).forEach(file => {
                        // Check file size (max 10MB)
                        if (file.size > 10 * 1024 * 1024) {
                            showNotification('File terlalu besar. Maksimal 10MB.', 'error');
                            return;
                        }

                        replyAttachments.push(file);

                        // Show attachment in UI
                        showReplyAttachment(file);
                    });

                    const fileInput = document.getElementById('reply-file-input');
                    if (fileInput) {
                        fileInput.value = '';
                    }

                    // Show attachments container
                    const container = document.getElementById('reply-attachments-container');
                    if (container) {
                        container.classList.remove('hidden');
                    }
                }

                // Function to show reply attachment in UI
                function showReplyAttachment(file) {
                    const attachmentsList = document.getElementById('reply-attachments-list');
                    if (!attachmentsList) return;

                    const attachmentItem = document.createElement('div');
                    attachmentItem.className = 'attachment-item';
                    attachmentItem.setAttribute('data-filename', file.name);

                    // Get file icon based on type
                    const fileIcon = getFileIcon(file.type);

                    attachmentItem.innerHTML = `
						<div class="attachment-info">
							<div class="attachment-icon">
								<i class="${fileIcon}"></i>
							</div>
							<div class="attachment-details">
								<h6>${file.name}</h6>
								<p>${formatFileSize(file.size)}</p>
							</div>
						</div>
						<button type="button" class="attachment-remove">
							<i class="bx bx-x"></i>
						</button>
					`;

                    const removeButton = attachmentItem.querySelector('.attachment-remove');
                    if (removeButton) {
                        removeButton.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            removeReplyAttachment(file.name);
                        });
                    }

                    attachmentsList.appendChild(attachmentItem);
                }

                // Function to remove reply attachment
                function removeReplyAttachment(fileName) {
                    replyAttachments = replyAttachments.filter(file => file.name !== fileName);

                    // Remove from UI
                    const attachmentItems = document.querySelectorAll('#reply-attachments-list .attachment-item');
                    attachmentItems.forEach(item => {
                        if (item.getAttribute('data-filename') === fileName) {
                            item.remove();
                        }
                    });

                    // Hide attachments container if no attachments
                    const container = document.getElementById('reply-attachments-container');
                    const attachmentsList = document.getElementById('reply-attachments-list');
                    if (container && attachmentsList && attachmentsList.children.length === 0) {
                        container.classList.add('hidden');
                    }
                }

                // Function to open forward modal
                function openForwardModal() {
                    if (!window.currentEmailId) {
                        showNotification('Tidak ada email yang dipilih', 'error');
                        return;
                    }

                    // Get current email data
                    const emailItem = document.querySelector(`[data-email-id="${window.currentEmailId}"]`);
                    if (!emailItem) {
                        showNotification('Data email tidak ditemukan', 'error');
                        return;
                    }

                    // Populate modal with email data
                    const subject = emailItem.dataset.emailSubject;
                    const sender = emailItem.dataset.emailFrom;
                    const to = emailItem.dataset.emailTo;
                    const date = emailItem.dataset.emailDate;
                    const bodyHtml = emailItem.dataset.emailBodyHtml;
                    const bodyText = emailItem.dataset.emailBodyText;

                    // Set original email info
                    document.getElementById('forward-original-subject').textContent = subject || '(No Subject)';
                    document.getElementById('forward-original-from').textContent = sender || 'Unknown Sender';
                    document.getElementById('forward-original-to').textContent = to || 'N/A';
                    document.getElementById('forward-original-date').textContent = date || '';

                    // Set original body
                    const originalBody = document.getElementById('forward-original-body');
                    if (bodyText) {
                        // Use text content to avoid HTML rendering
                        originalBody.innerHTML = '<pre class="whitespace-pre-wrap text-gray-300 font-mono text-sm">' +
                            bodyText + '</pre>';
                    } else if (bodyHtml) {
                        // Strip HTML tags and show as plain text
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = bodyHtml;
                        const plainText = tempDiv.textContent || tempDiv.innerText || '';
                        originalBody.innerHTML = '<pre class="whitespace-pre-wrap text-gray-300 font-mono text-sm">' +
                            plainText + '</pre>';
                    } else {
                        originalBody.innerHTML =
                            '<pre class="whitespace-pre-wrap text-gray-300 font-mono text-sm">No content available</pre>';
                    }

                    // Set forward form data
                    document.getElementById('forward-email-id').value = window.currentEmailId;
                    document.getElementById('forward-subject').value = subject || '(No Subject)';
                    document.getElementById('forward-body-editor').innerHTML = '';
                    const forwardTemplate = document.getElementById('forward-template');
                    if (forwardTemplate) forwardTemplate.value = '';

                    // Clear email tags
                    clearForwardEmailTags();

                    // Show modal
                    document.getElementById('forward-modal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                // Function to close reply modal
                function closeReplyModalHandler() {
                    document.getElementById('reply-modal').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    replyAttachments = [];

                    const fileInput = document.getElementById('reply-file-input');
                    if (fileInput) {
                        fileInput.value = '';
                    }

                    const attachmentsList = document.getElementById('reply-attachments-list');
                    if (attachmentsList) {
                        attachmentsList.innerHTML = '';
                    }

                    const attachmentsContainer = document.getElementById('reply-attachments-container');
                    if (attachmentsContainer) {
                        attachmentsContainer.classList.add('hidden');
                    }
                }

                // Function to close forward modal
                function closeForwardModalHandler() {
                    document.getElementById('forward-modal').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                // Function to clear forward email tags
                function clearForwardEmailTags() {
                    ['to', 'cc', 'bcc'].forEach(type => {
                        const container = document.getElementById(`forward-${type}-tags`);
                        const tags = container.querySelectorAll('.forward-email-tag');
                        tags.forEach(tag => tag.remove());
                        document.getElementById(`forward-${type}-input`).value = '';
                        hideValidation(`forward${type.charAt(0).toUpperCase() + type.slice(1)}`);
                    });
                }

                // Function to save reply draft
                function saveReplyDraftHandler() {
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('input[name="_token"]').value);
                    formData.append('draft_id', document.getElementById('reply-draft-id').value);
                    const replyRefId = window.currentEmailStatus === 'draft' ?
                        (window.currentEmailRefId || '') :
                        (window.currentEmailId || '');
                    if (replyRefId) {
                        formData.append('ref_id', replyRefId);
                    }
                    formData.append('to', document.getElementById('reply-to').value);
                    formData.append('subject', document.getElementById('reply-subject').value.trim());
                    formData.append('body', document.getElementById('reply-body-editor').innerHTML.trim());

                    replyAttachments.forEach((file, index) => {
                        formData.append(`attachments[${index}]`, file);
                    });

                    fetch('/email/save-draft', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.draft_id) {
                                document.getElementById('reply-draft-id').value = data.draft_id;
                                showNotification('Draft berhasil disimpan!', 'success');
                            } else {
                                showNotification(data.message || 'Gagal menyimpan draft', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error saving draft:', error);
                            showNotification('Terjadi kesalahan saat menyimpan draft', 'error');
                        });
                }

                // Function to save forward draft
                function saveForwardDraftHandler() {
                    const draftData = {
                        to: getForwardEmailTags('to'),
                        cc: getForwardEmailTags('cc'),
                        bcc: getForwardEmailTags('bcc'),
                        subject: document.getElementById('forward-subject').value.trim(),
                        message: document.getElementById('forward-body-editor').innerHTML.trim(),
                        saved: new Date().toISOString()
                    };

                    localStorage.setItem('email_forward_draft', JSON.stringify(draftData));
                    showNotification('Draft berhasil disimpan!', 'success');
                }


                // Function to handle reply submit
                async function handleReplySubmit() {
                    const subject = document.getElementById('reply-subject').value.trim();
                    const body = document.getElementById('reply-body-editor').innerHTML.trim();

                    if (!subject) {
                        alert('Subjek email tidak boleh kosong');
                        return;
                    }

                    if (!body || body === '<br>') {
                        alert('Pesan email tidak boleh kosong');
                        return;
                    }

                    // Show loading
                    const sendBtn = document.getElementById('send-reply');
                    const originalText = sendBtn.innerHTML;
                    sendBtn.disabled = true;
                    sendBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin mr-2"></i>Sending...';

                    try {
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('input[name="_token"]').value);
                        formData.append('to', document.getElementById('reply-to').value);
                        formData.append('subject', subject);
                        formData.append('body', body);
                        const draftId = document.getElementById('reply-draft-id').value;
                        if (draftId) {
                            formData.append('draft_id', draftId);
                        }

                        // Add attachments
                        replyAttachments.forEach((file, index) => {
                            formData.append(`attachments[${index}]`, file);
                        });

                        const replyTargetId = (window.currentEmailStatus === 'draft' && window.currentEmailRefId) ?
                            window.currentEmailRefId :
                            window.currentEmailId;

                        if (!replyTargetId) {
                            showNotification('Email asal untuk reply tidak ditemukan', 'error');
                            sendBtn.disabled = false;
                            sendBtn.innerHTML = originalText;
                            return;
                        }

                        const response = await fetch(`/email/${replyTargetId}/reply`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            showNotification('Reply berhasil dikirim!', 'success');

                            // Update original email status to replied
                            if (window.currentEmailId) {
                                const emailItem = document.querySelector(
                                    `[data-email-id="${window.currentEmailId}"]`);
                                if (emailItem) {
                                    // Remove unread styling
                                    emailItem.classList.remove('bg-gray-900');

                                    // Update status indicator to replied (green)
                                    const statusIndicator = emailItem.querySelector('.w-2.h-2');
                                    if (statusIndicator) {
                                        statusIndicator.className =
                                            'w-2 h-2 bg-green-500 rounded-full flex-shrink-0';
                                        statusIndicator.title = 'Sudah di-reply';
                                    }

                                    // Update sender name font weight
                                    const senderName = emailItem.querySelector('.font-medium .text-white');
                                    if (senderName) {
                                        senderName.classList.remove('font-bold');
                                    }

                                    // Update data attribute
                                    emailItem.setAttribute('data-email-status', 'replied');
                                }

                                // Refresh replies and forwards
                                loadRepliesAndForwards(window.currentEmailId);
                            }

                            closeReplyModalHandler();
                        } else {
                            showNotification(result.message || 'Gagal mengirim reply', 'error');
                        }
                    } catch (error) {
                        console.error('Error sending reply:', error);
                        showNotification('Terjadi kesalahan saat mengirim reply', 'error');
                    } finally {
                        sendBtn.disabled = false;
                        sendBtn.innerHTML = originalText;
                    }
                }

                // Function to handle forward submit
                async function handleForwardSubmit() {
                    const toEmails = getForwardEmailTags('to');
                    const subject = document.getElementById('forward-subject').value.trim();
                    const body = document.getElementById('forward-body-editor').innerHTML.trim();

                    if (toEmails.length === 0) {
                        showValidation('forwardTo', 'Minimal harus ada satu penerima');
                        return;
                    }

                    if (!subject) {
                        alert('Subjek email tidak boleh kosong');
                        return;
                    }

                    if (!body || body === '<br>') {
                        alert('Pesan email tidak boleh kosong');
                        return;
                    }

                    // Show loading
                    const sendBtn = document.getElementById('send-forward');
                    const originalText = sendBtn.innerHTML;
                    sendBtn.disabled = true;
                    sendBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin mr-2"></i>Sending...';

                    try {
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('input[name="_token"]').value);
                        formData.append('to', toEmails.join(','));
                        formData.append('cc', getForwardEmailTags('cc').join(','));
                        formData.append('bcc', getForwardEmailTags('bcc').join(','));
                        formData.append('subject', subject);
                        formData.append('body', body);

                        const response = await fetch(`/email/${window.currentEmailId}/forward`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            showNotification('Forward berhasil dikirim!', 'success');
                            closeForwardModalHandler();
                            // Refresh replies and forwards
                            if (window.currentEmailId) {
                                loadRepliesAndForwards(window.currentEmailId);
                            }
                        } else {
                            showNotification(result.message || 'Gagal mengirim forward', 'error');
                        }
                    } catch (error) {
                        console.error('Error sending forward:', error);
                        showNotification('Terjadi kesalahan saat mengirim forward', 'error');
                    } finally {
                        sendBtn.disabled = false;
                        sendBtn.innerHTML = originalText;
                    }
                }




                // Function to reset profile
                function resetProfile() {
                    document.getElementById('profile-placeholder').classList.remove('hidden');
                    document.getElementById('profile-content').classList.add('hidden');
                    showTab('profile');
                }

                // Auto get profile and find customer function
                function getEmailProfileAndFindCustomer(email) {
                    if (!email) {
                        showNotification('Email tidak boleh kosong', 'error');
                        return;
                    }

                    // First get email profile
                    getEmailProfile(email);

                    // Then search customer
                    autoSearchCustomer(email);
                }

                // Auto search customer function
                function autoSearchCustomer(email) {
                    if (!email) {
                        showNotification('Email tidak boleh kosong', 'error');
                        return;
                    }

                    // Show loading notification
                    showNotification('Mencari customer...', 'info');

                    fetch('/email/search-customer', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                email: email
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show notification based on action
                                if (data.action === 'add_user') {
                                    showNotification('Customer tidak ditemukan di database.', 'warning');
                                } else if (data.action === 'existing_linked') {
                                    showNotification(
                                        'Customer ditemukan dan sudah terhubung dengan chat ticket user.',
                                        'success');
                                } else if (data.action === 'search_existing') {
                                    showNotification(
                                        'Customer ditemukan tapi belum terhubung dengan chat ticket user.',
                                        'info');
                                }

                                // Don't auto show modal, just show notification
                                // handleCustomerSearchResult(data);
                            } else {
                                showNotification(data.message || 'Error searching customer', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error searching customer:', error);
                            showNotification('Terjadi kesalahan saat mencari customer', 'error');
                        });
                }

                function handleCustomerSearchResult(data) {
                    const modal = document.getElementById('customerSearchModal');
                    const modalBody = document.getElementById('customerSearchModalBody');

                    if (data.action === 'add_user') {
                        // Show add user form
                        modalBody.innerHTML = `
							<div class="text-center">
								<h5 class="mb-3">User Tidak Ditemukan</h5>
								<p class="text-muted mb-4">Email <strong>${data.data.email}</strong> tidak ditemukan di channel_users. Silakan tambahkan user baru.</p>
								<form id="addUserForm">
									<div class="mb-3">
										<label class="form-label">Nama</label>
										<input type="text" class="form-control" name="name" required>
						</div>
									<div class="mb-3">
										<label class="form-label">Email</label>
										<input type="email" class="form-control" name="email" value="${data.data.email}" readonly>
							</div>
									<div class="mb-3">
										<label class="form-label">Phone</label>
										<input type="text" class="form-control" name="phone">
							</div>
									<div class="mb-3">
										<label class="form-label">Address</label>
										<textarea class="form-control" name="address" rows="3"></textarea>
							</div>
									<div class="d-flex gap-2">
										<button type="submit" class="btn btn-primary">Tambah User</button>
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
							</div>
								</form>
						</div>
					`;
                    } else if (data.action === 'existing_linked') {
                        // Show existing linked user
                        modalBody.innerHTML = `
							<div class="text-center">
								<h5 class="mb-3 text-success">User Sudah Terhubung</h5>
								<div class="card">
									<div class="card-body">
										<h6>${data.data.chat_ticket_user.name}</h6>
										<p class="text-muted mb-1">Email: ${data.data.chat_ticket_user.email}</p>
										<p class="text-muted mb-0">Phone: ${data.data.chat_ticket_user.phone || '-'}</p>
								</div>
								</div>
								<button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal">Tutup</button>
							</div>
						`;
                    } else if (data.action === 'search_existing') {
                        // Show search existing users
                        modalBody.innerHTML = `
							<div>
								<h5 class="mb-3">Pilih Chat Ticket User</h5>
								<p class="text-muted mb-3">User ditemukan di channel_users tapi belum terhubung. Silakan pilih chat ticket user yang ada.</p>
								<div class="mb-3">
									<input type="text" class="form-control" id="searchChatTicketUsers" placeholder="Cari berdasarkan nama, email, atau phone...">
								</div>
								<div id="searchResults" class="mb-3">
									<p class="text-muted text-center">Ketik untuk mencari...</p>
								</div>
								<div class="d-flex gap-2">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
								</div>
							</div>
						`;

                        // Add search functionality
                        document.getElementById('searchChatTicketUsers').addEventListener('input', function(e) {
                            const searchTerm = e.target.value;
                            if (searchTerm.length >= 2) {
                                searchChatTicketUsers(searchTerm);
                            } else {
                                document.getElementById('searchResults').innerHTML =
                                    '<p class="text-muted text-center">Ketik minimal 2 karakter...</p>';
                            }
                        });
                    }

                    // Show modal
                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }

                // Handle form submissions - using event delegation for dynamic forms
                document.addEventListener('submit', function(e) {
                    if (e.target.id === 'addUserForm') {
                        e.preventDefault();

                        // Show loading notification
                        showNotification('Membuat user baru...', 'info');

                        const formData = new FormData(e.target);
                        const data = Object.fromEntries(formData);

                        fetch('/email/create-new-user', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification(
                                        `User "${data.data.chat_ticket_user.name}" berhasil dibuat dan dihubungkan!`,
                                        'success');
                                    // Close modal
                                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                                        'customerSearchModal'));
                                    modal.hide();
                                    // Refresh profile
                                    getEmailProfile(data.data.chat_ticket_user.email);
                                } else {
                                    showNotification(data.message || 'Error creating user', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error creating user:', error);
                                showNotification('Terjadi kesalahan saat membuat user', 'error');
                            });
                    } else if (e.target.id === 'editUserForm') {
                        e.preventDefault();

                        // Show loading notification
                        showNotification('Mengupdate user...', 'info');

                        const formData = new FormData(e.target);
                        const data = Object.fromEntries(formData);

                        fetch('/email/update-user', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification(
                                        `User "${data.data.chat_ticket_user.name}" berhasil diupdate!`,
                                        'success');
                                    // Close modal
                                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                                        'customerSearchModal'));
                                    modal.hide();
                                    // Refresh profile
                                    getEmailProfile(data.data.chat_ticket_user.email);
                                } else {
                                    showNotification(data.message || 'Error updating user', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error updating user:', error);
                                showNotification('Terjadi kesalahan saat mengupdate user', 'error');
                            });
                    }
                });

                // Dropdown trigger functions - moved outside DOMContentLoaded for global access
            });

            // Global functions for dropdown triggers
            function triggerAddUser() {
                const senderElement = document.getElementById('detail-sender');
                if (!senderElement) {
                    showNotification('Tidak ada email yang dibuka', 'error');
                    return;
                }

                const sender = senderElement.textContent;
                if (!sender || sender.trim() === '') {
                    showNotification('Tidak ada email yang dipilih', 'error');
                    return;
                }

                // Extract email from "Name <email@domain.com>" format
                let currentEmail = sender;
                if (sender.includes('<') && sender.includes('>')) {
                    const match = sender.match(/<(.+?)>/);
                    if (match) {
                        currentEmail = match[1];
                    }
                }

                // Check if customer exists first
                checkCustomerExists(currentEmail, 'add_user');
            }

            function triggerAddExisting() {
                const senderElement = document.getElementById('detail-sender');
                if (!senderElement) {
                    showNotification('Tidak ada email yang dibuka', 'error');
                    return;
                }

                const sender = senderElement.textContent;
                if (!sender || sender.trim() === '') {
                    showNotification('Tidak ada email yang dipilih', 'error');
                    return;
                }

                // Extract email from "Name <email@domain.com>" format
                let currentEmail = sender;
                if (sender.includes('<') && sender.includes('>')) {
                    const match = sender.match(/<(.+?)>/);
                    if (match) {
                        currentEmail = match[1];
                    }
                }

                // Check if customer exists first
                checkCustomerExists(currentEmail, 'add_existing');
            }

            function triggerEditUser() {
                const senderElement = document.getElementById('detail-sender');
                if (!senderElement) {
                    showNotification('Tidak ada email yang dibuka', 'error');
                    return;
                }

                const sender = senderElement.textContent;
                if (!sender || sender.trim() === '') {
                    showNotification('Tidak ada email yang dipilih', 'error');
                    return;
                }

                // Extract email from "Name <email@domain.com>" format
                let currentEmail = sender;
                if (sender.includes('<') && sender.includes('>')) {
                    const match = sender.match(/<(.+?)>/);
                    if (match) {
                        currentEmail = match[1];
                    }
                }

                // Check if customer exists and get data for editing
                checkCustomerExists(currentEmail, 'edit_user');
            }

            function checkCustomerExists(email, action) {
                showNotification('Mencari customer...', 'info');

                fetch('/email/search-customer', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (action === 'add_user') {
                                handleAddUserAction(data);
                            } else if (action === 'add_existing') {
                                handleAddExistingAction(data);
                            } else if (action === 'edit_user') {
                                handleEditUserAction(data);
                            }
                        } else {
                            showNotification(data.message || 'Error searching customer', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error searching customer:', error);
                        showNotification('Terjadi kesalahan saat mencari customer', 'error');
                    });
            }

            function handleAddUserAction(data) {
                if (data.action === 'add_user') {
                    showNotification('Customer tidak ditemukan. Membuka form add user.', 'warning');
                    showAddUserModal(data.data.email);
                } else if (data.action === 'existing_linked') {
                    showNotification('Customer sudah ada dan terhubung!', 'success');
                } else if (data.action === 'search_existing') {
                    showNotification('Customer sudah ada di channel_users tapi belum terhubung. Membuka form add user.',
                        'info');
                    showAddUserModal(data.data.email);
                }
            }

            function handleAddExistingAction(data) {
                if (data.action === 'add_user') {
                    showNotification('Customer tidak ditemukan. Membuka form search existing user.', 'warning');
                    showAddExistingModal(data.data.email);
                } else if (data.action === 'existing_linked') {
                    showNotification('Customer sudah terhubung!', 'success');
                } else if (data.action === 'search_existing') {
                    showNotification('Customer sudah ada tapi belum terhubung. Membuka form search existing user.', 'info');
                    showAddExistingModal(data.data.email);
                }
            }

            function handleEditUserAction(data) {
                if (data.action === 'add_user') {
                    showNotification('Customer tidak ditemukan. Tidak bisa edit.', 'error');
                } else if (data.action === 'existing_linked') {
                    showNotification('Customer ditemukan. Membuka form edit.', 'success');
                    showEditUserModal(data.data.chat_ticket_user);
                } else if (data.action === 'search_existing') {
                    showNotification('Customer ada tapi belum terhubung. Tidak bisa edit.', 'warning');
                }
            }

            function showAddUserModal(email) {
                const modal = document.getElementById('customerSearchModal');
                const modalBody = document.getElementById('customerSearchModalBody');

                modalBody.innerHTML = `
					<div class="text-center">
						<h5 class="mb-3">Tambah User Baru</h5>
						<p class="text-muted mb-4">Email: <strong>${email}</strong></p>
						<form id="addUserForm">
							<div class="mb-3">
								<label class="form-label">Nama</label>
								<input type="text" class="form-control" name="name" required>
							</div>
							<div class="mb-3">
								<label class="form-label">Email</label>
								<input type="email" class="form-control" name="email" value="${email}" readonly>
							</div>
							<div class="mb-3">
								<label class="form-label">Phone</label>
								<input type="text" class="form-control" name="phone">
							</div>
							<div class="mb-3">
								<label class="form-label">Address</label>
								<textarea class="form-control" name="address" rows="3"></textarea>
							</div>
							<div class="d-flex gap-2">
								<button type="submit" class="btn btn-primary">Tambah User</button>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
							</div>
						</form>
							</div>
						`;

                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            }

            function showAddExistingModal(email) {
                const modal = document.getElementById('customerSearchModal');
                const modalBody = document.getElementById('customerSearchModalBody');

                modalBody.innerHTML = `
								<div>
						<h5 class="mb-3">Pilih Chat Ticket User</h5>
						<p class="text-muted mb-3">Email: <strong>${email}</strong></p>
						<div class="mb-3">
							<input type="text" class="form-control" id="searchChatTicketUsers" placeholder="Cari berdasarkan nama, email, atau phone...">
								</div>
						<div id="searchResults" class="mb-3">
							<p class="text-muted text-center">Ketik untuk mencari...</p>
						</div>
						<div class="d-flex gap-2">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						</div>
							</div>
						`;

                // Add search functionality
                document.getElementById('searchChatTicketUsers').addEventListener('input', function(e) {
                    const searchTerm = e.target.value;
                    if (searchTerm.length >= 2) {
                        searchChatTicketUsers(searchTerm);
                    } else {
                        document.getElementById('searchResults').innerHTML =
                            '<p class="text-muted text-center">Ketik minimal 2 karakter...</p>';
                    }
                });

                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            }

            function showEditUserModal(userData) {
                const modal = document.getElementById('customerSearchModal');
                const modalBody = document.getElementById('customerSearchModalBody');

                modalBody.innerHTML = `
					<div class="text-center">
						<h5 class="mb-3">Edit User</h5>
						<form id="editUserForm">
							<input type="hidden" name="user_id" value="${userData.id}">
							<div class="mb-3">
								<label class="form-label">Nama</label>
								<input type="text" class="form-control" name="name" value="${userData.name}" required>
							</div>
							<div class="mb-3">
								<label class="form-label">Email</label>
								<input type="email" class="form-control" name="email" value="${userData.email}" readonly>
							</div>
							<div class="mb-3">
								<label class="form-label">Phone</label>
								<input type="text" class="form-control" name="phone" value="${userData.phone || ''}">
							</div>
							<div class="mb-3">
								<label class="form-label">Address</label>
								<textarea class="form-control" name="address" rows="3">${userData.address || ''}</textarea>
							</div>
							<div class="d-flex gap-2">
								<button type="submit" class="btn btn-primary">Update User</button>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
							</div>
						</form>
						</div>
					`;

                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            }

            // Global functions for search functionality
            function searchChatTicketUsers(searchTerm) {
                // Show loading notification
                showNotification('Mencari chat ticket users...', 'info');

                fetch('/email/search-chat-ticket-users', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            search: searchTerm
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displaySearchResults(data.data);
                            // Show success notification
                            if (data.data.length > 0) {
                                showNotification(`Ditemukan ${data.data.length} chat ticket user(s)`, 'success');
                            } else {
                                showNotification('Tidak ada chat ticket user yang ditemukan', 'warning');
                            }
                        } else {
                            showNotification('Error: ' + data.message, 'error');
                            document.getElementById('searchResults').innerHTML = '<p class="text-danger">Error: ' + data
                                .message + '</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error searching chat ticket users:', error);
                        showNotification('Terjadi kesalahan saat mencari chat ticket users', 'error');
                        document.getElementById('searchResults').innerHTML =
                            '<p class="text-danger">Terjadi kesalahan saat mencari</p>';
                    });
            }

            function displaySearchResults(users) {
                const resultsContainer = document.getElementById('searchResults');

                if (users.length === 0) {
                    resultsContainer.innerHTML = '<p class="text-muted text-center">Tidak ada hasil ditemukan</p>';
                    return;
                }

                let html = '<div class="list-group">';
                users.forEach(user => {
                    html += `
						<div class="list-group-item list-group-item-action" onclick="selectChatTicketUser(${user.id}, '${user.name}', '${user.email}')">
							<div class="d-flex w-100 justify-content-between">
								<h6 class="mb-1">${user.name}</h6>
							</div>
							<p class="mb-1">Email: ${user.email}</p>
							<small>Phone: ${user.phone || '-'}</small>
						</div>
					`;
                });
                html += '</div>';

                resultsContainer.innerHTML = html;
            }

            function selectChatTicketUser(userId, userName, userEmail) {
                // Get the email from the current context
                const senderElement = document.getElementById('detail-sender');
                if (!senderElement) {
                    showNotification('Tidak ada email yang dibuka', 'error');
                    return;
                }

                const sender = senderElement.textContent;
                if (!sender || sender.trim() === '') {
                    showNotification('Tidak ada email yang dipilih', 'error');
                    return;
                }

                // Extract email from "Name <email@domain.com>" format
                let currentEmail = sender;
                if (sender.includes('<') && sender.includes('>')) {
                    const match = sender.match(/<(.+?)>/);
                    if (match) {
                        currentEmail = match[1];
                    }
                }

                // Show loading notification
                showNotification('Menghubungkan user...', 'info');

                fetch('/email/link-existing-user', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            email: currentEmail,
                            chat_ticket_user_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(`User "${userName}" berhasil dihubungkan!`, 'success');
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('customerSearchModal'));
                            modal.hide();
                            // Refresh profile
                            getEmailProfile(currentEmail);
                        } else {
                            showNotification(data.message || 'Error linking user', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error linking user:', error);
                        showNotification('Terjadi kesalahan saat menghubungkan user', 'error');
                    });
            }

            // Email management functions
            function markAsRead(emailId) {
                fetch(`/email/mark-as-read/${emailId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message, 'success');
                            // Update UI
                            const emailItem = document.querySelector(`[data-email-id="${emailId}"]`);
                            if (emailItem) {
                                emailItem.classList.remove('bg-gray-900');
                                emailItem.querySelector('.w-2.h-2.bg-blue-500')?.classList.remove('bg-blue-500');
                                emailItem.querySelector('.w-2.h-2.bg-blue-500')?.classList.add('bg-gray-600');
                                emailItem.querySelectorAll('.font-bold').forEach(el => el.classList.remove('font-bold'));
                            }
                            // Reload page to update status
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error marking as read:', error);
                        showNotification('Terjadi kesalahan saat menandai email', 'error');
                    });
            }

            function markAsReplied(emailId) {
                fetch(`/email/mark-as-replied/${emailId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message, 'success');
                            // Update UI
                            const emailItem = document.querySelector(`[data-email-id="${emailId}"]`);
                            if (emailItem) {
                                const statusIndicator = emailItem.querySelector('.w-2.h-2');
                                if (statusIndicator) {
                                    statusIndicator.classList.remove('bg-blue-500', 'bg-gray-600');
                                    statusIndicator.classList.add('bg-green-500');
                                    statusIndicator.title = 'Sudah di-reply';
                                }
                            }
                            // Reload page to update status
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error marking as replied:', error);
                        showNotification('Terjadi kesalahan saat menandai email', 'error');
                    });
            }

            // Archive dropdown functionality
            document.addEventListener('DOMContentLoaded', function() {
                const archiveBtn = document.getElementById('archive-btn');
                const archiveDropdown = document.getElementById('archive-dropdown');
                const archiveOptions = document.querySelectorAll('.archive-option');

                // Toggle dropdown
                if (archiveBtn && archiveDropdown) {
                    archiveBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        archiveDropdown.classList.toggle('hidden');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!e.target.closest('#archive-dropdown-container')) {
                            archiveDropdown.classList.add('hidden');
                        }
                    });

                    // Handle archive option clicks
                    archiveOptions.forEach(option => {
                        option.addEventListener('click', function(e) {
                            e.preventDefault();
                            const status = this.getAttribute('data-status');
                            if (window.currentEmailId) {
                                updateEmailStatus(window.currentEmailId, status);
                                archiveDropdown.classList.add('hidden');
                            } else {
                                showNotification('Tidak ada email yang dipilih', 'error');
                            }
                        });
                    });
                }
            });

            function updateEmailStatus(emailId, status) {
                fetch(`/email/${emailId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message, 'success');
                            // Reload page to update status
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating email status:', error);
                        showNotification('Terjadi kesalahan saat mengupdate status email', 'error');
                    });
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

            function viewEmail(emailId) {
                // Show email detail view
                const emailItem = document.querySelector(`[data-email-id="${emailId}"]`);
                if (!emailItem) return;

                document.getElementById('AddCustomer_Email').value = emailItem.dataset.emailFrom || '-';

                // Get email data from data attributes
                const emailData = {
                    id: emailItem.dataset.emailId,
                    subject: emailItem.dataset.emailSubject,
                    from: emailItem.dataset.emailFrom,
                    genesis: emailItem.dataset.emailGenesis,
                    to: emailItem.dataset.emailTo,
                    date: emailItem.dataset.emailDate,
                    bodyHtml: emailItem.dataset.emailBodyHtml,
                    bodyText: emailItem.dataset.emailBodyText,
                    attachments: emailItem.dataset.emailAttachments,
                    locationAttachment: emailItem.dataset.emailLocationAttachment,
                    status: emailItem.dataset.emailStatus,
                    ticketNo: emailItem.dataset.ticketNo,
                    agentName: emailItem.dataset.agentName
                };

                // Store current email ID for reply/forward actions
                window.currentEmailId = emailId;
                window.currentEmailStatus = emailItem.dataset.emailStatus || '';
                window.currentEmailRefId = emailItem.dataset.emailRefId || '';

                // Mark email as read and update updated_at
                const emailStatus = emailItem.dataset.emailStatus;
                if (emailStatus === 'unread') {
                    markEmailAsRead(emailId);
                }
                // Always update updated_at when email is opened
                updateEmailUpdatedAt(emailId);

                // 🔹 Generate ticket number saat buka email
                const ticketInput = document.getElementById('ticket_number');
                const ticketDisplay = document.getElementById('ticket_number_display');

                if (ticketInput && ticketDisplay) {
                    const ticketNumber = generateTicketNumber();
                    ticketInput.value = ticketNumber;
                    ticketDisplay.textContent = ticketNumber;
                }

                // Show email detail view
                showEmailDetail(emailData);

                getEmailProfile(emailItem.dataset.emailFrom)
                // Load replies and forwards for this email
                loadRepliesAndForwards(emailId);
            }

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
                                document.getElementById("namaUser").textContent = formData.name ||
                                    "Tidak Ada Nama";
                                document.getElementById("noTelpUser").textContent = formData
                                    .phone || "-";
                                document.getElementById("emailUser").textContent = formData.email ||
                                    "-";
                                document.getElementById("alamatUser").textContent = formData
                                    .address || "-";

                                // document.getElementById("nama_perusahaan").textContent = TicketUser.name || "-";
                                // document.getElementById("email_perusahaan").textContent = TicketUser.email || "-";
                                // document.getElementById("phone_perusahaan").textContent = TicketUser.phone || "-";


                                // document.getElementById('ticket_user_id').value = TicketUser.id || "";

                                document.getElementById('hidden_full_name').value = formData.name ||
                                    "";
                                document.getElementById('hidden_contact_number').value = formData
                                    .phone || "";
                                document.getElementById('hidden_email').value = formData.email ||
                                    "";

                                // Sembunyikan tombol Add dan tampilkan tombol Edit
                                document.getElementById("addCustomerButton").style.display = "none";
                                document.getElementById("editCustomerButton").style.display =
                                    "block";

                                // Isi form edit dengan data user
                                document.getElementById("EditCustomer_Id").value = ChannelUser.id ||
                                    "";
                                document.getElementById("EditCustomer_Name").value = ChannelUser
                                    .name || "";
                                document.getElementById("EditCustomer_HP").value = ChannelUser
                                    .phone || "";
                                document.getElementById("EditCustomer_Email").value = ChannelUser
                                    .email || "";
                                document.getElementById("EditCustomer_Address").value = ChannelUser
                                    .address || "";

                                // Trigger Infomedia history search
                                // if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                //     console.log('Triggering Infomedia history search for:', formData.phone);
                                //     window.InfomedHistory.searchFromParent(formData.phone);
                                // } else {
                                //     console.warn('InfomedHistory not available yet, retrying...');
                                //     // Retry after a short delay if the component hasn't loaded yet
                                //     setTimeout(() => {
                                //         if (typeof window.InfomedHistory !== 'undefined' && window.InfomedHistory.searchFromParent) {
                                //             console.log('Retry: Triggering Infomedia history search for:', formData.phone);
                                //             window.InfomedHistory.searchFromParent(formData.phone);
                                //         } else {
                                //             console.error('InfomedHistory still not available');
                                //         }
                                //     }, 500);
                                // }

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

            $(document).on('click', '#EditCustomerModal', function(e) {
                e.preventDefault();
                console.log('Edit button clicked');

                const formData = {
                    id: document.getElementById('EditCustomer_Id').value,
                    name: document.getElementById('EditCustomer_Name').value,
                    phone: document.getElementById('EditCustomer_HP').value,
                    email: document.getElementById('EditCustomer_Email').value,
                    address: document.getElementById('EditCustomer_Address').value,
                    // company_id: window.currentAgent.company_id
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
                                document.getElementById("namaUser").textContent = formData.name ||
                                    "Tidak Ada Nama";
                                document.getElementById("noTelpUser").textContent = formData
                                    .phone || "-";
                                document.getElementById("emailUser").textContent = formData.email ||
                                    "-";
                                document.getElementById("alamatUser").textContent = formData
                                    .address || "-";

                                // document.getElementById('ticket_user_id').value = formData.id || "";

                                document.getElementById('hidden_full_name').value = formData.name ||
                                    "";
                                document.getElementById('hidden_contact_number').value = formData
                                    .phone || "";
                                document.getElementById('hidden_email').value = formData.email ||
                                    "";

                                // Sembunyikan tombol Add dan tampilkan tombol Edit
                                // document.getElementById("addCustomerButton").style.display = "none";
                                // document.getElementById("editCustomerButton").style.display = "block";

                                // Isi form edit dengan data user
                                document.getElementById("EditCustomer_Id").value = formData.id ||
                                    "";
                                document.getElementById("EditCustomer_Name").value = formData
                                    .name || "";
                                document.getElementById("EditCustomer_HP").value = formData.phone ||
                                    "";
                                document.getElementById("EditCustomer_Email").value = formData
                                    .email || "";
                                document.getElementById("EditCustomer_Address").value = formData
                                    .address || "";

                                // Trigger Infomedia history search
                                if (typeof window.InfomedHistory !== 'undefined' && window
                                    .InfomedHistory.searchFromParent) {
                                    console.log('Triggering Infomedia history search for:', formData
                                        .phone);
                                    window.InfomedHistory.searchFromParent(formData.phone);
                                } else {
                                    console.warn('InfomedHistory not available yet, retrying...');
                                    // Retry after a short delay if the component hasn't loaded yet
                                    setTimeout(() => {
                                        if (typeof window.InfomedHistory !== 'undefined' &&
                                            window.InfomedHistory.searchFromParent) {
                                            console.log(
                                                'Retry: Triggering Infomedia history search for:',
                                                formData.phone);
                                            window.InfomedHistory.searchFromParent(formData
                                                .phone);
                                        } else {
                                            console.error(
                                                'InfomedHistory still not available');
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
                if (!formData.name || !formData.email) {
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
                                document.getElementById("nama_perusahaan").textContent = formData
                                    .name || "Tidak Ada Nama";
                                document.getElementById("phone_perusahaan").textContent = formData
                                    .phone || "-";
                                document.getElementById("email_perusahaan").textContent = formData
                                    .email || "-";
                                // document.getElementById("Profile_Address").textContent = formData.address || "-";

                                // document.getElementById("nama_perusahaan").textContent = TicketUser.name || "-";
                                // document.getElementById("email_perusahaan").textContent = TicketUser.email || "-";
                                // document.getElementById("phone_perusahaan").textContent = TicketUser.phone || "-";


                                document.getElementById('userIdEmail').value = TicketUser.id || "";

                                // document.getElementById('hidden_full_name').value = formData.name || "";
                                // document.getElementById('hidden_contact_number').value = formData.phone || "";
                                // document.getElementById('hidden_email').value = formData.email || "";

                                // Sembunyikan tombol Add dan tampilkan tombol Edit
                                document.getElementById("addPerusahaanButton").style.display =
                                    "none";
                                document.getElementById("editPerusahaanButton").style.display =
                                    "block";

                                // Isi form edit dengan data user
                                document.getElementById("EditCustomer_IdPerusahaan").value =
                                    TicketUser.id || "";
                                document.getElementById("EditCustomer_NamePerusahaan").value =
                                    TicketUser.name || "";
                                document.getElementById("EditCustomer_PhonePerusahaan").value =
                                    TicketUser.phone || "";
                                document.getElementById("EditCustomer_EmailPerusahaan").value =
                                    TicketUser.email || "";
                                document.getElementById("EditCustomer_AddressPerusahaan").value =
                                    TicketUser.address || "";

                                // Trigger Infomedia history search
                                if (typeof window.InfomedHistory !== 'undefined' && window
                                    .InfomedHistory.searchFromParent) {
                                    console.log('Triggering Infomedia history search for:', formData
                                        .phone);
                                    window.InfomedHistory.searchFromParent(formData.phone);
                                } else {
                                    console.warn('InfomedHistory not available yet, retrying...');
                                    // Retry after a short delay if the component hasn't loaded yet
                                    setTimeout(() => {
                                        if (typeof window.InfomedHistory !== 'undefined' &&
                                            window.InfomedHistory.searchFromParent) {
                                            console.log(
                                                'Retry: Triggering Infomedia history search for:',
                                                formData.phone);
                                            window.InfomedHistory.searchFromParent(formData
                                                .phone);
                                        } else {
                                            console.error(
                                                'InfomedHistory still not available');
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

            $(document).on('click', '#EditCustomerModalPerusahaan', function(e) {
                e.preventDefault();
                console.log('Edit button clicked');

                const formData = {
                    id: document.getElementById('EditCustomer_IdPerusahaan').value,
                    name: document.getElementById('EditCustomer_NamePerusahaan').value,
                    phone: document.getElementById('EditCustomer_PhonePerusahaan').value,
                    email: document.getElementById('EditCustomer_EmailPerusahaan').value,
                    address: document.getElementById('EditCustomer_AddressPerusahaan').value,
                    // company_id: window.currentAgent.company_id
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
                                document.getElementById("nama_perusahaan").textContent = formData
                                    .name || "Tidak Ada Nama";
                                document.getElementById("phone_perusahaan").textContent = formData
                                    .phone || "-";
                                document.getElementById("email_perusahaan").textContent = formData
                                    .email || "-";
                                // document.getElementById("Profile_Address").textContent = formData.address || "-";

                                document.getElementById('userIdEmail').value = formData.id || "";


                                // Isi form edit dengan data user
                                document.getElementById("EditCustomer_IdPerusahaan").value =
                                    formData.id || "";
                                document.getElementById("EditCustomer_NamePerusahaan").value =
                                    formData.name || "";
                                document.getElementById("EditCustomer_PhonePerusahaan").value =
                                    formData.phone || "";
                                document.getElementById("EditCustomer_EmailPerusahaan").value =
                                    formData.email || "";
                                document.getElementById("EditCustomer_AddressPerusahaan").value =
                                    formData.address || "";

                                // Trigger Infomedia history search
                                if (typeof window.InfomedHistory !== 'undefined' && window
                                    .InfomedHistory.searchFromParent) {
                                    console.log('Triggering Infomedia history search for:', formData
                                        .phone);
                                    window.InfomedHistory.searchFromParent(formData.phone);
                                } else {
                                    console.warn('InfomedHistory not available yet, retrying...');
                                    // Retry after a short delay if the component hasn't loaded yet
                                    setTimeout(() => {
                                        if (typeof window.InfomedHistory !== 'undefined' &&
                                            window.InfomedHistory.searchFromParent) {
                                            console.log(
                                                'Retry: Triggering Infomedia history search for:',
                                                formData.phone);
                                            window.InfomedHistory.searchFromParent(formData
                                                .phone);
                                        } else {
                                            console.error(
                                                'InfomedHistory still not available');
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

            function htmlToText(html) {
                const div = document.createElement('div');
                div.innerHTML = html;
                return div.textContent || div.innerText || '';
            }

            function showEmailDetail(emailData) {
                // Hide email list view
                document.getElementById('email-list-view').classList.add('hidden');

                // Show email detail view
                const detailView = document.getElementById('email-detail-view');
                detailView.classList.remove('hidden');

                // Show side card when email detail is opened
                const sideCard = document.getElementById('side-card');
                if (sideCard) {
                    sideCard.classList.remove('hidden');
                }

                // Populate email detail
                document.getElementById('detail-subject').textContent = emailData.subject;
                document.getElementById('detail-sender').textContent = emailData.from;
                document.getElementById('detail-recipient').textContent = emailData.to;
                document.getElementById('detail-date').textContent = emailData.date;
                document.getElementById('detail-body').innerHTML = htmlToText(emailData.bodyHtml) || emailData.bodyText;
                document.getElementById('genesisEmail').value = emailData.genesis;

                const locationContainer = document.getElementById('detail-location-attachment');
                if (locationContainer) {
                    let locationAttachment = emailData.locationAttachment || '';
                    const locationDate = emailData.date || '';

                    // Transform URL: convert http to https
                    if (locationAttachment && locationAttachment.startsWith('http://')) {
                        locationAttachment = locationAttachment.replace('http://', 'https://');
                    }

                    if (locationAttachment) {
                        locationContainer.innerHTML = `
							<div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-700">
								<div class="flex items-center space-x-3">
									<div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
										<i class="bx bx-link text-white text-lg"></i>
									</div>
									<div>
										<h6 class="text-white font-medium">${locationDate || 'Attachment'}</h6>
										<p class="text-gray-400 text-sm">LocationAttachment</p>
									</div>
								</div>
								<div class="flex items-center space-x-2">
									<a href="/email/attachment/${locationAttachment}/download" target="_blank"
									   class="text-blue-400 hover:text-blue-300 p-2 rounded-lg hover:bg-gray-700"
									   title="Download Attachment">
										<i class="bx bx-download text-lg"></i>
									</a>
								</div>
							</div>
						`;
                    } else {
                        locationContainer.innerHTML = '';
                    }
                }


                // Show additional info
                const additionalInfo = document.getElementById('detail-additional-info');
                if (additionalInfo) {
                    let infoHtml = '';
                    if (emailData.ticketNo) {
                        infoHtml += `<span class="bg-blue-900 text-blue-300 px-2 py-1 rounded text-xs mr-2">
							<i class="bx bx-ticket mr-1"></i>${emailData.ticketNo}
						</span>`;
                    }
                    if (emailData.agentName) {
                        infoHtml += `<span class="bg-green-900 text-green-300 px-2 py-1 rounded text-xs">
							<i class="bx bx-user mr-1"></i>${emailData.agentName}
						</span>`;
                    }
                    additionalInfo.innerHTML = infoHtml;
                }
            }



            // Back to list functionality
            document.getElementById('back-to-list').addEventListener('click', function() {
                document.getElementById('email-detail-view').classList.add('hidden');
                document.getElementById('email-list-view').classList.remove('hidden');

                document.getElementById("addCustomerButton").style.display = "block";
                document.getElementById("editCustomerButton").style.display = "none";

                document.getElementById("addPerusahaanButton").style.display = "block";
                document.getElementById("editPerusahaanButton").style.display = "none";

                document.getElementById('hidden_full_name').value = "";
                document.getElementById('hidden_contact_number').value = "";
                document.getElementById('hidden_email').value = "";

                document.getElementById('namaUser').textContent = '';
                document.getElementById('emailUser').textContent = '';
                document.getElementById('noTelpUser').textContent = '';
                document.getElementById('alamatUser').textContent = '';
                document.getElementById('userIdEmail').value = '';
                document.getElementById('genesisEmail').value = '';

                document.getElementById("nama_perusahaan").textContent = "";
                document.getElementById("phone_perusahaan").textContent = "";
                document.getElementById("email_perusahaan").textContent = "";

                document.getElementById("EditCustomer_IdPerusahaan").value = "";
                document.getElementById("EditCustomer_NamePerusahaan").value = "";
                document.getElementById("EditCustomer_PhonePerusahaan").value = "";
                document.getElementById("EditCustomer_EmailPerusahaan").value = "";
                document.getElementById("EditCustomer_AddressPerusahaan").value = "";

                document.getElementById("AddCustomer_Email").value = "";

                document.getElementById("EditCustomer_Id").value = "";
                document.getElementById("EditCustomer_Name").value = "";
                document.getElementById("EditCustomer_HP").value = "";
                document.getElementById("EditCustomer_Email").value = "";
                document.getElementById("EditCustomer_Address").value = "";

                $('#complaint_submission_form')[0].reset();
                $('#Form_Ticket_Status').val('');
                $('#Form_Ticket_Priority').val('');

                window.loadKategoriComplaint();
                window.resetDynamicFields();

                // Hide side card when going back to email list
                const sideCard = document.getElementById('side-card');
                if (sideCard) {
                    sideCard.classList.add('hidden');
                }
            });


            // Search form functionality
            document.getElementById('email-search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = document.getElementById('email-search-input').value;
                const url = new URL(window.location);
                if (searchTerm.trim()) {
                    url.searchParams.set('q', searchTerm);
                } else {
                    url.searchParams.delete('q');
                }
                window.location.href = url.toString();
            });

            // Notification function
            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white max-w-sm ${
					type === 'success' ? 'bg-green-500' :
					type === 'error' ? 'bg-red-500' :
					type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
				}`;
                notification.textContent = message;

                // Add to page
                document.body.appendChild(notification);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        </script>

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
                        findCustomerMode === 'chat' ?
                        `selectCustomerForChat(${customer.id}, '${customer.name}')` :
                        `selectFoundCustomer(${customer.id}, '${customer.name}', '${customer.email || ''}', '${customer.phone || ''}', '${customer.address || ''}')`;

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

            // Select found customer
            function selectFoundCustomer(id, name, email, phone, address) {
                // Fill profile data
                document.getElementById("nama_perusahaan").textContent = name || "Tidak Ada Nama";
                document.getElementById("phone_perusahaan").textContent = phone || "-";
                document.getElementById("email_perusahaan").textContent = email || "-";
                // document.getElementById("Profile_Address").textContent = address || "-";
                document.getElementById('userIdEmail').value = id || "";

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
        </script>

        <!-- Load ticket-form.js -->



        <!-- Add signal-bar element for web-socket component -->
        <div id="signal-bar" style="display: none;"></div>
        <div id="signal-status-label" style="display: none;"></div>
    </x-slot>

    <!-- Customer Search Modal -->
    <div class="modal fade" id="customerSearchModal" tabindex="-1" aria-labelledby="customerSearchModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerSearchModalLabel">Customer Search</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="customerSearchModalBody">
                    <!-- Dynamic content will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        window.currentEmailId = '{{ request()->get('email_id') ?? 'EMAIL_' . time() }}';
        document.body.setAttribute('data-email-id', window.currentEmailId);
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</x-dashonic-horizontal-layout>
