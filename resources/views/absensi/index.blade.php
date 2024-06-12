@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid pb-6 pb-xl-6">
            <div class="header-body">
            </div>
        </div>
    </div>
    <div class="container-fluid mt--8 pt--4">
        <div class="row">
            <div class="col-xl-12 mb-5 mt--6 mt-xl--6 mb-xl-0">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text"><strong>Success!</strong> {{ session('success') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card bg-gradient-white shadow">
                    <!-- Card header -->
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Master Data</h6>
                                <h2 class=" mb-0">Absensi </h2>
                            </div>
                            <div class="col">
                                {{-- <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales"
                                        data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}'
                                        data-prefix="$" data-suffix="k">
                                        <a href="/absensi/absen" class="nav-link py-2 px-3 active">
                                            <span class="d-none d-md-block">Tambah absen <i
                                                    class="ni ni-fat-add"></i></span>
                                        </a>
                                    </li>

                                </ul> --}}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6">
                                <label>Dari Tanggal :</label>
                                <input type="date" class="form-control" value="{{ $blnawal }}" id="dari">
                            </div>
                            <div class="col-6">
                                <label>Sampai Tanggal :</label>
                                <input type="date" class="form-control" value="{{ $blnakhir }}" id="sampai">
                            </div>

                            <div class="col-12 mt-2">
                                <label>Pilih Karyawan :</label>
                                <select class="form-control" id="karyawan">
                                    <option value="all"> Semua Karyawan</option>
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan['id'] }}">{{ $karyawan['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_list"
                                class="table align-items-center table-flush table-bordered dt-responsive nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="name">No</th>
                                        <th scope="col" class="sort" data-sort="name">Nama Karyawan</th>
                                        <th scope="col" class="sort" data-sort="status">Jam Masuk</th>
                                        <th scope="col" class="sort" data-sort="status">Jam Keluar</th>
                                        <th scope="col" class="sort" data-sort="status">Stratus</th>
                                        <th scope="col" class="sort" data-sort="status">Tanggal absen</th>
                                        <th scope="col" class="text-center" data-sort="completion">Aksi</th>

                                    </tr>
                                </thead>
                                <tbody class="list">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Card footer -->


                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var table = "";
        $(document).ready(function() {
            table = $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url()->current() }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    data: function(d) {
                        d.karyawan = $('#karyawan').val();
                        d.dari = $('#dari').val();
                        d.sampai = $('#sampai').val();
                    },
                    dataType: "json",
                    type: "GET",
                },
                oLanguage: {
                    "sEmptyTable": "Belum ada data",
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ data",
                    "sZeroRecords": "Tidak ditemukan data yang sesuai",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "sInfoFiltered": "(disaring dari total _MAX_ data)",
                    "sSearch": "Cari:",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sPrevious": "<",
                        "sNext": ">",
                        "sLast": "Terakhir"
                    }
                },
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, -1],
                    [10, 25, 50, 100, 500, 1000, "Semua"]
                ],

                pagingType: 'simple_numbers',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'karyawan',
                        name: 'karyawan'
                    },
                    {
                        data: 'jam_masuk',
                        name: 'jam_masuk'
                    },
                    {
                        data: 'jam_keluar',
                        name: 'jam_keluar'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'tgl_absen',
                        name: 'tgl_absen'
                    },
                    {
                        render: function(data, type, row) {
                            return '<div style="text-align: right;">' +
                                // '<a href="/absensi/' + row.tgl_absen +
                                // '/edit" class="btn btn-icon btn-primary btn-sm" type="button">' +
                                // '<span class="btn-inner--icon">Ubah <i class="fas fa-edit text-white"></i></span></a> ' +
                                '<form class="d-inline" action="/absensi/' + row.id +
                                '" method="post" onsubmit="return confirm(\'Yakin ingin hapus?\');" style="display: inline;"> ' +
                                '@method('delete') @csrf ' +
                                '<button type="submit" class="btn btn-icon btn-danger btn-sm">' +
                                '<span class="btn-inner--icon">Hapus <i class="fas fa-trash-alt"></i></span>' +
                                '</button></form>' +
                                '</div>';
                        }

                    }

                ]
            });
        });

        $('#karyawan').on('change', function() {

            table.ajax.reload();

        });

        $('#dari').on('change', function() {

            table.ajax.reload();

        });

        $('#sampai').on('change', function() {

            table.ajax.reload();

        });
    </script>
@endpush
