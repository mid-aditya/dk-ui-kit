<header class="fixed left-1/2 transform -translate-x-1/2 top-4 w-[500px] h-[60px] rounded-2xl bg-[#111827] z-50 stroke-slate-50 border-2 border-gray-700">
    <div class="h-full flex items-center justify-between px-6">
        <!-- Left side with social icons -->
        <div class="flex items-center space-x-3">
            <a href="https://wa.me/{{ current_agent()->whatsapp ?? '' }}" target="_blank"
               class="flex items-center justify-center text-white bg-success rounded-full w-9 h-9">
                <i class="fab fa-whatsapp fa-lg"></i>
            </a>
            <a href="{{ current_agent()->instagram ?? '#' }}" target="_blank"
               class="flex items-center justify-center text-white bg-danger rounded-full w-9 h-9">
                <i class="fab fa-instagram fa-lg"></i>
            </a>
        </div>

        <!-- Right side with user profile -->
        <div class="dropdown">
            <button type="button" class="flex items-center space-x-3 text-white"
                    id="page-header-user-dropdown" 
                    data-bs-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false">
                <img class="rounded-full w-10 h-10" src="{{ url('/') }}/assets/images/users/avatar-1.jpg" alt="Header Avatar">
                <div class="hidden sm:block text-left">
                    <span class="block text-sm">{{ current_agent()->name ?? '' }}</span>
                    <span class="text-xs text-gray-400">{{ current_agent()->user_owner->company->name ?? '' }}</span>
                </div>
                <i class="fas fa-circle text-success text-xs"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end mt-2 rounded-xl bg-[#1a1f2d] border-0">
                <div class="p-3">
                    <h6 class="mb-0 text-white">{{ current_agent()->name ?? '' }}</h6>
                    <p class="mb-0 text-xs text-gray-400">{{ current_agent()->user_owner->company->name ?? '' }}</p>
                </div>
                <a class="dropdown-item hover:bg-[#2a2f3d] text-white" href="{{ route('user.logs') }}">
                    <i class="mdi mdi-account-circle mr-2"></i>Logs
                </a>
                <form action="{{ route('logout') }}" method="post" id="form-logout" class="m-0">
                    @csrf
                    <a class="dropdown-item hover:bg-[#2a2f3d] text-white" href="#" onclick="$('#form-logout').submit()">
                        <i class="mdi mdi-logout mr-2"></i>Logout
                    </a>
                </form>
            </div>
        </div>
    </div>
</header>
