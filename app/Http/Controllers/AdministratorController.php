<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        //dd(User::where('id', '4')->get());
        return view('administrator.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama' => 'required|max:255',
            'email'  => 'required|unique:users',
            'role' => 'required',
            'password'  => 'required|min:8',
        ]);

        $validasi['password'] = Hash::make($validasi['password']);
        User::create($validasi);

        return redirect('/administrator')->with('success', 'Berhasil Menambah Admin!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->get();
        return view('administrator.edit', [
            'admins' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, User $user)
    {
        $rules = [
            'nama' => 'required|max:255',
            'role'  => 'required',
        ];
        $emails = User::where('id', $id)->get('email');
        foreach ($emails as $email) :
            if ($request->email != $email->email) {
                $rules['email'] = 'required|unique:users';
            }
        endforeach;

        if (!is_null($request->password)) {
            $rules['password'] = 'required|min:8';
            $validasi = $request->validate($rules);
            $validasi['password'] = Hash::make($validasi['password']);
        } else {
            $validasi = $request->validate($rules);
        }

        User::where('id', $id)
            ->update($validasi);

        return redirect('/administrator')->with('success', 'Berhasil Mengubah Admin!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('/administrator')->with('success', 'Berhasil Menghapus Admin!!');
    }
}
