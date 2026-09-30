<x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
	with-header="{{ request()->get('with-header') ?? 0 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">
	<div class="mt-2 relative h-[calc(100vh-1rem)] overflow-hidden">
		<div class="flex gap-2 h-[calc(100vh-1rem)]">
			<div class="flex-1 min-w-0">
				<div class="bg-gray-800 rounded-lg p-6 h-full flex flex-col">
					<div class="flex items-center justify-between mb-6">
						<h1 class="text-2xl font-bold text-white flex items-center">
							<i class="bx bx-file text-blue-500 mr-3 text-3xl"></i>
							Email Templates
						</h1>
						<a href="{{ route('email.index') }}"
							class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
							Kembali ke Email
						</a>
					</div>

					@if (session('success'))
						<div class="bg-green-700/30 text-green-200 px-4 py-3 rounded-lg mb-4">
							{{ session('success') }}
						</div>
					@endif

					@if ($errors->any())
						<div class="bg-red-700/30 text-red-200 px-4 py-3 rounded-lg mb-4">
							<ul class="list-disc list-inside space-y-1">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">
						<div class="lg:col-span-2 bg-gray-900 rounded-lg p-4 overflow-auto">
							<h2 class="text-lg font-semibold text-white mb-4">Daftar Template</h2>
							<div class="overflow-x-auto">
								<table class="min-w-full divide-y divide-gray-700">
									<thead class="bg-gray-700">
										<tr>
											<th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Nama</th>
											<th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Subject</th>
											<th class="px-4 py-3 text-right text-xs font-medium text-gray-300 uppercase">Aksi</th>
										</tr>
									</thead>
									<tbody class="divide-y divide-gray-700">
										@forelse ($templates as $template)
											<tr>
												<td class="px-4 py-3 text-sm text-white">{{ $template->name }}</td>
												<td class="px-4 py-3 text-sm text-gray-300">{{ $template->subject ?? '-' }}</td>
												<td class="px-4 py-3 text-right text-sm">
													<a href="{{ route('email.templates.index', ['edit' => $template->id]) }}"
														class="text-blue-400 hover:text-blue-300 mr-3">Edit</a>
													<form action="{{ route('email.templates.delete', $template->id) }}" method="post" class="inline">
														@csrf
														@method('delete')
														<button type="submit" class="text-red-400 hover:text-red-300"
															onclick="return confirm('Hapus template ini?')">Hapus</button>
													</form>
												</td>
											</tr>
										@empty
											<tr>
												<td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada template</td>
											</tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>

						<div class="bg-gray-900 rounded-lg p-4 overflow-auto">
							<h2 class="text-lg font-semibold text-white mb-4">
								{{ $editingTemplate ? 'Edit Template' : 'Buat Template' }}
							</h2>
							<form
								action="{{ $editingTemplate ? route('email.templates.update', $editingTemplate->id) : route('email.templates.store') }}"
								method="post">
								@csrf
								@if ($editingTemplate)
									@method('put')
								@endif
								<div class="mb-4">
									<label class="block text-sm text-gray-300 mb-2">Nama Template</label>
									<input type="text" name="name"
										value="{{ old('name', $editingTemplate->name ?? '') }}"
										class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2">
								</div>
								<div class="mb-4">
									<label class="block text-sm text-gray-300 mb-2">Subject (Opsional)</label>
									<input type="text" name="subject"
										value="{{ old('subject', $editingTemplate->subject ?? '') }}"
										class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2">
								</div>
								<div class="mb-4">
									<label class="block text-sm text-gray-300 mb-2">Body (HTML)</label>
									<div class="wysiwyg-container">
										<div class="wysiwyg-toolbar">
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('bold')" title="Bold"><b>B</b></button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('italic')" title="Italic"><i>I</i></button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('underline')" title="Underline"><u>U</u></button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('strikeThrough')" title="Strikethrough"><s>S</s></button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('insertUnorderedList')" title="Bullet List">•</button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('insertOrderedList')" title="Numbered List">1.</button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('justifyLeft')" title="Align Left">⌐</button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('justifyCenter')" title="Align Center">≡</button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('justifyRight')" title="Align Right">⌐</button>
											<button type="button" class="wysiwyg-btn" onclick="insertTemplateLink()" title="Insert Link">🔗</button>
											<button type="button" class="wysiwyg-btn" onclick="formatTemplateText('removeFormat')" title="Clear Format">✗</button>
										</div>
										<div class="wysiwyg-editor" id="template-body-editor" contenteditable="true"
											placeholder="Tulis isi template di sini..."></div>
									</div>
									<textarea name="body_html" id="template-body" style="display: none;">{{ old('body_html', $editingTemplate->body_html ?? '') }}</textarea>
								</div>
								<div class="flex items-center gap-2">
									<button type="submit"
										class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
										{{ $editingTemplate ? 'Update' : 'Simpan' }}
									</button>
									@if ($editingTemplate)
										<a href="{{ route('email.templates.index') }}"
											class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Batal</a>
									@endif
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<x-slot name="css">
	<style>
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
	</style>
</x-slot>

<x-slot name="js">
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const editor = document.getElementById('template-body-editor');
			const hidden = document.getElementById('template-body');
			if (editor && hidden) {
				editor.innerHTML = hidden.value || '';
				editor.addEventListener('input', function() {
					hidden.value = editor.innerHTML;
				});
			}
		});

		function formatTemplateText(command, value = null) {
			document.execCommand(command, false, value);
		}

		function insertTemplateLink() {
			const url = prompt('Enter URL:');
			if (url) {
				formatTemplateText('createLink', url);
			}
		}
	</script>
</x-slot>

</x-dashonic-horizontal-layout>
