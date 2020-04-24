<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('pages.admin.pengguna', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // diganti menggunakan modal
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request->all();

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users|min:5|max:20',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_admin' =>  $request->status
        ]);

        return redirect()->route('admin.pengguna')->with('massage', 'Pengguna berhasil ditambah');
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
        $user = User::find($id);
        return view('pages.admin.edit-pengguna', compact('user'));
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
        $cek_username = User::select('username')->where('id', $id)->first();

        if ($cek_username['username'] == $request->username) {
            $this->validate($request, [
                'name' => 'required',
                'username' => 'required|min:5|max:20',
                'password' => 'required|confirmed|min:6',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required',
                'username' => 'required|unique:users|min:5|max:20',
                'password' => 'required|confirmed|min:6',
            ]);
        }

        User::select('users')->where('id', $id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            // 'is_admin' => $req->status
        ]);

        return redirect()->route('admin.pengguna')->with('massage', 'Pengguna berhasil diupdate');
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
        return redirect()->route('admin.pengguna')->with('massage', 'Pengguna berhasil dihapus');
    }
}
