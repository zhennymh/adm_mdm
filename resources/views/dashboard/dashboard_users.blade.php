@extends('dashboard.layouts.main')

@section('contents')

    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        {{ $title }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button type="button" onclick="formAdd()" class="btn btn-success d-none d-sm-inline-block"><span>
                                <!-- Download SVG icon from http://tabler-icons.io/i/user-plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 11h6m-3 -3v6" />
                                </svg>
                            </span>Tambah User</button>
                        <button type="button" onclick="formAdd()" class="btn btn-success d-sm-none btn-icon">
                            <!-- Download SVG icon from http://tabler-icons.io/i/user-plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 11h6m-3 -3v6" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col">
                                <h3 class="align-items-start card-title">Daftar User</h3>
                            </div>
                        </div>
                        <div class="table-responsive-md">
                            <table id="users_table" class="table card-table table-vcenter datatable">
                                <thead>
                                    <tr>
                                        <th style="width:10%">No.</th>
                                        <th style="width:30%">Username</th>
                                        <th style="width:30%">Role</th>
                                        <th style="width:30%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit user --}}
    <div class="modal modal-blur fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" name="userid" id="user_id" hidden>
                        <div class="col-lg-6 col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Masukkan username">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" id="role" class="form-select">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="form-label">Permission</div>
                                <div class="modal_permission" id="modal_permission">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" onclick="updateUser()" class="btn btn-primary ms-auto">
                        Ubah Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal tambah user --}}
    <div class="modal modal-blur fade" id="modal-add-user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="add_username"
                                    placeholder="Masukkan username">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" id="add_role" class="form-select">
                                    <option selected disabled value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="add_password"
                                    placeholder="Masukkan password">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirm"
                                    id="add_password_confirm" placeholder="Konfirmasi password">
                            </div>
                            <div id="add_match"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="form-label">Permission</div>
                                <div id="add_modal_permission" class="modal_permission">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" onclick="addUser()" class="btn btn-success ms-auto">
                        Tambahkan User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var users;

        function menu() {
            //menampilkan daftar menu
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/getAllMenu') }}",
                type: 'POST',
                dataType: "json",
                data: {},
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {

                    let checkbox = '';
                    $('.modal_permission').html(checkbox);
                    for (let i in response) {
                        checkbox += '<label class="form-check form-check-inline">';
                        checkbox += '<input name="menu_permission" value="' + response[i].id +
                            '" class="form-check-input" type="checkbox" id="' + response[i]
                            .id + '">';
                        checkbox += '<span class="form-check-label">' + response[i].menu +
                            '</span>';
                        checkbox += '</label>';
                    }

                    $('.modal_permission').html(checkbox);

                }
            });
        }

        menu();

        $(document).ready(function() {

            //menampilkan data users dari database ke datatable
            users = $('#users_table').DataTable({
                columnDefs: [{
                    "searchable": false,
                    "orderable": false,
                    "targets": [0, 3],
                }],
                order: [
                    [1, "asc"]
                ],
                paging: false,
                searching: false,
                bInfo: false,
                ajax: {
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'url': "{{ url('/getUsers') }}",
                    'type': 'POST',
                    "data": function(data) {

                    }
                },
                processing: true,
                serverSide: false,
            });

            //membuat nomer urut di datatable
            users.on('order.dt search.dt', function() {
                users.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

        });

        function formAdd() {
            // Display Modal
            $('#modal-add-user').modal('show');
            $('#modal-add-user').find("input[type=text], input[type=password]").val("");
            menu();
        };

        function addUser() {
            let username = $('#add_username').val();
            let role_id = $('#add_role').val();
            let password = $('#add_password').val();
            let password_confirm = $('#add_password_confirm').val();
            let permission = [];

            $("#add_modal_permission :checkbox").each(function() {
                var ischecked = $(this).is(":checked");
                if (ischecked) {
                    permission.push($(this).val());
                }
            });

            if (username != '' || role_id != '' || password != '' || password_confirm != '') {
                if (password == password_confirm) {
                    console.log(username, role_id, password, password_confirm, permission);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ url('/addUser') }}",
                        type: 'POST',
                        dataType: "text",
                        data: {
                            username,
                            role_id,
                            password,
                            permission
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = xhr.status + ': ' + xhr.statusText;
                            alert('Error - ' + errorMessage);
                        },
                        success: function(response) {
                            alert(response);
                        }
                    });

                    $('#modal-add-user').modal('hide');

                    users.ajax.reload();
                } else {
                    alert('Password tidak cocok!');
                }

            } else {
                alert('Form tidak boleh kosong!');
            }


        }

        //menampilkan data user by id
        function formEdit(id) {
            console.log(id);

            // Display Modal
            $('#modal-edit-user').modal('show');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/getUserDetail') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    userid: id
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    // console.log(response)
                    $('#user_id').val(response.user_id);
                    $('#username').val(response.username);
                    $('#role option[value="' + response.role_id + '"]').prop('selected', true);
                    $('#modal_permission input:checkbox').prop('checked', false);
                    // $("#modal_permission input:checkbox").prop("checked", !$(".checkbox").prop("checked"));
                    for (let i in response.menu) {
                        $('#' + response.menu[i]).prop('checked', true);
                    }
                }
            });
        };

        //simpan perubahan user
        function updateUser() {
            let user_id = $('#user_id').val();
            let username = $('#username').val();
            let role_id = $('#role').val();
            let permission = [];

            $("#modal_permission :checkbox").each(function() {
                var ischecked = $(this).is(":checked");
                if (ischecked) {
                    permission.push($(this).val());
                }
            });

            console.log(user_id, username, role_id, permission);

            if (username == '' || role_id == '') {
                alert('Form tidak boleh kosong!');
            } else {
                console.log(user_id, username, role_id, permission);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/updateUser') }}",
                    type: 'POST',
                    dataType: "text",
                    data: {
                        user_id,
                        username,
                        role_id,
                        permission
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Error - ' + errorMessage);
                    },
                    success: function(response) {
                        alert(response);
                    }
                });

                $('#modal-edit-user').modal('hide');

                users.ajax.reload();
            }
        }

        //delete user
        function deleteUser(id, username) {
            if (confirm('Apakah anda yakin menghapus ' + username + '?')) {
                let user_id = id;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/deleteUser') }}",
                    type: 'POST',
                    dataType: "text",
                    data: {
                        user_id
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Error - ' + errorMessage);
                    },
                    success: function(response) {
                        alert(response);
                    }
                });

                users.ajax.reload();
            } else {
                // Do nothing!
                // console.log('Thing was not saved to the database.');
            }
        }

        // fungsi untuk cek kecocokan password di form add
        $('#add_password, #add_password_confirm').on('keyup', function() {
            if ($('#add_password').val() == $('#add_password_confirm').val()) {
                $('#add_match').removeClass().addClass('pt-2 text-success').html(
                    '<b><small>Password matched</small></b>');
            } else
                $('#add_match').removeClass().addClass('pt-2 text-danger').html(
                    '<b><small>Password not matched!</small></b>');
        });
    </script>

@endsection
