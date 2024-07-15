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
                <div class="card bg-gradient-white shadow">
                    <!-- Card header -->
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Master Data</h6>
                                <h2 class=" mb-0">Laporan Absensi</h2>
                            </div>
                            <div class="col">

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
                        </div>

                        <div class="row mt-2 d-flex align-items-center">
                            <div class="col-6">
                                <label>Grand Total :</label>
                                <input type="text" class="form-control" disabled
                                    style="background-color: white; font-weight:700; font-size:16px;" value="Rp. 5000000"
                                    id="grand_total_keseluruhan">
                            </div>
                            <div class="col-6 d-flex justify-content-end align-items-center mt-4">
                                <button id="cetakexcel" class="btn btn-success btn-md"><i
                                        class="fa fa-print"></i>&nbsp;Cetak
                                    Excel</button>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_list" class="table align-items-center text-centers table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="name">Kode</th>
                                        <th scope="col" class="sort" data-sort="name">Nama Karyawan</th>
                                        <th scope="col" class="sort" data-sort="budget">Hari</th>
                                        <th scope="col" class="sort" data-sort="status">Uang Makan</th>
                                        <th scope="col" class="sort" data-sort="status">Uang Lembur</th>
                                        <th scope="col" class="sort" data-sort="status">Total Uang</th>
                                        <th scope="col" class="sort" data-sort="status">Jam Kerja</th>
                                        <th scope="col" class="sort" data-sort="status">Jam Lembur</th>
                                        <th scope="col" class="text-center" data-sort="completion">Aksi</th>

                                    </tr>
                                </thead>
                                {{-- <tbody class="list">
                                <?php
                                $j = 1;
                                $i = 1;
                                //dd($absens->duplicates('tgl_absen'))
                                ?>
                                @foreach ($absens as $absen)
                                    @if ($absens->count() == $j)
                                        <?php
                                        $j = 0;
                                        ?>
                                    @endif
                                    @if ($absen->tgl_absen != $absens[$j]->tgl_absen)
                                        <tr>
                                            <td>
                                                {{ $i }}
                                            </td>
                                            <td>
                                                {{ tgl_indo::hari(date('D', strtotime($absen->tgl_absen))) }}
                                            </td>
                                            <td>
                                                {{ tgl_indo::tgl($absen->tgl_absen) }}
                                            </td>

                                            <td class="text-center">
                                                <a href="/laporan-absensi/{{ $absen->tgl_absen }}"
                                                    class="btn btn-icon btn-primary btn-sm" type="button">
                                                    <span class="btn-inner--icon">Lihat <i
                                                            class="fas fa-edit text-white"></i></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i += 1;
                                        ?>
                                    @endif
                                    <?php
                                    if ($j < $absens->count()) {
                                        $j = $j + 1;
                                    } else {
                                        $j = 0;
                                    }
                                    ?>
                                @endforeach
                            </tbody> --}}
                            </table>
                        </div>
                    </div>
                    <!-- Card footer -->


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lihatnya" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="col-6">
                        <h3 class="modal-title" id="modal-title-default">Detail Laporan</h3>
                    </div>
                    <div class="col-6" align="right">
                        <button id="links" class="btn btn-success btn-sm"><i class="fa fa-print"></i>
                            &nbsp;Cetak</button>
                    </div>

                </div>

                <div class="modal-body" style="padding-bottom: 0px;padding-top: 0px;">
                    <div class="row">
                        <div class="col-12">
                            <label>Nama Karyawan</label>
                            <br>
                            <div style="font-size: 16px;" id="nama_karyawan"></div>
                            <br>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table" width="100%">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Jam Kerja</th>
                                        <th>Jam Lembur</th>
                                        <th>Uang Makan</th>
                                        <th>Uang Lembur</th>
                                        <th>Total</th>
                                    </tr>
                                    <tbody id="contentnya">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer tombolnya2" style="display:none;">
                    <table width="100%">
                        <tr>
                            <td>
                                <button type="button" class="btn btn-secondary btn-block ml-auto"
                                    data-dismiss="modal">Tutup</button>
                            </td>
                            <td width="5%">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
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
                columnDefs: [{
                    "targets": [3, 4, 5],
                    "render": $.fn.dataTable.render.number('.', '.', 0, 'Rp. ')
                }],
                ajax: {
                    url: '{{ url()->current() }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    data: function(d) {
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
                        data: 'code',
                        name: 'code',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'total_masuk',
                        name: 'total_masuk'
                    },
                    {
                        data: 'total_uang_makan',
                        name: 'total_uang_makan'
                    },
                    {
                        data: 'total_uang_lembur',
                        name: 'total_uang_lembur'
                    },
                    {
                        render: function(data, type, row) {

                            const result = parseInt(row.total_uang_makan) + parseInt(row
                                .total_uang_lembur);
                            return formatRupiah(result);

                        }
                    },
                    {
                        render: function(data, type, row) {
                            return formatTime(row.jam_kerja);
                        }
                    },
                    {
                        render: function(data, type, row) {
                            return formatTime(row.jam_lembur);
                        }
                    },
                    {
                        render: function(data, type, row) {

                            return '&nbsp;<button class="btn btn-success btn-sm" onclick="Lihat(' +
                                row.id + ')"><i class="fa fa-eye"></i>';

                        }

                    }

                ],
                initComplete: function(settings, json) {
                    hitungGrandTotal(json)
                }
            }, );


        });

        function hitungGrandTotal(json) {

            const total_uang_makan = json.data.reduce((accumulator, currentValue) => {
                return accumulator + parseInt(currentValue.total_uang_makan);
            }, 0);

            const total_uang_lembur = json.data.reduce((accumulator, currentValue) => {
                return accumulator + parseInt(currentValue.total_uang_lembur);
            }, 0);

            $('#grand_total_keseluruhan').val(formatRupiah(total_uang_makan +
                total_uang_lembur));
        };

        $('#dari').on('change', function() {

            table.ajax.reload(function(json) {
                hitungGrandTotal(json)
            });

        });

        $('#sampai').on('change', function() {

            table.ajax.reload(function(json) {
                hitungGrandTotal(json)
            });

        });

        function Lihat(id) {

            $('#lihatnya').modal('show');

            $.ajax({
                type: 'POST',
                url: "{{ route('laporan-absensi.show') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id,
                    'dari': $('#dari').val(),
                    'sampai': $('#sampai').val(),
                },
                success: function(response) {
                    var content_data = '';
                    var nama_karyawan = '';
                    var id = '';
                    var grand_total = 0;
                    var total_jam_kerja = 0;
                    var total_jam_lembur = 0;
                    var time = "00:00:00";
                    var jam_lembur = [];
                    var total_uang_makan = 0;
                    var total_uang_lembur = 0;

                    $.each(response, function(index, data) {

                        jam_lembur.push(data.jam_lembur);

                        id = data.id;
                        nama_karyawan = data.name;
                        total_jam_kerja += parseInt(data.jam_kerja);
                        total_uang_makan += parseInt(data.uang_makan);

                        content_data += '<tr>';
                        content_data += '<td>' + data.tgl_absen + '</td>';
                        content_data += '<td>' + data.jam_masuk + '</td>';
                        content_data += '<td>' + data.jam_keluar + '</td>';
                        content_data += '<td>' + formatTime(data.jam_kerja) + '</td>';
                        content_data += '<td>' + (formatTime(data.jam_lembur) ?? '0') + '</td>';
                        content_data += '<td>' + formatRupiah(data.uang_makan ?? '0') + '</td>';
                        content_data += '<td>' + formatRupiah(data.uang_lembur ?? '0') + '</td>';
                        content_data += '<td>' + formatRupiah((parseInt(data.uang_makan) + parseInt(data
                                .uang_lembur)) ??
                            '0') + '</td>';
                        content_data += '</tr>';
                    });
                    total_jam_lembur = sumTimesToHours(jam_lembur);
                    total_uang_lembur += parseInt(total_jam_lembur * 20000);
                    grand_total = total_uang_makan + total_uang_lembur;

                    content_data += "<tr>"
                    content_data += "<th>GRANDTOTAL</th>"
                    content_data += '<th colspan="2"></th>'
                    content_data += '<th >' + (
                            total_jam_kerja ?? '0') +
                        '</th>'
                    content_data += '<th >' + (
                            sumTimesToHoursAndMinutes(jam_lembur) ?? '0') +
                        '</th>'
                    content_data += '<th>' + formatRupiah(
                            total_uang_makan ?? '0') +
                        '</th>'
                    content_data += '<th >' + formatRupiah(
                            total_uang_lembur ?? '0') +
                        '</th>'
                    content_data += '<th >' + formatRupiah(
                            grand_total ?? '0') +
                        '</th>'
                    content_data += "</tr>"


                    $('#contentnya').html(content_data);
                    $('#nama_karyawan').html(nama_karyawan);
                    $('#links').attr('onclick', 'CetakPdf("' + id + '")');
                }
            });

        }

        function formatRupiah(angka) {
            angka = angka.toString()
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return rupiah ? "Rp. " + rupiah : "";
        }

        function sumTimesToHours(times) {
            // Fungsi untuk memeriksa dan memisahkan jam, menit, dan detik dari string waktu
            function parseTime(time) {
                // Default nilai jika input tidak sesuai
                const defaultTime = {
                    hours: 0,
                    minutes: 0,
                    seconds: 0
                };

                // Periksa apakah waktu sesuai dengan format yang diharapkan
                if (typeof time !== 'string' || !/^(\d{2}):(\d{2}):(\d{2})$/.test(time)) {
                    console.error('Invalid time format:', time);
                    return defaultTime;
                }

                // Pisahkan jam, menit, dan detik dari string waktu
                const parts = time.split(':');
                return {
                    hours: parseInt(parts[0], 10),
                    minutes: parseInt(parts[1], 10),
                    seconds: parseInt(parts[2], 10)
                };
            }

            let totalSeconds = 0;

            // Iterasi melalui setiap waktu dalam array
            for (const time of times) {
                const t = parseTime(time);

                // Hitung total detik dari waktu saat ini dan tambahkan ke total
                totalSeconds += t.hours * 3600 + t.minutes * 60 + t.seconds;
            }

            // Konversikan total detik ke total jam dan bulatkan ke bawah
            const totalHours = Math.floor(totalSeconds / 3600);

            return totalHours;
        }

        function sumTimesToHoursAndMinutes(times) {
            // Fungsi untuk memeriksa dan memisahkan jam, menit, dan detik dari string waktu
            function parseTime(time) {
                // Default nilai jika input tidak sesuai
                const defaultTime = {
                    hours: 0,
                    minutes: 0,
                    seconds: 0
                };

                // Periksa apakah waktu sesuai dengan format yang diharapkan
                if (typeof time !== 'string' || !/^(\d{2}):(\d{2}):(\d{2})$/.test(time)) {
                    console.error('Invalid time format:', time);
                    return defaultTime;
                }

                // Pisahkan jam, menit, dan detik dari string waktu
                const parts = time.split(':');
                return {
                    hours: parseInt(parts[0], 10),
                    minutes: parseInt(parts[1], 10),
                    seconds: parseInt(parts[2], 10)
                };
            }

            let totalSeconds = 0;

            // Iterasi melalui setiap waktu dalam array
            for (const time of times) {
                const t = parseTime(time);

                // Hitung total detik dari waktu saat ini dan tambahkan ke total
                totalSeconds += t.hours * 3600 + t.minutes * 60 + t.seconds;
            }

            // Konversikan total detik ke total jam dan menit
            const totalHours = Math.floor(totalSeconds / 3600);
            const totalMinutes = Math.floor((totalSeconds % 3600) / 60);

            return `${totalHours} jam ${totalMinutes} menit`;
        }

        function formatTime(time) {
            const [hours, minutes, seconds] = time.split(':').map(Number);
            let formattedTime = '';

            if (hours > 0) {
                formattedTime += `${hours} jam `;
            }

            if (minutes > 0) {
                formattedTime += `${minutes} menit`;
            }

            if (formattedTime === '') {
                return '0';
            }

            // Trim the trailing space if there's any
            return formattedTime.trim();
        }

        $("#cetakexcel").click(() => {
            const url =
                `{{ route('laporan-absensi.cetak-excel', '') }}?dari=${$('#dari').val()}&sampai=${$('#sampai').val()}`;
            window.open(url, '_blank');
        });

        CetakPdf = (id) => {
            const url =
                `{{ route('laporan-absensi.cetak-pdf', '') }}?id=${id}&dari=${$('#dari').val()}&sampai=${$('#sampai').val()}`;
            window.open(url, '_blank');
        }
    </script>
@endpush
