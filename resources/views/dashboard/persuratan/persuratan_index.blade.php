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
            </div>
        </div>

        <div class="page-body">
            <div class="mt-1 row row-deck row-cards">
                <div class="card">
                    <form action="{{ url('/persuratan_export') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <div class="col">
                                <h3 class="align-items-start card-title"><span>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/filter -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5" />
                                        </svg>
                                    </span>Filter Data</h3>
                            </div>
                            <div class="col text-end">
                                <button type="submit" id="btn_save_excel"
                                    class=" align-items-end btn btn-sm btn-outline-success align-items-center"><span>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/download -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <polyline points="7 11 12 16 17 11" />
                                            <line x1="12" y1="4" x2="12" y2="16" />
                                        </svg>
                                    </span>Excel</button>
                            </div>
                        </div>
                        <div class="card-body" id="filter">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-label">Jenis Surat</div>
                                    <select class="form-select" name="filter_jenis_surat" id="filter_jenis_surat">
                                        <option value="" selected disabled>Pilih Jenis Surat</option>
                                        <option value="masuk">Surat Masuk</option>
                                        <option value="keluar">Surat Keluar</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-label">Periode</div>
                                    <input type="text" class="datepicker2 form-control" name="filter_tanggal"
                                        id="filter_tanggal" placeholder="Periode">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col text-center pb-3">
                            <button id="btn_filter" class="btn btn-primary">Filter</button>
                            <button id="btn_reset" class="btn btn-white">Reset Filter</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="col">
                                <h3 class="align-items-start card-title"><span>
                                    </span>Surat Masuk</h3>
                            </div>
                            <div class="col text-end">
                                <button onclick="add_masuk()" type="submit" id="btn_save_excel"
                                    class="align-items-end btn btn-sm btn-outline-primary align-items-center"><span>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/download -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                                            <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                        </svg>
                                    </span>Tambah Surat Masuk</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-md">
                                <table id="masuk_table" class="table card-table table-vcenter datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nomor Surat</th>
                                            <th>Tanggal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="col">
                                <h3 class="align-items-start card-title"><span>
                                    </span>Surat Keluar</h3>
                            </div>
                            <div class="col text-end">
                                <button onclick="add_keluar()" type="submit" id="btn_save_excel"
                                    class="align-items-end btn btn-sm btn-outline-primary align-items-center"><span>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/download -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M15 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
                                            <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                        </svg>
                                    </span>Tambah Surat Keluar</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-md">
                                <table id="keluar_table" class="table card-table table-vcenter datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nomor Surat</th>
                                            <th>Tanggal</th>
                                            <th>Perihal</th>
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

    </div>

    {{-- modal untuk tambah surat masuk --}}
    <div class="modal modal-blur fade" id="modal_add_masuk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Surat Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="form-label">Tanggal Masuk</label>
                            <input id="add_masuk_tanggal" type="text" class="datepicker1 form-control mb-2">
                        </div>
                        <div class="col-lg-8">
                            <label class="form-label">Nomor Surat</label>
                            <input id="add_masuk_nomor_surat" type="text" class="form-control mb-2">
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Perihal</label>
                            <textarea id="add_masuk_perihal" class="form-control mb-2" placeholder="Perihal Surat" rows="5"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button id="add_masuk_clear" type="button" class="btn me-auto">Clear</button>
                    <button id="add_masuk_save" type="button" class="btn btn-success">Tambah Surat</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal untuk tambah surat keluar --}}
    <div class="modal modal-blur fade" id="modal_add_keluar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Surat Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input id="add_keluar_tanggal" type="text" class="datepicker1 form-control mb-2">
                        </div>
                        <div class="col-lg-9">
                            <label class="form-label">Nomor Surat</label>
                            <input id="add_keluar_nomor_surat" type="text" class="form-control mb-2">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Jenis Surat</label>
                            <select id="add_keluar_jenis_surat" type="text" class="form-control mb-2">
                                <option value="" disabled selected>Pilih jenis surat</option>
                                <option value="KP">KP</option>
                                <option value="ND">ND</option>
                            </select>
                        </div>
                        <div class="col-lg-3" hidden id="header_div">
                            <label class="form-label">Header</label>
                            <select id="add_keluar_header" type="text" class="form-control mb-2">

                            </select>
                        </div>
                        <div class="col-lg-3" hidden id="subheader_div">
                            <label class="form-label">Sub Header</label>
                            <select id="add_keluar_subheader" type="text" class="form-control mb-2">
                                <option value="" disabled selected>Pilih Sub Header</option>'
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <button id="add_keluar_generate" type="button"
                                class="form-control btn btn-success text-center me-auto" style="margin-top:28px">
                                Generate
                            </button>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Perihal</label>
                            <textarea id="add_keluar_perihal" class="form-control mb-2" placeholder="Perihal Surat" rows="5"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button id="add_keluar_clear" type="button" class="btn me-auto">Clear</button>
                    <button disabled id="add_keluar_save" type="button" class="btn btn-primary">Tambah Surat</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal untuk detail surat --}}
    <div class="modal modal-blur fade" id="modal_show" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input hidden id="show_id" type="text" class="datepicker1 form-control mb-2">
                        <div class="col-lg-4">
                            <label class="form-label">Tanggal</label>
                            <input disabled id="show_tanggal" type="text" class="datepicker1 form-control mb-2">
                        </div>
                        <div class="col-lg-8">
                            <label class="form-label">Nomor Surat</label>
                            <input disabled id="show_nomor_surat" type="text" class="form-control mb-2">
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Perihal</label>
                            <textarea disabled id="show_perihal" class="form-control mb-2" placeholder="Perihal Surat" rows="5"></textarea>
                        </div>
                    </div>

                </div>
                {{-- <div class="modal-footer">
                    <button id="add_masuk_clear" type="button" class="btn me-auto">Clear</button>
                    <button id="add_masuk_save" type="button" class="btn btn-success">Tambah Surat</button>
                </div> --}}
            </div>
        </div>
    </div>

    {{-- daterange picker --}}
    <script>
        $(function() {
            let startDate;
            let endDate;

            $('.datepicker2').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract(
                        'month', 1).endOf('month')]
                },
                showCustomRangeLabel: true,
                alwaysShowCalendars: true,
                autoUpdateInput: false,
            });
        });

        $('.datepicker2').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('.datepicker2').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $(function() {
            $(".datepicker1").datepicker({
                todayBtn: 'linked',
                format: "yyyy-mm-dd",
                autoclose: true,
                orientation: "bottom"
            });
        });

        // console.log($('#filter_masuk').data('daterangepicker').startDate.format('YYYY/MM/DD'));
    </script>

    {{-- manajemen surat --}}
    <script>
        //fungsi untuk menarik site
        function query_surat(field_id, route, filter, db_table) {
            let i = 1;
            let id_user = @json(auth()->user());
            id_user = id_user.id;

            let tanggal = $('#filter_tanggal').val().split(" - ");

            if (id_user == 1) {
                const table = $(field_id).DataTable({
                    scrollX: false,
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [
                        [5, 10, 25, 50, 100],
                        [5, 10, 25, 50, 100]
                    ],
                    bLengthChange: true,
                    bFilter: true,
                    bInfo: true,
                    searching: true,
                    processing: true,
                    bServerSide: true,
                    order: [
                        [1, "asc"]
                    ],
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: route,
                        type: "POST",
                        // data: {
                        //     db_table,
                        //     data.tanggal_start = tanggal[0],
                        //     data.tanggal_end = tanggal[1],
                        // }
                        data: function(data) {
                            data.db_table = db_table;
                            if (filter == true) {
                                data.tanggal_start = tanggal[0];
                                data.tanggal_end = tanggal[1];
                            } else {

                            }
                        }
                    },
                    buttons: [{
                        extend: 'copy',
                        className: 'btn-primary'
                    }],
                    columns: [{
                            "data": null,
                            "sortable": false,
                            "render": function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.nomor_surat
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.tanggal
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return '<button type="button" onclick="showSurat(`' + row.id + '`, `' +
                                db_table +
                                '`)"class = " align-items-end btn btn-sm btn-outline-primary align-items-center">Detail </button>' +
                                    '<button type="button" onclick="deleteSurat(`' + row.id + '`, `' + row
                                .nomor_surat + '`, `' + db_table +
                                '`)"class = " align-items-end btn btn-sm btn-outline-danger align-items-center">Delete </button>'
                            }
                        },

                    ]
                });
            } else {
                const table = $(field_id).DataTable({
                    scrollX: false,
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [
                        [5, 10, 25, 50, 100],
                        [5, 10, 25, 50, 100]
                    ],
                    bLengthChange: true,
                    bFilter: true,
                    bInfo: true,
                    searching: true,
                    processing: true,
                    bServerSide: true,
                    order: [
                        [1, "asc"]
                    ],
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: route,
                        type: "POST",
                        data: {
                            db_table
                        }
                        // data: function(data) {
                        //     if (filter == true) {
                        //         data.id_jenis_pemohon = $('#filter_pemohon').val();
                        //         data.tanggal_masuk_start = tanggal_masuk[0];
                        //         data.tanggal_masuk_end = tanggal_masuk[1];
                        //         data.tanggal_terima_start = tanggal_terima[0];
                        //         data.tanggal_terima_end = tanggal_terima[1];
                        //         data.tanggal_keluar_start = tanggal_keluar[0];
                        //         data.tanggal_keluar_end = tanggal_keluar[0];
                        //     } else {

                        //     }
                        // }
                    },
                    buttons: [{
                        extend: 'copy',
                        className: 'btn-primary'
                    }],
                    columns: [{
                            "data": null,
                            "sortable": false,
                            "render": function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.nomor_surat
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.tanggal
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return '<button type="button" onclick="showSurat(`' + row.id + '`, `' +
                                db_table +
                                '`)"class = " align-items-end btn btn-sm btn-outline-primary align-items-center">Detail </button>'
                            }
                        },

                    ]
                });
            }
        }

        let click = false;

        query_surat("#masuk_table", "{{ url('/persuratan') }}", false, 'persuratan_masuk'); //tampilkan di datatable
        query_surat("#keluar_table", "{{ url('/persuratan') }}", false, 'persuratan_keluar'); //tampilkan di datatable

        //handle ketika tombol filter di tekan
        $("#btn_filter").click(function() {
            if ($('#filter_jenis_surat').val() == 'masuk') {
                console.log(true);
                $('#masuk_table').DataTable().destroy();
                query_surat("#masuk_table", "{{ url('/persuratan') }}", true, 'persuratan_masuk'); //tampilkan di datatable
            } else if ($('#filter_jenis_surat').val() == 'keluar') {
                $('#keluar_table').DataTable().destroy();
                query_surat("#keluar_table", "{{ url('/persuratan') }}", true, 'persuratan_keluar'); //tampilkan di datatable
            } else if ($('#filter_tanggal').val() != null && $('#filter_jenis_surat').val() == null) {
                console.log('here');
                $('#masuk_table').DataTable().destroy();
                $('#keluar_table').DataTable().destroy();
                query_surat("#masuk_table", "{{ url('/persuratan') }}", true, 'persuratan_masuk'); //tampilkan di datatable
                query_surat("#keluar_table", "{{ url('/persuratan') }}", true, 'persuratan_keluar'); //tampilkan di datatable
            } else {
                $('#masuk_table').DataTable().destroy();
                $('#keluar_table').DataTable().destroy();
                query_surat("#masuk_table", "{{ url('/persuratan') }}", false, 'persuratan_masuk'); //tampilkan di datatable
                query_surat("#keluar_table", "{{ url('/persuratan') }}", false, 'persuratan_keluar'); //tampilkan di datatable
            }
            click = true;
        })

        //handle ketika tombol reset di tekan
        $("#btn_reset").click(function() {
            $('#filter').find("input[type=text]").val("");
            $("#filter select").val("").change();
        })

        //handle ketika tomboll add surat masuk di tekan
        function add_masuk() {
            // Display Modal
            $('#modal_add_masuk').modal('show');
            $('#modal_add_masuk').find("input[type=text]").val("");
        }

        $("#add_masuk_clear").click(function() {
            $('#modal_add_masuk').find("input[type=text]").val("");
            $('#modal_add_masuk').find("textarea").val("");
        })

        $("#add_masuk_save").click(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/persuratan_add_masuk') }}",
                type: 'POST',
                dataType: "text",
                data: {
                    tanggal: $('#add_masuk_tanggal').val(),
                    nomor_surat: $('#add_masuk_nomor_surat').val(),
                    perihal: $('#add_masuk_perihal').val(),
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    alert(response);

                    $('#masuk_table').DataTable().destroy();
                    query_surat("#masuk_table", "{{ url('/persuratan') }}", false, 'persuratan_masuk');
                    click = true;
                    $('#modal_add_masuk').modal('hide');
                }
            });
        })

        //handle ketika tomboll add surat masuk di tekan
        function add_keluar() {
            // Display Modal
            $('#modal_add_keluar').modal('show');
            $('#modal_add_keluar').find("input[type=text]").val("");
            document.getElementById("add_keluar_save").disabled = true;
        }
        $("#add_keluar_clear").click(function() {
            $('#modal_add_keluar').find("input[type=text]").val("");
            $('#modal_add_keluar').find("textarea").val("");
            $('#add_keluar_jenis_surat[value=""]').attr("selected", true);
            document.getElementById("add_keluar_save").disabled = true;
        })

        $("#add_keluar_save").click(function() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/persuratan_add_keluar') }}",
                type: 'POST',
                dataType: "text",
                data: {
                    tanggal: $('#add_keluar_tanggal').val(),
                    nomor_surat: $('#add_keluar_nomor_surat').val(),
                    perihal: $('#add_keluar_perihal').val(),
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    alert(response);

                    $('#keluar_table').DataTable().destroy();
                    query_surat("#keluar_table", "{{ url('/persuratan') }}", false, 'persuratan_keluar');
                    click = true;
                    $('#modal_add_keluar').modal('hide');
                }
            });
        })

        function deleteSurat(id_surat, surat, db_table) {
            if (confirm('Apakah anda yakin menghapus ' + surat + '?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/persuratan_deleteSurat') }}",
                    type: 'POST',
                    dataType: "text",
                    data: {
                        id_surat,
                        db_table
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Error - ' + errorMessage);
                    },
                    success: function(response) {
                        alert(response);

                        if (db_table == 'persuratan_masuk') {
                            $('#masuk_table').DataTable().destroy();
                            query_surat("#masuk_table", "{{ url('/persuratan') }}", false, 'persuratan_masuk');
                        } else if (db_table == 'persuratan_keluar') {
                            $('#keluar_table').DataTable().destroy();
                            query_surat("#keluar_table", "{{ url('/persuratan') }}", false, 'persuratan_keluar');
                        }

                    }
                });



            } else {
                // Do nothing!
                // console.log('Thing was not saved to the database.');
            }
        }

        function showSurat(id_surat, db_table) {
            $('#modal_show').modal('show');
            $('#modal_show').find("input[type=text]").val("");
            $('#modal_show').find("textarea").val("");

            // $('#show_edit').attr("hidden", false);
            // $('#show_clear').attr("hidden", true);
            // $('#show_cancel').attr("hidden", true);
            // $('#show_save').attr("hidden", true);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/persuratan_showSurat') }}",
                type: 'POST',
                dataType: "text",
                data: {
                    id_surat,
                    db_table
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    response = JSON.parse(response)[0]
                    // console.log(response);
                    $('#show_id').val(response.id);
                    $('#show_tanggal').val(response.tanggal);
                    $('#show_nomor_surat').val(response.nomor_surat);
                    $('#show_perihal').val(response.perihal);
                }
            });
        }

        $("#show_edit").click(function() {
            $('#modal_show').find("input[type=text]").attr("disabled", false);
            $('#modal_show').find("select").attr("disabled", false);
            $('#show_edit').attr("hidden", true);
            $('#show_clear').attr("hidden", false);
            $('#show_cancel').attr("hidden", false);
            $('#show_save').attr("hidden", false);
        })

        $("#show_cancel").click(function() {
            if (confirm('Data yang sudah diubah tidak akan tersimpan, lanjutkan?')) {
                showSurat($("#show_id").val());
                $('#show_edit').attr("hidden", false);
                $('#show_clear').attr("hidden", true);
                $('#show_cancel').attr("hidden", true);
                $('#show_save').attr("hidden", true);
            }
        })

        $("#show_clear").click(function() {
            $('#modal_show').find("input[type=text]").val("");
            $('#show_jenis_pemohon option[value=""]').prop('selected', true);
        })

        $("#show_save").click(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/peldata_save') }}",
                type: 'POST',
                dataType: "text",
                data: {
                    id: $('#show_id').val(),
                    tanggal_masuk: $('#show_tanggal_masuk').val(),
                    tanggal_terima: $('#show_tanggal_terima').val(),
                    surat_masuk: $('#show_surat_masuk').val(),
                    pemohon: $('#show_pemohon').val(),
                    id_jenis_pemohon: $('#show_jenis_pemohon').val(),
                    jumlah_lokasi: $('#show_jumlah_lokasi').val(),
                    lokasi: $('#show_lokasi').val(),
                    jumlah_parameter: $('#show_jumlah_parameter').val(),
                    parameter: $('#show_parameter').val(),
                    periode: $('#show_periode').val(),
                    tanggal_keluar: $('#show_tanggal_keluar').val(),
                    surat_keluar: $('#show_surat_keluar').val(),
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    alert(response);
                    showSurat($("#show_id").val());
                    $('#show_edit').attr("hidden", false);
                    $('#show_clear').attr("hidden", true);
                    $('#show_cancel').attr("hidden", true);
                    $('#show_save').attr("hidden", true);

                    $('#pelayanan_table').DataTable().destroy();
                    query_surat(true);
                    click = true;
                }
            });
        })

        //fungsi untuk menarik header
        function tarikHeader(field) {
            $.getJSON("{{ url('/persuratan_header') }}", function(data) {
                $(field).html('');
                $(field).append('<option value="" disabled selected>Pilih Header</option>')
                $.each(data, function() {
                    $(field).append('<option value="' + this.id_header + '">' + '(' + this.id_header +
                        ') ' + this.header +
                        '</option>')
                })
            })
        }

        $("#add_keluar_jenis_surat").change(function() {
            if ($("#add_keluar_jenis_surat").val() == 'KP') {
                $('#header_div').attr("hidden", false);
                tarikHeader("#add_keluar_header");
            } else {
                $('#header_div').attr("hidden", true);
                $('#subheader_div').attr("hidden", true);
            }
        });

        $("#add_keluar_header").change(function() {
            const header = ['00', '01', '02', '03', '04', '05', '06'];
            if (header.includes($("#add_keluar_header").val()) == true) {
                $('#subheader_div').attr("hidden", false);
            } else {
                $('#subheader_div').attr("hidden", true);
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/persuratan_subheader') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    id_header: $("#add_keluar_header").val()
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(kabupaten) {
                    $("#add_keluar_subheader").html('');
                    $("#add_keluar_subheader").append(
                        '<option value="" disabled selected>Pilih Sub Header</option>');
                    $.each(kabupaten, function() {
                        $("#add_keluar_subheader").append('<option value="' + this
                            .id_subheader + '">' + '(' + this.id_subheader + ') ' + this
                            .subheader + '</option>');
                    })
                }
            });
        });
    </script>

    <script>
        function romanize(num) {
            if (!+num)
                return false;
            var digits = String(+num).split(""),
                key = ["", "C", "CC", "CCC", "CD", "D", "DC", "DCC", "DCCC", "CM",
                    "", "X", "XX", "XXX", "XL", "L", "LX", "LXX", "LXXX", "XC",
                    "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX"
                ],
                roman = "",
                i = 3;
            while (i--)
                roman = (key[+digits.pop() + (i * 10)] || "") + roman;
            return Array(+digits.join("") + 1).join("M") + roman;
        }

        function generateNomor() {
            let jenis = $("#add_keluar_jenis_surat").val();
            let header = $("#add_keluar_header").val();
            let subheader = $("#add_keluar_subheader").val();
            let date = Date.parse($("#add_keluar_tanggal").val());

            date = new Date(date);

            let month = romanize(date.getMonth() + 1);
            let year = date.getFullYear();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/persuratan_cekSequence') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    jenis,
                    header,
                    subheader,
                    year,
                    month,
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(nomor_surat) {
                    $("#add_keluar_nomor_surat").val(nomor_surat);
                }
            });



            // console.log(jenis, header, subheader, date, month, year);
        }

        $("#add_keluar_generate").click(function() {
            generateNomor();
            document.getElementById("add_keluar_save").disabled = false;
        })
    </script>
@endsection
