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
                                <h2 class=" mb-0">Laporan Absen | {{ $tgl_absen }}</h2>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center text-centers table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort">No</th>
                                    <th scope="col" class="sort">Nama</th>
                                    <th scope="col" class="sort">Status</th>
                                    <th scope="col" class="sort">Tanggal absen</th>
                                    <th scope="col" class="sort">Jam Masuk</th>
                                    <th scope="col" class="sort">Jam Keluar</th>

                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php
                                $i = 0;
                                ?>
                                @foreach ($absens as $absen)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $absen->karyawan->name }}
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->


                </div>
            </div>

        </div>


        @include('layouts.footers.auth')
    </div>
@endsection
