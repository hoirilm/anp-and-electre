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
        $kriteria = DB::table('kriteria')->paginate(5);
        return view('pages.admin.daftar-kriteria', compact('kriteria'));
    }

    public function keterkaitankriteria()
    {
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));

        // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        $tahun = array_map(function ($value) {
            return (array) $value;
        }, $tahun);

        // dd($tahun);

        return view('pages.admin.keterkaitan-kriteria', compact('tahun'));
    }

    public function cariKeterkaitan()
    {

        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));

        // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        $tahun = array_map(function ($value) {
            return (array) $value;
        }, $tahun);
       
        $keterkaitan = DB::table('kriteria')->whereYear('created_at', request('tahun'))->get();

        // return $keterkaitan;

        $batas = count($keterkaitan);
        $a = 0;
        $b = 1;
        for ($i = $a; $i < $batas; $i++) {
            $kriteria1 = $keterkaitan[$i];
            for ($j = $b; $j < $batas; $j++) {
                $kriteria2 = $keterkaitan[$j];

                $gabungan[] = [
                    'satu' => ['nama' => $kriteria1->kriteria, 'id' => $kriteria1->id, 'tahun_kriteria' => $kriteria1->created_at],
                    'dua' => ['nama' => $kriteria2->kriteria, 'id' => $kriteria2->id, 'tahun_kriteria' => $kriteria2->created_at]
                ];
            }
            $a += 1;
            $b += 1;
        }

        // return $gabungan;

        return view('pages.admin.keterkaitan-kriteria', ['gabungan' => $gabungan, 'tahun' => $tahun]);
    }
}
