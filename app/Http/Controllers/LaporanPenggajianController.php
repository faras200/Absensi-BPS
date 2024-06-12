<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class LaporanPenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.penggajian', [
            'karyawans' => Penggajian::with('karyawan')
                ->whereHas(
                    'karyawan'
                )
                ->get()
        ]);
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
    public function show(Request $request, $id)
    {

        $filter = explode("-", $request->filters);
        //dd($filter);
        return view('laporan.detail_penggajian', [
            'absen_masuk' => Absen::where('karyawan_id', $id)->whereMonth('created_at', '=', $filter[1])->whereYear('created_at', '=', $filter[0])->where('status', '=', 'masuk')->get(),
            'absen_telat' => Absen::where('karyawan_id', $id)->whereMonth('created_at', '=', $filter[1])->whereYear('created_at', '=', $filter[0])->where('status', '=', 'telat')->get(),
            'penggajian' => Penggajian::where('karyawan_id', $id)->first(),
        ]);
    }

    public function cetak(Request $request, $id)
    {
        $filter = explode("-", $request->filters);
        $data = Pdf::loadview('laporan.cetak_penggajian', [
            'absen_masuk' => Absen::where('karyawan_id', $id)->whereMonth('created_at', '=', $filter[1])->whereYear('created_at', '=', $filter[0])->where('status', '=', 'masuk')->get(),
            'absen_telat' => Absen::where('karyawan_id', $id)->whereMonth('created_at', '=', $filter[1])->whereYear('created_at', '=', $filter[0])->where('status', '=', 'telat')->get(),
            'penggajian' => Penggajian::where('karyawan_id', $id)->first(),
        ]);

        return $data->stream('Slip Gaji');
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
}
