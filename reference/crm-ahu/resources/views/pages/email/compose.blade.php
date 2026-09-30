<x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
    with-header="{{ request()->get('with-header') ?? 0 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">

<div class="mt-2 relative h-[calc(100vh-1rem)] overflow-y-auto">
<div class="min-h-screen bg-gray-900 text-white">
	<div class="container mx-auto px-4 py-8">
		<!-- Header -->
		<div class="mb-8">
			<div class="flex items-center justify-between">
				<div>
					<h1 class="text-3xl font-bold text-white mb-2">Compose Email</h1>
					<p class="text-gray-400">Buat dan kirim email baru</p>
				</div>
				<div class="flex items-center space-x-4">
					<a href="{{ route('email.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
						<i class="bx bx-arrow-back mr-2"></i>Kembali ke Inbox
					</a>
					<a href="{{ route('email.send') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
						<i class="bx bx-send mr-2"></i>Lihat Email Terkirim
					</a>
				</div>
			</div>
		</div>

		<!-- Compose Form -->
		<div class="bg-gray-800 rounded-lg shadow-xl h-[calc(100vh-1rem)] overflow-y-auto">
			<form id="compose-form" class="p-6">
				@csrf
				<input type="hidden" id="draft-id" value="">
				
				<!-- To Field with Email Tags -->
				<div class="mb-6">
					<label for="to" class="block text-sm font-medium text-gray-300 mb-2">Kepada *</label>
					<div class="email-input-container">
						<div class="email-tags" onclick="focusInput('to')">
							<input type="text" class="email-input" id="to" placeholder="Masukkan alamat email dan tekan Enter">
						</div>
					</div>
					<div class="validation-message" id="toValidation"></div>
				</div>

				<!-- Toggle CC/BCC -->
				<div class="toggle-section mb-6">
					<button type="button" class="toggle-btn" onclick="toggleSection('cc')">CC</button>
					<button type="button" class="toggle-btn" onclick="toggleSection('bcc')">BCC</button>
				</div>

				<!-- CC Field with Email Tags -->
				<div class="form-group cc-section hidden mb-6" id="ccSection">
					<label for="cc" class="block text-sm font-medium text-gray-300 mb-2">CC:</label>
					<div class="email-input-container">
						<div class="email-tags" onclick="focusInput('cc')">
							<input type="text" class="email-input" id="cc" placeholder="Masukkan alamat email CC dan tekan Enter">
						</div>
					</div>
					<div class="validation-message" id="ccValidation"></div>
				</div>

				<!-- BCC Field with Email Tags -->
				<div class="form-group bcc-section hidden mb-6" id="bccSection">
					<label for="bcc" class="block text-sm font-medium text-gray-300 mb-2">BCC:</label>
					<div class="email-input-container">
						<div class="email-tags" onclick="focusInput('bcc')">
							<input type="text" class="email-input" id="bcc" placeholder="Masukkan alamat email BCC dan tekan Enter">
						</div>
					</div>
					<div class="validation-message" id="bccValidation"></div>
				</div>

				<!-- Subject -->
				<div class="mb-6">
					<label for="compose-template" class="block text-sm font-medium text-gray-300 mb-2">Template</label>
					<select id="compose-template" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
						<option value="">Pilih template...</option>
						@foreach ($templates ?? [] as $template)
							<option value="{{ $template->id }}"
								data-subject="{{ e($template->subject ?? '') }}"
								data-body-html="{{ htmlspecialchars($template->body_html ?? '', ENT_QUOTES, 'UTF-8') }}">
								{{ $template->name }}
							</option>
						@endforeach
					</select>
				</div>

				<!-- Subject -->
				<div class="mb-6">
					<label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Subject *</label>
					<input type="text" id="subject" name="subject" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500" placeholder="Email subject" required>
				</div>

				<!-- File Attachments -->
				<div id="attachments-container" class="hidden mb-6">
					<label class="block text-sm font-medium text-gray-300 mb-2">Attachments</label>
					<div id="attachments-list" class="space-y-2">
						<!-- Attachments will be added here dynamically -->
					</div>
				</div>

				<!-- Message with WYSIWYG -->
				<div class="mb-6">
					<label for="body-main" class="block text-sm font-medium text-gray-300 mb-2">Message *</label>
					<div class="wysiwyg-container">
						<div class="wysiwyg-toolbar">
							<button type="button" class="wysiwyg-btn" onclick="formatText('bold')" title="Bold"><b>B</b></button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('italic')" title="Italic"><i>I</i></button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('underline')" title="Underline"><u>U</u></button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('strikeThrough')" title="Strikethrough"><s>S</s></button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('insertUnorderedList')" title="Bullet List">•</button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('insertOrderedList')" title="Numbered List">1.</button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('justifyLeft')" title="Align Left">⌐</button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('justifyCenter')" title="Align Center">≡</button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('justifyRight')" title="Align Right">⌐</button>
							<button type="button" class="wysiwyg-btn" onclick="insertLink()" title="Insert Link">🔗</button>
							<button type="button" class="wysiwyg-btn" onclick="formatText('removeFormat')" title="Clear Format">✗</button>
						</div>
						<div class="wysiwyg-editor" id="body-main" contenteditable="true" placeholder="Tulis pesan email Anda di sini..."></div>
					</div>
					<!-- Hidden textarea to store the HTML content -->
					<textarea name="body" id="body" style="display: none;"></textarea>
				</div>

				<!-- Action Buttons -->
				<div class="flex items-center justify-between pt-4 border-t border-gray-700">
					<div class="flex items-center space-x-2">
						<button type="button" id="attach-file" class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-700" title="Attach File">
							<i class="bx bx-paperclip text-lg"></i>
						</button>
						<input type="file" id="file-input" multiple class="hidden" accept="*/*">
						<button type="button" id="save-draft" class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800" title="Save Draft">
							<i class="bx bx-save"></i>
						</button>
					</div>
					<div class="flex items-center space-x-3">
						<button type="button" id="clear-form" class="text-gray-400 hover:text-white px-4 py-2 rounded-lg border border-gray-600 hover:border-gray-500">
							Batal
						</button>
						<button type="button" id="save-draft-btn" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium">
							Simpan Draft
						</button>
						<button type="submit" id="send-email" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
							<i class="bx bx-send mr-2"></i>Kirim Email
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- File Preview Modal -->
<div id="file-preview-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
	<div class="flex items-center justify-center min-h-screen p-4">
		<div class="bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
			<div class="flex items-center justify-between p-6 border-b border-gray-700">
				<h3 id="preview-filename" class="text-xl font-semibold text-white">File Preview</h3>
				<button id="close-preview-modal" class="text-gray-400 hover:text-white">
					<i class="bx bx-x text-2xl"></i>
				</button>
			</div>
			<div class="p-6 overflow-y-auto max-h-[70vh]">
				<div id="preview-content">
					<!-- File content will be loaded here -->
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	/* WYSIWYG Editor Styles */
	.wysiwyg-container {
		border: 1px solid #4B5563;
		border-radius: 0.5rem;
		background-color: #1F2937;
		overflow: hidden;
	}

	.wysiwyg-container:focus-within {
		border-color: #3B82F6;
		box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
	}

	.wysiwyg-toolbar {
		display: flex;
		align-items: center;
		padding: 0.5rem;
		background-color: #374151;
		border-bottom: 1px solid #4B5563;
		gap: 0.25rem;
	}

	.wysiwyg-btn {
		padding: 0.5rem;
		background-color: transparent;
		border: 1px solid transparent;
		border-radius: 0.25rem;
		color: #D1D5DB;
		cursor: pointer;
		transition: all 0.2s;
		font-size: 0.875rem;
		min-width: 2rem;
		text-align: center;
	}

	.wysiwyg-btn:hover {
		background-color: #4B5563;
		border-color: #6B7280;
		color: #FFFFFF;
	}

	.wysiwyg-btn.active {
		background-color: #3B82F6;
		border-color: #3B82F6;
		color: #FFFFFF;
	}

	.wysiwyg-editor {
		min-height: 200px;
		padding: 1rem;
		color: #FFFFFF;
		outline: none;
		line-height: 1.6;
	}

	.wysiwyg-editor:empty:before {
		content: attr(placeholder);
		color: #9CA3AF;
		pointer-events: none;
	}

	.wysiwyg-editor ul {
		margin: 0.5rem 0;
		padding-left: 1.5rem;
	}

	.wysiwyg-editor ol {
		margin: 0.5rem 0;
		padding-left: 1.5rem;
	}

	.wysiwyg-editor li {
		margin: 0.25rem 0;
	}

	.wysiwyg-editor ul ul {
		margin: 0.25rem 0;
	}

	.wysiwyg-editor ul ul ul {
		margin: 0.25rem 0;
	}

	/* Attachment Styles */
	.attachment-item {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0.75rem;
		background-color: #374151;
		border: 1px solid #4B5563;
		border-radius: 0.5rem;
		margin-bottom: 0.5rem;
	}

	.attachment-info {
		display: flex;
		align-items: center;
		flex: 1;
	}

	.attachment-icon {
		width: 2rem;
		height: 2rem;
		background-color: #3B82F6;
		border-radius: 0.25rem;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 0.75rem;
		color: white;
	}

	.attachment-details h6 {
		font-size: 0.875rem;
		font-weight: 600;
		color: #FFFFFF;
		margin: 0;
	}

	.attachment-details p {
		font-size: 0.75rem;
		color: #9CA3AF;
		margin: 0;
	}

	.attachment-remove {
		background-color: #EF4444;
		color: white;
		border: none;
		border-radius: 0.25rem;
		padding: 0.25rem 0.5rem;
		cursor: pointer;
		font-size: 0.75rem;
		transition: background-color 0.2s;
	}

	.attachment-remove:hover {
		background-color: #DC2626;
	}

	/* Email Tags Styles */
	.email-input-container {
		border: 1px solid #4B5563;
		border-radius: 0.5rem;
		background-color: #1F2937;
		min-height: 2.5rem;
		padding: 0.5rem;
		cursor: text;
	}

	.email-tags {
		display: flex;
		flex-wrap: wrap;
		gap: 0.5rem;
		align-items: center;
		min-height: 1.5rem;
	}

	.email-tag {
		background-color: #3B82F6;
		color: white;
		padding: 0.25rem 0.5rem;
		border-radius: 0.375rem;
		font-size: 0.875rem;
		display: flex;
		align-items: center;
		gap: 0.25rem;
	}

	.email-tag .remove-tag {
		cursor: pointer;
		font-weight: bold;
		padding: 0 0.25rem;
		border-radius: 0.25rem;
		background-color: rgba(255, 255, 255, 0.2);
	}

	.email-tag .remove-tag:hover {
		background-color: rgba(255, 255, 255, 0.3);
	}

	.email-input {
		background: transparent;
		border: none;
		outline: none;
		color: white;
		flex: 1;
		min-width: 200px;
		font-size: 0.875rem;
	}

	.email-input::placeholder {
		color: #9CA3AF;
	}

	.toggle-section {
		display: flex;
		gap: 0.5rem;
	}

	.toggle-btn {
		background-color: #374151;
		color: #D1D5DB;
		border: 1px solid #4B5563;
		padding: 0.5rem 1rem;
		border-radius: 0.375rem;
		cursor: pointer;
		font-size: 0.875rem;
		transition: all 0.2s;
	}

	.toggle-btn:hover {
		background-color: #4B5563;
		border-color: #6B7280;
	}

	.toggle-btn.active {
		background-color: #3B82F6;
		border-color: #3B82F6;
		color: white;
	}

	.validation-message {
		color: #EF4444;
		font-size: 0.75rem;
		margin-top: 0.25rem;
		display: none;
	}

	.validation-message.show {
		display: block;
	}
