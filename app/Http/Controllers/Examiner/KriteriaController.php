<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use App\KeterkaitanKriteria;
use App\Kriteria;
use App\xyKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $gabungan = [];
        $cek_update_kriteria_di_keterkaitan = 'gagal';
        $cek_update_kriteria_di_xykriteria = 'gagal';

        $tahun = date('Y', strtotime(Auth::user()->created_at));

        $kriteria = Kriteria::whereYear('created_at', $tahun)->get();

        if (!empty($kriteria)) {
            $batas = count($kriteria);
            $a = 0;
            $b = 1;
            for ($i = $a; $i < $batas; $i++) {
                $kriteria1 = $kriteria[$i];
                for ($j = $b; $j < $batas; $j++) {
                    $kriteria2 = $kriteria[$j];
                    $gabungan[] = [
                        'satu' => ['nama' => $kriteria1->kriteria, 'id' => $kriteria1->id, 'tahun_kriteria' => $kriteria1->created_at],
                        'dua' => ['nama' => $kriteria2->kriteria, 'id' => $kriteria2->id, 'tahun_kriteria' => $kriteria2->created_at]
                    ];
                }
                $a += 1;
                $b += 1;
            }
        }


        $input_terakhir = xyKriteria::where('user_id', Auth::user()->id)->get();

        $keterkaitan_kriteria = DB::select(DB::raw("SELECT kriteria_x.kriteria as kriteria_x, kriteria_y.kriteria as kriteria_y, terkait as terkait FROM keterkaitan_kriteria JOIN kriteria as kriteria_x ON keterkaitan_kriteria.kriteria_x = kriteria_x.id JOIN kriteria as kriteria_y ON keterkaitan_kriteria.kriteria_Y = kriteria_Y.id"));

        // $nilai_perbandingan = DB::select(DB::raw("SELECT kriteria_x.kriteria as kriteria_x, kriteria_y.kriteria as kriteria_y, nilai FROM xy_kriteria JOIN kriteria AS kriteria_x ON xy_kriteria.kriteria_x = kriteria_x.id JOIN kriteria AS kriteria_y ON xy_kriteria.kriteria_y = kriteria_y.id"));

        // NOTE!!
        // digunakan untuk mengecek apakah ada kriteria baru yang belum diproses.
        // dengan mencocokkan id di table kriteria dengan id yang ada di table xy_kriteria. jika tidak ada id yang dicari,
        // diasumsikan bahwa penilaian untuk kriteria terbaru belum dilakukan.  
        $kriteria_id = Kriteria::select('id')->get()->pluck('id')->toArray();

        $kriteria_x_keterkaitan = KeterkaitanKriteria::select('kriteria_x')->distinct()->get()->pluck('kriteria_x')->toArray();
        $kriteria_y_keterkaitan = KeterkaitanKriteria::select('kriteria_y')->distinct()->get()->pluck('kriteria_y')->toArray();

        $kriteria_x = xyKriteria::select('kriteria_x')->distinct()->get()->pluck('kriteria_x')->toArray();
        $kriteria_y = xyKriteria::select('kriteria_y')->distinct()->get()->pluck('kriteria_y')->toArray();
        
        $kriteria_xy_1 = array_merge($kriteria_x_keterkaitan, $kriteria_y_keterkaitan);
        $kriteria_xy_2 = array_merge($kriteria_x, $kriteria_y);

        if (!empty($kriteria_xy_1)) {
            for ($i = 0; $i < count($kriteria_id); $i++) {
                if (in_array($kriteria_id[$i], $kriteria_xy_1)) {
                    $result1[] = 'sukses';
                } else {
                    $result1[] = 'gagal';
                }
            }

            if (in_array('gagal', $result1)) {
                $cek_update_kriteria_di_keterkaitan = 'gagal';
            } else {
                $cek_update_kriteria_di_keterkaitan = 'sukses';
            }
        }

        if (!empty($kriteria_xy_2)) {
            for ($i = 0; $i < count($kriteria_id); $i++) {
                if (in_array($kriteria_id[$i], $kriteria_xy_2)) {
                    $result2[] = 'sukses';
                } else {
                    $result2[] = 'gagal';
                }
            }

            if (in_array('gagal', $result2)) {
                $cek_update_kriteria_di_xykriteria = 'gagal';
            } else {
                $cek_update_kriteria_di_xykriteria = 'sukses';
            }
        }
        // =====================================================================================================

        return view('pages.penguji.kriteria', [
            'kriteria' => $kriteria,
            'keterkaitan_kriteria' => $keterkaitan_kriteria,
            'gabungan' => $gabungan,
            'input_terakhir' => $input_terakhir,
            'cek_update_kriteria_di_keterkaitan' => $cek_update_kriteria_di_keterkaitan,
            'cek_update_kriteria_di_xykriteria' => $cek_update_kriteria_di_xykriteria
        ]);
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
        //
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
