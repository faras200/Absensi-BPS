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
                                <h2 class=" mb-0">Penggajian</h2>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">No</th>
                                    <th scope="col" class="sort" data-sort="budget">Nama</th>
                                    <th scope="col" class="sort" data-sort="status">Deskripsi</th>
                                    <th scope="col">Uang Makan</th>
                                    <th scope="col">Uang Lembur</th>
                                    {{-- <th scope="col" class="text-center" data-sort="completion">Aksi</th> --}}

                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($penggajian as $gaji)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $gaji->name }}
                                        </td>
                                        <td>
                                            {{ $gaji->description }}
                                        </td>
                                        <td>
                                            {{ $gaji->uang_makan }}
                                        </td>
                                        <td>
                                            {{ $gaji->uang_lembur }}
                                        </td>
                                        {{-- <td class="text-center">
                                            <a href="/penggajian/{{ $gaji->id }}/edit"
                                                class="btn btn-icon btn-primary btn-sm" type="button">
                                                <span class="btn-inner--icon">Ubah <i
                                                        class="fas fa-edit text-white"></i></span>
                                            </a>
                                        </td> --}}
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
