<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AbsenController extends Controller
{


    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {

            $absen = Absen::whereHas('karyawan');

            // Kondisi users
            if (!empty($request['karyawan'])) {
                $users = $request['karyawan'];
                if ($users != 'all') {
                    $absen = $absen->where('karyawan_id', $users);
                }
            } else {
                $absen = $absen->where('karyawan_id', $user->id);
            }

            // Kondisi jangka waktu
            if (!empty($request['dari']) && !empty($request['sampai'])) {
                $dari = $request['dari'];
                $sampai = date('Y-m-d', strtotime($request['sampai'] . ' +1 day'));
                $absen = $absen->where('tgl_absen', '>=', $dari);
                $absen = $absen->where('tgl_absen', '<', $sampai);
            }

            $absen = $absen->orderBy('tgl_absen', 'desc')->get();
            return Datatables::of($absen)->addColumn('karyawan', function ($absen) {
                return $absen->karyawan->name;
            })->addIndexColumn()->make(true);
        }

        $hariini = date('Y-m-d');
        $blnawal = date('Y-m-01', strtotime($hariini));
        $blnakhir = date('Y-m-t', strtotime($hariini));

        $karyawans = Karyawan::select('id', 'name')->get();

        return view('absensi.index', compact('karyawans', 'user', 'blnawal', 'blnakhir'));
    }

    public function tambah()
    {
        return view('absensi.tambah', [
            'karyawans' => Karyawan::get()
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->absens as $key => $value) {
            $absensi[] = Absen::create([
                'karyawan_id' => $value['karyawan'],
                'jam_masuk' => date('H:i:s', strtotime($value['masuk'])),
                'jam_keluar' => date('H:i:s', strtotime($value['keluar'])),
                'tgl_absen' => $request->input('tgl_absen'),
                'status'  => $value['status'],
            ]);
        }

        return redirect('/absensi')->with('success', 'Berhasil Absen!!');
    }

    public function edit(Request $request)
    {
        $tgl = $request->tgl_absen;
        return view('absensi.edit', [
            'absens' => Absen::where('tgl_absen', $tgl)->whereHas('karyawan')->get(),
            'tgl' => $tgl,
        ]);
    }

    public function update(Request $request)
    {
        $tgl = $request->tgl_absen;
        foreach (Absen::where('tgl_absen', $tgl)->get() as $list) {
            if ($list->status != $request->input('absen' . $list->karyawan->id)) {
                $datas[] = array(
                    'absen_id' => $list->id,
                    'status'  => $request->input('absen' . $list->karyawan->id),
                );
            }
        }
        //dd($datas);
        foreach ($datas as $data) {
            //dd($data);
            Absen::where('id', $data['absen_id'])
                ->update(['status' => $data['status']]);
        }
        return redirect('/absensi')->with('success', 'Berhasil Diubah!!');
    }

    public function delete(Request $request)
    {
        Absen::where('id', $request->id)->delete();
        return redirect('/absensi')->with('success', 'Berhasil Dihapus!!');
    }
}
