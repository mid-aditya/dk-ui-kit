<x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
    with-header="{{ request()->get('with-header') ?? 0 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">
    <div class="mt-2 relative h-[calc(100vh-1rem)] overflow-hidden">
        <!-- Main Card Layout -->
        <div class="flex gap-2 h-[calc(100vh-1rem)]">
            <!-- Main Card - Email History Interface -->
            <div class="flex-1 min-w-0">
                <div class="bg-gray-800 rounded-lg p-6 h-full flex flex-col">
                    <!-- Email History List View -->
                    <div id="email-history-list-view" class="flex-1 flex flex-col h-[calc(100vh-1rem)] overflow-y-auto">
                        <!-- Gmail Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <h1 class="text-2xl font-bold text-white flex items-center">
                                    <i class="bx bx-history text-blue-500 mr-3 text-4xl"></i>
                                    Email History
                                </h1>
                                <span class="text-sm text-gray-400">({{ $emails->total() ?? 0 }})</span>
                            </div>

                            <div class="flex items-center space-x-4">

                                {{-- RESET BUTTON --}}
                                @if (request()->has('q') && request('q') !== '')
                                    <a href="{{ url()->current() }}"
                                        class="px-3 rounded-full bg-gray-700 hover:bg-gray-600 text-gray-400 hover:text-white"
                                        title="Reset">
                                        Clear
                                    </a>
                                @endif

                                <!-- Search Bar -->
                                <form method="get" class="w-full max-w-md">
                                    <div class="relative">
                                        <input type="text" name="q" value="{{ request('q') }}"
                                            placeholder="Search email history..."
                                            class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-400 rounded-full pl-10 pr-12 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                        <span class="absolute left-3 top-2.5 text-gray-400">
                                            <i class="bx bx-search text-sm"></i>
                                        </span>

                                        <!-- Right buttons -->
                                        <div class="absolute right-2 top-1.5 flex items-center space-x-1">



                                            {{-- Search options --}}
                                            <button type="button"
                                                class="p-1 rounded-full hover:bg-gray-600 text-gray-400 hover:text-white"
                                                title="Search options">
                                                <i class="bx bx-tune text-xs"></i>
                                            </button>

                                            {{-- Submit --}}
                                            <button type="submit"
                                                class="p-1 rounded-full hover:bg-gray-600 text-gray-400 hover:text-white">
                                                <i class="bx bx-search text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <!-- Filter Options -->
                        <div id="filter-options" class="hidden bg-gray-800 rounded-lg mb-4 p-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Date Range</label>
                                    <select
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2">
                                        <option>Last 7 days</option>
                                        <option>Last 30 days</option>
                                        <option>Last 3 months</option>
                                        <option>Last year</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                                    <select
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2">
                                        <option>All</option>
                                        <option>Sent</option>
                                        <option>Received</option>
                                        <option>Draft</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Sender</label>
                                    <input type="text" placeholder="Filter by sender"
                                        class="w-full bg-gray-700 border border-gray-600 text-white placeholder-gray-400 rounded-lg px-3 py-2">
                                </div>
                                <div class="flex items-end">
                                    <button
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                        Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Gmail Toolbar -->
                        {{-- <div class="bg-gray-800 rounded-lg mb-4">
							<div class="flex items-center justify-between px-4 py-3">
								<div class="flex items-center space-x-3">
									<!-- Filter Button -->
                                    <button id="filter-history-btn" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
									<i class="bx bx-filter text-lg"></i>
									<span>Filter</span>
								</button>

								<!-- Export Button -->
								<button id="export-history-btn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
									<i class="bx bx-download text-lg"></i>
									<span>Export</span>
								</button>
								</div>
								<div class="flex items-center space-x-3 text-sm text-gray-400">
									<span>1-{{ $emails->count() ?? 0 }} of {{ $emails->total() ?? 0 }}</span>
									<button class="p-1 rounded hover:bg-gray-700">
										<i class="bx bx-chevron-left"></i>
									</button>
									<button class="p-1 rounded hover:bg-gray-700">
										<i class="bx bx-chevron-right"></i>
									</button>
								</div>
							</div>
						</div> --}}

                        <!-- Email History Table -->
                        <div class="bg-gray-800 rounded-lg flex-1 h-[calc(100vh-1rem)] overflow-y-auto">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead class="bg-gray-700 sticky top-0 z-10">
                                        <tr>
                                            {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
												<input type="checkbox" class="rounded border-gray-600 text-blue-600 focus:ring-blue-500">
											</th> --}}
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                From
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                To
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                Subject
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                                        @forelse ($emails ?? [] as $item)
                                            <tr class="hover:bg-gray-750 cursor-pointer email-history-item"
                                                data-email-id="{{ $item->id }}"
                                                data-email-subject="{{ $item->email_subject ?? '(No Subject)' }}"
                                                data-email-from="{{ $item->email_from ?? 'Unknown Sender' }}"
                                                data-email-to="{{ $item->email_to ?? '' }}"
                                                data-email-cc="{{ $item->email_cc ?? '' }}"
                                                data-email-bcc="{{ $item->email_bcc ?? '' }}"
                                                data-chat-header-history-id="{{ $item->chat_header_history_id }}"
                                                data-email-date="{{ optional($item->email_sent_date ?? $item->created_at)->timezone(config('app.timezone'))->format('F j, Y \a\t g:i A') }}"
                                                data-email-body-html="{{ htmlspecialchars($item->email_body_html ?? '') }}"
                                                data-email-body-text="{{ e(strip_tags($item->email_body_text ?? $item->email_body_html)) }}"
                                                data-email-attachments="{{ $item->attachments ? $item->attachments->count() : 0 }}">

                                                {{-- <!-- Checkbox -->
												<td class="px-6 py-4 whitespace-nowrap">
													<input type="checkbox" class="rounded border-gray-600 text-blue-600 focus:ring-blue-500">
												</td> --}}

                                                <!-- From -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <div
                                                                class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                                                                <span class="text-sm font-medium text-white">
                                                                    @php
                                                                        $from = $item->email_from ?? 'Unknown Sender';
                                                                        // Extract name from email format "Name <email@domain.com>"
                                                                        if (
                                                                            preg_match(
                                                                                '/^(.+?)\s*<(.+?)>$/',
                                                                                $from,
                                                                                $matches,
                                                                            )
                                                                        ) {
                                                                            $senderName = trim($matches[1], '"');
                                                                            $senderEmail = $matches[2];
                                                                        } else {
                                                                            $senderName = $from;
                                                                            $senderEmail = $from;
                                                                        }
                                                                    @endphp
                                                                    {{ strtoupper(substr($senderName, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-white">
                                                                {{ $senderName }}
                                                            </div>
                                                            <div class="text-sm text-gray-400">
                                                                {{ $senderEmail }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- To -->
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-300 max-w-xs truncate">
                                                        {{ $item->email_to ?? 'N/A' }}
                                                    </div>
                                                    @if ($item->email_cc)
                                                        <div class="text-xs text-gray-500">
                                                            CC: {{ $item->email_cc }}
                                                        </div>
                                                    @endif
                                                    @if ($item->email_bcc)
                                                        <div class="text-xs text-gray-500">
                                                            BCC: {{ $item->email_bcc }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- Subject -->
                                                <td class="px-6 py-4">
                                                    <div class="text-sm font-medium text-white max-w-md truncate">
                                                        {{ $item->email_subject ?? '(No Subject)' }}
                                                    </div>
                                                    <div class="text-sm text-gray-400 max-w-md truncate">
                                                        {!! \Illuminate\Support\Str::limit(strip_tags($item->email_body_text ?? $item->email_body_html), 60) !!}
                                                    </div>
                                                    @if ($item->attachments && $item->attachments->count() > 0)
                                                        <div class="flex items-center mt-1">
                                                            <i class="bx bx-paperclip text-gray-400 text-xs mr-1"></i>
                                                            <span
                                                                class="text-xs text-gray-400">{{ $item->attachments->count() }}
                                                                attachment(s)</span>
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- Status -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($item->is_draft)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <i class="bx bx-edit mr-1"></i>
                                                            Draft
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="bx bx-check mr-1"></i>
                                                            Sent
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- Date -->
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                                    @php
                                                        $date = $item->email_sent_date ?? $item->created_at;
                                                        $timezone_date = optional($date)->timezone(
                                                            config('app.timezone'),
                                                        );
                                                        $is_today = $timezone_date ? $timezone_date->isToday() : false;
                                                        $is_this_year = $timezone_date
                                                            ? $timezone_date->isCurrentYear()
                                                            : false;
                                                    @endphp
                                                    <div>
                                                        @if ($is_today)
                                                            {{ $timezone_date->format('g:i A') }}
                                                        @elseif($is_this_year)
                                                            {{ $timezone_date->format('M j, g:i A') }}
                                                        @else
                                                            {{ $timezone_date->format('M j, Y') }}
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $timezone_date->format('D') }}
                                                    </div>
                                                </td>

                                                <!-- Actions -->
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                    <button type="button"
                                                        class="inline-flex items-center justify-center text-blue-400 hover:text-blue-300"
                                                        title="View" onclick="viewTicket(this)">
                                                        <i class="bx bx-show text-lg"></i>
                                                    </button>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-6 py-16 text-center">
                                                    <i class="bx bx-history text-8xl text-gray-600 mb-6"></i>
                                                    <div class="text-2xl text-gray-400 mb-3">No email history found
                                                    </div>
                                                    <div class="text-gray-500">Start sending emails to see them here!
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if (($emails ?? collect())->count() > 0)
                                <div class="p-4 border-t border-gray-800">
                                    {{ $emails->links() }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Email History Detail View -->
                    <div id="email-history-detail-view" class="hidden flex-1 flex flex-col h-full">
                        <!-- Back Button and Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <button id="back-to-history-list"
                                    class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800">
                                    <i class="bx bx-arrow-back text-xl"></i>
                                </button>
                                <h2 id="history-detail-subject" class="text-2xl font-bold text-white truncate"></h2>
                            </div>
                            {{-- <div class="flex items-center space-x-2">
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Print">
									<i class="bx bx-printer"></i>
								</button>
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Export">
									<i class="bx bx-download"></i>
								</button>
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="More options">
									<i class="bx bx-dots-vertical-rounded"></i>
								</button>
							</div> --}}
                        </div>

                        <!-- Email Actions -->
                        {{-- <div class="flex items-center justify-between px-0 py-3 mb-6 border-b border-gray-700">
							<div class="flex items-center space-x-2">
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Resend">
									<i class="bx bx-send"></i>
								</button>
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Edit">
									<i class="bx bx-edit"></i>
								</button>
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Delete">
									<i class="bx bx-trash"></i>
								</button>
								<div class="h-5 w-px bg-gray-600 mx-2"></div>
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Archive">
									<i class="bx bx-archive"></i>
								</button>
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Forward">
									<i class="bx bx-share"></i>
								</button>
							</div>
							<div class="flex items-center space-x-2 text-sm text-gray-400">
								<button class="p-1 rounded hover:bg-gray-800">
									<i class="bx bx-chevron-left"></i>
								</button>
								<button class="p-1 rounded hover:bg-gray-800">
									<i class="bx bx-chevron-right"></i>
								</button>
							</div>
						</div> --}}

                        <!-- Email Content -->
                        <div class="bg-gray-800 rounded-lg p-6 flex-1 overflow-y-auto">
                            <!-- Email Meta -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-start space-x-4">
                                    <div id="history-detail-sender-avatar"
                                        class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span id="history-detail-sender" class="text-white font-semibold"></span>
                                            <span id="history-detail-status"
                                                class="px-2 py-1 bg-green-600 text-green-100 text-xs rounded-full"></span>
                                        </div>
                                        <div class="text-sm text-gray-400">
                                            <div>to <span id="history-detail-to"></span></div>
                                            <div id="history-detail-cc-container" class="hidden">cc: <span
                                                    id="history-detail-cc"></span></div>
                                            <div id="history-detail-bcc-container" class="hidden">bcc: <span
                                                    id="history-detail-bcc"></span></div>
                                            <div>sent on <span id="history-detail-date"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span id="history-detail-timestamp" class="text-sm text-gray-400"></span>
                                    {{-- <button class="text-gray-400 hover:text-yellow-400 p-1 rounded">
										<i class="bx bx-star"></i>
									</button> --}}
                                </div>
                            </div>

                            <!-- Email Body -->
                            <div id="history-detail-body"
                                class="prose prose-invert prose-blue max-w-none text-gray-300"></div>
                            <div id="detail-attachments" class="mt-4 hidden">
                                <div class="text-sm text-gray-300 mb-2"><strong>Attachments:</strong></div>
                                <div id="detail-attachments-list" class="space-y-2"></div>
                            </div>
                            <div id="replies-forwards-section" class="mt-8 hidden">
                                <div class="border-t border-gray-700 pt-6">
                                    <div id="replies-container" class="mb-6">
                                        <div id="replies-list" class="space-y-4">
                                            <!-- Replies will be populated here -->
                                        </div>
                                    </div>

                                    <!-- Forwards -->
                                    <div id="forwards-container" class="mb-6">
                                        <div id="forwards-list" class="space-y-4">
                                            <!-- Forwards will be populated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        {{-- <div class="mt-6">
							<div class="flex items-center space-x-3">
								<button class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
									<i class="bx bx-send"></i>
									<span>Resend</span>
								</button>
								<button class="flex items-center space-x-2 text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
									<i class="bx bx-edit"></i>
									<span>Edit</span>
								</button>
								<button class="flex items-center space-x-2 text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
									<i class="bx bx-share"></i>
									<span>Forward</span>
								</button>
							</div>
						</div> --}}
                    </div>
                </div>
            </div>

            <!-- Side Card - Fixed width (Statistics) -->
            <!-- <div class="w-[500px] flex-shrink-0">
    <div class="bg-gray-800 rounded-lg p-3 h-full flex flex-col">
     <div class="flex w-full mb-4 border-b border-gray-700">
      <button id="tab-stats" class="flex-1 text-center py-2 text-white font-semibold border-b-2 border-blue-400 focus:outline-none transition-all
							hover:bg-gray-700 hover:text-blue-400 hover:border-blue-400 bg-gray-700 text-blue-400"
       onclick="showHistoryTab('stats')">
       Statistics
      </button>
      <button id="tab-timeline" class="flex-1 text-center py-2 text-white font-semibold border-b-2 border-transparent focus:outline-none transition-all
							hover:bg-gray-700 hover:text-blue-400 hover:border-blue-400"
       onclick="showHistoryTab('timeline')">
       Timeline
      </button>
      <button id="tab-export" class="flex-1 text-center py-2 text-white font-semibold border-b-2 border-transparent focus:outline-none transition-all
							hover:bg-gray-700 hover:text-blue-400 hover:border-blue-400"
       onclick="showHistoryTab('export')">
       Export
      </button>
     </div>
     <div class="flex-1 w-full">
      <div id="tab-content-stats" class="tab-content">
       <div class="text-gray-300">
        <div class="grid grid-cols-2 gap-4 mb-6">
         <div class="bg-gray-700 rounded-lg p-4 text-center">
          <div class="text-2xl font-bold text-blue-400">{{ $emails->total() ?? 0 }}</div>
          <div class="text-sm text-gray-400">Total Emails</div>
         </div>
         <div class="bg-gray-700 rounded-lg p-4 text-center">
          <div class="text-2xl font-bold text-green-400">{{ ($emails ?? collect())->where('is_draft', false)->count() }}</div>
          <div class="text-sm text-gray-400">Sent</div>
         </div>
         <div class="bg-gray-700 rounded-lg p-4 text-center">
          <div class="text-2xl font-bold text-yellow-400">{{ ($emails ?? collect())->where('is_draft', true)->count() }}</div>
          <div class="text-sm text-gray-400">Drafts</div>
         </div>
         <div class="bg-gray-700 rounded-lg p-4 text-center">
          <div class="text-2xl font-bold text-purple-400">0</div>
          <div class="text-sm text-gray-400">Failed</div>
         </div>
        </div>

        <div class="bg-gray-700 rounded-lg p-4 mb-4">
         <h4 class="text-lg font-semibold text-white mb-3">Email Activity</h4>
         <div class="h-32 bg-gray-600 rounded flex items-center justify-center">
          <i class="bx bx-bar-chart text-4xl text-gray-400"></i>
         </div>
        </div>

        <div class="bg-gray-700 rounded-lg p-4">
         <h4 class="text-lg font-semibold text-white mb-3">Recent Activity</h4>
         <div class="space-y-2">
          <div class="flex items-center space-x-3 text-sm">
           <div class="w-2 h-2 bg-green-500 rounded-full"></div>
           <span class="text-gray-300">Email sent to john@example.com</span>
           <span class="text-gray-500 text-xs">2 min ago</span>
          </div>
          <div class="flex items-center space-x-3 text-sm">
           <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
           <span class="text-gray-300">Draft saved</span>
           <span class="text-gray-500 text-xs">1 hour ago</span>
          </div>
          <div class="flex items-center space-x-3 text-sm">
           <div class="w-2 h-2 bg-green-500 rounded-full"></div>
           <span class="text-gray-300">Email sent to admin@company.com</span>
           <span class="text-gray-500 text-xs">3 hours ago</span>
          </div>
         </div>
        </div>
       </div>
      </div>
      <div id="tab-content-timeline" class="tab-content hidden">
       <div class="text-gray-300">
        <div class="space-y-4">
         <div class="flex items-start space-x-3">
          <div class="w-3 h-3 bg-green-500 rounded-full mt-2"></div>
          <div class="flex-1">
           <div class="text-sm font-semibold text-white">Email Sent</div>
           <div class="text-xs text-gray-400">to: john@example.com</div>
           <div class="text-xs text-gray-500">2 minutes ago</div>
          </div>
         </div>
         <div class="flex items-start space-x-3">
          <div class="w-3 h-3 bg-yellow-500 rounded-full mt-2"></div>
          <div class="flex-1">
           <div class="text-sm font-semibold text-white">Draft Created</div>
           <div class="text-xs text-gray-400">Subject: Meeting Request</div>
           <div class="text-xs text-gray-500">1 hour ago</div>
          </div>
         </div>
         <div class="flex items-start space-x-3">
          <div class="w-3 h-3 bg-green-500 rounded-full mt-2"></div>
          <div class="flex-1">
           <div class="text-sm font-semibold text-white">Email Sent</div>
           <div class="text-xs text-gray-400">to: admin@company.com</div>
           <div class="text-xs text-gray-500">3 hours ago</div>
          </div>
         </div>
        </div>
       </div>
      </div>
      <div id="tab-content-export" class="tab-content hidden">
       <div class="text-gray-300">
        <div class="bg-gray-700 rounded-lg p-4 mb-4">
         <h4 class="text-lg font-semibold text-white mb-3">Export Options</h4>
         <div class="space-y-3">
          <div>
           <label class="block text-sm font-medium text-gray-300 mb-2">Format</label>
           <select class="w-full bg-gray-600 border border-gray-500 text-white rounded-lg px-3 py-2">
            <option>CSV</option>
            <option>Excel</option>
            <option>PDF</option>
           </select>
          </div>
          <div>
           <label class="block text-sm font-medium text-gray-300 mb-2">Date Range</label>
           <select class="w-full bg-gray-600 border border-gray-500 text-white rounded-lg px-3 py-2">
            <option>Last 7 days</option>
            <option>Last 30 days</option>
            <option>Last 3 months</option>
            <option>All time</option>
           </select>
          </div>
          <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
           <i class="bx bx-download mr-2"></i>Export Data
          </button>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
    <script>
        function showHistoryTab(tab) {
            const tabs = ['stats', 'timeline', 'export'];
            tabs.forEach(function(name) {
                document.getElementById('tab-content-' + name).classList.add('hidden');
                document.getElementById('tab-' + name).classList.remove('border-blue-400', 'text-blue-400',
                    'bg-gray-700');
            });
            document.getElementById('tab-content-' + tab).classList.remove('hidden');
            document.getElementById('tab-' + tab).classList.add('border-blue-400', 'text-blue-400', 'bg-gray-700');
        }

        document.addEventListener('DOMContentLoaded', function() {
            showHistoryTab('stats');
        });
    </script>
   </div> -->
        </div>
    </div>

    <!-- Ticket Detail Modal -->
    <div id="ticketModal" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-gray-800 rounded-lg w-full max-w-lg shadow-lg">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                    <h2 class="text-lg font-semibold text-white">
                        Ticket Terkait
                    </h2>
                    <button onclick="closeTicketModal()" class="text-gray-400 hover:text-white">
                        ✕
                    </button>
                </div>

                <div id="ticketModalBody" class="px-6 py-4 text-gray-300 space-y-4 max-h-[60vh] overflow-y-auto">

                    <!-- diisi via JS -->
                </div>

                <div class="px-6 py-4 border-t border-gray-700 text-right">
                    <button onclick="closeTicketModal()"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded text-white">
                        Close
                    </button>
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
        </style>
    </x-slot>

    <x-slot name="js">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const emailHistoryItems = document.querySelectorAll('.email-history-item');
                const emailHistoryListView = document.getElementById('email-history-list-view');
                const emailHistoryDetailView = document.getElementById('email-history-detail-view');
                const backBtn = document.getElementById('back-to-history-list');
                const filterBtn = document.getElementById('filter-history-btn');
                const filterOptions = document.getElementById('filter-options');

                // Toggle filter options
                if (filterBtn && filterOptions) {
                    filterBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        filterOptions.classList.toggle('hidden');
                    });
                }

                // Open email history detail
                emailHistoryItems.forEach(item => {
                    item.addEventListener('click', function(e) {
                        // Don't open if clicking on checkboxes or action buttons
                        if (e.target.matches('input[type="checkbox"]') ||
                            e.target.closest('button')) {
                            e.preventDefault();
                            e.stopPropagation();
                            return;
                        }

                        // Get email data
                        const id = this.dataset.emailId;
                        const subject = this.dataset.emailSubject;
                        const sender = this.dataset.emailFrom;
                        const to = this.dataset.emailTo;
                        const cc = this.dataset.emailCc;
                        const bcc = this.dataset.emailBcc;
                        const date = this.dataset.emailDate;
                        const bodyHtml = this.dataset.emailBodyHtml;
                        const bodyText = this.dataset.emailBodyText;
                        const attachments = this.dataset.emailAttachments;

                        // Populate detail view
                        document.getElementById('history-detail-subject').textContent = subject;
                        document.getElementById('history-detail-sender').textContent = sender;
                        document.getElementById('history-detail-to').textContent = to || 'N/A';
                        document.getElementById('history-detail-date').textContent = date;
                        document.getElementById('history-detail-timestamp').textContent = date;

                        // Show/hide CC and BCC
                        const ccContainer = document.getElementById('history-detail-cc-container');
                        const bccContainer = document.getElementById('history-detail-bcc-container');

                        if (cc) {
                            document.getElementById('history-detail-cc').textContent = cc;
                            ccContainer.classList.remove('hidden');
                        } else {
                            ccContainer.classList.add('hidden');
                        }

                        if (bcc) {
                            document.getElementById('history-detail-bcc').textContent = bcc;
                            bccContainer.classList.remove('hidden');
                        } else {
                            bccContainer.classList.add('hidden');
                        }

                        // Set avatar
                        const avatar = document.getElementById('history-detail-sender-avatar');
                        avatar.textContent = sender.charAt(0).toUpperCase();

                        // Set email body
                        const emailBody = document.getElementById('history-detail-body');
                        if (bodyHtml) {
                            emailBody.innerHTML = htmlToText(bodyHtml);
                        } else {
                            emailBody.innerHTML =
                                '<pre class="whitespace-pre-wrap text-gray-300 font-mono text-sm">' +
                                bodyText + '</pre>';
                        }


                        // Handle attachments
                        const attachmentsSection = document.getElementById('detail-attachments');
                        const attachmentsList = document.getElementById('detail-attachments-list');

                        // Reset attachments list
                        attachmentsList.innerHTML = '';
                        attachmentsSection.classList.add('hidden');

                        // Determine source based on active tab or item properties
                        // In history view, we can infer from the status badge or the filter
                        // For now, assuming default history list is incoming unless specified
                        let source = 'incoming';
                        const statusSpan = this.querySelector(
                        '.bg-green-100'); // Simple heuristic for now
                        // Better: check if we are in 'sent' or 'draft' mode
                        const urlParams = new URLSearchParams(window.location.search);
                        const currentStatus = urlParams.get('status');

                        if (currentStatus === 'sent' || currentStatus === 'draft') {
                            source = 'outgoing';
                        }

                        // Load attachments via AJAX
                        // Always call this to check for both regular attachments and location_attachment
                        loadEmailAttachments(id, attachmentsList, attachmentsSection, source);


                        loadRepliesAndForwards(id);

                        // Switch views
                        emailHistoryListView.classList.add('hidden');
                        emailHistoryDetailView.classList.remove('hidden');
                    });
                });

                // Back to email history list
                if (backBtn) {
                    backBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        emailHistoryDetailView.classList.add('hidden');
                        emailHistoryListView.classList.remove('hidden');

                    });
                }

                // Select all checkbox functionality
                const selectAllCheckbox = document.querySelector('thead input[type="checkbox"]');
                const emailHistoryCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');

                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', function() {
                        emailHistoryCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                    });
                }

                // Individual checkbox change
                emailHistoryCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allChecked = Array.from(emailHistoryCheckboxes).every(cb => cb.checked);
                        const someChecked = Array.from(emailHistoryCheckboxes).some(cb => cb.checked);

                        if (selectAllCheckbox) {
                            selectAllCheckbox.checked = allChecked;
                            selectAllCheckbox.indeterminate = someChecked && !allChecked;
                        }
                    });
                });
            });

            function htmlToText(html) {
                const div = document.createElement('div');
                div.innerHTML = html;
                return div.textContent || div.innerText || '';
            }

            // Function to get attachment URL with proper formatting
            // Uses the viewAttachment route which handles .zip extension on download
            function getAttachmentUrl(attachment) {
                // Always use the viewAttachment route for consistent download handling
                return '/email/attachment/' + attachment.id + '/view';
            }

            // Function to load email attachments
            function loadEmailAttachments(emailId, container, section, source = 'incoming') {
                const url = source ? `/email/${emailId}?source=${source}` : `/email/${emailId}`;
                fetch(url, {
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
                        if (data.success && data.email) {
                            container.innerHTML = '';
                            let hasAttachments = false;

                            const attachments = Array.isArray(data.email.attachments) ? data.email.attachments : [];

                            if (attachments.length > 0) {
                                hasAttachments = true;
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
                            }

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
                                hasAttachments = true;
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

                            if (hasAttachments) {
                                section.classList.remove('hidden');
                            } else {
                                section.classList.add('hidden');
                            }

                        } else {
                            container.innerHTML = '<p class="text-gray-400 text-sm">No attachments found</p>';
                            section.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading attachments:', error);
                        container.innerHTML = '<p class="text-red-400 text-sm">Error loading attachments</p>';
                        section.classList.remove('hidden');
                    });
            }

            function loadRepliesAndForwards(emailId) {
                // Ensure functions are available globally
                // if (typeof loadPage === 'function') {
                //     window.loadPage = loadPage;
                //     window.loadPreviousPage = loadPreviousPage;
                //     window.loadNextPage = loadNextPage;
                //     window.loadEmailsPage = loadEmailsPage;
                // }

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
                // window.loadPage = loadPage;
                // window.loadPreviousPage = loadPreviousPage;
                // window.loadNextPage = loadNextPage;
                // window.loadEmailsPage = loadEmailsPage;

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
                // window.loadPage = loadPage;
                // window.loadPreviousPage = loadPreviousPage;
                // window.loadNextPage = loadNextPage;
                // window.loadEmailsPage = loadEmailsPage;

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
                // // Ensure functions are available globally
                // window.loadPage = loadPage;
                // window.loadPreviousPage = loadPreviousPage;
                // window.loadNextPage = loadNextPage;
                // window.loadEmailsPage = loadEmailsPage;

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
                // window.loadPage = loadPage;
                // window.loadPreviousPage = loadPreviousPage;
                // window.loadNextPage = loadNextPage;
                // window.loadEmailsPage = loadEmailsPage;

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
                // window.loadPage = loadPage;
                // window.loadPreviousPage = loadPreviousPage;
                // window.loadNextPage = loadNextPage;
                // window.loadEmailsPage = loadEmailsPage;

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

            function viewTicket(button) {
                const row = button.closest('tr');
                const genesisNumber = row.dataset.chatHeaderHistoryId;

                if (!genesisNumber) {
                    alert('Genesis number tidak ditemukan');
                    return;
                }

                fetch('/email/view/ticket', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            genesisnumber: genesisNumber
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (!res.status) {
                            alert(res.message);
                            return;
                        }

                        renderTicketModal(res.data);
                    })
                    .catch(() => {
                        alert('Gagal mengambil data ticket');
                    });
            }

            function renderTicketModal(ticket) {
                const payload = JSON.parse(ticket.payload ?? '[]');

                const specialFields = [
                    'customer_category',
                    'enquiry_type',
                    'enquiry_detail',
                    'problem'
                ];

                let payloadHtml = payload.map(item => {
                    let value = item.value ?? '-';

                    // 🔥 Ambil dari additional_data.name untuk field tertentu
                    if (
                        specialFields.includes(item.field_name) &&
                        item.additional_data &&
                        item.additional_data.name
                    ) {
                        value = item.additional_data.name;
                    }

                    return `
                        <div class="flex justify-between border-b border-gray-700 py-2 gap-4">
                            <span class="text-gray-400">${item.label}</span>
                            <span class="text-white text-right">${value}</span>
                        </div>
                    `;
                }).join('');

                const body = `
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-400 text-sm">Ticket Number</p>
                            <p class="text-white">${ticket.ticket_number}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Status</p>
                            <p class="text-green-400">${ticket.status}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Priority</p>
                            <p class="text-white">${ticket.priority}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Agent</p>
                            <p class="text-white">${ticket.user_agent?.username ?? '-'}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-white font-semibold mb-2">Detail</h3>
                        <div class="bg-gray-900 rounded p-4 space-y-2">
                            ${payloadHtml}
                        </div>
                    </div>
                `;

                document.getElementById('ticketModalBody').innerHTML = body;
                document.getElementById('ticketModal').classList.remove('hidden');
            }


            function closeTicketModal() {
                document.getElementById('ticketModal').classList.add('hidden');
            }
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
