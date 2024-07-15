@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid pb-6 pb-xl-6">
            <div class="header-body">
            </div>
        </div>
    </div>
    <form method="post" action="/absensi">
        @csrf
        <div class="container-fluid mt--8 pt--4">
            <div class="row">
                <div class="col-xl-12 mb-5 mt--6 mt-xl--6 mb-xl-0">
                    <div class="card bg-gradient-white shadow">
                        <!-- Card header -->
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase text-light ls-1 mb-1"></h6>
                                    <h2 class=" mb-0">Absen </h2>
                                </div>

                                <div class="col">
                                    <div class="form-group" style="margin-bottom:0; !important">
                                        <label for="example-date-input" class="form-control-label">Tanggal absen</label>
                                        <input class="form-control" name="tgl_absen" type="date"
                                            value="{{ date('Y-m-d') }}" id="example-date-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="card-body" style="padding:0; !important">
                            {{-- <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="name">No</th>
                                            <th scope="col" class="sort" data-sort="budget">Nama Karyawan</th>
                                            <th scope="col">Jam masuk</th>
                                            <th scope="col">Jam keluar</th>
                                            <th scope="col" class="text-center">Absen</th>

                                        </tr>
                                    </thead>
                                    <tbody id="dynamicInput" class="list">

                                        @foreach ($karyawans as $karyawan)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $karyawan->name }}
                                                </td>
                                                <td>
                                                    <input type="time" required class="form-control"
                                                        id="masuk{{ $karyawan->id }}">
                                                </td>
                                                <td>
                                                    <input type="time" required class="form-control"
                                                        id="keluar{{ $karyawan->id }}">
                                                </td>
                                                <td class="text-center">
                                                    <select id="role" name="absen{{ $karyawan->id }}"
                                                        class="form-control " aria-label="With textarea"
                                                        value="{{ old('absen') }}">
                                                        <option value="alpha" selected>Alpha</option>
                                                        <option value="masuk">Masuk</option>
                                                        <option value="izin">Izin</option>
                                                        <option value="sakit">Sakit</option>
                                                        <option value="telat">Telat</option>
                                                    </select>
                                                    @error('role')
                                                        <div class="text-danger"> {{ $message }} </div>
                                                    @enderror

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> --}}
                            <div id="dynamicInput" class="row card-body">

                            </div>

                            <div id="addmore" class="row">

                            </div>
                            <hr>
                        </div>
                        <div class="col-12 card-body">
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
@push('scripts')
    <script type="text/javascript">
        var karyawans = {{ Js::from($karyawans) }}
        var i = 0;
        $(document).ready(function() {


            inputHtml = htmlPembelian(i);
            $(document).ready(function() {
                $('.use-select2').select2({
                    theme: "bootstrap4"
                });

            });

            $('#dynamicInput').html(inputHtml);

        });


        $(document).on('click', '#add', function() {
            ++i;
            $('#dynamicTable').append(htmlProduct(i));
        });

        function htmlPembelian(i) {
            return `
            <div class="col-12">
            <table class="table table-bordered" id="dynamicTable">  

        <tr>

            <th style="width: 30%" >Nama Karyawan</th>
            <th>Jam masuk</th>
            <th>Jam keluar</th>
            <th>Absen</th>
            <th>Action</th>

        </tr>

        <tr>  

            <td> <select id="category" style="width: 100%"  name="absens[` + i + `][karyawan]" class="form-control use-select2"
                   value="{{ old('type') }}">
                    <option value="" selected disabled>Pilih</option>` +
                karyawans.map(function(user) {
                    return `<option value="${user.id}">${user.name}</option>`
                }).join('') +
                `</select></td>  
             <td>
                <input type="time" required class="form-control"
                   name="absens[` + i + `][masuk]">
            </td>
            <td>
                <input type="time" required class="form-control"
                   name="absens[` + i + `][keluar]">
            </td>

            <td>

                 <select id="role" name="absens[` + i + `][status] }}"
                    class="form-control "
                    value="{{ old('absen') }}">
                    <option value="masuk" selected>Masuk</option>
                    <option value="telat">Telat</option>
                </select>

            </td>  

            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  

        </tr>  

        </table> 
            </div>
            `;
        }

        function htmlProduct(i) {
            return `
             <tr>  

            <td> <select style="width: 100%"  id="category" name="absens[` + i + `][karyawan]" class="form-control use-select2"
                   value="{{ old('type') }}">
                    <option value="" selected disabled>Pilih</option>` +
                karyawans.map(function(user) {
                    return `<option value="${user.id}">${user.name}</option>`
                }).join('') +
                `</select></td>  
             <td>
                <input type="time" required class="form-control"
                   name="absens[` + i + `][masuk]">
            </td>
            <td>
                <input type="time" required class="form-control"
                   name="absens[` + i + `][keluar]">
            </td>

            <td>

                 <select id="role" name="absens[` + i + `][status] }}"
                    class="form-control "
                    value="{{ old('absen') }}">
                     <option value="masuk" selected>Masuk</option>
                    <option value="telat">Telat</option>
                </select>

            </td>  

             <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>  

        </tr>  
            `
        }

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
@endpush
