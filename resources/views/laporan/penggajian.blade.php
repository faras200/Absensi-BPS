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
                                <h2 class=" mb-0">Laporan Penggajian</h2>
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
                                    <th scope="col" class="sort" data-sort="name">No</th>
                                    <th scope="col" class="sort" data-sort="budget">Nama</th>
                                    <th scope="col" class="sort" data-sort="status">Email</th>
                                    <th scope="col" class="sort" data-sort="status">Gaji pokok harian</th>
                                    <th scope="col" class="text-center" data-sort="completion">Aksi</th>

                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($karyawans as $karyawan)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $karyawan->karyawan->name }}
                                        </td>
                                        <td>
                                            {{ $karyawan->karyawan->email }}
                                        </td>
                                        <td>
                                            {{ $karyawan->gaji_pokok }}
                                        </td>
                                        {{-- <td>
                                    {{ $karyawan->penggajian->bonus }}
                </td>
                <td>
                  {{ $karyawan->penggajian->thr }}
                </td> --}}
                                        <td class="text-center">
                                            <a href="/laporan-penggajian/{{ $karyawan->karyawan->id . '?filters=' . now()->format('Y-m') }}"
                                                class="btn btn-icon btn-primary btn-sm" type="button">
                                                <span class="btn-inner--icon">Lihat <i
                                                        class="fas fa-search text-white"></i></span>
                                            </a>


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

    </div>
@endsection
