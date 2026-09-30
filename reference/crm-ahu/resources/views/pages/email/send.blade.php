<x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
    with-header="{{ request()->get('with-header') ?? 0 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">
	<div class="mt-2 relative h-[calc(100vh-1rem)] overflow-hidden">
		<!-- Main Card Layout -->
		<div class="flex gap-2 h-[calc(100vh-1rem)]">
			<!-- Main Card - Email Sent Interface -->
			<div class="flex-1 min-w-0">
				<div class="bg-gray-800 rounded-lg p-6 h-full flex flex-col">
					<!-- Email List View -->
					<div id="email-list-view" class="flex-1 flex flex-col h-[calc(100vh-12rem)] overflow-y-auto">
						<!-- Gmail Header -->
						<div class="flex items-center justify-between mb-6">
							<div class="flex items-center space-x-4">
								<h1 class="text-2xl font-bold text-white flex items-center">
									<i class="bx bx-send text-blue-500 mr-3 text-4xl"></i>
									Email Terkirim
								</h1>
								<span class="text-sm text-gray-400">({{ $emails->total() ?? 0 }})</span>
							</div>
							
							<div class="flex items-center space-x-4">		
								<!-- Search Bar -->
								<form method="get" class="w-full max-w-md">
									<div class="relative">
										<input type="text" name="q" value="{{ request('q') }}" 
											   placeholder="Search sent emails..." 
											   class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-400 rounded-full pl-10 pr-12 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
										<span class="absolute left-3 top-2.5 text-gray-400">
											<i class="bx bx-search text-sm"></i>
										</span>
										<div class="absolute right-2 top-1.5 flex items-center space-x-1">
											<button type="button" class="p-1 rounded-full hover:bg-gray-600 text-gray-400 hover:text-white" title="Search options">
												<i class="bx bx-tune text-xs"></i>
											</button>
											<button type="submit" class="p-1 rounded-full hover:bg-gray-600 text-gray-400 hover:text-white">
												<i class="bx bx-search text-xs"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
				</div>

						<!-- Gmail Toolbar -->
						<div class="bg-gray-800 rounded-lg mb-4">
							<div class="flex items-center justify-between px-4 py-3">
								<div class="flex items-center space-x-3">
									<!-- Compose Button -->
									<a href="{{ route('email.compose') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
										<i class="bx bx-edit text-lg"></i>
										<span>Compose</span>
									</a>
									
									<!-- Inbox Button -->
									<a href="{{ route('email.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
										<i class="bx bx-inbox text-lg"></i>
										<span>Inbox</span>
					</a>
				</div>
			</div>
		</div>

						<!-- Gmail Email List -->
						<div class="bg-gray-800 rounded-lg flex-1 h-[calc(100vh-1rem)] overflow-y-auto" id="email-list-container">
							@forelse ($emails ?? [] as $item)
								<div class="email-item flex items-center px-4 py-3 border-b border-gray-700 hover:bg-gray-750 cursor-pointer"
									 data-email-id="{{ $item->id }}"
									 data-email-subject="{{ $item->email_subject ?? '(No Subject)' }}"
									 data-email-from="{{ $item->email_from ?? 'Unknown Sender' }}"
									 data-email-to="{{ $item->email_to ?? '' }}"
									 data-email-cc="{{ $item->email_cc ?? '' }}"
									 data-email-bcc="{{ $item->email_bcc ?? '' }}"
									 data-email-date="{{ optional($item->email_sent_date ?? $item->created_at)->timezone(config('app.timezone'))->format('F j, Y \a\t g:i A') }}"
									 data-email-body-html="{{ htmlspecialchars($item->email_body_html ?? '') }}"
									 data-email-body-text="{{ e(strip_tags($item->email_body_text ?? $item->email_body_html)) }}"
									 data-email-attachments="{{ $item->attachments ? $item->attachments->count() : 0 }}"
									 data-email-attachments-data="{{ $item->attachments ? $item->attachments->toJson() : '[]' }}">
																		
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
														<span class="text-white">{{ $senderName }}</span>
														<span class="text-gray-400 text-sm">({{ $senderEmail }})</span>
			</div>
		</div>

												<!-- Date -->
												<div class="text-sm text-gray-400 whitespace-nowrap">
													@php
														$date = $item->email_sent_date ?? $item->created_at;
														$timezone_date = optional($date)->timezone(config('app.timezone'));
														$is_today = $timezone_date ? $timezone_date->isToday() : false;
														$is_this_year = $timezone_date ? $timezone_date->isCurrentYear() : false;
													@endphp
													@if($is_today)
														{{ $timezone_date->format('g:i A') }}
													@elseif($is_this_year)
														{{ $timezone_date->format('M j') }}
													@else
														{{ $timezone_date->format('n/j/y') }}
													@endif
				</div>
				</div>

											<!-- Second Row: To and Attachments -->
											<div class="flex items-center justify-between mb-1">
												<div class="flex items-center space-x-2">
													<span class="text-gray-400 text-sm">to:</span>
													<span class="text-gray-300 text-sm truncate max-w-md">
														{{ $item->email_to ?? 'N/A' }}
													</span>
			</div>

												<!-- Attachments -->
												@if($item->attachments && $item->attachments->count() > 0)
													<div class="flex items-center space-x-1">
														<i class="bx bx-paperclip text-gray-400 text-sm"></i>
														<span class="text-gray-400 text-sm">{{ $item->attachments->count() }} attachment(s)</span>
														<div class="flex space-x-1 ml-2">
															@foreach($item->attachments as $attachment)
																<a href="{{ route('email.attachment.view', $attachment->id) }}" 
																   target="_blank" 
																   class="text-blue-400 hover:text-blue-300 text-xs"
																   title="View {{ $attachment->filename }}">
																	<i class="bx bx-show"></i>
																</a>
																<a href="{{ route('email.attachment.download', $attachment->id) }}" 
																   class="text-green-400 hover:text-green-300 text-xs"
																   title="Download {{ $attachment->filename }}">
																	<i class="bx bx-download"></i>
																</a>
															@endforeach
			</div>
		</div>
												@endif
	</div>
											
											<!-- Third Row: Subject -->
											<div class="mb-1">
												<span class="font-semibold text-white text-sm">
													{{ $item->email_subject ?? '(No Subject)' }}
												</span>
