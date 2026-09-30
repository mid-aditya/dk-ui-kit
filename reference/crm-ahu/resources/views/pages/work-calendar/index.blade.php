<x-dashonic-horizontal-layout sidebar="0">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="mb-8 mt-8 ml-3">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <i class="fa fa-calendar-alt text-blue-500 mr-3 text-4xl"></i>
                        Work Calendar
                    </h1>
                    <p class="mt-2 text-gray-400 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Kelola hari libur nasional dan pemerintahan untuk perhitungan SLA
                    </p>
                </div>
                <div class="text-right bg-gray-800/50 p-3 rounded-lg shadow-lg">
                    <div class="text-gray-300 text-lg font-semibold" id="currentDateTime"></div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-12">
                <div class="card bg-gray-800 border-0">
                    <div class="card-body">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex gap-2">
                                <button type="button"
                                    class="btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center"
                                    onclick="openCreateModal()">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Hari Libur
                                </button>
                                <button type="button"
                                    class="btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center"
                                    onclick="openBulkModal()">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Import Bulk
                                </button>
                            </div>
                            <div class="flex gap-2">
                                <select id="filterYear"
                                    class="form-select bg-gray-700 text-white border-gray-600 rounded-lg px-3 py-2"
                                    onchange="loadCalendars()">
                                    @for ($y = date('Y') - 1; $y <= date('Y') + 2; $y++)
                                        <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>
                                            {{ $y }}</option>
                                    @endfor
                                </select>
                                <select id="filterCategory"
                                    class="form-select bg-gray-700 text-white border-gray-600 rounded-lg px-3 py-2"
                                    onchange="loadCalendars()">
                                    <option value="">Semua Kategori</option>
                                    <option value="national">Libur Nasional</option>
                                    <option value="government">Libur Pemerintahan</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success bg-green-100 text-green-800 rounded-lg p-4 mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger bg-red-100 text-red-800 rounded-lg p-4 mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            No</th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Nama</th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Kategori</th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Template</th>
                                        <th
                                            class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="calendarTableBody" class="bg-gray-800 divide-y divide-gray-700">
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <div id="loadingSpinner" class="text-center py-8 hidden">
                            <i class="fas fa-spinner fa-spin text-4xl text-blue-500"></i>
                            <p class="text-gray-400 mt-2">Loading...</p>
                        </div>

                        <div id="pagination" class="d-flex justify-content-center mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-gray-800 text-white">
                <div class="modal-header border-gray-700">
                    <h5 class="modal-title" id="calendarModalLabel">Tambah Hari Libur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="calendarForm">
                        <input type="hidden" id="editId" value="">
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control bg-gray-700 border-gray-600 focus:bg-gray-700 disabled:bg-gray-700" id="date"
                                required style="color: #e5e7eb !important;">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Hari Libur</label>
                            <input type="text" class="form-control bg-gray-700 border-gray-600 focus:bg-gray-700 disabled:bg-gray-700" id="name"
                                placeholder="Contoh: Hari Kemerdekaan" required style="color: #e5e7eb !important;">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select bg-gray-700 text-white border-gray-600 focus:bg-gray-700 disabled:bg-gray-700" id="category"
                                required>
                                <option value="national">Libur Nasional</option>
                                <option value="government">Libur Pemerintahan</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control bg-gray-700 border-gray-600 focus:bg-gray-700 disabled:bg-gray-700" id="description" rows="2"
                                style="color: #e5e7eb !important;"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" checked>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-gray-700">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveCalendar()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Import Modal -->
    <div class="modal fade" id="bulkModal" tabindex="-1" aria-labelledby="bulkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-gray-800 text-white">
                <div class="modal-header border-gray-700">
                    <h5 class="modal-title" id="bulkModalLabel">Import Bulk Hari Libur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info bg-blue-900 text-blue-200 border-blue-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        Format JSON: <code>[{"date": "2026-01-01", "name": "Tahun Baru", "category": "national"},
                            ...]</code>
                    </div>
                    <div class="mb-3">
                        <label for="bulkJson" class="form-label">Data JSON</label>
                        <textarea class="form-control bg-gray-700 text-white border-gray-600 font-mono" id="bulkJson" rows="10"
                            placeholder='[{"date": "2026-01-01", "name": "Tahun Baru", "category": "national"}]'></textarea>
                    </div>
                    <button type="button" class="btn btn-outline-info" onclick="loadSampleHolidays()">
                        <i class="fas fa-download mr-1"></i> Load Contoh Hari Libur 2026
                    </button>
                </div>
                <div class="modal-footer border-gray-700">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="importBulk()">Import</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Autoreply Template Modal -->
    <div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-gray-800 text-white">
                <div class="modal-header border-gray-700">
                    <h5 class="modal-title" id="templateModalLabel">Template Email Autoreply</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="templateCalendarId">

                    <div class="mb-3 rounded-lg border border-gray-700 bg-gray-900/50 px-3 py-2 focus:bg-gray-700 disabled:bg-gray-700">
                        <div class="text-xs text-gray-400">Tanggal Work Calendar</div>
                        <div id="templateCalendarLabel" class="text-sm text-white">-</div>
                    </div>

                    <div class="mb-3">
                        <label for="templateSubject" class="form-label">Subject (Opsional)</label>
                        <input type="text" id="templateSubject" class="form-control bg-gray-700 text-white border-gray-600 focus:bg-gray-700 disabled:bg-gray-700"
                            placeholder="Subject email autoreply">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Body (HTML)</label>
                        <div class="wysiwyg-container">
                            <div class="wysiwyg-toolbar">
                                <button type="button" class="wysiwyg-btn" onclick="formatWorkCalendarTemplateText('bold')"
                                    title="Bold"><b>B</b></button>
                                <button type="button" class="wysiwyg-btn" onclick="formatWorkCalendarTemplateText('italic')"
                                    title="Italic"><i>I</i></button>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatWorkCalendarTemplateText('underline')" title="Underline"><u>U</u></button>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatWorkCalendarTemplateText('strikeThrough')"
                                    title="Strikethrough"><s>S</s></button>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatWorkCalendarTemplateText('insertUnorderedList')" title="Bullet List">&bull;</button>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatWorkCalendarTemplateText('insertOrderedList')" title="Numbered List">1.</button>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatWorkCalendarTemplateText('justifyLeft')" title="Align Left">L</button>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatWorkCalendarTemplateText('justifyCenter')" title="Align Center">C</button>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatWorkCalendarTemplateText('justifyRight')" title="Align Right">R</button>
                                <button type="button" class="wysiwyg-btn" onclick="insertWorkCalendarTemplateLink()"
                                    title="Insert Link">Link</button>
                                <button type="button" class="wysiwyg-btn"
                                    onclick="formatWorkCalendarTemplateText('removeFormat')" title="Clear Format">X</button>
                            </div>
                            <div class="wysiwyg-editor" id="templateBodyHtmlEditor" contenteditable="true"
                                placeholder="Tulis isi autoreply di sini..."></div>
                        </div>
                        <textarea id="templateBodyHtml" style="display:none;"></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="templateIsActive" checked>
                        <label class="form-check-label" for="templateIsActive">Aktif</label>
                    </div>

                    <div id="templateHelper" class="text-xs"></div>
                </div>
                <div class="modal-footer border-gray-700">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-warning text-dark" onclick="saveTemplate()">
                        Simpan Template
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="css">
        <style>
            .wysiwyg-container {
                border: 1px solid #4b5563;
                border-radius: 0.5rem;
                background-color: #1f2937;
                overflow: hidden;
            }

            .wysiwyg-container:focus-within {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .wysiwyg-toolbar {
                display: flex;
                align-items: center;
                padding: 0.5rem;
                background-color: #374151;
                border-bottom: 1px solid #4b5563;
                gap: 0.25rem;
                flex-wrap: wrap;
            }

            .wysiwyg-btn {
                padding: 0.5rem;
                background-color: transparent;
                border: 1px solid transparent;
                border-radius: 0.25rem;
                color: #d1d5db;
                cursor: pointer;
                transition: all 0.2s;
                font-size: 0.875rem;
                min-width: 2rem;
                text-align: center;
                user-select: none;
            }

            .wysiwyg-btn:hover {
                background-color: #4b5563;
                border-color: #6b7280;
                color: #ffffff;
            }

            .wysiwyg-editor {
                min-height: 220px;
                padding: 1rem;
                color: #ffffff;
                outline: none;
                line-height: 1.6;
                background-color: #1f2937;
            }

            .wysiwyg-editor:empty:before {
                content: attr(placeholder);
                color: #9ca3af;
                pointer-events: none;
            }

            .wysiwyg-editor ul,
            .wysiwyg-editor ol {
                margin: 0.5rem 0;
                padding-left: 1.5rem;
            }
        </style>
    </x-slot>

    <x-slot name="js">
        <script>
            const API_BASE = '/api/work-calendar';
            const CURRENT_COMPANY_ID = @json((int) (current_agent()->company_id ?? 0));
            let currentPage = 1;

            function stripWorkCalendarTailwindStyleVars(html) {
                if (!html) return html;

                try {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = html;

                    wrapper.querySelectorAll('script').forEach((el) => el.remove());

                    wrapper.querySelectorAll('[style]').forEach((el) => {
                        const style = (el.getAttribute('style') || '');
                        if (!style.includes('--tw-')) return;

                        const kept = style
                            .split(';')
                            .map((s) => s.trim())
                            .filter(Boolean)
                            .filter((s) => !s.startsWith('--tw-'));

                        if (kept.length === 0) el.removeAttribute('style');
                        else el.setAttribute('style', kept.join('; ') + ';');
                    });

                    return wrapper.innerHTML;
                } catch (e) {
                    return html;
                }
            }

            function setWorkCalendarTemplateBodyHtml(html) {
                const editor = document.getElementById('templateBodyHtmlEditor');
                const hidden = document.getElementById('templateBodyHtml');
                if (!editor || !hidden) return;

                const cleaned = stripWorkCalendarTailwindStyleVars(html || '');
                editor.innerHTML = cleaned;
                hidden.value = cleaned;
            }

            function getWorkCalendarTemplateBodyHtml() {
                const editor = document.getElementById('templateBodyHtmlEditor');
                const hidden = document.getElementById('templateBodyHtml');
                if (!editor || !hidden) return '';

                const cleaned = stripWorkCalendarTailwindStyleVars(editor.innerHTML || '');
                hidden.value = cleaned;
                return cleaned;
            }

            document.addEventListener('DOMContentLoaded', function() {
                const editor = document.getElementById('templateBodyHtmlEditor');
                const hidden = document.getElementById('templateBodyHtml');
                if (!editor || !hidden) return;

                editor.addEventListener('input', function() {
                    hidden.value = stripWorkCalendarTailwindStyleVars(editor.innerHTML || '');
                });
            });

            function formatWorkCalendarTemplateText(command, value = null) {
                const editor = document.getElementById('templateBodyHtmlEditor');
                if (editor) editor.focus();
                document.execCommand(command, false, value);
                getWorkCalendarTemplateBodyHtml();
            }

            function insertWorkCalendarTemplateLink() {
                const url = prompt('Enter URL:');
                if (url) formatWorkCalendarTemplateText('createLink', url);
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

            function loadCalendars(page = 1) {
                currentPage = page;
                const year = document.getElementById('filterYear').value;
                const category = document.getElementById('filterCategory').value;

                document.getElementById('loadingSpinner').classList.remove('hidden');
                document.getElementById('calendarTableBody').innerHTML = '';

                let url = `${API_BASE}?year=${year}&page=${page}&per_page=15`;
                if (category) url += `&category=${category}`;

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        document.getElementById('loadingSpinner').classList.add('hidden');
                        renderTable(response.data.data, response.data.from || 1);
                        renderPagination(response.data);
                    },
                    error: function(xhr) {
                        document.getElementById('loadingSpinner').classList.add('hidden');
                        Swal.fire('Error', 'Gagal memuat data', 'error');
                    }
                });
            }

            function renderTable(data, startNum) {
                const tbody = document.getElementById('calendarTableBody');
                if (!data || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center text-gray-400 py-8">Tidak ada data</td></tr>';
                    return;
                }

                let html = '';
                data.forEach((item, index) => {
                    const categoryBadge = getCategoryBadge(item.category);
                    const statusBadge = item.is_active ?
                        '<span class="badge bg-green-600">Aktif</span>' :
                        '<span class="badge bg-gray-600">Non-Aktif</span>';

                    html += `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${startNum + index}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${formatDate(item.date)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${item.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${categoryBadge}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${statusBadge}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="openTemplateModal(${item.id})">
                                    <i class="fas fa-envelope mr-1"></i> Template
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" class="btn btn-info btn-sm mr-1" onclick="editCalendar(${item.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteCalendar(${item.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
                tbody.innerHTML = html;
            }

            function getCategoryBadge(category) {
                const badges = {
                    'national': '<span class="badge bg-red-600">Libur Nasional</span>',
                    'government': '<span class="badge bg-yellow-600">Libur Pemerintahan</span>',
                    'custom': '<span class="badge bg-purple-600">Custom</span>'
                };
                return badges[category] || category;
            }

            function formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('id-ID', {
                    weekday: 'short',
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function renderPagination(data) {
                if (!data.last_page || data.last_page <= 1) {
                    document.getElementById('pagination').innerHTML = '';
                    return;
                }

                let html = '<nav><ul class="pagination">';
                for (let i = 1; i <= data.last_page; i++) {
                    html += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="loadCalendars(${i}); return false;">${i}</a>
                    </li>`;
                }
                html += '</ul></nav>';
                document.getElementById('pagination').innerHTML = html;
            }

            function openCreateModal() {
                document.getElementById('editId').value = '';
                document.getElementById('calendarForm').reset();
                document.getElementById('is_active').checked = true;
                document.getElementById('calendarModalLabel').textContent = 'Tambah Hari Libur';
                new bootstrap.Modal(document.getElementById('calendarModal')).show();
            }

            function editCalendar(id) {
                $.ajax({
                    url: `${API_BASE}/${id}`,
                    type: 'GET',
                    success: function(response) {
                        const data = response.data;
                        document.getElementById('editId').value = data.id;
                        document.getElementById('date').value = data.date.split('T')[0];
                        document.getElementById('name').value = data.name;
                        document.getElementById('category').value = data.category;
                        document.getElementById('description').value = data.description || '';
                        document.getElementById('is_active').checked = data.is_active;
                        document.getElementById('calendarModalLabel').textContent = 'Edit Hari Libur';
                        new bootstrap.Modal(document.getElementById('calendarModal')).show();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Gagal memuat data', 'error');
                    }
                });
            }

            function saveCalendar() {
                const id = document.getElementById('editId').value;
                const data = {
                    date: document.getElementById('date').value,
                    name: document.getElementById('name').value,
                    category: document.getElementById('category').value,
                    description: document.getElementById('description').value,
                    is_active: document.getElementById('is_active').checked
                };

                if (CURRENT_COMPANY_ID > 0) {
                    data.company_id = CURRENT_COMPANY_ID;
                }

                const url = id ? `${API_BASE}/${id}` : API_BASE;
                const method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        bootstrap.Modal.getInstance(document.getElementById('calendarModal')).hide();
                        Swal.fire('Sukses', response.message, 'success');
                        loadCalendars(currentPage);
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        Swal.fire('Error', error.message || 'Gagal menyimpan data', 'error');
                    }
                });
            }

            function deleteCalendar(id) {
                Swal.fire({
                    title: 'Hapus Hari Libur?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `${API_BASE}/${id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Dihapus!', response.message, 'success');
                                loadCalendars(currentPage);
                            },
                            error: function(xhr) {
                                Swal.fire('Error', 'Gagal menghapus data', 'error');
                            }
                        });
                    }
                });
            }

            function openBulkModal() {
                document.getElementById('bulkJson').value = '';
                new bootstrap.Modal(document.getElementById('bulkModal')).show();
            }

            function openTemplateModal(id) {
                document.getElementById('templateCalendarId').value = id;
                document.getElementById('templateCalendarLabel').textContent = 'Memuat data...';
                document.getElementById('templateSubject').value = '';
                setWorkCalendarTemplateBodyHtml('');
                document.getElementById('templateIsActive').checked = true;
                document.getElementById('templateHelper').innerHTML = '';

                new bootstrap.Modal(document.getElementById('templateModal')).show();

                $.ajax({
                    url: `${API_BASE}/${id}/autoreply-template?company_id=${CURRENT_COMPANY_ID}`,
                    type: 'GET',
                    success: function(response) {
                        const data = response.data || {};
                        const calendar = data.calendar || {};
                        const template = data.template || null;
                        const defaultTemplate = data.default_template || null;
                        const isHoliday = !!data.is_holiday;

                        const label = `${calendar.name || '-'} (${(calendar.date || '').toString().substring(0, 10)})`;
                        document.getElementById('templateCalendarLabel').textContent = label;

                        if (template) {
                            document.getElementById('templateSubject').value = template.subject || '';
                            setWorkCalendarTemplateBodyHtml(template.body_html || '');
                            document.getElementById('templateIsActive').checked = !!template.is_active;
                            document.getElementById('templateHelper').innerHTML =
                                '<span class="text-green-300">Template override sudah ada. Silakan edit lalu simpan.</span>';
                        } else {
                            document.getElementById('templateSubject').value = (defaultTemplate && defaultTemplate.subject) || '';
                            setWorkCalendarTemplateBodyHtml((defaultTemplate && defaultTemplate.body_html) || '');
                            document.getElementById('templateIsActive').checked = true;
                            document.getElementById('templateHelper').innerHTML =
                                '<span class="text-yellow-300">Belum ada template override. Form sudah diisi dari template default weekend/holiday (jika ada).</span>';
                        }

                        if (!isHoliday) {
                            document.getElementById('templateHelper').innerHTML +=
                                '<div class="mt-2 text-orange-300">Catatan: tanggal ini bertipe workday, jadi template biasanya tidak terpakai saat pengiriman autoreply.</div>';
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON || {};
                        document.getElementById('templateCalendarLabel').textContent = 'Gagal memuat data';
                        Swal.fire('Error', error.message || 'Gagal memuat template', 'error');
                    }
                });
            }

            function saveTemplate() {
                const id = document.getElementById('templateCalendarId').value;
                const payload = {
                    subject: document.getElementById('templateSubject').value,
                    body_html: getWorkCalendarTemplateBodyHtml(),
                    is_active: document.getElementById('templateIsActive').checked,
                    company_id: CURRENT_COMPANY_ID
                };

                $.ajax({
                    url: `${API_BASE}/${id}/autoreply-template`,
                    type: 'PUT',
                    data: payload,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Sukses', response.message, 'success');
                        loadCalendars(currentPage);
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON || {};
                        Swal.fire('Error', error.message || 'Gagal menyimpan template', 'error');
                    }
                });
            }

            function loadSampleHolidays() {
                const sample = [{
                        "date": "2026-01-01",
                        "name": "Tahun Baru Masehi",
                        "category": "national"
                    },
                    {
                        "date": "2026-01-29",
                        "name": "Tahun Baru Imlek",
                        "category": "national"
                    },
                    {
                        "date": "2026-03-20",
                        "name": "Hari Raya Nyepi",
                        "category": "national"
                    },
                    {
                        "date": "2026-03-31",
                        "name": "Idul Fitri",
                        "category": "national"
                    },
                    {
                        "date": "2026-04-01",
                        "name": "Idul Fitri",
                        "category": "national"
                    },
                    {
                        "date": "2026-04-03",
                        "name": "Wafat Isa Almasih",
                        "category": "national"
                    },
                    {
                        "date": "2026-05-01",
                        "name": "Hari Buruh",
                        "category": "national"
                    },
                    {
                        "date": "2026-05-14",
                        "name": "Kenaikan Isa Almasih",
                        "category": "national"
                    },
                    {
                        "date": "2026-05-26",
                        "name": "Hari Raya Waisak",
                        "category": "national"
                    },
                    {
                        "date": "2026-06-01",
                        "name": "Hari Lahir Pancasila",
                        "category": "national"
                    },
                    {
                        "date": "2026-06-07",
                        "name": "Idul Adha",
                        "category": "national"
                    },
                    {
                        "date": "2026-06-27",
                        "name": "Tahun Baru Hijriah",
                        "category": "national"
                    },
                    {
                        "date": "2026-08-17",
                        "name": "Hari Kemerdekaan RI",
                        "category": "national"
                    },
                    {
                        "date": "2026-09-05",
                        "name": "Maulid Nabi Muhammad",
                        "category": "national"
                    },
                    {
                        "date": "2026-12-25",
                        "name": "Hari Natal",
                        "category": "national"
                    }
                ];
                document.getElementById('bulkJson').value = JSON.stringify(sample, null, 2);
            }

            function importBulk() {
                let jsonData;
                try {
                    jsonData = JSON.parse(document.getElementById('bulkJson').value);
                } catch (e) {
                    Swal.fire('Error', 'Format JSON tidak valid', 'error');
                    return;
                }

                const payload = (jsonData || []).map(item => ({
                    ...item,
                    company_id: item.company_id ?? (CURRENT_COMPANY_ID > 0 ? CURRENT_COMPANY_ID : null)
                }));

                $.ajax({
                    url: `${API_BASE}/bulk`,
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        holidays: payload
                    }),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        bootstrap.Modal.getInstance(document.getElementById('bulkModal')).hide();
                        Swal.fire('Sukses',
                            `${response.data.created_count} data berhasil diimport, ${response.data.skipped_count} dilewati`,
                            'success');
                        loadCalendars();
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        Swal.fire('Error', error.message || 'Gagal import data', 'error');
                    }
                });
            }

            $(document).ready(function() {
                updateDateTime();
                setInterval(updateDateTime, 1000);
                loadCalendars();
            });
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
