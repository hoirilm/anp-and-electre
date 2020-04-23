<?php

namespace App\Http\Controllers;

use App\Jurusan;
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
        $list_jurusan = Jurusan::all();
        return view('pages.admin.peserta', ['peserta' => $peserta, 'list_jurusan' => $list_jurusan]);
    }

    public function kriteria()
    {
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));
        // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        $tahun = array_map(function ($value) {
            return (array) $value;
        }, $tahun);

        return view('pages.admin.daftar-kriteria', compact('tahun'));
    }

    public function keterkaitankriteria()
    {
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));
        // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        $tahun = array_map(function ($value) {
            return (array) $value;
        }, $tahun);

        return view('pages.admin.keterkaitan-kriteria', compact('tahun'));
    }

}
