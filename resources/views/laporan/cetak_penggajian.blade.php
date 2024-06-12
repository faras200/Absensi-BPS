<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>
    <div class="text-center" style="margin-top: -240px !important">
        <img src="img/logo.jpeg" class="" style="height: 100px;margin-top: 250px !important;" alt="">
        <h2 class="d-inline" style="margin-top: -100px !important;">PT Buyung Poetra Sembada</h2>
    </div>
    <div class="table-responsive" style="margin-top: -25px !important">
        <table class="table align-items-center table-bordered">
            <h4></h4>
            <thead class="thead-light">
                <tr>
                    <td colspan="3" class="text-center">
                        <h4>Slip Gaji Karyawan</h4>
                    </td>
                </tr>
                <tr>
                    <td>Nama karyawan:
                    </td>

                    <td colspan="2"> {{ $penggajian->karyawan->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:
                    </td>

                    <td colspan="2"> {{ tgl_indo::tgl($_GET['filters'] . '-30') }}</td>
                </tr>
            </thead>
            <tbody class="list">
                @php
                    $telat = $absen_telat->count() * 10000;
                    $masuk = $penggajian->gaji_pokok * ($absen_masuk->count() + $absen_telat->count());
                    $total = $masuk + $penggajian->lembur + $penggajian->bonus + $penggajian->thr - $telat;
                @endphp
                <tr>
                    <td>Gaji pokok harian x jumlah masuk :</td>
                    <td class="text-right">
                        Rp.{{ $penggajian->gaji_pokok . ' x ' . ($absen_masuk->count() + $absen_telat->count()) }}
                    </td>
                    <td>Rp.{{ $masuk }}</td>
                </tr>
                <tr>
                    <td>Lembur</td>
                    <td class="text-right"></td>
                    <td>Rp.{{ $penggajian->lembur }}</td>
                </tr>
                <tr>
                    <td>Bonus</td>
                    <td class="text-right"></td>
                    <td>Rp.{{ $penggajian->bonus }}</td>
                </tr>
                <tr>
                    <td>THR</td>
                    <td class="text-right"></td>
                    <td>Rp.{{ $penggajian->thr }}</td>
                </tr>
                <tr>
                    <td>Jumlah Telat</td>
                    <td class="text-right">{{ $absen_telat->count() . ' x Rp.10000 ' }}</td>
                    <td>-Rp.{{ $telat }}</td>
                </tr>
                <tr>
                    <td>Total Gaji</td>
                    <td class="text-right"></td>
                    <td>Rp.{{ $total }}</td>
                </tr>

                {{-- @foreach ($absens as $absen)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td>
                    {{ $absen->karyawan->nama }}
                </td>
                <td>
                    {{ $absen->status }}
                </td>
                <td>
                    {{ $absen->tgl_absen }}
                </td>
                <td>
                    {{ $absen->jam_masuk }}
                </td>
                <td>
                    {{ $absen->jam_keluar }}
                </td>

            </tr>
            @endforeach --}}
            </tbody>
        </table>
    </div>
</body>

</html>
