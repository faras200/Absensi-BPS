<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Absen;
use App\Models\Karyawan;
use App\Http\Resources\AbsenResource;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $datas = Absen::where('tgl_absen', now()->format('Y-m-d'))
        //     ->where('karyawan_id', '2')
        //     ->latest()
        //     ->first();
        // dd(is_null($datas));
        $diff = date_diff(date_create('02:14:00'), date_create());
        //$absen = Absen::latest()->limit(1)->get();
        // dd($diff);
        //$data = Absen::latest()->limit(1)->get();
        echo $diff->format('Usia anda adalah %h jam %i menit %s detik');
        return response()->json($diff);
        // $Absens = AbsenResource::collection($data)->all();
        // foreach ($Absens as $datas) {
        //     $datac = [
        //         'id' => $datas['id'],
        //         'nama' => $datas['nama'],
        //         'id_finger'  => $datas['id_fingerprint'],
        //     ];
        // }

        // return response(json_encode($datac));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->api_key != 'absen') {
            return response(json_encode([
                'notif' => 'Api Key Salah'
            ]));
        }
        $datas = Karyawan::where('id_fingerprint', $request->id_finger)->first();
        if (is_null($datas)) {
            return response(json_encode([
                'notif' => 'Data Kosong'
            ]));
        } else {
            $absen = Absen::where('tgl_absen', now()->format('Y-m-d'))
                ->where('karyawan_id', $datas->id)
                ->latest()
                ->first();

            if (is_null($absen)) {
                $data[] = array(
                    'karyawan_id' => $datas->id,
                    'jam_masuk' => now()->format('H:i:s'),
                    'tgl_absen' => now()->format('Y-m-d'),
                    'status'  => 'masuk',
                    'created_at' => now(),
                );
                DB::table('absen')->insert($data);
                return response(json_encode([
                    'notif' => 'Absen Masuk'
                ]));
            } else if (is_null($absen->jam_keluar)) {
                Absen::where('id', $absen->id)
                    ->update(['jam_keluar' => now()->format('H:i:s')]);
                return response(json_encode([
                    'notif' => 'Absen Keluar'
                ]));
            } else {
                return response(json_encode([
                    'notif' => 'Sudah Absen'
                ]));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Absen = Absen::find($id);

        if (is_null($Absen)) {
            return response()->json(['message' => 'Data not found from api'], 404);
        }

        // Jika kamu ingin menggunakan AbsenResource, pastikan untuk mengimpor dan menggunakannya dengan benar
        return response()->json(new AbsenResource($Absen));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absen $Absen)
    {

        $validator['status'] = 'aktif';
        Absen::where('id', $request->id)
            ->update($validator);

        return response()->json(['Absen updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absen $Absen)
    {
        $Absen->delete();

        return response()->json('Absen deleted successfully');
    }
}
