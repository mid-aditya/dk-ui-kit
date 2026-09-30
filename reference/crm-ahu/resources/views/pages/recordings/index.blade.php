<x-dashonic-horizontal-layout sidebar="1" with-sidebar="1" with-header="1" with-footer="1">

    <div class="min-h-screen bg-gray-900 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <i class="bx bxs-phone-call text-blue-500 mr-3 text-4xl"></i>
                        Call Recordings
                    </h1>
                    <p class="mt-2 text-gray-400 flex items-center">
                        <i class="bx bx-headphone mr-2"></i>
                        View and manage call recordings
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

        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg">
            <div class="mb-6">
                <form method="get">
                    <div class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label for="search" class="block text-sm font-medium text-gray-400 mb-2">
                                <i class="bx bx-search mr-2"></i>
                                Search Recordings
                            </label>
                            <input type="text"
                                class="w-full bg-gray-700/50 border-0 text-white rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500"
                                placeholder="Search by Unique ID" name="search" value="{{ request('search') ?? '' }}">
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
                            <th class="pb-4 text-gray-400 font-medium w-[150px]">Unique ID</th>
                            <th class="pb-4 text-gray-400 font-medium w-[120px]">Call Date</th>
                            <th class="pb-4 text-gray-400 font-medium w-[100px]">Disposition</th>
                            <th class="pb-4 text-gray-400 font-medium w-[100px]">Customer</th>
                            <th class="pb-4 text-gray-400 font-medium w-[100px]">Agent</th>
                            <th class="pb-4 text-gray-400 font-medium w-[80px]">Duration</th>
                            <th class="pb-4 text-gray-400 font-medium w-[250px]">Recording</th>
                            @if (company_has_module('Mimin AI'))
                                <th class="pb-4 text-gray-400 font-medium w-[60px]">STT</th>
                                <th class="pb-4 text-gray-400 font-medium w-[60px]">QA</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach ($data as $row)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="py-4 text-gray-300">{{ $row['uniqueid'] }}</td>
                                <td class="py-4 text-gray-300">{{ $row['calldate'] }}</td>
                                {{-- <td class="py-4 text-gray-300">{{ $row['dst_cnam'] }}</td> --}}
                                <td class="py-4 text-gray-300">{{ $row['disposition'] }}</td>
                                <td class="py-4 text-gray-300">{{ $row['src'] }}</td>
                                <td class="py-4 text-gray-300">{{ $row['dst'] }}</td>
                                <td class="py-4 text-gray-300">{{ $row['duration'] }}</td>
                                <td class="py-4">
                                    <div class="bg-gray-700/30 rounded-lg p-3">
                                        <audio controls class="w-full">
                                            <source src="{{ $row['recordingfile_url'] }}" type="audio/wav">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                </td>
                                @if (company_has_module('Mimin AI'))
                                    <td class="py-4">
                                        <button
                                            class="p-2 bg-gray-700/30 hover:bg-gray-700/50 rounded-lg transition-colors"
                                            onclick="openTss('{{ $row['uniqueid'] }}')">
                                            <img src="https://cdn-icons-png.flaticon.com/512/1599/1599234.png"
                                                class="w-6 h-6" alt="STT">
                                        </button>
                                    </td>
                                    <td class="py-4">
                                        <a class="p-2 bg-gray-700/30 hover:bg-gray-700/50 rounded-lg transition-colors inline-block"
                                            target="_blank" onclick="openTss('{{ $row['uniqueid'] }}')">
                                            <img src="https://cloud.uidesk.id/v2uidesk/images/icon/qa.png"
                                                class="w-6 h-6" alt="QA">
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $data->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tssModal" tabindex="-1" aria-labelledby="tssModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-gray-800 text-white">
                <div class="modal-header border-b border-gray-700">
                    <h5 class="modal-title" id="tssModalLabel">Transcript</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer border-t border-gray-700">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
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

            function openTss(uniqueid) {
                Swal.fire({
                    title: 'Pushing Recording...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        ;
                        Swal.showLoading();
                    }
                });

                fetch(`/outbound/recording-push-mimin/${uniqueid}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(result => {
                        Swal.close();
                        console.log('Result push:', result);

                        if (result.success) {
                            if (result.response.transcript && result.response.summary) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Transcript & Summary Found',
                                    html: `
                    <b>Transcript:</b><br>${result.response.transcript}<br><br>
                    <b>Summary:</b><br>${result.response.summary}
                `,
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: result.message || 'Recording pushed successfully',
                                    confirmButtonText: 'OK'
                                });
                            }

                            console.log('Mimin API response:', result.response);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: result.message || 'Failed to push recording',
                                confirmButtonText: 'OK'
                            });
                            console.error('Mimin API error:', result.error);
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Unexpected error occurred',
                            confirmButtonText: 'OK'
                        });
                        console.error('Fetch error:', error);
                    });
            }

            $(document).ready(() => {
                updateDateTime();
                setInterval(updateDateTime, 1000);
            });
        </script>
    </x-slot>
</x-dashonic-horizontal-layout>