</div>

											<!-- Fourth Row: Preview -->
											<div class="text-gray-400 text-sm truncate">
												{!! \Illuminate\Support\Str::limit(strip_tags($item->email_body_text ?? $item->email_body_html), 120) !!}
		</div>
	</div>
</div>

						</div>
							@empty
								<div class="p-16 text-center">
									<i class="bx bx-send text-8xl text-gray-600 mb-6"></i>
									<div class="text-2xl text-gray-400 mb-3">No sent emails found</div>
									<div class="text-gray-500">Start sending emails to see them here!</div>
								</div>
							@endforelse
						</div>
						
						<!-- Pagination -->
						@if(($emails ?? collect())->count() > 0)
							<div class="p-4 border-t border-gray-800 bg-gray-800 rounded-lg mt-2">
								<div class="flex items-center justify-between">
									<!-- Pagination Info -->
									<div class="flex items-center space-x-3 text-sm text-gray-400">
										<span class="pagination-info">
											{{ $emails->firstItem() }}-{{ $emails->lastItem() }} of {{ $emails->total() }}
										</span>
			</div>
									
									<!-- Pagination Controls -->
									<div class="flex items-center space-x-2">
										<!-- Previous Button -->
										<button id="prev-btn" class="p-2 rounded hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" 
												onclick="loadPreviousPage()" 
												{{ $emails->currentPage() <= 1 ? 'disabled' : '' }}>
											<i class="bx bx-chevron-left text-lg"></i>
			</button>
										
										<!-- Page Numbers -->
										<div class="flex items-center space-x-1">
											@php
												$currentPage = $emails->currentPage();
												$lastPage = $emails->lastPage();
												$start = max(1, $currentPage - 2);
												$end = min($lastPage, $currentPage + 2);
											@endphp
											
											@if($start > 1)
												<button class="p-2 rounded hover:bg-gray-700 text-sm" onclick="loadPage(1)">1</button>
												@if($start > 2)
													<span class="text-gray-500">...</span>
												@endif
											@endif
											
											@for($i = $start; $i <= $end; $i++)
												<button class="p-2 rounded text-sm {{ $i == $currentPage ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 text-gray-400' }}" 
														onclick="loadPage({{ $i }})">
													{{ $i }}
				</button>
											@endfor
											
											@if($end < $lastPage)
												@if($end < $lastPage - 1)
													<span class="text-gray-500">...</span>
												@endif
