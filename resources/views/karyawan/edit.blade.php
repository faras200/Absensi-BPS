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
                                <h2 class=" mb-0">Ubah Data Karyawan</h2>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="card-body">
                        <form method="post" action="/karyawan/{{ $karyawan->id }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name', $karyawan->name) }}">
                                        @error('name')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="code">Kode Karyawan</label>
                                        <input type="text" name="code" class="form-control" id="code"
                                            value="{{ old('code', $karyawan->code) }}">
                                        @error('code')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea id="alamat" name="alamat" class="form-control">{{ old('alamat', $karyawan->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="id_finger">Status Karyawan</label>
                                        <select id="status" name="status_id" class="form-control"
                                            aria-label="With textarea" value="{{ old('status_id', $karyawan->status_id) }}">
                                            <option value="">pilh status</option>
                                            @foreach ($status as $sts)
                                                <option value="{{ $sts->id }}"
                                                    {{ $karyawan->status_id == $sts->id ? 'selected' : '' }}>
                                                    {{ $sts->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('status_id')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="text-right">
                                    <button type="submit" name="submit" class="btn btn-default">Ubah
                                        data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
