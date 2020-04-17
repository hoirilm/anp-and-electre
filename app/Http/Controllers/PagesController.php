<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PagesController extends Controller
{
    public function pengguna()
    {
        $users = DB::table('users')->paginate(5);
        return view('pages.admin.pengguna', ['users' => $users]);
    }

    public function peserta()
    {
        $peserta = DB::table('peserta')->paginate(5);
        return view('pages.admin.peserta', ['peserta' => $peserta]);
    }
}
