<div class="fixed inset-y-0 left-0 z-[9999] w-20 bg-gray-900/60 backdrop-blur-xl border-r border-gray-800 transition-all duration-300 flex flex-col sidebar-mini"
    id="sidebar">
    <!-- Logo Section -->
    <!-- <div class="flex items-center justify-between h-16 px-6 border-b border-gray-800"> -->
    <div class="flex items-center justify-between h-16 px-2 border-b border-gray-800">
        <div class="flex items-center">
            <span class="logo-long h-12 w-32 flex-shrink-0">
                <img src="{{ sidebar_logo('panjang') }}" alt="Logo Panjang" class="h-full w-full object-contain">
            </span>
            <span class="logo-short h-12 w-12 ml-2 flex-shrink-0">
                <img src="{{ sidebar_logo('pendek') }}" alt="Logo Kecil" class="h-full w-full object-contain">
            </span>
        </div>
        <span class="text-white font-bold text-lg mr-20 logo-text">AHULINK</span>
        {{-- <div class="flex items-center">
            <span class="logo-long h-12 w-40 flex-shrink-0 mt-1 ml-2">
                <img src="/assets/images/DK-Putih.png" alt="Logo Panjang" class="h-full w-full">
            </span>
            <span class="logo-short h-8 w-8 flex-shrink-0">
                <img src="/assets/images/logo-dk.svg" alt="Logo Kecil" class="h-full w-full object-cover">
            </span>
        </div> --}}
        <button type="button" class="text-gray-400 hover:text-blue-400 transition-colors toggle-button hidden">
            <i class="fa fa-bars text-2xl"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 overflow-y-auto py-4">
        <nav class="px-2">
            <ul class="space-y-1">
                @auth
                    @if (current_agent()->company_id == 40 && (auth()->user()->is_user_leader == 1 || current_agent()->user_type == 'owner'))
                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg
                                {{ Request::is('index') || Request::is('ticket') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-home-alt mr-3 text-xl'></i>
                                    <span>Home</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('index') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Overview
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent.performance') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Agent
                                    </a>
                                </li>
                                {{-- <li>
                            <a href="{{ route('agent-productivity-dashboard') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                Agent Productivity
                            </a>
                        </li> --}}
                                <li>
                                    <a href="{{ route('api.qa-result-forms.indexView') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        QA Report
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg
                                {{ Request::is('outbound2/dashboard') || Request::is('ticket') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-layout mr-3 text-xl'></i>
                                    <span>Dashboard</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('outbound2.dashboard') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Dashboard Outbound Ticket
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Customer Interaction Menu -->
                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('facebook*') || (Request::is('chat*') && !Request::is('chat/v3/internal-groups*') && !Request::is('chat/v3/report/blast-history')) || Request::is('crm*') || Request::is('ticketing*') || Request::is('outbound2') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-conversation mr-3 text-xl'></i>
                                    <span>Workspace</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('Outbound2') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Outbound
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Monitoring Menu -->
                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('spv*') || Request::is('analytic*') || Request::routeIs('chat.index') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-desktop mr-3 text-xl'></i>
                                    <span>Monitoring</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('recordings.index') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Recording
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('spv.outbound.index') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Monitoring Outbound
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Reporting Menu -->
                        {{-- <li class="menu-section">
                    <button
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('report*') ? 'bg-blue-600 text-white' : '' }}">
                        <div class="flex items-center">
                            <i class='bx bx-bar-chart-alt-2 mr-3 text-xl'></i>
                            <span>Reporting</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm transition-transform"></i>
                    </button>
                    <ul class="pl-12 mt-1 space-y-1 hidden">
                        <li>
                            <a href="{{ route('report.outbound') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                Reporting Transaksi Outbound
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('report.daily-call') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                Daily Call Performance Report
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('report.calldaily') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                Daily Call Report
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('report.agent-productivity') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                Agent Productivity Report
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('report.cdr') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                CDR Report - Call Detail Records
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('report.wallboard.outbound') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg"
                                target="_blank" rel="noopener">
                                Wallboard Outbound
                            </a>
                        </li>

                    </ul>
                </li> --}}

                        {{-- <li class="menu-section">
                    <a href="{{ route('company.settings') }}"
                        class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ (Request::is('settings*') || Request::is('channel-page*') || Request::is('bot-campaign*') || Request::is('blast*') || Request::is('bot*') || Request::is('operational-time*') || Request::is('userManagement*') || Request::is('group-route*') || Request::is('company*') || Request::is('integration-owner*')) && !Request::routeIs('blast-hsm-guide.dashboard') ? 'bg-blue-600 text-white' : '' }}">
                        <i class='bx bx-cog mr-3 text-xl'></i>
                        <span>Settings</span>
                    </a>
                </li> --}}
                    @elseif (current_agent()->company_id == 40 && current_agent()->user_type == 'agent' && auth()->user()->is_user_leader != 1)
                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg
                                    {{ Request::is('home') || Request::is('agent-productivity-dashboard') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-home-alt mr-3 text-xl'></i>
                                    <span>Home</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('index') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Overview
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg
                                {{ Request::is('outbound2/dashboard') || Request::is('ticket') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-layout mr-3 text-xl'></i>
                                    <span>Dashboard</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('outbound2.dashboard') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Dashboard Outbound Ticket
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Customer Interaction Menu -->
                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('facebook*') || (Request::is('chat*') && !Request::is('chat/v3/internal-groups*') && !Request::is('chat/v3/report/blast-history')) || Request::is('crm*') || Request::is('ticketing*') || Request::is('outbound2') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-conversation mr-3 text-xl'></i>
                                    <span>Workspace</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('Outbound2') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Outbound
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Home Menu -->
                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg
                                {{ Request::is('home') || Request::is('agent*') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-home-alt mr-3 text-xl'></i>
                                    <span>Home</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('index') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Overview
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent.performance') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Agent Performance
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent-productivity-dashboard') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Agent Productivity
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg
                                {{ Request::is('chat/v3/ticket/result') || Request::is('outbound/dashboard') || Request::is('dashboard/schedule/blast') || Request::is('blast-thread/history') || Request::is('api/qa-result-forms/view') || Request::routeIs('blast-hsm-guide.dashboard') ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-layout mr-3 text-xl'></i>
                                    <span>Dashboard</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                @if (get_config('msg.category.form', current_agent()->company_id) == '1')
                                    <li>
                                        <a href="{{ route('chat.v3.ticket.result.index') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                            Ticket
                                        </a>
                                    </li>
                                    @if (company_has_module('Outbound Call'))
                                        @if (current_agent()->company_id == 47)
                                            <li>
                                                <a href="{{ route('outbound2.dashboard') }}"
                                                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                    Outbound Ticket
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('outbound.dashboard') }}"
                                                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                    Outbound Ticket
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                    <li>
                                        <a href="{{ route('dashboard.schedule.blast') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                            Blast Schedule
                                        </a>
                                    </li>
                                    {{-- <li>
                            <a href="{{ route('blast-thread.history') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                Blast Thread History
                            </a>
                        </li> --}}
                                    <li>
                                        <a href="{{ route('blast-hsm-guide.dashboard') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::routeIs('blast-hsm-guide.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                                            HSM Template
                                        </a>
                                    </li>
                                    @if (company_has_module('QA Report'))
                                        <li>
                                            <a href="{{ route('api.qa-result-forms.indexView') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                QA Report
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>

                        @if (current_agent()->user_type == 'owner' || current_agent()->is_user_leader == 1)
                            <!-- Channel Menu -->
                            {{-- <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('channel-page*') ? 'bg-blue-600 text-white' : '' }}">
                <div class="flex items-center">
                    <i class='bx bx-doughnut-chart mr-3 text-xl'></i>
                    <span>Channel</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                </button>
                <ul class="pl-12 mt-1 space-y-1 hidden">
                    <li>
                        <a href="{{ route('channel-page.index') }}"
                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                            Subscription
                        </a>
                    </li>
                </ul>
                </li> --}}

                            <!-- Digital Campaign Menu -->
                            {{-- <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('bot-campaign*') || Request::is('blast*') ? 'bg-blue-600 text-white' : '' }}">
                <div class="flex items-center">
                    <i class='bx bx-food-menu mr-3 text-xl'></i>
                    <span>Digital Campaign</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                </button>
                <ul class="pl-12 mt-1 space-y-1 hidden">
                    <li>
                        <a href="{{ route('bot-campaign.schedule.index') }}"
                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                            Create Campaign
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blast.schedule.index') }}"
                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                            Blast
                        </a>
                    </li>
                </ul>
                </li> --}}

                            <!-- Bot Interaction Menu -->
                            {{-- <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('bot*') && !Request::is('bot-campaign*') ? 'bg-blue-600 text-white' : '' }}">
                <div class="flex items-center">
                    <i class='bx bx-bot mr-3 text-xl'></i>
                    <span>Bot Interaction</span>
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                </button>
                <ul class="pl-12 mt-1 space-y-1 hidden">
                    <li>
                        <a href="{{ route('bot.index-v2') }}"
                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                            Create Bot
                        </a>
                    </li>
                </ul>
                </li> --}}

                            <!-- Customer Interaction Menu -->
                            <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('facebook*') || (Request::is('chat*') && !Request::is('chat/v3/internal-groups*') && !Request::is('chat/v3/ticket/result') && !Request::is('chat/v3/report/blast-history')) || Request::is('blast-thread') || Request::is('crm*') || Request::is('ticketing*') || Request::is('outbound') ? 'bg-blue-600 text-white' : '' }}">
                                    <div class="flex items-center">
                                        <i class='bx bx-conversation mr-3 text-xl'></i>
                                        <span>Workspace</span>
                                    </div>
                                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                                </button>
                                <ul class="pl-12 mt-1 space-y-1 hidden">
                                    @if (company_has_module('Omnichat'))
                                        <li>
                                            <a href="{{ route('chat.v3.index') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Omnichat
                                            </a>
                                        </li>
                                    @endif
                                    @if (company_has_module('Comments'))
                                        <li>
                                            <a href="{{ route('facebook.v3.pages.list2') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Comments Interaction
                                            </a>
                                        </li>
                                    @endif
                                    @if (company_has_module('Inbound Call'))
                                        <li>
                                            <a href="{{ route('ticketing') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Inbound Call
                                            </a>
                                        </li>
                                    @endif
                                    @if (company_has_module('Outbound Call'))
                                        @if (current_agent()->company_id == 47)
                                            <li>
                                                <a href="{{ route('Outbound2') }}"
                                                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                    Outbound Call
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('Outbound') }}"
                                                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                    Outbound Call
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                    @if (company_has_module('Plain Ticketing'))
                                        <li>
                                            <a href="{{ route('plain-ticketing.index') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Ticketing
                                            </a>
                                        </li>
                                    @endif
                                    {{-- <li>
                            <a href="{{ route('blast-thread.index') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                Blast Thread
                            </a>
                        </li> --}}
                                    {{-- @if (company_has_module('Internal Group Chat'))
                        <li>
                            <a href="{{ route('chat.v3.internal-groups') }}"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                Internal
                            </a>
                        </li>
                        @endif --}}
                                    @if (get_config('feature.extra.iframe', company_id: current_agent()->company_id))
                                        <li>
                                            <a href="{{ route('crm.view') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                CRM
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            <!-- Integration Menu -->
                            {{-- <li class="menu-section">
                                <a href="{{ route('integration_owner.index') }}"
                class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('integration-owner*') ? 'bg-blue-600 text-white' : '' }}">
                <i class='bx bxs-detail mr-3 text-xl'></i>
                <span>Integration</span>
                </a>
                </li> --}}

                            <!-- Email Menu -->
                            @if (company_has_module('Email') && current_agent()->company_id != 40)
                                <li class="menu-section">
                                    <button
                                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('email*') ? 'bg-blue-600 text-white' : '' }}">
                                        <div class="flex items-center">
                                            <i class='bx bx-envelope mr-3 text-xl'></i>
                                            <span>Email</span>
                                        </div>
                                        <i class="fas fa-chevron-down text-sm transition-transform"></i>
                                    </button>
                                    <ul class="pl-12 mt-1 space-y-1 hidden">
                                        <li>
                                            <a href="{{ route('email.compose') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Compose
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('email.index') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Inbox
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('email.send') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Sent
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('email.index', ['status' => 'draft']) }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Draft
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('email.templates.index') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Templates
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('email.history') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                History
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            <!-- Monitoring Menu -->
                            <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('spv*') || Request::is('analytic*') || Request::routeIs('chat.index') ? 'bg-blue-600 text-white' : '' }}">
                                    <div class="flex items-center">
                                        <i class='bx bx-desktop mr-3 text-xl'></i>
                                        <span>Monitoring</span>
                                    </div>
                                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                                </button>
                                <ul class="pl-12 mt-1 space-y-1 hidden">
                                    <li>
                                        <a href="{{ route('spv.index') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                            Channel Interaction
                                        </a>
                                    </li>
                                    @if (company_has_module('Outbound Call'))
                                        <li>
                                            <a href="{{ route('spv.outbound.index') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Outbound Interaction
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('analytic.index') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                            Analytic
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ route('chat.index') }}"
                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                        Chat
                        </a>
                        </li> --}}
                                    <li>
                                        <a href="{{ route('recordings.index') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                            Call Recording
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('wallboard*') ? 'bg-blue-600 text-white' : '' }}">
                                    <div class="flex items-center">
                                        <i class='bx bx-tv mr-3 text-xl'></i>
                                        <span>Wallboard</span>
                                    </div>
                                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                                </button>
                                <ul class="pl-12 mt-1 space-y-1 hidden">
                                    <li>
                                        <a href="{{ route('report.wallboard.omnichat') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                            Wallboard Omnichat
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('report.wallboard.outbound') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                            Wallboard Outbound
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{-- <li class="menu-section">
                    <a href="{{ route('company.settings') }}"
            class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('settings*') || Request::is('channel-page*') || Request::is('bot-campaign*') || Request::is('blast*') || Request::is('bot*') || Request::is('operational-time*') || Request::is('userManagement*') || Request::is('group-route*') || Request::is('company*') || Request::is('integration-owner*') || (Request::is('outbound*') && !Request::is('outbound/dashboard') && !Request::is('outbound')) ? 'bg-blue-600 text-white' : '' }}">
            <i class='bx bx-cog mr-3 text-xl'></i>
            <span>Settings</span>
            </a>
            </li> --}}

                            <!-- Settings Menu -->

                            {{-- <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg">
                                    <div class="flex items-center">
                                        <i class='bx bx-server mr-3 text-xl'></i>
                                        <span>Data Ticket</span>
                                    </div>
                                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                                </button>
                                <ul class="pl-12 mt-1 space-y-1 hidden">
                                    @if (get_config('msg.category.form', current_agent()->company_id) == '1')
                                        <li>
                                            <a href="{{ route('company.master.form-builder.index') }}"
            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
            Builder
            </a>
            </li>
            <li>
                <a href="{{ route('company.master.status.index') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Status
                </a>
            </li>
            <li>
                <a href="{{ route('company.master.priority.index') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Priority
                </a>
            </li>
            <li>
                <a href="{{ route('company.master.category.index') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Category
                </a>
            </li>
            <li>
                <a href="{{ route('company.master.category-type.index') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Sub Category
                </a>
            </li>
            @endif
            </ul>
            </li> --}}
                            {{-- <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg">
                                    <div class="flex items-center">
                                        <i class='bx bx-server mr-3 text-xl'></i>
                                        <span>Data Outbound</span>
                                    </div>
                                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                                </button>
                                <ul class="pl-12 mt-1 space-y-1 hidden">
                                    @if (get_config('msg.category.form', current_agent()->company_id) == '1')
                                        <li>
                                            <a href="{{ route('outbound.status') }}"
            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
            Status
            </a>
            </li>
            <li>
                <a href="{{ route('outbound.priority') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Priority
                </a>
            </li>
            <li>
                <a href="{{ route('outbound.kategori') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Category
                </a>
            </li>
            <li>
                <a href="{{ route('outbound.subkategori') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Sub Category
                </a>
            </li>
            <li>
                <a href="{{ route('outbound.tickets.index') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Import Data
                </a>
            </li>
            @endif
            </ul>
            </li> --}}
                        @endif

                        {{-- <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg">
                                <div class="flex items-center">
                                    <i class='bx bx-cog mr-3 text-xl'></i>
                                    <span>Setting</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('operational-time.index') }}"
            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
            Setting Operational Time
            </a>
            </li>
            <li>
                <a href="{{ route('userManagement') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    User Management
                </a>
            </li>
            <li>
                <a href="{{ route('group-route.index') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Group Route
                </a>
            </li>
            <li>
                <a href="{{ route('company.config.index') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    Config
                </a>
            </li>
            <li>
                <a href="{{ route('company.setting') }}"
                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    API
                </a>
            </li>
            </ul>
            </li> --}}

                        @if (current_agent()->user_type == 'agent' && current_agent()->is_user_leader != 1)
                            <!-- Customer Interaction Menu -->
                            <li class="menu-section">
                                <button
                                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('facebook*') || (Request::is('chat*') && !Request::is('chat/v3/internal-groups*') && !Request::is('chat/v3/ticket/result') && !Request::is('chat/v3/report/blast-history')) || Request::is('crm*') || (Request::is('ticketing*') && !Request::is('chat/v3/internal-groups*')) ? 'bg-blue-600 text-white' : '' }}">
                                    <div class="flex items-center">
                                        <i class='bx bx-conversation mr-3 text-xl'></i>
                                        <span>Workspace</span>
                                    </div>
                                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                                </button>
                                <ul class="pl-12 mt-1 space-y-1 hidden">
                                    @if (company_has_module('Omnichat'))
                                        <li>
                                            <a href="{{ route('chat.v3.index') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Omnichat
                                            </a>
                                        </li>
                                    @endif
                                    @if (company_has_module('Comments'))
                                        <li>
                                            <a href="{{ route('facebook.v3.pages.list2') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Comments Interaction
                                            </a>
                                        </li>
                                    @endif
                                    @if (company_has_module('Inbound Call'))
                                        <li>
                                            <a href="{{ route('ticketing') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Inbound Call
                                            </a>
                                        </li>
                                    @endif
                                    @if (company_has_module('Outbound Call'))
                                        @if (current_agent()->company_id == 47)
                                            <li>
                                                <a href="{{ route('Outbound2') }}"
                                                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                    Outbound Call
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('Outbound') }}"
                                                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                    Outbound Call
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                    @if (company_has_module('Plain Ticketing'))
                                        <li>
                                            <a href="{{ route('plain-ticketing.index') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Ticketing
                                            </a>
                                        </li>
                                    @endif
                                    {{-- <li>
                        <a href="{{ route('blast-thread.index') }}"
                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                            Blast Thread
                        </a>
                    </li> --}}
                                    {{-- @if (company_has_module('Internal Group Chat'))
                    <li>
                        <a href="{{ route('chat.v3.internal-groups') }}"
                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                            Internal
                        </a>
                    </li>
                    @endif --}}
                                    @if (get_config('feature.extra.iframe', current_agent()->company_id))
                                        <li>
                                            <a href="{{ route('crm.view') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                CRM
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            @if (company_has_module('Email') && current_agent()->company_id != 40)
                                <!-- Agent Email Menu -->
                                <li class="menu-section">
                                    <button
                                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('email*') ? 'bg-blue-600 text-white' : '' }}">
                                        <div class="flex items-center">
                                            <i class='bx bx-envelope mr-3 text-xl'></i>
                                            <span>Email</span>
                                        </div>
                                        <i class="fas fa-chevron-down text-sm transition-transform"></i>
                                    </button>
                                    <ul class="pl-12 mt-1 space-y-1 hidden">
                                        <li>
                                            <a href="{{ route('email.compose') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Compose
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('email.index') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Inbox
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('email.send') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                Sent
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('email.history') }}"
                                                class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                                History
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <!-- Agent Monitoring Menu -->
                            {{-- <li class="menu-section">
                <button
                    class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('analytic*') ? 'bg-blue-600 text-white' : '' }}">
                    <div class="flex items-center">
                        <i class='bx bx-desktop mr-3 text-xl'></i>
                        <span>Monitoring</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                </button>
                <ul class="pl-12 mt-1 space-y-1 hidden">
                    <li>
                        <a href="{{ route('analytic.index') }}"
                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                            Analytic
                        </a>
                    </li>
                </ul>
            </li> --}}

                            <!-- Agent Reporting Menu -->
                        @endif

                    @endif
                @endauth
            </ul>
        </nav>
    </div>

    <!-- Bottom Menu Section -->
    <div class="border-t border-gray-800">
        <nav class="px-4 py-2">
            <ul class="space-y-1">
                @auth
                    @if (current_agent()->user_type == 'owner' || current_agent()->is_user_leader == 1)
                        <!-- Reporting Menu -->
                        <li class="menu-section">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('report*') || (Request::is('chat/v3/report/blast-history') && !Request::is('report/wallboard*')) ? 'bg-blue-600 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class='bx bx-bar-chart-alt-2 mr-3 text-xl'></i>
                                    <span>Report</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                            <ul class="pl-12 mt-1 space-y-1 hidden">
                                <li>
                                    <a href="{{ route('report.article') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Reporting Article
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('report.omnichat') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Reporting Omnichat
                                    </a>
                                </li>
                                @if (company_has_module('Outbound Call'))
                                    <li>
                                        <a href="{{ route('report.outbound') }}"
                                            class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                            Reporting Transaksi Outbound
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('report.daily-call') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Daily Call Performance Report
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('report.calldaily') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Daily Call Report
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('report.agent-productivity') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Agent Productivity Report
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('report.cdr') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        CDR Report - Call Detail Records
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('chat.v3.report.blast-history') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                                        Blast History Report
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Chat Group Menu -->
                        @if (company_has_module('Internal Group Chat'))
                            <li class="menu-section">
                                <a href="{{ route('chat.v3.internal-groups') }}"
                                    class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('chat/v3/internal-groups*') ? 'bg-blue-600 text-white' : '' }}">
                                    <i class='bx bx-group mr-3 text-xl'></i>
                                    <span>Chat Group</span>
                                </a>
                            </li>
                        @endif

                        <li class="menu-section">
                            <a href="{{ route('company.settings') }}"
                                class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ (Request::is('settings*') || Request::is('channel-page*') || Request::is('bot-campaign*') || (Request::is('blast*') && !Request::is('blast/schedule*')) || Request::is('bot*') || Request::is('operational-time*') || Request::is('userManagement*') || Request::is('group-route*') || Request::is('company*') || Request::is('integration-owner*') || (Request::is('outbound*') && !Request::is('outbound/dashboard') && !Request::is('outbound'))) && !Request::routeIs('blast-hsm-guide.dashboard') ? 'bg-blue-600 text-white' : '' }}">
                                <i class='bx bx-cog mr-3 text-xl'></i>
                                <span>Settings</span>
                            </a>
                        </li>

                        {{-- @elseif ((current_agent()->user_type == 'owner') || (current_agent()->user_type == 'agent' && current_agent()->is_user_leader == 1))
                <!-- Settings Menu -->
                <li class="menu-section">
                    <a href="{{ route('company.settings') }}"
                        class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('settings*') || Request::is('channel-page*') || Request::is('bot-campaign*') || Request::is('blast*') || Request::is('bot*') || Request::is('operational-time*') || Request::is('userManagement*') || Request::is('group-route*') || Request::is('company*') || Request::is('integration-owner*') || (Request::is('outbound*') && !Request::is('outbound/dashboard') && !Request::is('outbound')) ? 'bg-blue-600 text-white' : '' }}">
                        <i class='bx bx-cog mr-3 text-xl'></i>
                        <span>Settings</span>
                    </a>
                </li> --}}
                        {{-- @elseif (current_agent()->user_type == 'agent' && current_agent()->is_user_leader != 1) --}}
                    @else
                        <!-- Chat Group Menu for Agent -->
                        @if (company_has_module('Internal Group Chat'))
                            <li class="menu-section">
                                <a href="{{ route('chat.v3.internal-groups') }}"
                                    class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg {{ Request::is('chat/v3/internal-groups*') ? 'bg-blue-600 text-white' : '' }}">
                                    <i class='bx bx-group mr-3 text-xl'></i>
                                    <span>Chat Group</span>
                                </a>
                            </li>
                        @endif
                    @endif
                @endauth
            </ul>
        </nav>
    </div>

    <!-- User Profile Section (Bottom) -->
    <div class="border-t border-gray-800 mt-auto">
        <div class="p-4 relative">
            <div class="flex items-center space-x-3">
                <div class="relative flex-shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-700"
                        src="{{ url('/') }}/assets/images/users/Profile.png" alt="User Avatar">

                    <!-- Status online -->
                    @php
                        $auxStatus =
                            auth()->check() && current_agent() && current_agent()->user_agent
                                ? current_agent()->user_agent->aux
                                : null;
                        $statusColor = 'bg-gray-500'; // default color

                        if ($auxStatus) {
                            switch ($auxStatus) {
                                case 'ready':
                                    $statusColor = 'bg-green-500';
                                    break;
                                case 'istirahat':
                                    $statusColor = 'bg-yellow-500';
                                    break;
                                case 'eskalasi':
                                    $statusColor = 'bg-orange-500';
                                    break;
                                case 'briefing':
                                    $statusColor = 'bg-blue-500';
                                    break;
                                case 'outgoing_call':
                                    $statusColor = 'bg-purple-500';
                                    break;
                                case 'isi_form':
                                    $statusColor = 'bg-indigo-500';
                                    break;
                                case 'rest_room':
                                    $statusColor = 'bg-pink-500';
                                    break;
                                case 'sholat':
                                    $statusColor = 'bg-cyan-500';
                                    break;
                                case 'system_error':
                                    $statusColor = 'bg-red-500';
                                    break;
                                case 'login':
                                    $statusColor = 'bg-green-500';
                                    break;
                                case 'logout':
                                    $statusColor = 'bg-gray-500';
                                    break;
                                case 'system_aux':
                                    $statusColor = 'bg-gray-400';
                                    break;
                                default:
                                    $statusColor = 'bg-gray-500';
                                    break;
                            }
                        } elseif (auth()->check()) {
                            $statusColor = 'bg-green-500'; // logged in but no aux status
                        }
                    @endphp
                    <span id="userStatusIndicator"
                        class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full {{ $statusColor }} ring-2 ring-gray-900">
                    </span>

                    <!-- Badge Reminder -->
                    <span id="notificationCountBadgeR"
                        class="absolute -top-1 -right-1
                               min-w-[18px] h-[18px]
                               px-1
                               flex items-center justify-center
                               text-[10px] font-bold
                               rounded-full
                               bg-red-600 text-white
                               ring-2 ring-gray-900"
                        style="display: none;">
                        0
                    </span>
                </div>

                <div class="flex-1 min-w-0 profile-info">
                    <button type="button" class="flex items-center w-full text-left" onclick="toggleProfileMenu()">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white truncate">
                                {{ current_agent()->name ?? '' }}
                            </p>
                            <p class="text-xs text-gray-400 truncate">
                                {{ current_agent()->user_owner->company->name ?? '' }}
                            </p>
                            <p class="text-xs text-blue-400 truncate font-medium">
                                Role: {{ current_agent()->user_agent ? current_agent()->user_agent->layer : 'Admin' }}
                            </p>
                            @php
                                $assignedChannels = \App\Models\UserChatHandle::where('user_id', current_agent()->id)
                                    ->with(['channel'])
                                    ->get()
                                    ->unique('channel_id')
                                    ->filter(function ($assignedChannel) {
                                        // Filter out livechat, facebook comment, and instagram comment channels
                                        $channelCode = $assignedChannel->channel->code ?? '';
                                        $channelName = strtolower($assignedChannel->channel->name ?? '');

                                        return !in_array($channelCode, [
                                            'chat-widget',
                                            'ws-chat',
                                            'fb-comment',
                                            'ig-comment',
                                        ]) &&
                                            !str_contains($channelName, 'chat-widget') &&
                                            !str_contains($channelName, 'ws-chat') &&
                                            !str_contains($channelName, 'facebook comment') &&
                                            !str_contains($channelName, 'instagram comment');
                                    });
                            @endphp
                            @if ($assignedChannels->count() > 0)
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach ($assignedChannels as $assignedChannel)
                                        <img src="{{ url($assignedChannel->channel->icon ?? '/assets/images/icons/user.png') }}"
                                            class="w-4 h-4 object-contain"
                                            alt="{{ $assignedChannel->channel->name ?? 'Channel' }}"
                                            title="{{ $assignedChannel->channel->name ?? 'Channel' }}">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <i class="fas fa-chevron-up text-gray-400 ml-2 transform transition-transform duration-200"
                            id="profileArrow"></i>
                    </button>
                </div>
            </div>

            <!-- Profile Dropdown Menu -->
            <div id="profileMenu"
                class="absolute bottom-full left-0 right-0 mb-2 mr-6 ml-6 p-2 bg-gray-800 rounded-lg shadow-lg transform scale-95 opacity-0 pointer-events-none transition-all duration-200">
                <div class="profile-info-block">
                    <h6 class="text-sm font-medium text-white mb-0">{{ current_agent()->name ?? '' }}</h6>
                    <p class="text-xs text-gray-400 mb-0">{{ current_agent()->user_owner->company->name ?? '' }}</p>


                    <!-- Assigned Channels Section -->
                    @php
                        $assignedChannels = \App\Models\UserChatHandle::where('user_id', current_agent()->id)
                            ->with(['channel'])
                            ->get()
                            ->unique('channel_id')
                            ->filter(function ($assignedChannel) {
                                // Filter out livechat, facebook comment, and instagram comment channels
                                $channelCode = $assignedChannel->channel->code ?? '';
                                $channelName = strtolower($assignedChannel->channel->name ?? '');

                                return !in_array($channelCode, [
                                    'chat-widget',
                                    'ws-chat',
                                    'fb-comment',
                                    'ig-comment',
                                ]) &&
                                    !str_contains($channelName, 'chat-widget') &&
                                    !str_contains($channelName, 'ws-chat') &&
                                    !str_contains($channelName, 'facebook comment') &&
                                    !str_contains($channelName, 'instagram comment');
                            });
                    @endphp

                    @if ($assignedChannels->count() > 0)
                        <div class="ml-5 mt-3 pt-3 border-t border-gray-700">
                            <p class="text-xs text-gray-400 mb-2">Assigned Channels:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($assignedChannels as $assignedChannel)
                                    <img src="{{ url($assignedChannel->channel->icon ?? '/assets/images/icons/user.png') }}"
                                        class="w-6 h-6 object-contain"
                                        alt="{{ $assignedChannel->channel->name ?? 'Channel' }}"
                                        title="{{ $assignedChannel->channel->name ?? 'Channel' }}">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Menu Items -->
                <div class="space-y-1 mt-2">
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center px-3 py-2.5 text-gray-300 hover:bg-gray-700 hover:text-blue-400 rounded-md transition-all duration-200 group">
                        <div
                            class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-500/20 transition-colors">
                            <i class="fas fa-user-edit text-blue-400 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <span class="text-sm font-medium">Edit Profile</span>
                        </div>
                        <i
                            class="fas fa-chevron-right text-gray-500 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </a>

                    <a href="{{ route('user.logs') }}"
                        class="flex items-center px-3 py-2.5 text-gray-300 hover:bg-gray-700 hover:text-blue-400 rounded-md transition-all duration-200 group">
                        <div
                            class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-500/20 transition-colors">
                            <i class="fas fa-history text-blue-400 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <span class="text-sm font-medium">Logs</span>
                        </div>
                        <i
                            class="fas fa-chevron-right text-gray-500 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </a>

                    <button type="button" onclick="openNotificationPage()"
                        class="w-full flex items-center px-3 py-2.5 text-gray-300 hover:bg-gray-700 hover:text-purple-400 rounded-md transition-all duration-200 group"
                        id="notificationToggleBtn">
                        <div
                            class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-500/20 transition-colors">
                            <i class="fas fa-bell text-purple-400 text-sm" id="notificationToggleIcon"></i>
                        </div>
                        <div class="flex-1 text-left">
                            <span class="text-sm font-medium" id="notificationToggleText">
                                Notification
                                <span
                                    class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full bg-red-600 text-white"
                                    id="notificationCountBadge" style="display: none;">0</span>
                            </span>
                        </div>
                        <i
                            class="fas fa-chevron-right text-gray-500 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </button>

                    <button type="button" onclick="openAuxModal()"
                        class="w-full flex items-center px-3 py-2.5 text-gray-300 hover:bg-gray-700 hover:text-green-400 rounded-md transition-all duration-200 group">
                        <div
                            class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-500/20 transition-colors">
                            <i class="fas fa-cog text-green-400 text-sm"></i>
                        </div>
                        <div class="flex-1 text-left">
                            <span class="text-sm font-medium">AUX</span>
                        </div>
                        <i
                            class="fas fa-chevron-right text-gray-500 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </button>

                    <!-- <div class="border-t border-gray-700 my-2"></div> -->

                    <form method="POST" action="{{ route('logout') }}" class="m-0" id="logoutForm">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-3 py-2.5 text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-md transition-all duration-200 group">
                            <div
                                class="w-8 h-8 bg-red-500/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-500/20 transition-colors">
                                <i class="fas fa-sign-out-alt text-red-400 text-sm"></i>
                            </div>
                            <div class="flex-1 text-left">
                                <span class="text-sm font-medium">Logout</span>
                            </div>
                            <i
                                class="fas fa-chevron-right text-gray-500 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="auxModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0"
        id="auxModalContent">
        <!-- Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cog text-blue-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">System AUX</h3>
                </div>
            </div>
            <button type="button" onclick="closeAuxModal()"
                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors duration-200">
                <i class="fas fa-times text-gray-500 text-sm"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="mb-6">
                <label for="auxSelect" class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-list-ul mr-2 text-blue-500"></i>
                    Select AUX Status
                </label>
                <div class="relative">
                    <select id="auxSelect"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white text-gray-700 font-medium">
                        <option value="" class="text-gray-500">Choose your status...</option>
                        <!-- <option value="login" class="py-2">🔓 Login</option>
                        <option value="logout" class="py-2">🔒 Logout</option>
                        <option value="system_aux" class="py-2">System Aux</option> -->
                        <option value="istirahat" class="py-2">🍴 Istirahat</option>
                        <option value="eskalasi" class="py-2">📞 Eskalasi</option>
                        <option value="briefing" class="py-2">📋 Briefing</option>
                        <option value="outgoing_call" class="py-2">📞 Outgoing Call</option>
                        <option value="isi_form" class="py-2">📝 Isi Form</option>
                        <option value="rest_room" class="py-2">🚽 Rest Room</option>
                        <option value="sholat" class="py-2">🕌 Sholat</option>
                        <option value="system_error" class="py-2">⚠️ System Error</option>
                        <option value="ready" class="py-2">✅ Ready</option>
                    </select>
                </div>
            </div>

            <!-- Status Preview -->
            <div id="statusPreview" class="hidden mb-6 p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                <div class="flex items-center space-x-3">
                    <div id="statusIcon" class="text-2xl"></div>
                    <div>
                        <h4 id="statusTitle" class="font-semibold text-gray-900"></h4>
                        <p id="statusDescription" class="text-sm text-gray-600"></p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeAuxModal()"
                    class="flex-1 px-4 py-3 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </button>
                <button type="button" onclick="submitAuxStatus()"
                    class="flex-1 px-4 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                    <i class="fas fa-check mr-2"></i>
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Scrollbar styling */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: transparent;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background-color: rgb(31, 41, 55);
        /* gray-800 */
        border-radius: 3px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background-color: rgb(55, 65, 81);
        /* gray-700 */
    }

    /* Mini sidebar default state */
    .sidebar-mini {
        width: 80px !important;
    }

    .sidebar-mini .logo-long {
        display: none !important;
    }

    .sidebar-mini .logo-short {
        display: block !important;
    }

    .sidebar-mini .logo-text,
    .sidebar-mini .menu-section span:not(.status-indicator),
    .sidebar-mini .submenu,
    .sidebar-mini .fa-chevron-down,
    .sidebar-mini .profile-info,
    .sidebar-mini .profile-actions {
        display: none !important;
    }

    .sidebar-mini .menu-section a,
    .sidebar-mini .menu-section button {
        padding: 0.75rem !important;
        justify-content: center !important;
    }

    .sidebar-mini .menu-section i {
        margin: 0 !important;
        font-size: 1.5rem !important;
    }

    .sidebar-mini .profile-section {
        padding: 0.75rem !important;
    }

    .sidebar-mini .profile-section img {
        width: 2.5rem !important;
        height: 2.5rem !important;
        margin: 0 auto !important;
    }

    /* Hover expand effect */
    .sidebar-mini:hover {
        width: 288px !important;
    }

    .sidebar-mini:hover .logo-long {
        display: block !important;
    }

    .sidebar-mini:hover .logo-short {
        display: none !important;
    }

    .sidebar-mini:hover .logo-text,
    .sidebar-mini:hover .menu-section span:not(.status-indicator),
    .sidebar-mini:hover .profile-info,
    .sidebar-mini:hover .profile-actions {
        display: block !important;
    }

    .sidebar-mini:hover .menu-section a,
    .sidebar-mini:hover .menu-section button {
        padding: 0.75rem 1rem !important;
        justify-content: flex-start !important;
    }

    .sidebar-mini:hover .menu-section i {
        margin-right: 0.75rem !important;
        font-size: 1.25rem !important;
    }

    .sidebar-mini:hover .profile-section {
        padding: 1rem !important;
    }

    .sidebar-mini:hover .profile-section img {
        width: 2.5rem !important;
        height: 2.5rem !important;
        margin: 0 !important;
    }

    /* Hover effect for mini menu items */
    .sidebar-mini .menu-section a:hover,
    .sidebar-mini .menu-section button:hover {
        background-color: rgba(59, 130, 246, 0.1) !important;
        transform: scale(1.05) !important;
    }

    /* Active state for mini menu items */
    .sidebar-mini .menu-section a.active,
    .sidebar-mini .menu-section button.active {
        background-color: rgb(37, 99, 235) !important;
        color: white !important;
    }

    /* Collapsed state styles (legacy support) */
    .sidebar-collapsed {
        width: 100px !important;
    }

    .logo-long {
        display: block;
    }

    .logo-short {
        display: none;
    }

    .sidebar-collapsed .logo-long {
        display: none !important;
    }

    .sidebar-collapsed .logo-short {
        display: block !important;
    }

    .sidebar-collapsed .logo-text,
    .sidebar-collapsed .menu-section span:not(.status-indicator),
    .sidebar-collapsed .submenu,
    .sidebar-collapsed .fa-chevron-down,
    .sidebar-collapsed .profile-info,
    .sidebar-collapsed .profile-actions {
        display: none !important;
    }

    .sidebar-collapsed .menu-section a,
    .sidebar-collapsed .menu-section button {
        padding: 0.75rem !important;
        justify-content: center !important;
    }

    .sidebar-collapsed .menu-section i {
        margin: 0 !important;
        font-size: 1.5rem !important;
    }

    .sidebar-collapsed .profile-section {
        padding: 0.75rem !important;
    }

    .sidebar-collapsed .profile-section img {
        width: 2.5rem !important;
        height: 2.5rem !important;
        margin: 0 auto !important;
    }

    /* Hover effect for collapsed menu items */
    .sidebar-collapsed .menu-section a:hover,
    .sidebar-collapsed .menu-section button:hover {
        background-color: rgba(59, 130, 246, 0.1) !important;
        transform: scale(1.1) !important;
    }

    /* Active state for collapsed menu items */
    .sidebar-collapsed .menu-section a.active,
    .sidebar-collapsed .menu-section button.active {
        background-color: rgb(37, 99, 235) !important;
        color: white !important;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        #sidebar {
            transform: translateX(-100%);
        }

        #sidebar.mobile-show {
            transform: translateX(0);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .sidebar-overlay.show {
            display: block;
        }
    }

    /* Menu item transitions */
    .menu-section a,
    .menu-section button {
        transition: all 0.2s ease-in-out;
    }

    .menu-section a:hover,
    .menu-section button:hover {
        transform: translateX(4px);
    }

    /* Submenu animations */
    .submenu {
        transition: all 0.3s ease-in-out;
    }

    .submenu.hidden {
        opacity: 0;
        transform: translateY(-10px);
    }

    /* Profile section enhancements */
    .profile-section {
        transition: all 0.3s ease-in-out;
    }

    .profile-section img {
        transition: all 0.2s ease-in-out;
    }

    .profile-section img:hover {
        transform: scale(1.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.toggle-button');
        const mainContent = document.querySelector('main');
        const userMenu = document.getElementById('userMenu');
        let isCollapsed = false;

        // Function to close all submenus
        function closeAllSubmenus() {
            document.querySelectorAll('.menu-section > button').forEach(button => {
                const submenu = button.nextElementSibling;
                const icon = button.querySelector('.fa-chevron-down');
                if (submenu && !submenu.classList.contains('hidden')) {
                    submenu.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        }

        // Sidebar is now always in mini mode by default
        // No toggle functionality needed - hover will expand it

        // Ensure main content has proper margin for mini sidebar
        if (mainContent) {
            mainContent.classList.add('ml-20');
            mainContent.classList.remove('ml-72');
        }

        // Submenu Toggle - Only works when sidebar is expanded (on hover)
        document.querySelectorAll('.menu-section > button').forEach(button => {
            button.addEventListener('click', function(e) {
                // Only allow submenu toggle when sidebar is expanded (hover state)
                if (!sidebar.matches(':hover')) {
                    return;
                }

                const submenu = this.nextElementSibling;
                const icon = this.querySelector('.fa-chevron-down');

                // Close other submenus
                document.querySelectorAll('.menu-section > button').forEach(otherButton => {
                    if (otherButton !== button) {
                        const otherSubmenu = otherButton.nextElementSibling;
                        const otherIcon = otherButton.querySelector('.fa-chevron-down');
                        if (otherSubmenu && !otherSubmenu.classList.contains(
                            'hidden')) {
                            otherSubmenu.classList.add('hidden');
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
                    }
                });

                submenu.classList.toggle('hidden');
                icon.style.transform = submenu.classList.contains('hidden') ? 'rotate(0deg)' :
                    'rotate(180deg)';
            });
        });

        // User Menu Toggle
        window.showUserMenu = function() {
            userMenu.classList.toggle('hidden');
        };

        // Close submenus and profile menu when mouse leaves sidebar
        sidebar.addEventListener('mouseleave', function() {
            closeAllSubmenus();
            // Close profile menu when sidebar closes
            const profileMenu = document.getElementById('profileMenu');
            const arrow = document.getElementById('profileArrow');
            if (profileMenu && arrow) {
                profileMenu.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
                profileMenu.classList.remove('scale-100', 'opacity-100');
                arrow.classList.remove('rotate-180');
            }
        });


        // Mobile responsive
        const createOverlay = () => {
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);
            return overlay;
        };

        const overlay = createOverlay();

        toggleBtn.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-show');
                overlay.classList.toggle('show');

                // Close all submenus when toggling mobile sidebar
                closeAllSubmenus();
            }
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-show');
            overlay.classList.remove('show');

            // Close all submenus when closing mobile sidebar
            closeAllSubmenus();
        });

        // Update online status
        const updateOnlineStatus = () => {
            const statusIndicator = document.querySelector('.status-indicator');
            const statusText = document.querySelector('.status-text');

            if (navigator.onLine) {
                statusIndicator?.classList.replace('bg-gray-500', 'bg-green-500');
                if (statusText) {
                    statusText.textContent = 'Online';
                    statusText.classList.replace('text-gray-500', 'text-green-500');
                }
            } else {
                statusIndicator?.classList.replace('bg-green-500', 'bg-gray-500');
                if (statusText) {
                    statusText.textContent = 'Offline';
                    statusText.classList.replace('text-green-500', 'text-gray-500');
                }
            }
        };

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
        updateOnlineStatus();

        // Handle window resize to close submenus on mobile
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768) {
                closeAllSubmenus();
            }
        });
    });

    function toggleProfileMenu() {
        // Only allow profile menu toggle when sidebar is expanded (hover state)
        const sidebar = document.getElementById('sidebar');
        if (!sidebar.matches(':hover')) {
            return;
        }

        const menu = document.getElementById('profileMenu');
        const arrow = document.getElementById('profileArrow');
        const isHidden = menu.classList.contains('pointer-events-none');

        if (isHidden) {
            // Show menu
            menu.classList.remove('pointer-events-none', 'scale-95', 'opacity-0');
            menu.classList.add('scale-100', 'opacity-100');
            arrow.classList.add('rotate-180');
        } else {
            // Hide menu
            menu.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
            menu.classList.remove('scale-100', 'opacity-100');
            arrow.classList.remove('rotate-180');
        }
    }



    function openAuxModal() {
        const modal = document.getElementById('auxModal');
        const modalContent = document.getElementById('auxModalContent');

        if (!modal || !modalContent) {
            console.error('AUX modal elements not found');
            return;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Animate modal content
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Load current AUX status
        loadCurrentAuxStatus();

        // Close profile menu when opening AUX modal
        const profileMenu = document.getElementById('profileMenu');
        const arrow = document.getElementById('profileArrow');
        if (profileMenu && arrow) {
            profileMenu.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
            profileMenu.classList.remove('scale-100', 'opacity-100');
            arrow.classList.remove('rotate-180');
        }
    }

    function loadCurrentAuxStatus() {
        fetch('/aux/current', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    const auxSelect = document.getElementById('auxSelect');
                    if (auxSelect) {
                        auxSelect.value = data.data.aux_status || '';

                        // Trigger change event to show preview
                        if (data.data.aux_status) {
                            auxSelect.dispatchEvent(new Event('change'));
                        }
                    }

                    // Update status indicator color
                    if (data.data.aux_status) {
                        updateStatusIndicatorColor(data.data.aux_status);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading current AUX status:', error);
            });
    }

    function closeAuxModal() {
        const modal = document.getElementById('auxModal');
        const modalContent = document.getElementById('auxModalContent');

        if (!modal || !modalContent) {
            console.error('AUX modal elements not found');
            return;
        }

        // Animate modal content out
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        // Hide modal after animation
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);

        // Reset form
        const auxSelect = document.getElementById('auxSelect');
        const statusPreview = document.getElementById('statusPreview');

        if (auxSelect) auxSelect.value = '';
        if (statusPreview) statusPreview.classList.add('hidden');
    }

    function updateStatusIndicatorColor(auxStatus) {
        const statusIndicator = document.getElementById('userStatusIndicator');
        if (!statusIndicator) return;

        // Remove all possible color classes
        const colorClasses = [
            'bg-green-500', 'bg-yellow-500', 'bg-orange-500', 'bg-blue-500',
            'bg-purple-500', 'bg-indigo-500', 'bg-pink-500', 'bg-cyan-500',
            'bg-red-500', 'bg-gray-500', 'bg-gray-400'
        ];
        statusIndicator.classList.remove(...colorClasses);

        // Set color based on aux status
        let statusColor = 'bg-gray-500'; // default
        if (auxStatus) {
            switch (auxStatus) {
                case 'ready':
                    statusColor = 'bg-green-500';
                    break;
                case 'istirahat':
                    statusColor = 'bg-yellow-500';
                    break;
                case 'eskalasi':
                    statusColor = 'bg-orange-500';
                    break;
                case 'briefing':
                    statusColor = 'bg-blue-500';
                    break;
                case 'outgoing_call':
                    statusColor = 'bg-purple-500';
                    break;
                case 'isi_form':
                    statusColor = 'bg-indigo-500';
                    break;
                case 'rest_room':
                    statusColor = 'bg-pink-500';
                    break;
                case 'sholat':
                    statusColor = 'bg-cyan-500';
                    break;
                case 'system_error':
                    statusColor = 'bg-red-500';
                    break;
                case 'login':
                    statusColor = 'bg-green-500';
                    break;
                case 'logout':
                    statusColor = 'bg-gray-500';
                    break;
                case 'system_aux':
                    statusColor = 'bg-gray-400';
                    break;
                default:
                    statusColor = 'bg-gray-500';
                    break;
            }
        }
        statusIndicator.classList.add(statusColor);
    }

    function submitAuxStatus() {
        const select = document.getElementById('auxSelect');
        if (!select) {
            showNotification('AUX select element not found', 'error');
            return;
        }

        const selectedValue = select.value;

        if (!selectedValue) {
            showNotification('Please select an AUX status', 'error');
            return;
        }

        // Show loading state
        const submitBtn = document.querySelector('button[onclick="submitAuxStatus()"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            submitBtn.disabled = true;

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Make the API call to Laravel endpoint
            fetch('/aux/change', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        aux_status: selectedValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Send to PBX system after successful Laravel update
                        sendToPBX(selectedValue);

                        // Update status indicator color
                        updateStatusIndicatorColor(selectedValue);

                        showNotification(data.message || 'Status AUX berhasil diubah!', 'success');
                        setTimeout(() => {
                            closeAuxModal();
                        }, 1000);
                    } else {
                        showNotification(data.message || 'Gagal mengubah status AUX. Silakan coba lagi.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error mengubah status AUX. Periksa koneksi Anda.', 'error');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        } else {
            // Fallback if button not found
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('/aux/change', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        aux_status: selectedValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Send to PBX system after successful Laravel update
                        sendToPBX(selectedValue);

                        // Update status indicator color
                        updateStatusIndicatorColor(selectedValue);

                        showNotification(data.message || 'Status AUX berhasil diubah!', 'success');
                        setTimeout(() => {
                            closeAuxModal();
                        }, 1000);
                    } else {
                        showNotification(data.message || 'Gagal mengubah status AUX. Silakan coba lagi.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error mengubah status AUX. Periksa koneksi Anda.', 'error');
                });
        }
    }


    function sendToPBX(auxStatus) {
        // Check if PBX integration is enabled (you can set this to false to disable)
        const PBX_ENABLED = true; // Set to false to disable PBX integration

        if (!PBX_ENABLED) {
            console.log('PBX integration is disabled');
            return;
        }

        // Determine the URL based on selected value
        let url;
        if (auxStatus === 'ready') {
            url = 'http://localhost:60024/pbxin';
        } else if (auxStatus === 'login') {
            url = 'http://localhost:60024/pbxlogin';
        } else if (auxStatus === 'logout') {
            url = 'http://localhost:60024/pbxlogout';
        } else {
            url = `http://localhost:60024/aux/${auxStatus}`;
        }

        console.log('Attempting to send AUX status to PBX:', auxStatus, 'URL:', url);

        // Make the API call to PBX with better error handling
        fetch(url, {
                method: 'GET',
                mode: 'cors', // Enable CORS
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                // Add timeout
                signal: AbortSignal.timeout(5000) // 5 second timeout
            })
            .then(response => {
                console.log('PBX Response status:', response.status);
                if (response.ok) {
                    console.log('PBX AUX status updated successfully');
                    return response.text(); // Get response body
                } else {
                    throw new Error(`PBX responded with status: ${response.status}`);
                }
            })
            .then(data => {
                console.log('PBX Response data:', data);
            })
            .catch(error => {
                if (error.name === 'TimeoutError') {
                    console.warn('PBX request timed out after 5 seconds');
                } else if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
                    console.warn('PBX server is not accessible. This might be normal if PBX is not running.');
                } else {
                    console.error('Error updating PBX AUX status:', error);
                }
                // Don't show error to user as this is background operation
            });
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className =
            `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;

        // Set background color based on type
        if (type === 'success') {
            notification.className += ' bg-green-500 text-white';
        } else if (type === 'error') {
            notification.className += ' bg-red-500 text-white';
        } else {
            notification.className += ' bg-blue-500 text-white';
        }

        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Handle AUX select change for immediate action (optional)
    document.addEventListener('DOMContentLoaded', function() {
        const auxSelect = document.getElementById('auxSelect');
        const statusPreview = document.getElementById('statusPreview');
        const statusIcon = document.getElementById('statusIcon');
        const statusTitle = document.getElementById('statusTitle');
        const statusDescription = document.getElementById('statusDescription');

        if (auxSelect) {
            auxSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                if (selectedValue && statusPreview && statusIcon && statusTitle && statusDescription) {
                    statusPreview.classList.remove('hidden');
                    let iconClass = '';
                    let title = '';
                    let description = '';

                    switch (selectedValue) {
                        // case 'login':
                        //     iconClass = 'fas fa-sign-in-alt';
                        //     title = '🔓 Login';
                        //     description = 'Logging into the system.';
                        //     break;
                        // case 'logout':
                        //     iconClass = 'fas fa-sign-out-alt';
                        //     title = '🔒 Logout';
                        //     description = 'Logging out of the system.';
                        //     break;
                        // case 'system_aux':
                        //     iconClass = 'fas fa-cog';
                        //     title = 'System Aux';
                        //     description = 'System auxiliary status.';
                        //     break;
                        case 'istirahat':
                            iconClass = 'fas fa-utensils';
                            title = '🍴 Istirahat';
                            description = 'Taking a break for food or relaxation.';
                            break;
                        case 'eskalasi':
                            iconClass = 'fas fa-phone';
                            title = '📞 Eskalasi';
                            description = 'Escalating a call or issue.';
                            break;
                        case 'briefing':
                            iconClass = 'fas fa-clipboard-list';
                            title = '📋 Briefing';
                            description = 'Preparing for a briefing or meeting.';
                            break;
                        case 'outgoing_call':
                            iconClass = 'fas fa-phone-alt';
                            title = '📞 Outgoing Call';
                            description = 'Making an outgoing call.';
                            break;
                        case 'isi_form':
                            iconClass = 'fas fa-file-alt';
                            title = '📝 Isi Form';
                            description = 'Filling out a form or document.';
                            break;
                        case 'rest_room':
                            iconClass = 'fas fa-restroom';
                            title = '🚽 Rest Room';
                            description = 'Using the restroom.';
                            break;
                        case 'sholat':
                            iconClass = 'fas fa-mosque';
                            title = '🕌 Sholat';
                            description = 'Praying or attending a prayer session.';
                            break;
                        case 'system_error':
                            iconClass = 'fas fa-exclamation-triangle';
                            title = '⚠️ System Error';
                            description = 'Encountering a system error or issue.';
                            break;
                        case 'ready':
                            iconClass = 'fas fa-check-circle';
                            title = '✅ Ready';
                            description = 'Available for work.';
                            break;
                    }

                    statusIcon.className = iconClass;
                    statusTitle.textContent = title;
                    statusDescription.textContent = description;

                    // Optional: You can add immediate action here if needed
                    console.log('AUX status changed to:', selectedValue);
                } else if (statusPreview) {
                    statusPreview.classList.add('hidden');
                }
            });
        }
    });



    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('profileMenu');
        const arrow = document.getElementById('profileArrow');
        if (!e.target.closest('.profile-info') && !menu.classList.contains('pointer-events-none')) {
            menu.classList.add('pointer-events-none', 'scale-95', 'opacity-0');
            menu.classList.remove('scale-100', 'opacity-100');
            arrow.classList.remove('rotate-180');
        }

        // Close submenus when clicking outside sidebar on mobile
        if (window.innerWidth <= 768 && !e.target.closest('#sidebar')) {
            closeAllSubmenus();
        }
    });


    function openNotificationPage() {
        window.location.href = '{{ route('reminder-ticket.index') }}';
    }

    // Function to load reminder ticket count
    function loadReminderTicketCount() {
        fetch('{{ route('reminder-ticket.count') }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success !== undefined) {
                    const count = data.count || 0;

                    // daftar badge yang mau di-update
                    const badgeIds = [
                        'notificationCountBadge',
                        'notificationCountBadgeR'
                    ];

                    badgeIds.forEach(id => {
                        const badge = document.getElementById(id);
                        if (!badge) return;

                        badge.textContent = count;

                        // hide / show badge
                        badge.style.display = count === 0 ? 'none' : 'inline-flex';
                    });
                }
            })
            .catch(error => {
                console.error('Error loading reminder ticket count:', error);
            });
    }


    // Load count on page load (if DOM is already loaded, call immediately)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            loadReminderTicketCount();

            // Refresh count every 30 seconds
            setInterval(loadReminderTicketCount, 30000);
        });
    } else {
        // DOM is already loaded
        loadReminderTicketCount();

        // Refresh count every 30 seconds
        setInterval(loadReminderTicketCount, 30000);
    }
</script>
