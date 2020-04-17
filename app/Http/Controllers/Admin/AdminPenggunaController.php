<?php

// namespace App;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminPenggunaController extends Controller
{
    public function tambahPengguna(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
            'username' => 'required|unique:users|min:5|max:20',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $req->name,
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'is_admin' => $req->status
        ]);

        return redirect()->route('admin.pengguna')->with('massage', 'Admin berhasil ditambah');
    }
}
