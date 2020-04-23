<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kriteria;
use Illuminate\Http\Request;

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
}
