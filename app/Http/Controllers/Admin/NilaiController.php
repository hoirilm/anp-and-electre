<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kriteria;
use App\Nilai;
use App\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function edit($id)
    {
        $nilai = DB::table('nilai')
            ->join('kriteria', 'nilai.kriteria_id', '=', 'kriteria.id')
            ->where('peserta_id', $id)
            ->get();

        $peserta = Peserta::find($id);

        $kriteria = Kriteria::all();

        return view('pages.admin.edit-nilai', ['nilai' => $nilai, 'peserta' => $peserta, 'kriteria' => $kriteria]);
    }

    public function update(Request $request)
    {

        // Nilai::where('peserta_id', request('peserta_id'))->delete();

        // for ($i = 1; $i <= request('loop'); $i++) {
        //     $validate_array['nilai_kriteria_' . $i] = 'required|max:100|numeric';
        // }
        // $this->validate($request, $validate_array);

        // for ($i = 1; $i <= request('loop'); $i++) {
        //     Nilai::select('nilai')->where('peserta_id', request('peserta_id'))->update([
        //         'nilai' => request('nilai_kriteria_' . $i),
        //         'peserta_id' => request('peserta_id'),
        //         'kriteria_id' => request('kriteria_id_' . $i)
        //     ]);
        // }

        // return redirect()->back()->with('update', 'Nilai berhasil diubah');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // $validate_array = ['key' => 'value'];
        for ($i = 1; $i <= request('loop'); $i++) {
            $validate_array['nilai_kriteria_' . $i] = 'required|max:100|numeric';
        }
        $this->validate($request, $validate_array);

        $cek_data = Nilai::where('peserta_id', $request->peserta_id)->get();

        if (isset($cek_data)) {
            Nilai::where('peserta_id', $request->peserta_id)->delete();
        }

        for ($i = 1; $i <= request('loop'); $i++) {
            Nilai::create([
                'nilai' => request('nilai_kriteria_' . $i),
                'peserta_id' => request('peserta_id'),
                'kriteria_id' => request('kriteria_id_' . $i),
                'jurusan_id' => request('jurusan')
            ]);
        }

        return redirect()->back()->with('massage', 'Nilai berhasil disimpan');
    }
}
