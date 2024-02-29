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
                        <button type="button" onclick="add_surat()" class="btn btn-success d-none d-sm-inline-block"><span>
                                <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="13" y1="20" x2="20" y2="13" />
                                    <path
                                        d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" />
                                </svg>
                            </span>Tambah Surat</button>
                        <button type="button" onclick="add_surat()" class="btn btn-success d-sm-none btn-icon">
                            <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="13" y1="20" x2="20" y2="13" />
                                <path
                                    d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" />
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
                        <form action="{{ url('/peldata_export') }}" method="POST">
                            @csrf
                            <div class="card-header">
                                <div class="col">
                                    <h3 class="align-items-start card-title"><span>
                                            <!-- Download SVG icon from http://tabler-icons.io/i/filter -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-label">Jenis Pemohon</div>
                                        <select class="form-select" name="filter_pemohon" id="filter_pemohon">
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-label">Tanggal Masuk</div>
                                        <input type="text" class="datepicker2 form-control" name="filter_masuk"
                                            id="filter_masuk" placeholder="Tanggal masuk">
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-label">Tanggal Terima</div>
                                        <input type="text" class="datepicker2 form-control" name="filter_terima"
                                            id="filter_terima" placeholder="Tanggal Terima">
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-label">Tanggal Keluar</div>
                                        <input type="text" class="datepicker2 form-control" name="filter_keluar"
                                            id="filter_keluar" placeholder="Tanggal keluar">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col text-center">
                                <button id="btn_filter" class="btn btn-primary">Filter</button>
                                <button id="btn_reset" class="btn btn-white">Reset Filter</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-md">
                                <table id="pelayanan_table" class="table card-table table-vcenter datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Terima</th>
                                            <th>Surat Masuk</th>
                                            <th>Pemohon</th>
                                            <th>Jenis Pemohon</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Surat Keluar</th>
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
            </div>
        </div>

    </div>

    {{-- modal untuk tambah surat --}}
    <div class="modal modal-blur fade" id="modal_add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="form_add_surat" action="javascript:void(0)">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-label">Tanggal Masuk</label>
                                <input name="add_tanggal_masuk" id="add_tanggal_masuk" type="text"
                                    class="datepicker1 form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Tanggal Terima</label>
                                <input name="add_tanggal_terima" id="add_tanggal_terima" type="text"
                                    class="datepicker1 form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">No. Surat Masuk</label>
                                <input name="add_surat_masuk" id="add_surat_masuk" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Unggah Surat Masuk</label>
                                <input name="add_file_surat_masuk" id="add_file_surat_masuk" type="file"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Pemohon</label>
                                <input name="add_pemohon" id="add_pemohon" type="text" class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Jenis Pemohon</label>
                                <select class="form-select mb-2" name="add_jenis_pemohon" id="add_jenis_pemohon">
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">PIC</label>
                                <select class="form-select mb-2" name="add_pic"
                                    id="add_pic" type="text">
                                    <option value='' selected disabled>Silakan pilih PIC</option>
                                    <option value="feizal">Feizal Amri Permana</option>
                                    <option value="heru">Heru Tri Buwono</option>
                                    <option value="hesti">Hesti Hati Nurani</option>
                                    <option value="join">Join Wan Chanlyn</option>
                                    <option value="mahisa">Mahisa Ajy Kusuma</option>
                                    <option value="ayu">MDN Ayu Bima</option>
                                    <option value="maya">Mayanatela Putri</option>
                                    <option value="zack">M. Hajar Zakariya</option>
                                    <option value="jeje">Zhenny M. Husna</option>
                                    <option value="fauzi">Fauzi Mahardika</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Link Data</label>
                                <input name="add_link_data" id="add_link_data" type="text" class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Jumlah Lokasi</label>
                                <input name="add_jumlah_lokasi" id="add_jumlah_lokasi" type="number"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Lokasi</label>
                                <input name="add_lokasi" id="add_lokasi" type="text" class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Jumlah Parameter</label>
                                <input name="add_jumlah_parameter" id="add_jumlah_parameter" type="number"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Parameter</label>
                                <input name="add_parameter" id="add_parameter" type="text" class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Periode</label>
                                <input name="add_periode" id="add_periode" type="text" class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Tanggal Keluar</label>
                                <input name="add_tanggal_keluar" id="add_tanggal_keluar" type="text"
                                    class="datepicker1 form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">No. Surat Keluar</label>
                                <input name="add_surat_keluar" id="add_surat_keluar" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Unggah Surat Keluar</label>
                                <input name="add_file_surat_keluar" id="add_file_surat_keluar" type="file"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Keterangan</label>
                                <input name="add_keterangan" id="add_keterangan" type="text" class="form-control mb-2">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button id="add_clear" type="button" class="btn me-auto">Clear</button>

                        <button id="add_save" type="submit" class="btn btn-success">Tambah Surat</button>
                    </div>
                </form>
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
                <form method="POST" enctype="multipart/form-data" id="form_edit_surat" action="javascript:void(0)">
                    <div class="modal-body">
                        <div class="row">
                            <input name="show_id" id="show_id" type="hidden">
                            <div class="col-lg-6">
                                <label class="form-label">Tanggal Masuk</label>
                                <input disabled name="show_tanggal_masuk" id="show_tanggal_masuk" type="text"
                                    class="datepicker1 form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Tanggal Terima</label>
                                <input disabled name="show_tanggal_terima" id="show_tanggal_terima" type="text"
                                    class="datepicker1 form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Surat Masuk <a target="_blank" id="show_file_surat_masuk"
                                        href=""><svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-arrow-up-right-circle" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="12" cy="12" r="9"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <polyline points="15 15 15 9 9 9"></polyline>
                                        </svg></a></label>
                                <input disabled name="show_surat_masuk" id="show_surat_masuk" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Ubah Surat Masuk</label>
                                <input name="show_file_surat_masuk" id="show_file_surat_masuk" type="file"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Pemohon</label>
                                <input disabled name="show_pemohon" id="show_pemohon" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Jenis Pemohon</label>
                                <select disabled class="form-select mb-2" name="show_jenis_pemohon"
                                    id="show_jenis_pemohon">
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">PIC</label>
                                <select disabled class="form-select mb-2"  id="show_pic">
                                    <option value='' selected disabled>Silakan pilih PIC</option>
                                    <option value='feizal'>Feizal Amri Permana</option>
                                    <option value='heru'>Heru Tri Buwono</option>
                                    <option value='hesti'>Hesti Hati Nurani</option>
                                    <option value='join'>Join Wan Chanlyn</option>
                                    <option value='mahisa'>Mahisa Ajy Kusuma</option>
                                    <option value='ayu'>MDN Ayu Bima</option>
                                    <option value='maya'>Mayanatela Putri</option>
                                    <option value='zack'>M. Hajar Zakariya</option>
                                    <option value='jeje'>Zhenny M. Husna</option>
                                    <option value='fauzi'>Fauzi Mahardika</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Link Data</label>
                                <input disabled name="show_link_data" id="show_link_data" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Jumlah Lokasi</label>
                                <input disabled name="show_jumlah_lokasi" id="show_jumlah_lokasi" type="number"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Lokasi</label>
                                <input disabled name="show_lokasi" id="show_lokasi" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Jumlah Parameter</label>
                                <input disabled name="show_jumlah_parameter" id="show_jumlah_parameter" type="number"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Parameter</label>
                                <input disabled name="show_parameter" id="show_parameter" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Periode</label>
                                <input disabled name="show_periode" id="show_periode" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Tanggal Keluar</label>
                                <input disabled name="show_tanggal_keluar" id="show_tanggal_keluar" type="text"
                                    class="datepicker1 form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Surat Keluar <a target="_blank" id="show_file_surat_keluar"
                                        href=""><svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-arrow-up-right-circle" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="12" cy="12" r="9"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <polyline points="15 15 15 9 9 9"></polyline>
                                        </svg></a></label>
                                <input disabled name="show_surat_keluar" id="show_surat_keluar" type="text"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Ubah Surat Keluar</label>
                                <input name="show_file_surat_keluar" id="show_file_surat_keluar" type="file"
                                    class="form-control mb-2">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Keterangan</label>
                                <input disabled name="show_keterangan" id="show_keterangan" type="text" class="form-control mb-2">
                            </div>
                        </div>

                    </div>


                    <div class="modal-body">
                        <p>Waktu Respons : <b><span id="show_respon"></span></b> hari</p>
                    </div>

                    <div class="modal-footer">
                        <button id="show_edit" type="button" class="btn me-auto">Edit</button>

                        <button hidden id="show_clear" type="button" class="btn me-auto">Clear</button>
                        <button hidden id="show_cancel" type="button" class="btn btn-danger">Batal</button>
                        <button hidden id="show_save" type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
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
        //fungsi untuk menarik id alat
        function tarikPemohon(field) {
            $.getJSON("{{ url('/peldata_getPemohon') }}", function(data) {
                $(field).html(''); //# buat nyari id
                $(field).append('<option value="" disabled selected>Pilih Jenis Pemohon</option>')
                // menambahkan opsi ke dropdown jenis alat
                $.each(data, function() {
                    $(field).append('<option value="' + this.id + '">' + '(' + this.id + ') ' +
                        this.jenis_pemohon + '</option>')
                })
            })
        }

        tarikPemohon("#filter_pemohon"); //id pemohon untuk form filter
        tarikPemohon("#show_jenis_pemohon");
        tarikPemohon("#add_jenis_pemohon");

        //fungsi untuk menarik site
        function query_surat(filter) {
            let i = 1;
            let id_user = @json(auth()->user());
            id_user = id_user.id;

            let tanggal_masuk = $('#filter_masuk').val().split(" - ");
            let tanggal_terima = $('#filter_terima').val().split(" - ");
            let tanggal_keluar = $('#filter_keluar').val().split(" - ");

            if (id_user == 1) {
                const table = $("#pelayanan_table").DataTable({
                    scrollX: true,
                    responsive: true,
                    pageLength: 25,
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
                        url: "{{ url('/peldata_getSurat') }}",
                        type: "POST",
                        data: function(data) {
                            if (filter == true) {
                                data.id_jenis_pemohon = $('#filter_pemohon').val();
                                data.tanggal_masuk_start = tanggal_masuk[0];
                                data.tanggal_masuk_end = tanggal_masuk[1];
                                data.tanggal_terima_start = tanggal_terima[0];
                                data.tanggal_terima_end = tanggal_terima[1];
                                data.tanggal_keluar_start = tanggal_keluar[0];
                                data.tanggal_keluar_end = tanggal_keluar[0];
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
                                return row.tanggal_masuk
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.tanggal_terima
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.surat_masuk
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.pemohon
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.jenis_pemohon
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.tanggal_keluar
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.surat_keluar
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return '<button type="button" onclick="showSurat(`' + row.id +
                                '`)"class = " align-items-end btn btn-sm btn-outline-primary align-items-center">Detail </button>' +
                                    '<button type="button" onclick="deleteSurat(`' + row.id + '`, `' + row
                                .surat_masuk +
                                '`)"class = " align-items-end btn btn-sm btn-outline-danger align-items-center">Delete </button>'
                            }
                        },

                    ]
                });
            } else {
                const table = $("#pelayanan_table").DataTable({
                    scrollX: false,
                    responsive: true,
                    pageLength: 25,
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
                        url: "{{ url('/peldata_getSurat') }}",
                        type: "POST",
                        data: function(data) {
                            if (filter == true) {
                                data.id_jenis_pemohon = $('#filter_pemohon').val();
                                data.tanggal_masuk_start = tanggal_masuk[0];
                                data.tanggal_masuk_end = tanggal_masuk[1];
                                data.tanggal_terima_start = tanggal_terima[0];
                                data.tanggal_terima_end = tanggal_terima[1];
                                data.tanggal_keluar_start = tanggal_keluar[0];
                                data.tanggal_keluar_end = tanggal_keluar[0];
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
                                return row.tanggal_masuk
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.tanggal_terima
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.surat_masuk
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.pemohon
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.jenis_pemohon
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.tanggal_keluar
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return row.surat_keluar
                            }
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return '<button type="button" onclick="showSurat(`' + row.id +
                                '`)"class = " align-items-end btn btn-sm btn-outline-primary align-items-center">Detail </button>'
                            }
                        },

                    ]
                });
            }
        }

        let click = false;

        query_surat(false); //tampilkan di datatable

        //handle ketika tombol filter di tekan
        $("#btn_filter").click(function() {
            $('#pelayanan_table').DataTable().destroy();
            query_surat(true);
            click = true;
        })

        //handle ketika tombol reset di tekan
        $("#btn_reset").click(function() {
            $('#filter').find("input[type=text]").val("");

            tarikPemohon("#filter_pemohon");
            $('#pelayanan_table').DataTable().destroy();
            query_surat(false);
        })

        //handle ketika tomboll add di tekan
        function add_surat() {
            // Display Modal
            $('#modal_add').modal('show');
            $('#modal_add').find("input[type=text], input[type=number], input[type=file]").val("");
            tarikPemohon("#add_jenis_pemohon");
        }

        $("#add_clear").click(function() {
            $('#modal_add').find("input[type=text], input[type=number], input[type=file]").val("");
            tarikPemohon("#add_jenis_pemohon");
        })

        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#form_add_surat').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ url('peldata_add') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        this.reset();
                        alert(response);
                        $('#modal_add').modal('hide');
                        $('#pelayanan_table').DataTable().destroy();
                        query_surat(true);
                        click = true;
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        });

        function deleteSurat(id_surat, surat) {
            if (confirm('Apakah anda yakin menghapus ' + surat + '?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/peldata_deleteSurat') }}",
                    type: 'POST',
                    dataType: "text",
                    data: {
                        id_surat
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Error - ' + errorMessage);
                    },
                    success: function(response) {
                        alert(response);

                        $('#pelayanan_table').DataTable().destroy();
                        query_surat(true);
                    }
                });



            } else {
                // Do nothing!
                // console.log('Thing was not saved to the database.');
            }
        }

        function showSurat(id_surat) {
            $('#modal_show').modal('show');
            $('#modal_show').find("input[type=text]").val("");

            $('#modal_show').find("input[type=text]").attr("disabled", true);
            $('#modal_show').find("input[type=file]").attr("disabled", true);
            $('#modal_show').find("input[type=number]").attr("disabled", true);
            $('#modal_show').find("select").attr("disabled", true);

            $('#show_edit').attr("hidden", false);
            $('#show_clear').attr("hidden", true);
            $('#show_cancel').attr("hidden", true);
            $('#show_save').attr("hidden", true);

            $("#show_file_surat_masuk").attr("hidden", true);
            $("#show_file_surat_keluar").attr("hidden", true);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/peldata_showSurat') }}",
                type: 'POST',
                dataType: "text",
                data: {
                    id_surat
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    response = JSON.parse(response)[0]
                    console.log(response);
                    $('#show_id').val(response.id);
                    $('#show_tanggal_masuk').val(response.tanggal_masuk);
                    $('#show_tanggal_terima').val(response.tanggal_terima);
                    $('#show_surat_masuk').val(response.surat_masuk);
                    if (response.file_surat_masuk) {
                        $("#show_file_surat_masuk").attr("hidden", false);
                        $("#show_file_surat_masuk").attr("href", "{{ url('/storage/upload/surat_masuk') }}/" + response
                            .file_surat_masuk);
                    }
                    $('#show_pemohon').val(response.pemohon);
                    $('#show_jenis_pemohon option[value="' + response.id_jenis_pemohon + '"]').prop('selected',
                        true);
                    $('#show_pic').val(response.PIC);
                    $('#show_link_data').val(response.link_data);
                    $('#show_jumlah_lokasi').val(response.jumlah_lokasi);
                    $('#show_lokasi').val(response.lokasi);
                    $('#show_jumlah_parameter').val(response.jumlah_parameter);
                    $('#show_parameter').val(response.parameter);
                    $('#show_periode').val(response.periode);
                    $('#show_tanggal_keluar').val(response.tanggal_keluar);
                    $('#show_keterangan').val(response.keterangan);
                    $('#show_surat_keluar').val(response.surat_keluar);
                    if (response.file_surat_keluar) {
                        $("#show_file_surat_keluar").attr("hidden", false);
                        $("#show_file_surat_keluar").attr("href", "{{ url('/storage/upload/surat_keluar') }}/" + response
                            .file_surat_keluar);
                    }


                    if (response.tanggal_masuk != null && response.tanggal_keluar != null) {
                        // const date1 = new Date(response.tanggal_masuk);
                        const date1 = new Date(response.tanggal_terima);
                        const date2 = new Date(response.tanggal_keluar);                        
                        const diffTime = Math.abs(date2 - date1);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        let respon = diffDays;
                        $('#show_respon').html(respon);
                    } else {
                        $('#show_respon').html('-');
                    }


                }
            });
        }

        $("#show_edit").click(function() {
            $('#modal_show').find("input[type=text]").attr("disabled", false);
            $('#modal_show').find("input[type=file]").attr("disabled", false);
            $('#modal_show').find("input[type=number]").attr("disabled", false);
            $('#modal_show').find("select").attr("disabled", false);
            $('#show_edit').attr("hidden", true);
            $('#show_clear').attr("hidden", false);
            $('#show_cancel').attr("hidden", false);
            $('#show_save').attr("hidden", false);
            $("#show_file_surat_masuk").attr("hidden", true);
            $("#show_file_surat_keluar").attr("hidden", true);
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

        // $("#show_save").click(function() {
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         url: '/peldata_save',
        //         type: 'POST',
        //         dataType: "text",
        //         data: {
        //             id: $('#show_id').val(),
        //             tanggal_masuk: $('#show_tanggal_masuk').val(),
        //             tanggal_terima: $('#show_tanggal_terima').val(),
        //             surat_masuk: $('#show_surat_masuk').val(),
        //             pemohon: $('#show_pemohon').val(),
        //             id_jenis_pemohon: $('#show_jenis_pemohon').val(),
        //             jumlah_lokasi: $('#show_jumlah_lokasi').val(),
        //             lokasi: $('#show_lokasi').val(),
        //             jumlah_parameter: $('#show_jumlah_parameter').val(),
        //             parameter: $('#show_parameter').val(),
        //             periode: $('#show_periode').val(),
        //             tanggal_keluar: $('#show_tanggal_keluar').val(),
        //             surat_keluar: $('#show_surat_keluar').val(),
        //         },
        //         error: function(xhr, status, error) {
        //             let errorMessage = xhr.status + ': ' + xhr.statusText;
        //             alert('Error - ' + errorMessage);
        //         },
        //         success: function(response) {
        //             alert(response);
        //             showSurat($("#show_id").val());
        //             $('#show_edit').attr("hidden", false);
        //             $('#show_clear').attr("hidden", true);
        //             $('#show_cancel').attr("hidden", true);
        //             $('#show_save').attr("hidden", true);

        //             $('#pelayanan_table').DataTable().destroy();
        //             query_surat(true);
        //             click = true;
        //         }
        //     });
        // })

        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#form_edit_surat').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ url('peldata_save') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        this.reset();
                        alert(response);
                        showSurat($("#show_id").val());
                        $('#show_edit').attr("hidden", false);
                        $('#show_clear').attr("hidden", true);
                        $('#show_cancel').attr("hidden", true);
                        $('#show_save').attr("hidden", true);

                        $('#pelayanan_table').DataTable().destroy();
                        query_surat(true);
                        click = true;
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endsection
