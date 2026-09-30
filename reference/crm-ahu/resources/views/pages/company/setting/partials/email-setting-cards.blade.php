<h3 class="text-xl sm:text-2xl font-semibold text-white mb-6">Email Setting</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 equal-card-grid">
    <a href="{{ route('email.smtp.index') }}" class="block h-full group">
        <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
            <div class="flex items-center gap-4">
                <i class="fas fa-envelope-open-text text-2xl text-blue-300 group-hover:text-white"></i>
                <div>
                    <h4 class="text-base font-medium text-white">Config Smtp</h4>
                    <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Smtp Email</p>
                </div>
            </div>
        </div>
    </a>
    <a href="{{ route('autoreply-configs.index') }}" class="block h-full group">
        <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
            <div class="flex items-center gap-4">
                <i class="bx bx-reply text-2xl text-blue-300 group-hover:text-white"></i>
                <div>
                    <h4 class="text-base font-medium text-white">Config Autoreply Email</h4>
                    <p class="text-xs text-gray-300 group-hover:text-gray-100">Autoreply outside operational hours</p>
                </div>
            </div>
        </div>
    </a>
    <a href="{{ route('email-settings.index') }}" class="block h-full group">
        <div class="bg-gray-700 p-5 rounded-xl shadow-md setting-card h-full flex hover:bg-blue-600 hover:shadow-lg transition-all duration-300 group-hover:scale-105">
            <div class="flex items-center gap-4">
                <i class="bx bx-envelope text-2xl text-blue-300 group-hover:text-white"></i>
                <div>
                    <h4 class="text-base font-medium text-white">Config Email</h4>
                    <p class="text-xs text-gray-300 group-hover:text-gray-100">Manage Email Configs</p>
                </div>
            </div>
        </div>
    </a>
</div>
