<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Karyawan;
use App\Models\Absen;
use App\Http\Resources\ApiKaryawanResource;
use App\Models\Penggajian;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->api_key == 'id_tambah') {
            $data = Karyawan::Where('status', 'tambah')->orWhere('status', 'ubah')->latest()->limit(1)->get();
            //return response()->json(ApiKaryawanResource::collection($data));
            if ($data->isEmpty()) {
                return response()->json(['notif' => 'DATA KOSONG']);
            } else {
                $karyawans = ApiKaryawanResource::collection($data)->all();
                foreach ($karyawans as $datas) {
                    $datac = [
                        'id' => $datas['id'],
                        'nama' => $datas['nama'],
                        'id_finger'  => (int) $datas['id_fingerprint'],
                    ];
                }
                return response(json_encode($datac));
            }
        } elseif ($request->api_key == 'id_hapus') {
            $data = Karyawan::Where('status', 'hapus')->latest()->first();
            // $hapus = Absen::where('karyawan_id', 0)->delete();
            // dd($hapus);
            //return response()->json(ApiKaryawanResource::collection($data));
            if (is_null($data)) {
                return response(json_encode(['notif' => 'DATA KOSONG']));
            } else {
                Karyawan::destroy($data->id);
                Absen::where('karyawan_id', $data->id)->delete();
                Penggajian::where('karyawan_id', $data->id)->delete();
                return response(json_encode(['notif' => 'Berhasil Dihapus']));
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->api_key != 'tambah') {
            return response()->json('API KEY SALAH');
        }

        Karyawan::where('id_fingerprint', $request->id_finger)
            ->update(['status' => 'aktif']);
        return response()->json(['Karyawan Berhasil Ditambah.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Karyawan = Karyawan::find($id);
        if (is_null($Karyawan)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new ApiKaryawanResource($Karyawan)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karyawan $Karyawan)
    {

        $validator['status'] = 'aktif';
        Karyawan::where('id', $request->id)
            ->update($validator);

        return response()->json(['Karyawan updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $Karyawan)
    {
        $Karyawan->delete();

        return response()->json('Karyawan deleted successfully');
    }
}
