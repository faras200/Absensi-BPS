<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Absen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IclockController extends Controller
{
    // handshake
    public function handshake(Request $request)
    {
        $content = $request->getContent();

        DB::table('request_log')->insert(['content' => $content, 'type' => 'handshake']);
        $data['url'] = $request->getRequestUri();
        $data["data"] = json_encode($request->all());
        $data["sn"] = $request->SN;
        $data["option"] = $request->option;
        DB::table('device_log')->insert($data);

        // update status device
        DB::table('devices')->where('no_sn', $request->SN)->update(['online' => now()]);
        $r = "GET OPTION FROM: " . $request->SN . "
            Stamp=9999
            OpStamp=" . strtotime('now') . "
            ErrorDelay=60
            Delay=30
            ResLogDay=18250
            ResLogDelCount=10000
            ResLogCount=50000
            TransTimes=00:00;14:05
            TransInterval=1
            TransFlag=1111000000
            Realtime=1
            Encrypt=0";
        $r = trim(preg_replace('/\t+/', '', $r));
        // $r = "GET OPTION FROM:%s{$request->SN}\nStamp=1565089939\nOpStamp=1565089939\nErrorDelay=30\nDelay=10\nTransTimes=00:00;14:05\nTransInterval=1\nTransFlag=1111000000\nTimeZone=7\nRealtime=1\nEncrypt=0\n";

        return $r;
    }
    // implementasi https://docs.nufaza.com/docs/devices/zkteco_attendance/push_protocol/
    // setting timezone

    // request absensi
    public function receiveRecords(Request $request)
    {
        // return "OK: " . '1';

        // cek validasi device fingerprint berdasarkan serial number
        $cek = DB::table('devices')->select('id')->where('no_sn', '=', $request->SN)->first();
        if (is_null($cek)) {
            return "Mesin Absensi Belum Terdaftar";
        }

        // try {
        $content = $request->getContent();
        DB::table('request_log')->insert(['content' => $content, 'type' => 'absensi']);
        $arr = preg_split('/\\r\\n|\\r|,|\\n/', $content);
        $jml = count($arr);


        foreach ($arr as $rey) {
            // $jam = $req[1];
            $req = preg_split('/\\t\\n|\\t|,|\\n/', $rey);
            if (trim($req[0]) == 'OPLOG') {
                return "OK: " . '1';
            } elseif (trim($req[0]) == 'USER PIN') {
                DB::table('request_log')->insert(['content' => $req, 'type' => 'new-user']);
                return "OK: " . '1';
            }
            $jam = date('H:i:s', strtotime($req[1]));
            $tgl = date('Y-m-d', strtotime($req[1]));
            $code = trim($req[0]);
            $tipe_absen = (int) $req[2];

            if (!empty($code)) {
                $karyawan = Karyawan::where('code', $code)->first();
                if (is_null($karyawan)) {
                    return response(json_encode([
                        'notif' => 'Karyawan Tidak Ada'
                    ]));
                } else {
                    // $absen = Absen::where('tgl_absen', now()->format('Y-m-d'))
                    //     ->where('karyawan_id', $karyawan->id)
                    //     ->latest()
                    //     ->first();

                    // absen masuk
                    if ($tipe_absen == 0) {
                        $cekabsen = Absen::where('tgl_absen', $tgl)
                            ->where('karyawan_id', $karyawan->id)
                            ->latest()
                            ->first();

                        if (is_null($cekabsen)) {
                            $absen = DB::table('absen')->insert([
                                'karyawan_id' => $karyawan->id,
                                'jam_masuk' => $jam,
                                'tgl_absen' => $tgl,
                                'status'  => 'masuk',
                                'created_at' => now(),
                            ]);
                        }
                        // return response(json_encode([
                        //     'notif' => 'Absen Masuk',
                        //     'data' => $absen
                        // ]));
                    } else if ($tipe_absen == 1) {
                        $absen = Absen::whereNull('jam_keluar')
                            ->where('karyawan_id', $karyawan->id)
                            ->latest()
                            ->first()?->update(['jam_keluar' => $jam]);

                        // return response(json_encode([
                        //     'notif' => 'Absen Keluar',
                        //     'data' => $absen
                        // ]));
                    } else {
                        // return response(json_encode([
                        //     'notif' => 'Sudah Absen'
                        // ]));
                    }
                }
            }
        }
        return "OK: " . $jml;
        // } catch (Throwable $e) {
        //     DB::table('error_log')->insert([
        //         'error' => $e,
        //         'type' => 'absensi-cdata',
        //     ]);
        //     report($e);

        //     return "ERROR:" . $jml . "\n";
        // }


        // if (isset($request->table)) {
        //     $table = $request->table;
        // } else {
        //     $this->doNothing();
        // }
        // switch ($table) {
        //     case 'ATTLOG':
        //         $this->savetoTable($request);
        //         $this->logAttendance($request);

        //         return $this->returnOk();
        //         break;
        //     case 'ATTPHOTO':
        //         //receiveOnSitePhoto($request);
        //         break;
        //     case 'OPERLOG':
        //         $this->savetoTable($request);
        //         $this->receiveOperationLog($request);
        //         break;
        //     default:
        //         $this->doNothing();
        //         break;
        // }
        // return $this->returnOk();
    }
}
