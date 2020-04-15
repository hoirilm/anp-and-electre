<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function daftarAdmin()
    {
        $users = DB::table('users')->where('is_admin', '=', 1)->paginate(5);
        return view('pages.admin.pengguna', ['users' => $users]);
    }

    public function daftarPenguji()
    {
        $users = DB::table('users')->where('is_admin', '=', 0)->paginate(5);
        return view('pages.admin.pengguna', ['users' => $users]);
    }

    public function daftarPeserta()
    {
        $peserta = DB::table('peserta')->paginate(5);
        return view('pages.admin.peserta', ['peserta' => $peserta]);
    }
}
