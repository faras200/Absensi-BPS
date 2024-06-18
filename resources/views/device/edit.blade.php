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
                                <h6 class="text-uppercase text-light ls-1 mb-1"></h6>
                                <h2 class=" mb-0">Ubah absen | {{ tgl_indo::tgl($tgl) }}</h2>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="card-body" style="padding:0; !important">
                        <form method="post" action="/absensi/{{ $tgl }}/edit">
                            @csrf
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="name">No</th>
                                            <th scope="col" class="sort" data-sort="budget">Nama</th>
                                            <th scope="col" class="sort" data-sort="status">Kode</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col" class="text-center">Absen</th>

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
                                                    {{ $absen->karyawan->code }}
                                                </td>
                                                <td>
                                                    {{ $absen->karyawan->alamat }}
                                                </td>

                                                <td class="text-center">
                                                    <div class="form-group">
                                                        <select id="role" name="absen{{ $absen->karyawan->id }}"
                                                            class="form-control" aria-label="With textarea"
                                                            value="{{ old('absen') }}">
                                                            <option value="{{ $absen->status }}" selected>
                                                                {{ $absen->status }}</option>
                                                            <option value="masuk">Masuk</option>
                                                            <option value="izin">Izin</option>
                                                            <option value="sakit">Sakit</option>
                                                            <option value="telat">Telat</option>
                                                        </select>
                                                        @error('role')
                                                            <div class="text-danger"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="col-12 pb-4 pl-2">
                        <div class="text-right">
                            <button type="submit" class="btn btn-default">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