<button class="p-2 rounded hover:bg-gray-700 text-sm pagination-btn" data-page="{{ $lastPage }}">{{ $lastPage }}</button>
											@endif
										</div>
										
										<!-- Next Button -->
										<button id="next-btn" class="p-2 rounded hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" 
												onclick="loadNextPage()"
												{{ $emails->currentPage() >= $emails->lastPage() ? 'disabled' : '' }}>
											<i class="bx bx-chevron-right text-lg"></i>
			</button>
								</div>
								</div>
							</div>
						@endif
					</div>

					<!-- Email Detail View -->
					<div id="email-detail-view" class="hidden flex-1 flex flex-col h-[calc(100vh-1rem)] overflow-y-auto">
						<!-- Back Button and Header -->
						<div class="flex items-center justify-between mb-2">
							<div class="flex items-center space-x-4">
								<button id="back-to-list" class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800">
									<i class="bx bx-arrow-back text-xl"></i>
								</button>
								<h2 id="detail-subject" class="text-2xl font-bold text-white truncate"></h2>
							</div>
							<div class="flex items-center space-x-2">
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Print">
									<i class="bx bx-printer"></i>
								</button>
								<button class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="More options">
									<i class="bx bx-dots-vertical-rounded"></i>
								</button>
				</div>
						</div>

						<!-- Email Actions -->
						<!-- <div class="flex items-center justify-between px-0 py-3 mb-6 border-b border-gray-700">
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
						</div> -->

						<!-- Email Content -->
						<div class="bg-gray-800 rounded-lg p-6 flex-1 overflow-y-auto">
							<!-- Email Meta -->
							<div class="mb-6">
								<div class="flex items-center space-x-4 mb-4">
									<div id="detail-sender-avatar" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
									</div>
									<div class="flex-1">
										<div class="text-white font-semibold" id="detail-sender"></div>
										<div class="text-sm text-gray-400" id="detail-date"></div>
									</div>
								</div>
								<div class="text-sm text-gray-400 space-y-1">
									<div><span class="text-gray-500">To:</span> <span id="detail-to"></span></div>
									<div id="detail-cc-container" class="hidden"><span class="text-gray-500">CC:</span> <span id="detail-cc"></span></div>
									<div id="detail-bcc-container" class="hidden"><span class="text-gray-500">BCC:</span> <span id="detail-bcc"></span></div>
								</div>
							</div>
					
							<!-- Email Body -->
							<div id="detail-body" class="prose prose-invert prose-blue max-w-none text-gray-300"></div>

							<!-- Attachments Section -->
							<div id="attachments-section" class="mt-6 hidden">
								<div class="border-t border-gray-700 pt-6">
									<h3 class="text-lg font-semibold text-white mb-4 flex items-center">
										<i class="bx bx-paperclip mr-2"></i>
										Attachments
									</h3>
									<div id="attachments-list" class="space-y-3">
										<!-- Attachments will be loaded here -->
									</div>
								</div>
							</div>
						</div>

						<!-- Reply Actions -->
						<div class="mt-6">
							<div class="flex items-center space-x-3">
								<button class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
									<i class="bx bx-reply"></i>
									<span>Reply</span>
								</button>
								<button class="flex items-center space-x-2 text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
									<i class="bx bx-reply-all"></i>
									<span>Reply all</span>
								</button>
								<button class="flex items-center space-x-2 text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-700 hover:border-gray-600">
									<i class="bx bx-share"></i>
									<span>Forward</span>
								</button>
				</div>
						</div>
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

			/* Enhanced email content styling */
			.prose-blue {
				line-height: 1.7;
			}

			.prose-blue p {
				margin-bottom: 1rem;
			}

			.prose-blue h1, .prose-blue h2, .prose-blue h3, .prose-blue h4, .prose-blue h5, .prose-blue h6 {
				color: #f3f4f6;
				margin-top: 1.5rem;
				margin-bottom: 0.75rem;
			}

			.prose-blue ul, .prose-blue ol {
				margin-bottom: 1rem;
				padding-left: 1.5rem;
			}

			.prose-blue li {
				margin-bottom: 0.25rem;
			}

			.prose-blue blockquote {
				border-left: 4px solid #3b82f6;
				padding-left: 1rem;
				margin: 1rem 0;
				font-style: italic;
				color: #d1d5db;
			}

			.prose-blue code {
				background: #374151;
				padding: 0.125rem 0.25rem;
				border-radius: 0.25rem;
				font-size: 0.875rem;
				color: #f3f4f6;
			}

			.prose-blue pre {
				background: #1f2937;
				padding: 1rem;
				border-radius: 0.5rem;
				overflow-x: auto;
				margin: 1rem 0;
			}

			.prose-blue pre code {
				background: transparent;
				padding: 0;
				color: #f3f4f6;
			}

			.prose-blue table {
				width: 100%;
				border-collapse: collapse;
				margin: 1rem 0;
			}

			.prose-blue th, .prose-blue td {
				border: 1px solid #4b5563;
				padding: 0.5rem;
				text-align: left;
			}

			.prose-blue th {
				background: #374151;
				font-weight: 600;
			}

			.prose-blue img {
				max-width: 100%;
				height: auto;
				border-radius: 0.5rem;
				margin: 1rem 0;
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
			
			/* Ensure email items are clickable */
			.email-item {
				cursor: pointer !important;
				position: relative;
				z-index: 1;
			}
			
			.email-item:hover {
				background-color: #374151 !important;
			}
			
			.email-item * {
				pointer-events: none;
			}
			
			.email-item button,
			.email-item input,
			.email-item a {
				pointer-events: auto;
			}
		</style>
	</x-slot>

	<x-slot name="js">
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				console.log('DOM loaded, initializing email functionality...');
				
				// Wait a bit for DOM to be fully ready
				setTimeout(function() {
					attachEmailItemListeners();
					setupBackButton();
					setupPaginationListeners();
				}, 100);
			});

			function setupBackButton() {
				const backBtn = document.getElementById('back-to-list');
				const emailListView = document.getElementById('email-list-view');
				const emailDetailView = document.getElementById('email-detail-view');
				
				if (backBtn) {
					backBtn.addEventListener('click', function(e) {
						e.preventDefault();
						console.log('Back button clicked');
						if (emailDetailView) emailDetailView.classList.add('hidden');
						if (emailListView) emailListView.classList.remove('hidden');
					});
				}
			}

			function setupPaginationListeners() {
				// Pagination buttons with data-page attribute
				const paginationBtns = document.querySelectorAll('.pagination-btn');
				paginationBtns.forEach(btn => {
					const pageNumber = btn.getAttribute('data-page');
					if (pageNumber) {
						btn.addEventListener('click', function(e) {
							e.preventDefault();
							window.location.href = `?page=${pageNumber}`;
						});
					}
				});
			}

			// Function to attach event listeners to email items
			function attachEmailItemListeners() {
				const emailItems = document.querySelectorAll('.email-item');
				console.log('Attaching listeners to', emailItems.length, 'email items');
				
				emailItems.forEach((item, index) => {
					console.log('Adding listener to email item', index);
					
					// Remove any existing listeners
					item.removeEventListener('click', handleEmailClick);
					
					// Add click handler
					item.addEventListener('click', handleEmailClick);
				});
			}

			function handleEmailClick(e) {
				console.log('Email item clicked!', e.target);
				
				// Don't open if clicking on checkboxes or action buttons
				if (e.target.matches('input[type="checkbox"]') || 
					e.target.closest('button') ||
					e.target.closest('a') ||
					e.target.closest('.hover\\:bg-gray-600')) {
					console.log('Click ignored - on checkbox, button, or link');
					e.preventDefault();
					e.stopPropagation();
					return;
				}
				
				// Get email data
				const subject = this.dataset.emailSubject;
				const sender = this.dataset.emailFrom;
				const to = this.dataset.emailTo;
				const cc = this.dataset.emailCc;
				const bcc = this.dataset.emailBcc;
				const date = this.dataset.emailDate;
				const bodyHtml = this.dataset.emailBodyHtml;
				const bodyText = this.dataset.emailBodyText;
				const attachmentsData = JSON.parse(this.dataset.emailAttachmentsData || '[]');
				
				console.log('Email data:', { subject, sender, to, date });
				
				// Populate detail view
				const detailSubject = document.getElementById('detail-subject');
				const detailSender = document.getElementById('detail-sender');
				const detailTo = document.getElementById('detail-to');
				const detailDate = document.getElementById('detail-date');
				
				if (detailSubject) detailSubject.textContent = subject || 'No Subject';
				if (detailSender) detailSender.textContent = sender || 'Unknown Sender';
				if (detailTo) detailTo.textContent = to || 'N/A';
				if (detailDate) detailDate.textContent = date || 'Unknown Date';
				
				// Show/hide CC and BCC
				const ccContainer = document.getElementById('detail-cc-container');
				const bccContainer = document.getElementById('detail-bcc-container');
				
				if (cc && ccContainer) {
					const detailCc = document.getElementById('detail-cc');
					if (detailCc) detailCc.textContent = cc;
					ccContainer.classList.remove('hidden');
				} else if (ccContainer) {
					ccContainer.classList.add('hidden');
				}
				
				if (bcc && bccContainer) {
					const detailBcc = document.getElementById('detail-bcc');
					if (detailBcc) detailBcc.textContent = bcc;
					bccContainer.classList.remove('hidden');
				} else if (bccContainer) {
					bccContainer.classList.add('hidden');
				}
				
				// Set avatar
				const avatar = document.getElementById('detail-sender-avatar');
				if (avatar) {
					avatar.textContent = (sender || 'U').charAt(0).toUpperCase();
				}
				
				// Set email body
				const emailBody = document.getElementById('detail-body');
				if (emailBody) {
					if (bodyHtml && bodyHtml.trim() !== '') {
						// Decode HTML entities and display as HTML
						const decodedHtml = bodyHtml.replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&amp;/g, '&').replace(/&quot;/g, '"').replace(/&#39;/g, "'");
						emailBody.innerHTML = decodedHtml;
					} else if (bodyText && bodyText.trim() !== '') {
						emailBody.innerHTML = '<pre class="whitespace-pre-wrap text-gray-300 font-mono text-sm">' + bodyText + '</pre>';
					} else {
						emailBody.innerHTML = '<p class="text-gray-500 italic">No content available</p>';
					}
				}

				// Display attachments
				displayAttachments(attachmentsData);
				
				// Switch views
				const emailListView = document.getElementById('email-list-view');
				const emailDetailView = document.getElementById('email-detail-view');
				
				if (emailListView && emailDetailView) {
					console.log('Switching to detail view');
					emailListView.classList.add('hidden');
					emailDetailView.classList.remove('hidden');
				} else {
					console.error('Could not find email list or detail view elements');
					console.log('emailListView:', emailListView);
					console.log('emailDetailView:', emailDetailView);
				}
			}

			// Display attachments in detail view
			function displayAttachments(attachmentsData) {
				const attachmentsSection = document.getElementById('attachments-section');
				const attachmentsList = document.getElementById('attachments-list');
				
				if (!attachmentsSection || !attachmentsList) return;
				
				// Clear existing attachments
				attachmentsList.innerHTML = '';
				
				if (attachmentsData && attachmentsData.length > 0) {
					// Show attachments section
					attachmentsSection.classList.remove('hidden');
					
					// Add each attachment
					attachmentsData.forEach(attachment => {
						const attachmentItem = document.createElement('div');
						attachmentItem.className = 'attachment-item';
						
						// Get file icon based on type
						const fileIcon = getAttachmentIcon(attachment.filetype || attachment.type);
						
						// Format file size
						const fileSize = attachment.filesize ? formatFileSize(attachment.filesize) : 'Unknown size';
						
						attachmentItem.innerHTML = `
							<div class="attachment-info">
								<div class="attachment-icon">
									<i class="${fileIcon}"></i>
								</div>
								<div class="attachment-details">
									<h6>${attachment.filename}</h6>
									<p>${fileSize}</p>
								</div>
							</div>
							<div class="flex space-x-2">
								<a href="/email/attachment/view/${attachment.id}" 
								   target="_blank" 
								   class="text-blue-400 hover:text-blue-300 px-3 py-1 rounded border border-blue-400 hover:border-blue-300 text-sm"
								   title="View ${attachment.filename}">
									<i class="bx bx-show mr-1"></i>View
								</a>
								<a href="/email/attachment/download/${attachment.id}" 
								   class="text-green-400 hover:text-green-300 px-3 py-1 rounded border border-green-400 hover:border-green-300 text-sm"
								   title="Download ${attachment.filename}">
									<i class="bx bx-download mr-1"></i>Download
								</a>
							</div>
						`;
						
						attachmentsList.appendChild(attachmentItem);
					});
				} else {
					// Hide attachments section if no attachments
					attachmentsSection.classList.add('hidden');
				}
			}

			// Get attachment icon based on file type
			function getAttachmentIcon(fileType) {
				if (!fileType) return 'bx bx-file';
				
				if (fileType.startsWith('image/')) return 'bx bx-image';
				if (fileType.startsWith('video/')) return 'bx bx-video';
				if (fileType.startsWith('audio/')) return 'bx bx-music';
				if (fileType.includes('pdf')) return 'bx bx-file-pdf';
				if (fileType.includes('word') || fileType.includes('document')) return 'bx bx-file-doc';
				if (fileType.includes('excel') || fileType.includes('spreadsheet')) return 'bx bx-file-xls';
				if (fileType.includes('powerpoint') || fileType.includes('presentation')) return 'bx bx-file-ppt';
				if (fileType.includes('zip') || fileType.includes('rar') || fileType.includes('archive')) return 'bx bx-file-zip';
				if (fileType.includes('text')) return 'bx bx-file-txt';
				
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
		</script>
	</x-slot>
</x-dashonic-horizontal-layout>