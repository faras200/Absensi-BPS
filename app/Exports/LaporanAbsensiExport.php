<?php

namespace App\Exports;

use App\Models\Karyawan;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanAbsensiExport implements FromView
{
    use Exportable;

    private $dari;
    private $sampai;
    private $sales;


    public function __construct($dari, $sampai, $sales)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
        $this->sales = $sales;
    }

    public function view(): View
    {
        $dari =  $this->dari;
        $sampai = date('Y-m-d', strtotime($this->sampai . " +1 days"));


        // Call the API to get users data
        $absen = Karyawan::select(
            'karyawan.*',
            'status_karyawan.name as status_karyawan',
            DB::raw('COUNT(absen.karyawan_id) as total_masuk'),
            DB::raw('SUM(CASE WHEN absen.status = "telat" THEN 1 ELSE 0 END) as total_telat'),
            // DB::raw('SUM(status_karyawan.uang_makan) as total_uang_makan'),
            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(HOUR, absen.jam_masuk, absen.jam_keluar) < 9 THEN status_karyawan.uang_makan / 2 ELSE status_karyawan.uang_makan END) as total_uang_makan'),

            DB::raw('SUM(TIMESTAMPDIFF(HOUR, absen.jam_masuk, absen.jam_keluar)) as jam_kerja'),
            DB::raw('SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, absen.jam_keluar) - 9)) as jam_lembur'),
            DB::raw('(SELECT SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, absen.jam_keluar) - 9)) FROM absen WHERE absen.karyawan_id = karyawan.id) as total_jam_lembur'),
            DB::raw('SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, absen.jam_keluar) - 9)) * status_karyawan.uang_lembur as total_uang_lembur')
        )
            ->leftJoin('absen', 'karyawan.id', '=', 'absen.karyawan_id')
            ->leftJoin('status_karyawan', 'karyawan.status_id', '=', 'status_karyawan.id')
            ->whereIn('absen.status', ['masuk', 'telat'])
            ->whereBetween('absen.tgl_absen', [$dari, $sampai])
            ->groupBy('karyawan.id')->get()->map(function ($result) {
                $result->total_uang_makan = number_format($result->total_uang_makan, 0, '', '');
                return $result;
            });

        return view('laporan.excel', [
            'absens' => $absen, 'awal' => $this->dari, 'akhir' => $this->sampai
        ]);
    }
}
