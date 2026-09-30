    <x-dashonic-horizontal-layout sidebar="1" with-sidebar="{{ request()->get('with-sidebar') ?? 1 }}"
        with-header="{{ request()->get('with-header') ?? 1 }}" with-footer="{{ request()->get('with-footer') ?? 0 }}">

        <div style="margin-top: 80px;"></div>
        <div class="d-lg-flex mb-4">
            <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
                <div class="card">
                    <div class="card-header d-lg-flex justify-content-between">
                        <h5 class="card-title">SPV Dashboard</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <button type="button" class="btn btn-primary w-100 mb-3"
                                    onclick="refreshData()">Refresh Data</button>
                                {{-- <button type="button" class="btn btn-secondary float-end m-1" onclick="btn_release_all()">Release all</button> --}}
                                <iframe src="{{ route('report_all.spv.iframe-chat-opens', request()->all()) }}"
                                    class="mt-3" id="iframe-chat-open" frameborder="0"
                                    style="width: 100%;border:none;" height="100%"></iframe>
                                {{-- <table class="table table-bordered" id="table-chat-opens">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Channel</th>
                                        <th>Account</th>
                                        <th>Agent</th>
                                        <th>Status</th>
                                        <th>Start at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title rounded-circle font-size-12">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Chat in Queue</p>
                                                <h5 class="font-size-16 mb-0" id="chat_queue">2.2 k</h5>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title rounded-circle font-size-12">
                                                        <i class="fas fa-hourglass-start"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Chat on Handled</p>
                                                <h5 class="font-size-16 mb-0" id="chat_handled">3.85 k</h5>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title rounded-circle font-size-12">
                                                        <i class="fas fa-stopwatch"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Total Chat Open</p>
                                                <h5 class="font-size-16 mb-0" id="chat_open">1 min</h5>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title rounded-circle font-size-12">
                                                        <i class="fas fa-chart-area"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Total Chat Closed</p>
                                                <h5 class="font-size-16 mb-0" id="chat_close">24.03 %</h5>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="selectAgents" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectAgentsLabel">List Agent Ready</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" id="table-select-agents">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <x-slot name="js">
            <script>
                $(document).ready(() => {
                    // setInterval(() => {
                    // table_chat_opens()
                    get_summary()

                    window.onload = function() {
                        var iframe = document.getElementById("iframe-chat-open");
                        iframe.height = iframe.contentWindow.document.body.scrollHeight;
                    }
                    // }, 3000);
                });

                function refreshData() {
                    document.getElementById('iframe-chat-open').contentWindow.location.reload(true);
                    // table_chat_opens()
                    get_summary()
                }

                function table_chat_opens() {
                    $.get("{{ route('report_all.spv.table-chat-opens', request()->all()) }}", (result) => {
                        $('#table-chat-opens tbody').html('');

                        let tbody = "";
                        result.forEach(row => {
                            tbody += `<tr>
                                    <td>${row.channel_user.name ?? ""}</td>
                                    <td>${row.channel.name ?? ""}</td>
                                    <td>${row.source.name ?? ""}</td>
                                    <td>${ (row.user_handle !== null) ? (row.user_handle.name ?? "") : ""}</td>
                                    <td>${genStatus(row.status)}</td>
                                    <td>${row.created_at ?? ""}</td>
                                    <td>${genBtnAction(row)}</td>
                                </tr>`
                        });

                        $('#table-chat-opens tbody').html(tbody);
                    });
                }

                function genStatus(status) {
                    if (status == "open") return `<span class="badge badge-success bg-success">${status}</span>`
                    if (status == "close") return `<span class="badge badge-danger bg-danger">${status}</span>`
                    if (status == "queue") return `<span class="badge badge-danger bg-warning">${status}</span>`
                }

                function genBtnAction(row) {
                    let result = "";
                    if (row.user_handle != null) {
                        result +=
                            `<button class="btn btn-sm btn-warning m-1" type="button" onclick="btn_release(${row.id})">Release</button>`
                        result +=
                            `<button class="btn btn-sm btn-danger m-1" type="button" onclick="btn_assign(${row.id})">Re-assign to</button>`
                    } else {
                        result +=
                            `<button class="btn btn-sm btn-primary m-1" type="button" onclick="btn_assign(${row.id})">Assign to</button>`
                    }

                    return result;
                }

                function btn_release_all() {
                    $.post("{{ route('report_all.spv.release-all', request()->all()) }}", {}, (result) => {
                        Swal.fire('Success', result.msg, 'success')
                        refreshData()
                    })
                }

                function btn_release(id) {
                    $.post("{{ route('report_all.spv.release', request()->all()) }}", {
                        id: id
                    }, (result) => {
                        Swal.fire('Success', result.msg, 'success')
                        refreshData()
                    })
                }

                function btn_assign(chat_header_id) {
                    $.get("{{ route('report_all.spv.user-agents', request()->all()) }}", (result) => {
                        $('#table-select-agents tbody').html('');

                        let tbody = "";
                        result.forEach(row => {
                            tbody += `<tr>
                                    <td>${row.username ?? ""}</td>
                                    <td>${row?.user?.name ?? ""}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning m-1" type="button" onclick="assign(${chat_header_id}, ${row.user_id})">Assign</button>
                                    </td>
                                </tr>`
                        });

                        $('#table-select-agents tbody').html(tbody);
                        $('#selectAgents').modal('show')
                    });
                }

                function assign(chat_header_id, user_id) {
                    $.post("{{ route('report_all.spv.assign', request()->all()) }}", {
                        chat_header_id: chat_header_id,
                        user_id: user_id,
                        "_token": "{{ csrf_token() }}"
                    }, (result) => {
                        console.log(result)
                        if (result.status) {
                            $('#selectAgents').modal('hide');
                            Swal.fire('Success', result.msg, 'success')
                            refreshData()
                        } else {
                            alert("gagal");
                        }
                    })
                }

                function get_summary() {
                    $.get("{{ route('report_all.spv.chat-summary', request()->all()) }}", (result) => {
                        $('#chat_queue').text(result.chat_queue)
                        $('#chat_handled').text(result.chat_handled)
                        $('#chat_open').text(result.chat_open)
                        $('#chat_close').text(result.chat_close)
                    });
                }
            </script>
        </x-slot>
    </x-dashonic-horizontal-layout>
