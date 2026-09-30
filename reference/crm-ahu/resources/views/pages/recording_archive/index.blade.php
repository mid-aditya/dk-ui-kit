<x-dashonic-horizontal-layout sidebar="1" with-sidebar="1" with-header="1" with-footer="1">

    <div class="min-h-screen bg-gray-900 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <i class="bx bx-server text-blue-500 mr-3 text-4xl"></i>
                        Recording Archive
                    </h1>
                    <p class="mt-2 text-gray-400 flex items-center">
                        <i class="bx bx-folder-open mr-2"></i>
                        Search and view recording data from NAS
                    </p>
                </div>
                <div class="text-right bg-gray-800/50 p-3 rounded-lg shadow-lg">
                    <div class="text-gray-300 text-lg font-semibold" id="currentDateTime"></div>
                </div>
            </div>
        </div>

        <!-- Error Message Section -->
        @if (session('error'))
            <div class="mb-6 bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg relative"
                role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if (session('info'))
            <div class="mb-6 bg-blue-500/20 border border-blue-500 text-blue-200 px-4 py-3 rounded-lg relative"
                role="alert">
                <strong class="font-bold">Info:</strong>
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg">
            <div class="mb-6">
                <form method="get">
                    <div class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label for="search" class="block text-sm font-medium text-gray-400 mb-2">
                                <i class="bx bx-search mr-2"></i>
                                Search Files
                            </label>
                            <input type="text"
                                class="w-full bg-gray-700/50 border-0 text-white rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500"
                                placeholder="Search by phone number (normalized) or recording ID" name="search" value="{{ request('search') ?? '' }}">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="start_date" class="block text-sm font-medium text-gray-400 mb-2">
                                <i class="bx bx-calendar mr-2"></i>
                                Start Date
                            </label>
                            <input type="date"
                                class="w-full bg-gray-700/50 border-0 text-white rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500"
                                name="start_date" value="{{ request('start_date') ?? '' }}">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="end_date" class="block text-sm font-medium text-gray-400 mb-2">
                                <i class="bx bx-calendar mr-2"></i>
                                End Date
                            </label>
                            <input type="date"
                                class="w-full bg-gray-700/50 border-0 text-white rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500"
                                name="end_date" value="{{ request('end_date') ?? '' }}">
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl px-6 py-2.5 transition-colors flex items-center">
                                <i class="bx bx-filter-alt mr-2 text-xl"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-gray-700">
                            <th class="pb-4 text-gray-400 font-medium w-[150px]">File Name/ID</th>
                            <th class="pb-4 text-gray-400 font-medium w-[120px]">Call Date</th>
                            <th class="pb-4 text-gray-400 font-medium w-[150px]">Path</th>
                            <th class="pb-4 text-gray-400 font-medium w-[100px]">Size</th>
                            <th class="pb-4 text-gray-400 font-medium w-[250px]">Recording</th>
                            <th class="pb-4 text-gray-400 font-medium w-[100px]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($data as $row)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="py-4 text-gray-300">{{ $row['filename'] ?? '-' }}</td>
                                <td class="py-4 text-gray-300">{{ $row['calldate'] ?? '-' }}</td>
                                <td class="py-4 text-gray-300">{{ $row['path'] ?? '-' }}</td>
                                <td class="py-4 text-gray-300">{{ $row['size'] ?? '-' }}</td>
                                <td class="py-4">
                                    @if(isset($row['url']))
                                    <div class="bg-gray-700/30 rounded-lg p-3">
                                        <audio controls class="w-full">
                                            <source src="{{ $row['url'] }}" type="audio/wav">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                    @else
                                    <span class="text-gray-500 italic">No audio available</span>
                                    @endif
                                </td>
                                <td class="py-4">
                                    @if(isset($row['url']))
                                    <a href="{{ $row['url'] }}" download 
                                        class="p-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600/40 rounded-lg transition-colors inline-flex items-center">
                                        <i class="bx bx-download text-xl"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="bx bx-folder-open text-4xl mb-3 text-gray-500"></i>
                                        <p>No recording data found in NAS for the selected criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($data) && $data instanceof \Illuminate\Pagination\LengthAwarePaginator && count($data) > 0)
            <div class="mt-6">
                {{ $data->links() }}
            </div>
            @endif
        </div>
    </div>

    <x-slot name="js">
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

                document.getElementById('currentDateTime').innerHTML = `
                    <div class="text-xl">${date}</div>
                    <div class="text-2xl font-bold">${time}</div>
                `;
            }

            $(document).ready(() => {
                updateDateTime();
                setInterval(updateDateTime, 1000);
            });
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
