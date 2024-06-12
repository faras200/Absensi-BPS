<table id="customers" class="datatables" width="100%">
    <thead>
        <tr>
            <th rowspan="1" style="background-color: #dcdcdc;">Kode</th>
            <th rowspan="1" style="background-color: #dcdcdc;">Nama Karyawan</th>
            <th rowspan="1" style="background-color: #dcdcdc;">Hari</th>
            <th rowspan="1" style="background-color: #dcdcdc;">Uang Makan</th>
            <th rowspan="1" style="background-color: #dcdcdc;">Uang Lembur</th>
            <th rowspan="1" style="background-color: #dcdcdc;">Total Uang</th>
            <th rowspan="1" style="background-color: #dcdcdc;">Jam Kerja</th>
            <th rowspan="1" style="background-color: #dcdcdc;">Jam Lembur</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($absens as $absen)
            <tr>
                <td>{{ $absen['code'] }}</td>
                <td>{{ $absen['name'] }}</td>
                <td>{{ $absen['total_masuk'] }}</td>
                <td>{{ $absen['total_uang_makan'] }}</td>
                <td>{{ $absen['total_uang_lembur'] }}</td>
                <td>{{ $absen['total_uang_makan'] + $absen['total_uang_lembur'] }}</td>
                <td>{{ $absen['jam_kerja'] }}</td>
                <td>{{ $absen['jam_lembur'] }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
