<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <style>
        table td,
        .table th {
            font-size: 12px;
            padding: .20rem .25rem !important;
        }
    </style>
</head>

<body>
    <div class="container text-center" style="margin-top: -20px !important">
        <div class="row justify-content-center">
            <div class="col-12">
                <img src="{{ public_path('img/logo-bps.png') }}" style="height: 80px;" alt="">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <h4>PT. Buyung Potera Sembada</h4>
            </div>
        </div>
    </div>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h5>Laporan Absensi</h5>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 10px;">
        <div class="table-responsive">
            <table class="">
                <tr>
                    <td class="border-0 text-left">Nama</td>
                    <td class="border-0">:</td>
                    <td class="border-0 ">{{ $karyawan->name }}</td>
                </tr>
                <tr>
                    <td class="border-0 text-left">Periode</td>
                    <td class="border-0">:</td>
                    <td class="border-0 ">{{ $dari . ' - ' . $sampai }}</td>
                </tr>

            </table>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <h4></h4>
            <thead class="thead-light">
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
            </thead>
            <tbody class="list">
                @php
                    $total_jam_kerja = 0;
                    $total_jam_lembur = 0;
                    $total_uang_makan = 0;
                    $total_uang_lembur = 0;
                    $grand_total = 0;
                @endphp

                @foreach ($absens as $absen)
                    @php
                        $total_jam_kerja += $absen->jam_kerja;
                        $total_jam_lembur += $absen->jam_lembur;
                        $total_uang_makan += $absen->uang_makan;
                        $total_uang_lembur += $absen->uang_lembur;
                        $grand_total += $absen->uang_lembur + $absen->uang_makan;
                    @endphp
                    <tr>
                        <td>{{ $absen->tgl_absen }}</td>
                        <td>{{ $absen->jam_masuk }}</td>
                        <td>{{ $absen->jam_keluar }}</td>
                        <td>{{ $absen->jam_kerja }}</td>
                        <td>{{ $absen->jam_lembur }}</td>
                        <td>{{ number_format($absen->uang_makan, 0, ',', '.') }}</td>
                        <td>{{ number_format($absen->uang_lembur, 0, ',', '.') }}</td>
                        <td>{{ number_format($absen->uang_lembur + $absen->uang_makan, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <tr>
                    <th>GRANDTOTAL</th>
                    <th colspan="2"></th>
                    <th>{{ $total_jam_kerja }}</th>
                    <th>{{ $total_jam_lembur }}</th>
                    <th>Rp. {{ number_format($total_uang_makan, 0, ',', '.') }}</th>
                    <th>Rp. {{ number_format($total_uang_lembur, 0, ',', '.') }}</th>
                    <th>Rp. {{ number_format($grand_total, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
