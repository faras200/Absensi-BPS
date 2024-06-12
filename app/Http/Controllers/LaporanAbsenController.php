<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Karyawan;
use App\Models\Penggajian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\LaporanAbsensiExport;
use Yajra\DataTables\Facades\DataTables;

class LaporanAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {

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
                ->whereIn('absen.status', ['masuk', 'telat']);



            // return response()->json($absen);

            // Kondisi jangka waktu
            if (!empty($request['dari']) && !empty($request['sampai'])) {
                $dari = $request['dari'];
                $sampai = date('Y-m-d', strtotime($request['sampai'] . ' +1 day'));
                $absen = $absen->where('absen.tgl_absen', '>=', $dari);
                $absen = $absen->where('absen.tgl_absen', '<', $sampai);
            }

            $absen = $absen->groupBy('karyawan.id')->get()->map(function ($result) {
                $result->total_uang_makan = number_format($result->total_uang_makan, 0, '', '');
                return $result;
            });
            return Datatables::of($absen)->addIndexColumn()->make(true);
        }

        $hariini = date('Y-m-d');
        $blnawal = date('Y-m-01', strtotime($hariini));
        $blnakhir = date('Y-m-t', strtotime($hariini));

        return view('laporan.absen', compact('user', 'blnawal', 'blnakhir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // return view('laporan.detail_absen', [
        //     'absens' => Absen::where('tgl_absen', $id)->whereHas(
        //         'karyawan'
        //     )->get(),
        //     'tgl_absen' => $id
        // ]);

        $absen = Karyawan::select(
            'karyawan.*',
            'status_karyawan.name as status_karyawan',
            'absen.jam_masuk',
            DB::raw('IFNULL(absen.jam_keluar, "belum keluar") as jam_keluar'),
            'absen.tgl_absen',
            DB::raw('COUNT(absen.karyawan_id) as total_masuk'),
            DB::raw('SUM(CASE WHEN absen.status = "telat" THEN 1 ELSE 0 END) as total_telat'),
            DB::raw('CASE WHEN TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) < 9 THEN status_karyawan.uang_makan / 2 ELSE status_karyawan.uang_makan END as uang_makan'),
            DB::raw('SUM(status_karyawan.uang_makan) as total_uang_makan'),
            DB::raw('SUM(TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk))) as jam_kerja'),
            DB::raw('SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) - 9)) as jam_lembur'),
            DB::raw('SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) - 9) * status_karyawan.uang_lembur) as uang_lembur'),
            DB::raw('(SELECT SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) - 9)) FROM absen WHERE absen.karyawan_id = karyawan.id) as total_jam_lembur'),
            DB::raw('(SELECT SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) - 9) * status_karyawan.uang_lembur) FROM absen WHERE absen.karyawan_id = karyawan.id) as total_uang_lembur')
        )
            ->leftJoin('absen', 'karyawan.id', '=', 'absen.karyawan_id')
            ->leftJoin('status_karyawan', 'karyawan.status_id', '=', 'status_karyawan.id')
            ->whereIn('absen.status', ['masuk', 'telat'])
            ->where('karyawan.id', $request->id);

        // Kondisi jangka waktu
        if (!empty($request['dari']) && !empty($request['sampai'])) {
            $dari = $request['dari'];
            $sampai = date('Y-m-d', strtotime($request['sampai'] . ' +1 day'));
            $absen = $absen->where('absen.tgl_absen', '>=', $dari);
            $absen = $absen->where('absen.tgl_absen', '<', $sampai);
        }

        $absen = $absen->orderBy('absen.tgl_absen')->groupBy('absen.id')->get()->map(function ($result) {
            $result->uang_makan = number_format($result->uang_makan, 0, '', '');
            return $result;
        });



        return response()->json($absen);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cetak(Request $request)
    {
        $absen = Karyawan::select(
            'karyawan.*',
            'status_karyawan.name as status_karyawan',
            'absen.jam_masuk',
            DB::raw('IFNULL(absen.jam_keluar, "belum keluar") as jam_keluar'),
            'absen.tgl_absen',
            DB::raw('COUNT(absen.karyawan_id) as total_masuk'),
            DB::raw('SUM(CASE WHEN absen.status = "telat" THEN 1 ELSE 0 END) as total_telat'),
            DB::raw('CASE WHEN TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) < 9 THEN status_karyawan.uang_makan / 2 ELSE status_karyawan.uang_makan END as uang_makan'),
            DB::raw('SUM(status_karyawan.uang_makan) as total_uang_makan'),
            DB::raw('SUM(TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk))) as jam_kerja'),
            DB::raw('SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) - 9)) as jam_lembur'),
            DB::raw('SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) - 9) * status_karyawan.uang_lembur) as uang_lembur'),
            DB::raw('(SELECT SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) - 9)) FROM absen WHERE absen.karyawan_id = karyawan.id) as total_jam_lembur'),
            DB::raw('(SELECT SUM(GREATEST(0, TIMESTAMPDIFF(HOUR, absen.jam_masuk, IFNULL(absen.jam_keluar, absen.jam_masuk)) - 9) * status_karyawan.uang_lembur) FROM absen WHERE absen.karyawan_id = karyawan.id) as total_uang_lembur')
        )
            ->leftJoin('absen', 'karyawan.id', '=', 'absen.karyawan_id')
            ->leftJoin('status_karyawan', 'karyawan.status_id', '=', 'status_karyawan.id')
            ->whereIn('absen.status', ['masuk', 'telat'])
            ->where('karyawan.id', $request->id);

        // Kondisi jangka waktu
        if (!empty($request['dari']) && !empty($request['sampai'])) {
            $dari = $request['dari'];
            $sampai = date('Y-m-d', strtotime($request['sampai'] . ' +1 day'));
            $absen = $absen->where('absen.tgl_absen', '>=', $dari);
            $absen = $absen->where('absen.tgl_absen', '<', $sampai);
        }

        $absen = $absen->orderBy('absen.tgl_absen')->groupBy('absen.id')->get()->map(function ($result) {
            $result->uang_makan = number_format($result->uang_makan, 0, '', '');
            return $result;
        });
        $dari = Carbon::parse($request->dari)->locale('id')->isoFormat('D MMMM YYYY');
        $sampai = Carbon::parse($request->sampai)->locale('id')->isoFormat('D MMMM YYYY');

        // return view('laporan.cetak_detail', [
        //     'absens' => $absen,
        //     'karyawan' => Karyawan::find($request->id),
        //     'dari' => $dari,
        //     'sampai' => $sampai,
        // ]);
        $data = Pdf::loadview('laporan.cetak_detail', [
            'absens' => $absen,
            'karyawan' => Karyawan::find($request->id),
            'dari' => $dari,
            'sampai' => $sampai,
        ]);

        return $data->stream('Laporan_Absen');
    }

    public function printExcel(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        return (new LaporanAbsensiExport($request->dari, $request->sampai, $request->sales))->download('laporan-absen_' . date('dMY', strtotime($request->dari)) . '-' . date('dMY', strtotime($request->sampai)) . '.xlsx');
    }
}
