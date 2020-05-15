<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\KeterkaitanKriteria;
use App\Kriteria;
use App\xyKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
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
        $kriteria = Kriteria::all();

        return view('pages.admin.kriteria', compact('kriteria'));
    }

    public function selectYear()
    {
        // $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));
        // // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        // $tahun = array_map(function ($value) {
        //     return (array) $value;
        // }, $tahun);
        
        // $kriteria = Kriteria::whereYear('created_at', request('tahun'))->get();

        // return view('pages.admin.kriteria', ['tahun' => $tahun, 'kriteria' => $kriteria]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // diganti dengan modal tambah kriteria
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
            'kriteria' => 'required',
        ]);

        Kriteria::create([
            'kriteria' => $request->kriteria,
        ]);

        return redirect()->route('admin.kriteria')->with('massage', 'Kriteria berhasil ditambah');
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
        $kriteria = Kriteria::find($id);
        return view('pages.admin.edit-kriteria', compact('kriteria'));
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
            'kriteria' => 'required',
        ]);

        Kriteria::find($id)->update([
            'kriteria' => request('kriteria')
        ]);

        return redirect()->route('admin.kriteria')->with('massage', 'Kriteria berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kriteria_x = KeterkaitanKriteria::select('kriteria_x')->where('kriteria_x', $id)->get()->pluck('kriteria_x')->toArray();
        $kriteria_y = KeterkaitanKriteria::select('kriteria_y')->where('kriteria_y', $id)->get()->pluck('kriteria_y')->toArray();
        $kriteria_xy = array_merge($kriteria_x, $kriteria_y);
        if (in_array($id, $kriteria_xy)) {
            return redirect()->route('admin.kriteria')->with('fail-massage', 'Gagal menghapus kriteria. Kriteria terhubung dengan tabel keterkaitan kriteria');
        } else {
            Kriteria::destroy($id);
            return redirect()->route('admin.kriteria')->with('success-massage', 'Kriteria berhasil dihapus');
        }
    }
}
