<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {

            $device = Device::get();
            return Datatables::of($device)->addIndexColumn()->make(true);
        }

        $hariini = date('Y-m-d');
        $blnawal = date('Y-m-01', strtotime($hariini));
        $blnakhir = date('Y-m-t', strtotime($hariini));

        $karyawans = Karyawan::select('id', 'name')->get();

        return view('device.index', compact('karyawans', 'user', 'blnawal', 'blnakhir'));
    }
}
