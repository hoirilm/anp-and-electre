<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use App\xyKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class xyKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $id_penguji = Auth::user()->id;

        // for ($i = 0; $i < request('loop'); $i++) {
        //     xyKriteria::updateOrCreate([
        //         'user_id' => $id_penguji,
        //         'prioritas' => request('prioritas_' . $i),
        //         'nilai' => request('kepentingan_' . $i),
        //         'kriteria_x' => request('id_x_' . $i),
        //         'kriteria_y' => request('id_y_' . $i)
        //     ]);
        // }

        $cek_data = xyKriteria::where('user_id', $id_penguji)->first();

        // dd($cek_data);

        if (isset($cek_data)) {
            xyKriteria::select('user_id', $id_penguji)->where('jurusan_id', request('jurusan_id'))->delete();
        } 
            
        for ($i = 0; $i < request('loop'); $i++) {
            xyKriteria::create([    
                'user_id' => $id_penguji,
                'prioritas' => (request('kepentingan_' . $i) < 1) ? (request('kriteria_y_' . $i) . ' | ' . request('kriteria_x_' . $i)) : (request('kriteria_x_' . $i) . ' | ' . request('kriteria_y_' . $i)),
                'nilai' => request('kepentingan_' . $i),
                'kriteria_x' => request('id_x_' . $i),
                'kriteria_y' => request('id_y_' . $i),
                'jurusan_id' => request('jurusan_id')
            ]);
        }

        return redirect()->route('examiner.kriteria')->with('massage', 'Kriteria berhasil disimpan');
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
