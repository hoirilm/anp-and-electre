<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminKriteriaController extends Controller
{
    public function tambahKriteria(Request $req)
    {
        
        // return $req->all();

        $this->validate($req, [
            'kriteria' => 'required',
        ]);

        Kriteria::create([
            'kriteria' => $req->kriteria,
        ]);

        return redirect()->route('admin.daftar-kriteria')->with('massage', 'Kriteria berhasil ditambah');
    }

    public function cariKriteria()
    {
        // digunakan untuk memilih tahun berikutnya. tidak ada kaitannya dengan query di bawah
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));
        // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        $tahun = array_map(function ($value) {
            return (array) $value;
        }, $tahun);


        $kriteria = DB::table('kriteria')->whereYear('created_at', request('tahun'))->get();

        return view('pages.admin.daftar-kriteria', ['kriteria' => $kriteria, 'tahun' => $tahun]);
    }

    public function updateKriteria($id)
    {
        // return request('kriteria');

        Kriteria::select('kriteria')->where('id', $id)->update([
            'kriteria' => request('kriteria')
        ]);

        return redirect()->route('admin.daftar-kriteria')->with('massage', 'Kriteria berhasil diubah');

    }

    public function hapusKriteria($id)
    {
        Kriteria::destroy($id);
        return redirect()->route('admin.daftar-kriteria')->with('massage', 'Kriteria berhasil dihapus');
    }
}
