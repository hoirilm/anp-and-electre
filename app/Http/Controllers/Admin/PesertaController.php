<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jurusan;
use App\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM peserta"));
        // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        $tahun = array_map(function ($value) {
            return (array) $value;
        }, $tahun);

        // digunakan pada tambah peserta
        $list_jurusan = Jurusan::all();

        // return $tahun;
        return view('pages.admin.peserta', ['tahun' => $tahun, 'list_jurusan' => $list_jurusan]);
    }

    public function selectYear()
    {
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM peserta"));
        // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        $tahun = array_map(function ($value) {
            return (array) $value;
        }, $tahun);

        $peserta = DB::table('peserta')
            ->join('jurusan', 'jurusan.id', '=', 'peserta.jurusan_id')
            ->select('peserta.*', 'jurusan.jurusan')
            ->whereYear('peserta.created_at', request('tahun'))
            ->get();

        // digunakan pada tambah peserta
        $list_jurusan = Jurusan::all();

        return view('pages.admin.peserta', ['tahun' => $tahun, 'peserta' => $peserta, 'list_jurusan' => $list_jurusan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_siswa' => 'required|max:30',
            'nomor_pendaftaran' => 'required|max:30',
            'npsn_sekolah' => 'required|max:30',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'jurusan' => 'required',
        ]);


        Peserta::create([
            'nama_siswa' => $request->nama_siswa,
            'nomor_pendaftaran' => $request->nomor_pendaftaran,
            'npsn_sekolah' => $request->npsn_sekolah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jurusan_id' => $request->jurusan,
        ]);

        return redirect()->route('admin.peserta')->with('massage', 'Peserta berhasil ditambah');
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
        $peserta = Peserta::find($id);
        $list_jurusan = Jurusan::all();

        return view('pages.admin.edit-peserta', ['peserta' => $peserta, 'list_jurusan' => $list_jurusan]);
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
        $this->validate($request, [
            'nama_siswa' => 'required|max:30',
            'nomor_pendaftaran' => 'required|max:30',
            'npsn_sekolah' => 'required|max:30',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'jurusan' => 'required',
        ]);


        Peserta::select('peserta')->where('id', $id)->update([
            'nama_siswa' => $request->nama_siswa,
            'nomor_pendaftaran' => $request->nomor_pendaftaran,
            'npsn_sekolah' => $request->npsn_sekolah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jurusan_id' => $request->jurusan,
        ]);

        return redirect()->route('admin.peserta')->with('massage', 'Peserta berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Peserta::destroy($id);
        return redirect()->route('admin.peserta')->with('massage', 'Peserta berhasil dihapus');
    }
}