</style>

<script>
	// File attachments array
	let attachments = [];
	
	// Email arrays for multiple emails
	let emails = {
		to: [],
		cc: [],
		bcc: []
	};

	document.addEventListener('DOMContentLoaded', function() {
		// Initialize WYSIWYG editor
		initializeWysiwygEditor();

		// Initialize file attachment handler
		const attachFileBtn = document.getElementById('attach-file');
		const fileInput = document.getElementById('file-input');

		if (attachFileBtn && fileInput) {
			attachFileBtn.addEventListener('click', function() {
				fileInput.click();
			});

			fileInput.addEventListener('change', function(e) {
				handleFileAttachments(e.target.files);
			});
		}

		// Form submission
		const composeForm = document.getElementById('compose-form');
		if (composeForm) {
			composeForm.addEventListener('submit', async function(e) {
				e.preventDefault();
				await sendEmail();
			});
		}

		// Clear form
		const clearFormBtn = document.getElementById('clear-form');
		if (clearFormBtn) {
			clearFormBtn.addEventListener('click', function() {
				if (confirm('Apakah Anda yakin ingin menghapus semua isian form?')) {
					resetComposeForm();
				}
			});
		}

		// Save draft
		const saveDraftBtn = document.getElementById('save-draft-btn');
		if (saveDraftBtn) {
			saveDraftBtn.addEventListener('click', function() {
				saveDraft();
			});
		}

		// Initialize email input handlers
		initializeEmailInputs();

		// Initialize template selector
		initializeTemplateSelector();

		// Initialize file preview modal
		initializeFilePreviewModal();
	});

	function initializeTemplateSelector() {
		const templateSelect = document.getElementById('compose-template');
		if (!templateSelect) return;

		templateSelect.addEventListener('change', function() {
			const selected = this.options[this.selectedIndex];
			if (!selected) return;

			const subject = selected.dataset.subject || '';
			const bodyHtml = decodeTemplateHtml(selected.dataset.bodyHtml || '');

			const subjectInput = document.getElementById('subject');
			if (subject) {
				if (subjectInput) subjectInput.value = subject;
			} else {
				if (subjectInput) subjectInput.value = '';
			}

			const editor = document.getElementById('body-main');
			const hidden = document.getElementById('body');
			if (bodyHtml) {
				if (editor) editor.innerHTML = bodyHtml;
				if (hidden) hidden.value = bodyHtml;
			} else {
				if (editor) editor.innerHTML = '';
				if (hidden) hidden.value = '';
			}
		});
	}

	function decodeTemplateHtml(encoded) {
		const textarea = document.createElement('textarea');
		textarea.innerHTML = encoded;
		return textarea.value;
	}

	// Initialize email input handlers
	function initializeEmailInputs() {
		// Add event listeners for email inputs
		['to', 'cc', 'bcc'].forEach(field => {
			const input = document.getElementById(field);
			if (input) {
				input.addEventListener('keydown', function(e) {
					if (e.key === 'Enter' || e.key === ',') {
						e.preventDefault();
						addEmailTag(field, this.value.trim());
						this.value = '';
					}
				});

				input.addEventListener('blur', function() {
					if (this.value.trim()) {
						addEmailTag(field, this.value.trim());
						this.value = '';
					}
				});
			}
		});
	}

	// Add email tag
	function addEmailTag(field, email) {
		if (!email || !isValidEmail(email)) {
			showValidation(field, 'Format email tidak valid');
			return;
		}

		if (emails[field].includes(email)) {
			showValidation(field, 'Email sudah ditambahkan');
			return;
		}

		emails[field].push(email);
		renderEmailTags(field);
		clearValidation(field);
	}

	// Remove email tag
	function removeEmailTag(field, email) {
		emails[field] = emails[field].filter(e => e !== email);
		renderEmailTags(field);
	}

	// Render email tags
	function renderEmailTags(field) {
		const container = document.querySelector(`#${field}`).parentElement;
		const existingTags = container.querySelectorAll('.email-tag');
		existingTags.forEach(tag => tag.remove());

		emails[field].forEach(email => {
			const tag = document.createElement('div');
			tag.className = 'email-tag';
			tag.innerHTML = `
				<span>${email}</span>
				<span class="remove-tag" onclick="removeEmailTag('${field}', '${email}')">×</span>
			`;
			container.insertBefore(tag, container.querySelector('.email-input'));
		});
	}

	// Focus input
	function focusInput(field) {
		document.getElementById(field).focus();
	}

	// Toggle section
	function toggleSection(field) {
		const section = document.getElementById(field + 'Section');
		const button = document.querySelector(`[onclick="toggleSection('${field}')"]`);
		
		if (section.classList.contains('hidden')) {
			section.classList.remove('hidden');
			button.classList.add('active');
		} else {
			section.classList.add('hidden');
			button.classList.remove('active');
		}
	}

	// Validate email
	function isValidEmail(email) {
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		return emailRegex.test(email);
	}

	// Show validation message
	function showValidation(field, message) {
		const validationDiv = document.getElementById(field + 'Validation');
		if (validationDiv) {
			validationDiv.textContent = message;
			validationDiv.classList.add('show');
			setTimeout(() => {
				validationDiv.classList.remove('show');
			}, 3000);
		}
	}

	// Clear validation message
	function clearValidation(field) {
		const validationDiv = document.getElementById(field + 'Validation');
		if (validationDiv) {
			validationDiv.classList.remove('show');
		}
	}

	// Initialize file preview modal
	function initializeFilePreviewModal() {
		const closePreviewModal = document.getElementById('close-preview-modal');
		const modal = document.getElementById('file-preview-modal');
		
		closePreviewModal.addEventListener('click', function() {
			modal.classList.add('hidden');
		});

		modal.addEventListener('click', function(e) {
			if (e.target === modal) {
				modal.classList.add('hidden');
			}
		});
	}

	// Preview attachment
	function previewAttachment(fileName, fileType) {
		// Find the file in attachments array
		const file = attachments.find(f => f.name === fileName);
		if (!file) return;

		// Set filename in modal
		document.getElementById('preview-filename').textContent = fileName;
		
		// Show modal
		const modal = document.getElementById('file-preview-modal');
		modal.classList.remove('hidden');

		// Generate preview content based on file type
		const previewContent = document.getElementById('preview-content');
		
		if (fileType.startsWith('image/')) {
			// Image preview
			const reader = new FileReader();
			reader.onload = function(e) {
				previewContent.innerHTML = `
					<div class="text-center">
						<img src="${e.target.result}" alt="${fileName}" class="max-w-full max-h-96 mx-auto rounded-lg">
						<p class="text-gray-400 mt-4">${fileName}</p>
						<p class="text-sm text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
					</div>
				`;
			};
			reader.readAsDataURL(file);
		} else if (fileType === 'text/plain' || fileType.startsWith('text/')) {
			// Text file preview
			const reader = new FileReader();
			reader.onload = function(e) {
				previewContent.innerHTML = `
					<div>
						<h4 class="text-white mb-4">${fileName}</h4>
						<pre class="bg-gray-700 p-4 rounded-lg text-white text-sm overflow-auto max-h-96">${e.target.result}</pre>
						<p class="text-sm text-gray-500 mt-2">${(file.size / 1024).toFixed(1)} KB</p>
					</div>
				`;
			};
			reader.readAsText(file);
		} else if (fileType === 'application/pdf') {
			// PDF preview
			const reader = new FileReader();
			reader.onload = function(e) {
				previewContent.innerHTML = `
					<div class="text-center">
						<iframe src="${e.target.result}" width="100%" height="500" class="rounded-lg"></iframe>
						<p class="text-gray-400 mt-4">${fileName}</p>
						<p class="text-sm text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
					</div>
				`;
			};
			reader.readAsDataURL(file);
		} else {
			// Generic file info
			previewContent.innerHTML = `
				<div class="text-center">
					<div class="w-32 h-32 bg-gray-700 rounded-lg flex items-center justify-center mx-auto mb-4">
						<i class="bx bx-file text-6xl text-gray-400"></i>
					</div>
					<h4 class="text-white text-xl mb-2">${fileName}</h4>
					<p class="text-gray-400 mb-2">${fileType}</p>
					<p class="text-sm text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
					<div class="mt-6">
						<button onclick="downloadAttachment('${fileName}')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg mr-2">
							<i class="bx bx-download mr-2"></i>Download
						</button>
						<button onclick="removeAttachment('${fileName}')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
							<i class="bx bx-trash mr-2"></i>Remove
						</button>
					</div>
				</div>
			`;
		}
	}

	// Download attachment
	function downloadAttachment(fileName) {
		const file = attachments.find(f => f.name === fileName);
		if (!file) return;

		const url = URL.createObjectURL(file);
		const a = document.createElement('a');
		a.href = url;
		a.download = fileName;
		document.body.appendChild(a);
		a.click();
		document.body.removeChild(a);
		URL.revokeObjectURL(url);
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
		editor.dispatchEvent(new Event('input', { bubbles: true }));
	}

	function insertLink() {
		const url = prompt('Masukkan URL:');
		if (url) {
			document.execCommand('createLink', false, url);
			document.getElementById('body-main').focus();
			// Trigger input event to update form data
			document.getElementById('body-main').dispatchEvent(new Event('input', { bubbles: true }));
		}
	}

	// Handle file attachments
	function handleFileAttachments(files) {
		Array.from(files).forEach(file => {
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
		attachmentItem.setAttribute('data-filename', file.name);

		// Get file icon based on type
		let icon = '📄';
		if (file.type.startsWith('image/')) icon = '🖼️';
		else if (file.type.startsWith('video/')) icon = '🎥';
		else if (file.type.startsWith('audio/')) icon = '🎵';
		else if (file.type.includes('pdf')) icon = '📕';
		else if (file.type.includes('word')) icon = '📝';
		else if (file.type.includes('excel') || file.type.includes('spreadsheet')) icon = '📊';
		else if (file.type.includes('zip') || file.type.includes('rar')) icon = '📦';

		attachmentItem.innerHTML = `
			<div class="attachment-info" onclick="previewAttachment('${file.name}', '${file.type}')" style="cursor: pointer;">
				<div class="attachment-icon">
					${icon}
				</div>
				<div class="attachment-details">
					<h6>${file.name}</h6>
					<p>${(file.size / 1024).toFixed(1)} KB</p>
				</div>
			</div>
			<button class="attachment-remove" onclick="removeAttachment('${file.name}')">
				<i class="bx bx-x"></i>
			</button>
		`;

		attachmentsList.appendChild(attachmentItem);
	}

	// Remove attachment
	function removeAttachment(fileName) {
		// Remove from attachments array
		attachments = attachments.filter(file => file.name !== fileName);

		// Remove from UI
		const attachmentItems = document.querySelectorAll('.attachment-item');
		attachmentItems.forEach(item => {
			if (item.getAttribute('data-filename') === fileName) {
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

	// Send email
	async function sendEmail() {
		const sendEmailBtn = document.getElementById('send-email');
		
		if (sendEmailBtn) {
			sendEmailBtn.disabled = true;
			sendEmailBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin mr-2"></i>Sending...';
		}

		try {
			// Validate required fields
			if (emails.to.length === 0) {
				showValidation('to', 'Minimal harus ada satu penerima');
				return;
			}

			const subject = document.getElementById('subject').value.trim();
			if (!subject) {
				alert('Subject is required');
				return;
			}

			// Update hidden textarea before sending
			const wysiwygEditor = document.getElementById('body-main');
			const bodyTextarea = document.getElementById('body');
			if (wysiwygEditor && bodyTextarea) {
				bodyTextarea.value = wysiwygEditor.innerHTML;
			}
			
			const message = bodyTextarea ? bodyTextarea.value.trim() : document.getElementById('body-main').innerHTML.trim();
			if (!message || message === '<br>') {
				alert('Message is required');
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
			const draftId = document.getElementById('draft-id').value;
			if (draftId) {
				formData.append('draft_id', draftId);
			}
			
			// Add attachments
			attachments.forEach((file, index) => {
				formData.append(`attachments[${index}]`, file);
			});
			
			// Add CSRF token
			formData.append('_token', document.querySelector('input[name="_token"]').value);
			
			const response = await fetch('{{ route("email.send") }}', {
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
				alert('Email berhasil dikirim!');
				resetComposeForm();
			} else {
				alert('Gagal mengirim email: ' + result.message);
			}

		} catch (error) {
			console.error('Error sending email:', error);
			alert('Terjadi kesalahan saat mengirim email: ' + error.message);
		} finally {
			if (sendEmailBtn) {
				sendEmailBtn.disabled = false;
				sendEmailBtn.innerHTML = '<i class="bx bx-send mr-2"></i>Kirim Email';
			}
		}
	}

	// Save draft
	function saveDraft() {
		const to = document.getElementById('to').value.trim();
		const subject = document.getElementById('subject').value.trim();
		const wysiwygEditor = document.getElementById('body-main');
		const bodyTextarea = document.getElementById('body');
		
		if (wysiwygEditor && bodyTextarea) {
			bodyTextarea.value = wysiwygEditor.innerHTML;
		}
		
		const message = bodyTextarea ? bodyTextarea.value.trim() : document.getElementById('body-main').innerHTML.trim();

		const formData = new FormData();
		formData.append('_token', document.querySelector('input[name="_token"]').value);
		formData.append('draft_id', document.getElementById('draft-id').value);
		formData.append('to', to);
		formData.append('cc', document.getElementById('cc').value.trim());
		formData.append('bcc', document.getElementById('bcc').value.trim());
		formData.append('subject', subject);
		formData.append('body', message);

		attachments.forEach((file, index) => {
			formData.append(`attachments[${index}]`, file);
		});

		fetch('{{ route("email.save-draft") }}', {
			method: 'POST',
			body: formData,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		.then(response => response.json())
		.then(data => {
			if (data.success && data.draft_id) {
				document.getElementById('draft-id').value = data.draft_id;
				alert('Draft berhasil disimpan!');
			} else {
				alert(data.message || 'Gagal menyimpan draft');
			}
		})
		.catch(error => {
			console.error('Error saving draft:', error);
			alert('Terjadi kesalahan saat menyimpan draft');
		});
	}

	function loadDraftFromServer() {
		const params = new URLSearchParams(window.location.search);
		const draftId = params.get('draft_id');
		if (!draftId) {
			return;
		}

		fetch(`/email/draft?draft_id=${draftId}`, {
			headers: {
				'X-Requested-With': 'XMLHttpRequest',
				'Accept': 'application/json'
			}
		})
		.then(response => response.json())
		.then(data => {
			if (data.success && data.draft) {
				document.getElementById('draft-id').value = data.draft.id;
				document.getElementById('to').value = data.draft.email_to || '';
				document.getElementById('cc').value = data.draft.email_cc || '';
				document.getElementById('bcc').value = data.draft.email_bcc || '';
				document.getElementById('subject').value = data.draft.email_subject || '';
				document.getElementById('body-main').innerHTML = data.draft.email_body_html || '';
				emails.to = (data.draft.email_to || '').split(',').map(item => item.trim()).filter(Boolean);
				emails.cc = (data.draft.email_cc || '').split(',').map(item => item.trim()).filter(Boolean);
				emails.bcc = (data.draft.email_bcc || '').split(',').map(item => item.trim()).filter(Boolean);
				['to', 'cc', 'bcc'].forEach(field => {
					renderEmailTags(field);
				});
				if (emails.cc.length > 0) {
					document.getElementById('ccSection').classList.remove('hidden');
					document.querySelector('[onclick="toggleSection(\'cc\')"]').classList.add('active');
				}
				if (emails.bcc.length > 0) {
					document.getElementById('bccSection').classList.remove('hidden');
					document.querySelector('[onclick="toggleSection(\'bcc\')"]').classList.add('active');
				}
			}
		})
		.catch(error => {
			console.error('Error loading draft:', error);
		});
	}

	document.addEventListener('DOMContentLoaded', function() {
		loadDraftFromServer();
	});

	// Reset compose form
	function resetComposeForm() {
		// Clear form fields
		document.getElementById('to').value = '';
		document.getElementById('cc').value = '';
		document.getElementById('bcc').value = '';
		document.getElementById('subject').value = '';
		document.getElementById('body-main').innerHTML = '';
		document.getElementById('body').value = '';
		const templateSelect = document.getElementById('compose-template');
		if (templateSelect) templateSelect.value = '';

		// Clear email arrays
		emails.to = [];
		emails.cc = [];
		emails.bcc = [];

		// Clear email tags
		['to', 'cc', 'bcc'].forEach(field => {
			renderEmailTags(field);
		});

		// Hide CC/BCC sections
		document.getElementById('ccSection').classList.add('hidden');
		document.getElementById('bccSection').classList.add('hidden');
		document.querySelector('[onclick="toggleSection(\'cc\')"]').classList.remove('active');
		document.querySelector('[onclick="toggleSection(\'bcc\')"]').classList.remove('active');

		// Clear attachments
		attachments = [];
		const attachmentsList = document.getElementById('attachments-list');
		if (attachmentsList) {
			attachmentsList.innerHTML = '';
		}
		const attachmentsContainer = document.getElementById('attachments-container');
		if (attachmentsContainer) {
			attachmentsContainer.classList.add('hidden');
		}
	}
</script>
</div>
</div>
</x-dashonic-horizontal-layout>
