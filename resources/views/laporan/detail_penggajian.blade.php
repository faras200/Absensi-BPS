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
                        <form method="get" action="/laporan-penggajian/{{ $penggajian->karyawan->id }}">

                            <div class="row align-items-center">
                                <div class="col">

                                    <h2 class=" mb-0">Detail penggajian</h2>
                                    <p>Bulan: {{ tgl_indo::bulan($_GET['filters']) }}</p>
                                </div>
                                <div class="col">
                                    <div class="form-group" style="margin-bottom:0; !important">
                                        <div class="input-group mb-3">
                                            <input type="month" class="form-control" name="filters"
                                                aria-describedby="button-addon2" value="{{ $_GET['filters'] }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-default" type="submit"
                                                    id="button-addon2">Filter</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center text-centers table-flush">
                            <h4></h4>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" colspan="3" class="text-center">Nama karyawan:
                                        {{ $penggajian->karyawan->name }}</th>
                                    {{-- <th scope="col" class="sort">Nama</th>
                                <th scope="col" class="sort">Status</th>
                                <th scope="col" class="sort">Tanggal absen</th>
                                <th scope="col" class="sort">Jam Masuk</th>
                                <th scope="col" class="sort">Jam Keluar</th> --}}

                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $telat = $absen_telat->count() * 10000;
                                    $masuk = $penggajian->gaji_pokok * ($absen_masuk->count() + $absen_telat->count());
                                    $total =
                                        $masuk + $penggajian->lembur + $penggajian->bonus + $penggajian->thr - $telat;
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
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <a class="btn btn-success"
                                            href="/laporan-penggajian/{{ $penggajian->karyawan->id }}/cetak?filters={{ request()->get('filters') }}"
                                            target="_blank">Cetak
                                            Slip Gaji
                                            <i class="ni ni-single-copy-04"></i></a>

                                    </td>
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
                    <!-- Card footer -->


                </div>
            </div>

        </div>
    </div>
@endsection
