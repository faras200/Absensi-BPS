<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absen;
use App\Models\Karyawan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard', [
            'absens' => Absen::where('tgl_absen', now()->format('Y-m-d'))->get(),
            'karyawans' => Karyawan::all(),
            'users' => User::all(),

        ]);
    }
}
