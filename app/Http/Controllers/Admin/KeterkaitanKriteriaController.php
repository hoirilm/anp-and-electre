<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\KeterkaitanKriteria;
use App\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeterkaitanKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));
        // // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        // $tahun = array_map(function ($value) {
        //     return (array) $value;
        // }, $tahun);

        $keterkaitan = Kriteria::all();

        // dd($keterkaitan[0]->kriteria);

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

        // dd($gabungan);

        return view('pages.admin.keterkaitan', ['gabungan' => $gabungan]);
    }

    public function selectYear()
    {
        // $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));
        // // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        // $tahun = array_map(function ($value) {
        //     return (array) $value;
        // }, $tahun);

        // $keterkaitan = Kriteria::whereYear('created_at', request('tahun'))->get();

        // // return $keterkaitan;

        // $batas = count($keterkaitan);
        // $a = 0;
        // $b = 1;
        // for ($i = $a; $i < $batas; $i++) {
        //     $kriteria1 = $keterkaitan[$i];
        //     for ($j = $b; $j < $batas; $j++) {
        //         $kriteria2 = $keterkaitan[$j];

        //         $gabungan[] = [
        //             'satu' => ['nama' => $kriteria1->kriteria, 'id' => $kriteria1->id, 'tahun_kriteria' => $kriteria1->created_at],
        //             'dua' => ['nama' => $kriteria2->kriteria, 'id' => $kriteria2->id, 'tahun_kriteria' => $kriteria2->created_at]
        //         ];
        //     }
        //     $a += 1;
        //     $b += 1;
        // }

        // return view('pages.admin.keterkaitan', ['tahun' => $tahun, 'gabungan' => $gabungan]);
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
    public function store()
    {
        // return request()->all();

        $tanggal = date('Y', strtotime(request('tahun_kriteria_1')));
        $cek_data = KeterkaitanKriteria::whereYear('tahun_kriteria', $tanggal)->first();

        if (isset($cek_data)) {
            KeterkaitanKriteria::whereYear('tahun_kriteria', $tanggal)->delete();
        }

        for ($i = 1; $i <= request('loop'); $i++) {
            KeterkaitanKriteria::create([
                'kriteria_x' => request('keterkaitan_x_' . $i),
                'kriteria_y' => request('keterkaitan_y_' . $i),
                'terkait' => request('keterkaitan' . $i),
                'tahun_kriteria' => request('tahun_kriteria_' . $i),
            ]);
        }

        return redirect()->route('admin.keterkaitan')->with('massage', 'Keterkaitan-kriteria berhasil disimpan');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
