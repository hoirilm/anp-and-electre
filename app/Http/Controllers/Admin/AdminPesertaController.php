<?php

// namespace App;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Peserta;
use Illuminate\Http\Request;

class AdminPesertaController extends Controller
{
    public function tambahPeserta(Request $req)
    {

        // return $req->all();

        $this->validate($req, [
            'nama_siswa' => 'required|max:30',
            'nomor_pendaftaran' => 'required|max:30',
            'npsn_sekolah' => 'required|max:30',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'jurusan' => 'required',
        ]);


        Peserta::create([
            'nama_siswa' => $req->nama_siswa,
            'nomor_pendaftaran' => $req->nomor_pendaftaran,
            'npsn_sekolah' => $req->npsn_sekolah,
            'jenis_kelamin' => $req->jenis_kelamin,
            'tanggal_lahir' => $req->tanggal_lahir,
            'jurusan_id' => $req->jurusan,
        ]);

        return redirect()->route('admin.peserta')->with('massage', 'Peserta berhasil ditambah');
    }
}
