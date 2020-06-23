<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jurusan;
use App\User;
use App\xyKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index(){
        $penguji = User::where('is_admin', 0)->get();
        $jurusan = Jurusan::all();
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM xy_kriteria"));

        return view('pages.admin.ranking', [
            'penguji' => $penguji,
            'jurusan' => $jurusan,
            'tahun' => $tahun
        ]);
    }

    public function ranking(){
        // return request()->all();

        $penguji = User::where('is_admin', 0)->get();
        $jurusan = Jurusan::all();
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM xy_kriteria"));



        // rumus perankingan here
    }
}
