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
                        <button type="button" onclick="add_site()" class="btn btn-success d-none d-sm-inline-block"><span>
                                <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="12" cy="11" r="3" />
                                    <path
                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                </svg>
                            </span>Tambah Site</button>
                        <button type="button" onclick="add_site()" class="btn btn-success d-sm-none btn-icon">
                            <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="11" r="3" />
                                <path
                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
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
                        </div>
                        <div class="card-body" id="filter">
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <div class="form-label">Jenis Alat</div>
                                    <select class="form-select" id="filter_alat">
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <div class="form-label">Date Start</div>
                                    <input type="text" class="datepicker form-control" id="filter_date_start"
                                        placeholder="Date Start">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <div class="form-label">Date End</div>
                                    <input type="text" class="datepicker form-control" id="filter_date_end"
                                        placeholder="Date End">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <div class="form-label">Provinsi</div>
                                    <select class="form-select" id="filter_provinsi">

                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <div class="form-label">Kabupaten</div>
                                    <select class="form-select" id="filter_kabupaten">
                                        <option value="" disabled selected>Pilih Kabupaten</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <div class="form-label">Kecamatan</div>
                                    <select class="form-select" id="filter_kecamatan">
                                        <option value="" disabled selected>Pilih Kecamatan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button id="btn_filter" class="btn btn-primary">Filter</button>
                                <button id="btn_reset" class="btn btn-white">Reset Filter</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-md">
                                <table id="site_table" class="table card-table table-vcenter datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Id Site</th>
                                            <th>Site</th>
                                            <th>Alat</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Elevasi</th>
                                            <th>Kecamatan</th>
                                            <th>Kabupaten</th>
                                            <th>Provinsi</th>
                                            <th>Created By</th>
                                            <th>Date Created</th>
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

    {{-- modal untuk tambah site --}}
    <div class="modal modal-blur fade" id="modal_add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row pb-2">
                        <div class="col-lg-6">
                            <label class="form-label">Nama Site</label>
                            <input id="add_site" type="text" class="form-control" name="example-text-input"
                                placeholder="Masukkan Nama Site">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Jenis Alat</label>
                            <select class="form-select" id="add_alat">

                            </select>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-lg-4">
                            <label class="form-label">Latitude</label>
                            <input id="add_latitude" type="text" class="form-control" name="example-text-input"
                                placeholder="Masukkan Latitude">
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Longitude</label>
                            <input id="add_longitude" type="text" class="form-control" name="example-text-input"
                                placeholder="Masukkan Longitude">
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Elevasi</label>
                            <input id="add_elevasi" type="text" class="form-control" name="example-text-input"
                                placeholder="Masukkan Elevasi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="form-label">Provinsi</label>
                            <select class="form-select" id="add_provinsi">

                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Kabupaten</label>
                            <select class="form-select" id="add_kabupaten">
                                <option value="" disabled selected>Pilih Kabupaten</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Kecamatan</label>
                            <select class="form-select" id="add_kecamatan">
                                <option value="" disabled selected>Pilih kecamatan</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">ID Baru</label>
                            <input readonly id="add_id_site" type="text" class="form-control" name="example-text-input"
                                placeholder="ID baru">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="add_clear" type="button" class="btn me-auto">Clear</button>

                    <button id="add_generate" type="button" class="btn btn-success">Generate ID</button>
                    <button disabled id="add_save" type="button" class="btn btn-primary">Simpan ID</button>
                </div>
            </div>
        </div>
    </div>

    {{-- datepicker --}}
    <script>
        $(function() {
            $(".datepicker").datepicker({
                todayBtn: 'linked',
                format: "yyyy-mm-dd",
                autoclose: true,
                orientation: "bottom"
            });
        });
    </script>

    <script>
        //fungsi untuk menarik id alat
        function tarikAlat(field) {
            $.getJSON("/idgen_getAlat", function(data) {
                $(field).html(''); //# buat nyari id
                $(field).append('<option value="" disabled selected>Pilih Jenis Peralatan</option>')
                // menambahkan opsi ke dropdown jenis alat
                $.each(data, function() {
                    $(field).append('<option value="' + this.id + '">' + '(' + this.id + ') ' +
                        this.alat + '</option>')
                })
            })
        }

        tarikAlat("#filter_alat"); //id alat untuk form filter
        tarikAlat("#add_alat"); //id alat untuk form add

        //fungsi untuk menarik id provinsi
        function tarikProvinsi(field) {
            $.getJSON("/idgen_getProvinsi", function(data) {
                $(field).html('');
                $(field).append('<option value="" disabled selected>Pilih Provinsi</option>')
                $.each(data, function() {
                    $(field).append('<option value="' + this.id + '">' + this.provinsi +
                        '</option>')
                })
            })
        }

        tarikProvinsi("#filter_provinsi"); //id provinsi untuk form filter
        tarikProvinsi("#add_provinsi"); //id provinsi untuk form add

        //fungsi untuk menarik site
        function query_site() {
            let i = 1;
            const table = $("#site_table").DataTable({
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
                searching: false,
                processing: true,
                bServerSide: true,
                order: [
                    [1, "asc"]
                ],
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/idgen_getSite",
                    type: "POST",
                    data: function(data) {
                        data.id_alat = $('#filter_alat').val();
                        data.date_start = $('#filter_date_start').val();
                        data.date_end = $('#filter_date_end').val();
                        data.id_provinsi = $('#filter_provinsi').val();
                        data.id_kabupaten = $('#filter_kabupaten').val();
                        data.id_kecamatan = $('#filter_kecamatan').val();
                    }
                },
                dom: 'Blfrtip',
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
                            return row.id_site
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.site
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.alat
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.lat
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.lon
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.elevasi
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.kecamatan
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.kabupaten
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.provinsi
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.username
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.date_created
                        }
                    },
                ]
            });
        }

        let click = false;

        query_site(); //tampilkan di datatable

        //handle ketika tombol filter di tekan
        $("#btn_filter").click(function() {
            $('#site_table').DataTable().destroy();
            query_site();
            click = true;
        })

        //handle ketika tombol reset di tekan
        $("#btn_reset").click(function() {
            $('#filter').find("input[type=text]").val("");

            tarikAlat("#filter_alat");
            tarikProvinsi("#filter_provinsi");

            $("#filter_kabupaten").html('');
            $("#filter_kabupaten").append('<option value="" disabled selected>Pilih Kabupaten</option>');

            $("#filter_kecamatan").html('');
            $("#filter_kecamatan").append('<option value="" disabled selected>Pilih Kecamatan</option>');
        })

        $("#add_clear").click(function() {
            $('#modal_add').find("input[type=text]").val("");

            tarikAlat("#add_alat");
            tarikProvinsi("#add_provinsi");

            $("#add_kabupaten").html('');
            $("#add_kabupaten").append('<option value="" disabled selected>Pilih Kabupaten</option>');

            $("#add_kecamatan").html('');
            $("#add_kecamatan").append('<option value="" disabled selected>Pilih Kecamatan</option>');
            document.getElementById("add_save").disabled = true;
        })

        //handle ketika tomboll add di tekan
        function add_site() {
            // Display Modal
            $('#modal_add').modal('show');
            $('#modal_add').find("input[type=text], input[type=password]").val("");

            tarikAlat("#add_alat");
            tarikProvinsi("#add_provinsi");

            $("#add_kabupaten").html('');
            $("#add_kabupaten").append('<option value="" disabled selected>Pilih Kabupaten</option>');

            $("#add_kecamatan").html('');
            $("#add_kecamatan").append('<option value="" disabled selected>Pilih Kecamatan</option>');
        }
    </script>

    <!-- menarik data kabupaten berdasarkan provinsi yang dipilih -->
    <script>
        $("#filter_provinsi").change(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'idgen_getKabupaten',
                type: 'POST',
                dataType: "json",
                data: {
                    id_provinsi: $("#filter_provinsi").val()
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(kabupaten) {
                    $("#filter_kabupaten").html('');
                    $("#filter_kabupaten").append(
                        '<option value="" disabled selected>Pilih Kabupaten</option>');
                    $.each(kabupaten, function() {
                        $("#filter_kabupaten").append('<option value="' + this.id + '">' + this
                            .kabupaten + '</option>');
                    })
                }
            });

            $("#filter_kecamatan").html('<option value="" disabled selected>Pilih Kecamatan</option>');
        });

        $("#add_provinsi").change(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'idgen_getKabupaten',
                type: 'POST',
                dataType: "json",
                data: {
                    id_provinsi: $("#add_provinsi").val()
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(kabupaten) {
                    $("#add_kabupaten").html('');
                    $("#add_kabupaten").append(
                        '<option value="" disabled selected>Pilih Kabupaten</option>');
                    $.each(kabupaten, function() {
                        $("#add_kabupaten").append('<option value="' + this.id + '">' + this
                            .kabupaten + '</option>');
                    })
                }
            });

            $("#add_kecamatan").html('<option value="" disabled selected>Pilih Kecamatan</option>');
        });
    </script>

    <!-- menarik data kecamatan berdasarkan kabupaten yang dipilih -->
    <script>
        $("#filter_kabupaten").change(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/idgen_getKecamatan',
                type: 'POST',
                dataType: "json",
                data: {
                    id_kabupaten: $("#filter_kabupaten").val()
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(kecamatan) {
                    $("#filter_kecamatan").html('');
                    $("#filter_kecamatan").append(
                        '<option value="" disabled selected>Pilih Kecamatan</option>');
                    $.each(kecamatan, function() {
                        $("#filter_kecamatan").append('<option value="' + this.id + '">' + this
                            .kecamatan + '</option>');
                    })
                }
            });
        });

        $("#add_kabupaten").change(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/idgen_getKecamatan',
                type: 'POST',
                dataType: "json",
                data: {
                    id_kabupaten: $("#add_kabupaten").val()
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(kecamatan) {
                    $("#add_kecamatan").html('');
                    $("#add_kecamatan").append(
                        '<option value="" disabled selected>Pilih Kecamatan</option>');
                    $.each(kecamatan, function() {
                        $("#add_kecamatan").append('<option value="' + this.id + '">' + this
                            .kecamatan + '</option>');
                    })
                }
            });
        });
    </script>

    <!-- melakukan generate id Baru -->
    <script>
        function check_radius(latitude, longitude) {
            var site_radius;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false, //deprecated
                url: '/idgen_getRadius',
                type: 'POST',
                dataType: 'text',
                data: {
                    latitude,
                    longitude
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    site_radius = response;
                }
            });
            return site_radius;
        }


        function generate_id(id_kecamatan, id_alat) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/idgen_getLatestId',
                type: 'POST',
                dataType: "json",
                data: {
                    id_kecamatan
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    var new_id_combine;
                    let latest_id = response[0].id_site;

                    if (latest_id == 'no_data') {
                        //gabungkan sequence menjadi id baru
                        new_id_combine = id_kecamatan.toString() + '01' + id_alat;

                        console.log(new_id_combine);

                        //tampilkan id baru di form
                        $("#add_id_site").val(new_id_combine);
                    } else {
                        //pecah id untuk ngambil sequencenya
                        latest_id = latest_id.slice(6, 8);

                        //ubah sequence dari string to number
                        latest_id = Number(latest_id);

                        //buat id baru dg increment
                        let new_id = latest_id + 1;

                        //pengkondisian untuk mengubah number ke string
                        if (new_id < 10) {
                            new_id_str = '0' + new_id.toString();
                        } else {
                            new_id_str = new_id.toString();
                        }

                        //gabungkan sequence menjadi id baru
                        new_id_combine = id_kecamatan + new_id_str + id_alat;

                        //tampilkan id baru di form
                        $("#add_id_site").val(new_id_combine);

                        // console.log(new_id_str);
                    }

                    document.getElementById("add_save").disabled = false;

                }
            });
        }

        $("#add_generate").click(function() {
            let site = $("#add_site").val();
            let id_alat = $("#add_alat").val();
            let id_kecamatan = $("#add_kecamatan").val();
            let lat = $("#add_latitude").val();
            let lon = $("#add_longitude").val();
            let radius;

            if (id_alat != null && id_kecamatan != null && lat != '' && lon != '' && site != '') {
                radius = check_radius(lat, lon);
                if (radius == 0) {
                    generate_id(id_kecamatan, id_alat);
                } else {
                    if (confirm(
                            'Site dengan lokasi yang sama sudah ada, apakah anda yakin untuk menambahkan site ini?'
                        )) {
                        generate_id(id_kecamatan, id_alat);
                    }

                }

            } else {
                alert('Harap isi form terlebih dahulu!');
            }

        });
    </script>

    <!-- menyimpan data id baru -->
    <script>
        $("#add_save").click(function() {

            let id_site = $("#add_id_site").val();
            let site = $("#add_site").val();
            let id_alat = $("#add_alat").val();
            let lat = $("#add_latitude").val();
            let lon = $("#add_longitude").val();
            let elevasi = $("#add_elevasi").val();
            let id_provinsi = $("#add_provinsi").val();
            let id_kabupaten = $("#add_kabupaten").val();
            let id_kecamatan = $("#add_kecamatan").val();
            let id_user = @json(auth()->user());
            id_user = id_user.id;

            console.log(id_site, site, id_alat, lat, lon, elevasi, id_provinsi, id_kabupaten, id_kecamatan,
                id_user);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/idgen_saveSite',
                type: 'POST',
                dataType: "text",
                data: {
                    id_site,
                    site,
                    id_alat,
                    lat,
                    lon,
                    elevasi,
                    id_provinsi,
                    id_kabupaten,
                    id_kecamatan,
                    id_user
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                },
                success: function(response) {
                    alert(response);
                    $('#modal_add').modal('hide');
                }
            });

        });
    </script>

@endsection
