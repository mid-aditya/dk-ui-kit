<h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Outbound Blasting</h3>

<section class="mb-8">
    <div class="mb-4">
        <h4 class="text-lg font-semibold text-white">WhatsApp Blasting</h4>
        <p class="text-sm text-gray-400">Template HSM, template plain text, dan blast WhatsApp official.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
        <a href="{{ route('wa-message-template-categories.index') }}" class="block h-full group">
            <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                <div class="flex items-center gap-4">
                    <i class="bx bx-category text-2xl text-blue-300 group-hover:text-white"></i>
                    <div>
                        <h4 class="text-base font-medium text-white">Template Category & Variables</h4>
                        <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage variable mapping for HSM templates</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('wa-message-templates.index') }}" class="block h-full group">
            <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                <div class="flex items-center gap-4">
                    <i class="bx bxl-whatsapp text-2xl text-blue-300 group-hover:text-white"></i>
                    <div>
                        <h4 class="text-base font-medium text-white">HSM Message Templates</h4>
                        <p class="text-xs text-gray-300 group-hover:text-gray-100">Create, submit, and sync Meta templates</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('outbound-hsm') }}" class="block h-full group">
            <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                <div class="flex items-center gap-4">
                    <i class="bx bx-send text-2xl text-blue-300 group-hover:text-white"></i>
                    <div>
                        <h4 class="text-base font-medium text-white">Blast WhatsApp</h4>
                        <p class="text-xs text-gray-300 group-hover:text-gray-100">Send using approved HSM templates</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>

<section class="mb-8">
    <div class="mb-4">
        <h4 class="text-lg font-semibold text-white">Email Blasting</h4>
        <p class="text-sm text-gray-400">Template, variable, dan batch blast khusus email.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
        <a href="{{ route('outbound-email-template-categories.index') }}" class="block h-full group">
            <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                <div class="flex items-center gap-4">
                    <i class="bx bx-category-alt text-2xl text-blue-300 group-hover:text-white"></i>
                    <div>
                        <h4 class="text-base font-medium text-white">Email Category & Variables</h4>
                        <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage variable mapping for email blast</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('outbound-email-templates.index') }}" class="block h-full group">
            <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                <div class="flex items-center gap-4">
                    <i class="bx bx-envelope text-2xl text-blue-300 group-hover:text-white"></i>
                    <div>
                        <h4 class="text-base font-medium text-white">Outbound Email Templates</h4>
                        <p class="text-xs text-gray-300 group-hover:text-gray-100">Create email templates for blasting</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('outbound-email-blast') }}" class="block h-full group">
            <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                <div class="flex items-center gap-4">
                    <i class="bx bx-mail-send text-2xl text-blue-300 group-hover:text-white"></i>
                    <div>
                        <h4 class="text-base font-medium text-white">Blast Email</h4>
                        <p class="text-xs text-gray-300 group-hover:text-gray-100">Send email batch from import data</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>

<section>
    <div class="mb-4">
        <h4 class="text-lg font-semibold text-white">Data & History</h4>
        <p class="text-sm text-gray-400">Dataset import dan riwayat eksekusi semua channel blasting.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
        <a href="{{ route('outbound.tickets.index') }}" class="block h-full group">
            <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                <div class="flex items-center gap-4">
                    <i class="bx bx-import text-2xl text-blue-300 group-hover:text-white"></i>
                    <div>
                        <h4 class="text-base font-medium text-white">Import Data</h4>
                        <p class="text-xs text-gray-300 group-hover:text-gray-100">Prepare WhatsApp and email blast datasets</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('chat.v3.report.blast-history') }}" class="block h-full group">
            <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                <div class="flex items-center gap-4">
                    <i class="bx bx-history text-2xl text-blue-300 group-hover:text-white"></i>
                    <div>
                        <h4 class="text-base font-medium text-white">Blast History</h4>
                        <p class="text-xs text-gray-300 group-hover:text-gray-100">Review outbound blast execution history</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>
