<x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
    with-header="{{ request()->get('with-header') ?? 1 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">
    <div class="container mx-auto px-2 py-2 bg-gray-900">
        <!-- Header -->
        <!-- <header class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-cogs text-blue-400 text-3xl sm:text-4xl"></i>
                    Company Settings
                </h1>
                <p class="mt-2 text-gray-300 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-user-circle text-gray-400"></i>
                    Welcome back, {{ auth()->user()->name }}
                </p>
            </div>
            <div class="bg-gray-800 p-3 rounded-xl shadow-md text-gray-200 text-right">
                <div id="currentDateTime" class="text-sm sm:text-base"></div>
            </div>
        </header> -->

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <aside class="w-full lg:w-80 bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-4 bg-gray-800">
                    <h2 class="text-lg font-semibold text-white">Settings Menu</h2>
                </div>
                <nav class="flex flex-col">
                    @if(current_agent()->company_id == 40 && auth()->user()->is_user_leader == 1)
                        <!-- Leader: Only Data Outbound -->
                    @elseif (current_agent()->company_id == 40 && current_agent()->user_type == 'owner')
                        <!-- Owner: All Tabs -->
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('general')"
                            data-tab="general">
                            <i class="fas fa-cog text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">General</span>
                                <p class="text-xs text-gray-400">Common Configuration setting</p>
                            </div>
                        </button>
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('email-setting')"
                            data-tab="email-setting">
                            <i class="bx bx-envelope text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">Email Setting</span>
                                <p class="text-xs text-gray-400">SMTP dan autoreply email</p>
                            </div>
                        </button>
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('outbound-blasting')"
                            data-tab="outbound-blasting">
                            <i class="bx bx-send text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">Outbound Blasting</span>
                                <p class="text-xs text-gray-400">Template dan blast outbound</p>
                            </div>
                        </button>
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('formbuilder')"
                            data-tab="formbuilder">
                            <i class="bx bx-buildings text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">Form Builder Ticket</span>
                                <p class="text-xs text-gray-400">Custom Field Form Builder</p>
                            </div>
                        </button>
                    @else
                        <!-- Other Users: All Tabs -->
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('general')"
                            data-tab="general">
                            <i class="fas fa-cog text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">General</span>
                                <p class="text-xs text-gray-400">Common Configuration setting</p>
                            </div>
                        </button>
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('email-setting')"
                            data-tab="email-setting">
                            <i class="bx bx-envelope text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">Email Setting</span>
                                <p class="text-xs text-gray-400">SMTP dan autoreply email</p>
                            </div>
                        </button>
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('outbound-blasting')"
                            data-tab="outbound-blasting">
                            <i class="bx bx-send text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">Outbound Blasting</span>
                                <p class="text-xs text-gray-400">Template dan blast outbound</p>
                            </div>
                        </button>
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('formbuilder-ticket')"
                            data-tab="formbuilder-ticket">
                            <i class="bx bx-buildings text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">Form Builder Ticket</span>
                                <p class="text-xs text-gray-400">Custom Field Form Builder</p>
                            </div>
                        </button>
                        <button
                            class="menu-item flex items-start gap-3 p-4 text-gray-200 hover:bg-gray-700 focus:bg-blue-500 focus:text-white transition-all duration-200"
                            onclick="showTab('master-data')"
                            data-tab="master-data">
                            <i class="bx bx-buildings text-xl"></i>
                            <div class="text-left">
                                <span class="font-medium">Master Data</span>
                                <p class="text-xs text-gray-400">Manage Master Data</p>
                            </div>
                        </button>
                    @endif
                </nav>
            </aside>

            <!-- Content Area -->
            <main class="flex-1 bg-gray-800 rounded-2xl shadow-lg p-6 overflow-y-auto">
                <div id="settingsTabsContent">
                    @if(current_agent()->company_id == 40 && auth()->user()->is_user_leader == 1)
                        <div id="general" class="tab-content">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Settings</h3>
                            <div class="rounded-lg bg-gray-700 p-6 text-gray-300">
                                Menu settings sementara belum tersedia.
                            </div>
                        </div>
                    @elseif (current_agent()->company_id == 40 && current_agent()->user_type == 'owner')
                        <!-- Owner: All Tabs -->
                        <div id="general" class="tab-content">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">General Settings</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('group-route.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-users text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Group Route</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Group Route</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.config.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-cogs text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Config</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Config</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('chat.v3.ticket.kirana.execution.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-violet-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="bx bx-play-circle text-2xl text-violet-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Kirana Execute Manual</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Run manual sync and batch process</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div id="email-setting" class="tab-content hidden">
                            @include('pages.company.setting.partials.email-setting-cards')
                        </div>
                        <div id="key1" class="tab-content hidden">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Data Ticket Settings</h3>
                            @if (get_config('msg.category.form', current_agent()->company_id) == '1')
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('company.master.status.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Status</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Status</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.master.priority.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Priority</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Priority</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.master.category.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.master.category-type.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Sub Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Sub Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('articles.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Article</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Knowledge Base</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                        <div id="key2" class="tab-content hidden">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Data Outbound Settings</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('outbound.status') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Status</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Status</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('outbound.priority') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Priority</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Priority</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('outbound.kategori') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('outbound.subkategori') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Sub Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Sub Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div id="outbound-blasting" class="tab-content hidden">
                            @include('pages.company.setting.partials.outbound-blasting-cards')
                        </div>
                        <div id="formbuilder" class="tab-content hidden">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Form Builder Ticket Settings</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('company.master.status.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Status</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Status</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.master.priority.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Priority</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Priority</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.kategori') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-tags text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Kategori</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Kategori for form</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.jenis') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-clipboard-list text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Jenis Pengaduan</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Jenis Pengaduan berdasarkan kategori</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.fields') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-th-list text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Field</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Field setiap jenis</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.components') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-object-group text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Components</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Components for field</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.jenis-fields') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-sitemap text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Konfigurasi Field</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Konfigurasi Field di setiap jenis</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Other Users: All Tabs -->
                        <div id="general" class="tab-content">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">General Settings</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                @if (current_agent()->company_id == 5)
                                <a href="{{ route('company.modules.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="bx bx-time text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Setting Company Modules</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Company Modules</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @endif
                                <a href="{{ route('userManagement') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="bx bx-user text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">User Management</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage User Management</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('group-route.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-users text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Group Route</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Group Route</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('user-divisions.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-users text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">User Divisions</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage User Division</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.config.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-cogs text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Config</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Config</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('channel-page.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="bx bx-doughnut-chart text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Channel</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Channel</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('bot.index-v2') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="bx bx-bot text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Bot Interaction</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Bot</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('config-pbx.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="bx bx-user text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Config PBX</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage PBX Configs</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('chat.v3.ticket.kirana.execution.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-violet-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="bx bx-play-circle text-2xl text-violet-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Kirana Execute Manual</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Run manual sync and batch process</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div id="email-setting" class="tab-content hidden">
                            @include('pages.company.setting.partials.email-setting-cards')
                        </div>
                        <div id="key1" class="tab-content hidden">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Data Ticket Settings</h3>
                            @if (get_config('msg.category.form', current_agent()->company_id) == '1')
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('company.master.status.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Status</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Status</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.master.priority.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Priority</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Priority</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.master.category.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.master.category-type.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Sub Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Sub Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('articles.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Article</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Knowledge Base</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                        <div id="key2" class="tab-content hidden">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Data Outbound Call Settings</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('outbound.status') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Status</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Status</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('outbound.priority') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Priority</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Priority</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('outbound.kategori') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('outbound.subkategori') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Sub Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Sub Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('outbound.tickets.index') }}" class="block group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="bx bx-import text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Import Data</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Data by Import</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('outbound.script-outbound') }}" class="block group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-phone text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Script Outbound</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Data Script Outbound</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div id="outbound-blasting" class="tab-content hidden">
                            @include('pages.company.setting.partials.outbound-blasting-cards')
                        </div>
                        <div id="formbuilder" class="tab-content hidden">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Form Builder Settings</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('admin.builder.kategori') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-tags text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Kategori</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Kategori for form</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.jenis') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-clipboard-list text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Jenis Pengaduan</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Jenis Pengaduan berdasarkan kategori</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.fields') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-th-list text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Field</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Field setiap jenis</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.components') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-object-group text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Components</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Components for field</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.jenis-fields') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-sitemap text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Konfigurasi Field</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Konfigurasi Field di setiap jenis</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div id="formbuilder-ticket" class="tab-content hidden">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Form Builder Ticket Settings</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('company.master.status.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Status</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Status</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('company.master.priority.index') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-ticket text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Priority</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Priority</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.kategori-ticket') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-tags text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Kategori</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Kategori for form</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.jenis-ticket') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-clipboard-list text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Jenis Pengaduan</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Jenis Pengaduan berdasarkan kategori</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.fields-ticket') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-th-list text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Field</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Field setiap jenis</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.components-ticket') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-object-group text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Components</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Components for field</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.builder.jenis-fields-ticket') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-sitemap text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Konfigurasi Field</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Konfigurasi Field di setiap jenis</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div id="master-data" class="tab-content hidden">
                            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Master Data Settings</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
                                <a href="{{ route('admin.master.category') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-tags text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Category</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Customer Category</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.master.enquiry-type') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-clipboard-list text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Enquiry Type</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Enquiry Type</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.master.enquiry-details') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-th-list text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Enquiry Details</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Enquiry Details</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.master.problems') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-object-group text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Problems</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Master Problems</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('admin.master.division') }}" class="block h-full group">
                                    <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                        <div class="flex items-center gap-4">
                                            <i class="fa fa-sitemap text-2xl text-blue-300 group-hover:text-white"></i>
                                            <div>
                                                <h4 class="text-base font-medium text-white">Division</h4>
                                                <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Master Division</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <x-slot name="js">
        <style>
            .equal-card-grid { grid-auto-rows: 1fr; }
            .setting-card { height: 100%; }
        </style>
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
                const dateTimeElement = document.getElementById('currentDateTime');
                if (!dateTimeElement) {
                    return;
                }
                dateTimeElement.innerHTML = `
                    <div>${date}</div>
                    <div class="font-semibold">${time}</div>
                `;
            }

            function showTab(tabId) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                // Show selected tab content
                const selectedContent = document.getElementById(tabId);
                if (selectedContent) {
                    selectedContent.classList.remove('hidden');
                }
                // Update active menu item
                document.querySelectorAll('.menu-item').forEach(item => {
                    item.classList.remove('bg-blue-500', 'text-white');
                    item.classList.add('text-gray-200');
                });
                const activeItem = document.querySelector(`.menu-item[data-tab="${tabId}"]`);
                if (activeItem) {
                    activeItem.classList.remove('text-gray-200');
                    activeItem.classList.add('bg-blue-500', 'text-white');
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                updateDateTime();
                setInterval(updateDateTime, 1000);
                // Set default tab based on user role
                @if(current_agent()->company_id == 40 && auth()->user()->is_user_leader == 1)
                    showTab('general');
                @else
                    showTab('general');
                @endif
            });
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
