<?php

namespace App\Http\Controllers\Examiner;

use App\BobotNormal;
use App\Http\Controllers\Controller;
use App\Kriteria;
use App\Unweight;
use App\xyKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

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

        // dd(request()->all());

        $loop = request('loop');
        $jurusan_id = request('jurusan_id');
        $id_x = [];
        $id_y = [];
        $kriteria_x = [];
        $kriteria_y = [];
        $kepentingan = [];

        // nilai perbandingan - 1
        $keterkaitan_kriteria = DB::select(DB::raw("SELECT kriteria_x.kriteria as kriteria_x, kriteria_x.id AS id_x,kriteria_y.id AS id_y,kriteria_y.kriteria as kriteria_y, terkait as terkait FROM keterkaitan_kriteria JOIN kriteria as kriteria_x ON keterkaitan_kriteria.kriteria_x = kriteria_x.id JOIN kriteria as kriteria_y ON keterkaitan_kriteria.kriteria_Y = kriteria_Y.id"));
        $kriteria = Kriteria::all();
        $nilai1 = 1.0;
        $index1 = 0;
        $index2 = 0;

        // mengambil data dari perulangan input form sebelumnya
        $count_id = [];
        for ($i = count($kriteria) - 1; $i > 0; $i--) {
            array_push($count_id, $i);
        }

        // ambil nilai id x dan y
        for ($i = 0; $i < array_sum($count_id); $i++) {
            array_push($id_x, request('id_x_' . $i));
            array_push($id_y, request('id_y_' . $i));
        }

        // ambil nilai kriteria x dan y
        for ($i = 0; $i < array_sum($count_id); $i++) {
            array_push($kriteria_x, request('kriteria_x_' . $i));
            array_push($kriteria_y, request('kriteria_y_' . $i));
        }

        // ambil nilai kepentingan
        for ($i = 0; $i < request('loop'); $i++) {
            array_push($kepentingan, request('kepentingan_' . $i));
        }


        if (count($kriteria) == 5) {
            // khusus 5 kriteria
            $array = array(0, 1, 4, 2, 5, 7, 3, 6, 8, 9);
        } else if (count($kriteria) == 6) {
            // khusus 6 kriteria
            $array = array(0, 1, 5, 2, 6, 9, 3, 7, 10, 12, 4, 8, 11, 13, 14);
        } else if (count($kriteria) == 7) {
            // khusus 7 kriteria
            $array = array(0, 1, 6, 2, 7, 11, 3, 8, 12, 15, 4, 9, 13, 16, 18, 5, 10, 14, 17, 19, 20);
        }


        for ($i = 1; $i <= count($kriteria); $i++) {
            for ($j = 1; $j <= count($kriteria); $j++) {
                if ($i === $j) {
                    $nilai_perbandingan[$j][] = floatval($nilai1); //tengah
                } else if ($i > $j) {
                    $nilai_perbandingan[$j][] = floatval(1 / request('kepentingan_' . $array[$index1])); // segitiga bawah
                    $index1++;
                } else if ($i < $j && $j) {
                    $nilai_perbandingan[$j][] = floatval(request('kepentingan_' . $index2)); // segitaga atas
                    $index2++;
                }
            }
        }

        for ($i = 1; $i <= count($nilai_perbandingan); $i++) {
            $total_perbandingan[] = floatval(array_sum($nilai_perbandingan[$i])); //total dari nilai perbandingan
        }

        // dd($nilai_perbandingan, $total_perbandingan);

        // normalisasi - 2
        for ($i = 0; $i < count($kriteria); $i++) {
            for ($j = 1; $j <= count($nilai_perbandingan); $j++) {
                $nilai_normalisasi[$j][] = floatval($nilai_perbandingan[$j][$i] / $total_perbandingan[$j - 1]);
            }
        }

        // dd($nilai_normalisasi,$nilai_normalisasi[1][0]);

        for ($i = 1; $i <= count($nilai_normalisasi); $i++) {
            $total_normalisasi[] = floatval(array_sum($nilai_normalisasi[$i]));
        }

        // dd($total_normalisasi);

        // bobot parsial - 2.1
        for ($i = 0; $i < count($nilai_normalisasi); $i++) {
            for ($j = 1; $j <= count($nilai_normalisasi); $j++) {
                $tampung_bobot_parsial[$i][] = $nilai_normalisasi[$j][$i];
            }
        }

        // dd($tampung_bobot_parsial);

        for ($i = 0; $i < count($nilai_normalisasi); $i++) {
            $bobot_parsial[] = floatval(array_sum($tampung_bobot_parsial[$i]) / count($kriteria));
        }

        // dd($bobot_parsial);

        $total_bobot_parsial = floatval(array_sum($bobot_parsial));

        // dd($total_bobot_parsial);

        // eigen vektor - 2.2
        for ($i = 0; $i < count($bobot_parsial); $i++) {
            for ($j = 1; $j <= count($nilai_perbandingan); $j++) {
                $tampung_eigen_verktor[$i][] = $nilai_perbandingan[$j][$i] * $bobot_parsial[$j - 1];
            }
        }

        // dd($tampung_eigen_verktor);

        for ($i = 0; $i < count($tampung_eigen_verktor); $i++) {
            $eigen_vektor[] = floatval(array_sum($tampung_eigen_verktor[$i]));
        }

        $total_eigen_vektor = floatval(array_sum($eigen_vektor));

        // dd($eigen_vektor, $total_eigen_vektor);

        // ternormalisasi terbobot - 2.3
        for ($i = 0; $i < count($kriteria); $i++) {
            $ternormalisasi_terbobot[] = floatval($eigen_vektor[$i] / $bobot_parsial[$i]);
        }

        $total_normalisasi_terbobot = floatval(array_sum($ternormalisasi_terbobot));

        // dd($ternormalisasi_terbobot, $total_normalisasi_terbobot);


        // eigen maximum - 3
        $eigen_maximum = floatval($total_normalisasi_terbobot / count($kriteria));

        // dd($eigen_maximum);

        // menghitung ci - 4
        $ci = floatval(($eigen_maximum - count($kriteria)) / (count($kriteria) - 1));

        // dd($eigen_maximum, $ci);

        // menghitung cr - 5
        if (count($kriteria) == 1 or count($kriteria) == 2) {
            $ri = 0;
        } elseif (count($kriteria) == 3) {
            $ri = 0.58;
        } elseif (count($kriteria) == 4) {
            $ri = 0.9;
        } elseif (count($kriteria) == 5 or count($kriteria) == 6) {
            $ri = 1.12;
        } elseif (count($kriteria) == 7) {
            $ri = 1.34;
        } elseif (count($kriteria) == 8) {
            $ri = 1.41;
        } elseif (count($kriteria) == 9) {
            $ri = 1.45;
        } elseif (count($kriteria) == 10) {
            $ri = 1.49;
        } else {
            $ri = null;
        }

        $cr = floatval($ci / $ri);



        // unweight - 6
        for ($i = 0; $i < count($kriteria); $i++) {
            for ($j = 0; $j < count($eigen_vektor); $j++) {
                $unweight[] = floatval($eigen_vektor[$i] * $eigen_vektor[$j]);
            }
        }

        // dd($unweight);

        // dd($nilai_perbandingan, $unweight);

        // NOTE: MUNGKIN BISA DIKASI KONDISI JIKA KRITERIA BELUM DIISI

        // weight - 7
        $weight = [];
        $index1 = 0;
        $index2 = 0;
        $index3 = 0;
        $index4 = 0;

        if (count($kriteria) == 5) {
            // khusus 5 kriteria
            $array = array(1, 2, 7, 3, 8, 13, 4, 9, 14, 19);
        } elseif (count($kriteria) == 6) {
            // khusus 6 kriteria
            $array = array(1, 2, 8, 3, 9, 15, 4, 10, 16, 22, 5, 11, 17, 23, 29);
        } elseif (count($kriteria) == 7) {
            // khusus 7 kriteria
            $array = array(1, 2, 9, 3, 10, 17, 4, 11, 18, 25, 5, 12, 19, 26, 33, 6, 13, 20, 27, 34, 41);
        }

        for ($i = 1; $i <= count($kriteria); $i++) {
            for ($j = 1; $j <= count($kriteria); $j++) {
                if ($i === $j) { //tengah
                    $weight[] = floatval($nilai_perbandingan[$j][$index1] * $unweight[$index2]);
                    $index2++;
                } elseif ($i > $j) {  // segitiga bawah
                    if ($weight[$array[$index3]] == 0) {
                        $weight[] = floatval(0);
                        $index2++;
                        $index3++;
                    } else {
                        $weight[] = floatval($nilai_perbandingan[$j][$index1] * $unweight[$index2]);
                        $index2++;
                        $index3++;
                    }
                } elseif ($i < $j && $j) { // segitiga atas
                    if ($keterkaitan_kriteria[$index4]->terkait == 0) {
                        $weight[] = floatval(0);
                        $index2++;
                        $index4++;
                    } else {
                        $weight[] = floatval($nilai_perbandingan[$j][$index1] * $unweight[$index2]);
                        $index2++;
                        $index4++;
                    }
                }
            }
            $index1++;
        }

        // dd($weight);


        // limit - 8
        $limit = [];
        $index1 = 0;
        $index2 = 0;
        $index3 = 0;

        // if ($i === $j) {
        //     $limit[$j][] = floatval(pow($weight[$index1], $weight[$index1]));
        //     $index1++;
        // } elseif ($i > $j) {
        //     $limit[$j][] = floatval(pow($weight[$index1], $weight[$index1]));
        //     $index1++;
        //     $index2++;
        // } elseif ($i < $j && $j) {
        //     $limit[$j][] = floatval(pow($weight[$index1], $weight[$index1]));
        //     $index1++;
        //     $index3++;
        // }

        for ($i = 1; $i <= count($kriteria); $i++) {
            for ($j = 1; $j <= count($kriteria); $j++) {
                if ($i === $j) {
                    $limit[$j][] = floatval(pow($weight[$index1], $weight[$index1]));
                    $index1++;
                } elseif ($i > $j) {
                    $limit[$j][] = floatval(pow($weight[$index1], $weight[$index1]));
                    $index1++;
                    $index2++;
                } elseif ($i < $j && $j) {
                    $limit[$j][] = floatval(pow($weight[$index1], $weight[$index1]));
                    $index1++;
                    $index3++;
                }
            }
        }

        // dd(gettype($limit[3][3]));

        for ($i=1; $i <= count($limit); $i++) {
            for ($j=0; $j < count($limit); $j++) {
                if ($limit[$i][$j] == INF){ //kondisi jika inf
                    $new_limit[$i][$j] = 0;
                } else {
                    $new_limit[$i][$j] = $limit[$i][$j];
                }
            }
        }

        // dd(array_sum($new_limit[3]));

        for ($i = 1; $i <= count($limit); $i++) {
            $total_limit[] = floatval(array_sum($new_limit[$i]));
        }

        // dd($new_limit, $total_limit);


        // normalisasi limit - 9
        $normalisasi_limit = [];
        $keterkaitan_fail = 0;
        $index1 = 0;
        $index2 = 0;
        $index3 = 0;

        for ($i = 0; $i < count($kriteria); $i++) {
            for ($j = 1; $j <= count($new_limit); $j++) {
                $normalisasi_limit[$j][] = floatval($new_limit[$j][$i] / $total_limit[$j - 1]);
            }
        }

        // dd($normalisasi_limit);

        for ($i = 1; $i <= count($normalisasi_limit); $i++) {
            $total_normalisasi_limit[] = floatval(array_sum($normalisasi_limit[$i]));
        }

        // dd($normalisasi_limit, $total_normalisasi_limit);

        // bobot raw - 9.1
        for ($i = 1; $i <= count($kriteria); $i++) {
            $bobot_raw[] = floatval(array_product($normalisasi_limit[$i]) / (1 / count($total_normalisasi_limit)));
            // $bobot_raw[] = number_format(floatval(array_product($normalisasi_limit[$i]) / (1 / count($total_normalisasi_limit))), 4);
        }

        // dd($bobot_raw);


        $total_bobot_raw = floatval(array_sum($bobot_raw));

        // dd($bobot_raw, $total_bobot_raw);

        // bobot normal - 9.2
        for ($i = 0; $i < count($keterkaitan_kriteria); $i++) {
            $a[] = [
                $keterkaitan_kriteria[$i]->id_x => $keterkaitan_kriteria[$i]->terkait,
                $keterkaitan_kriteria[$i]->id_y => $keterkaitan_kriteria[$i]->terkait
            ];
        }

        // dd($a);

        // cek keterkaitan mempengaruhi nilai bobot normal
        $keterkaitan = [];
        for ($i = 1; $i <= count($a); $i++) {
            $counter = 0;
            for ($j = 0; $j < count($a); $j++) {
                if (array_key_exists($i, $a[$j])) {
                    if ($a[$j][$i] === 0) {
                        $counter++;
                        $keterkaitan[$i] = $counter;
                    } else {
                        $keterkaitan[$i] = "success";
                    }
                }
            }
        }

        // dd($keterkaitan);

        // dd($kriteria);

        // jika kriteria tertentu tidak terkait dengan kriteria manapun
        for ($i = 1; $i <= count($kriteria); $i++) {
            if ($keterkaitan[$i] == (count($kriteria) - 1)) {
                $keterkaitan[$i] = "fail";
            }
        }

        // dd($keterkaitan);

        for ($i = 1; $i <= count($keterkaitan); $i++) {  // menghitung jumlah keterkaitan fail
            if ($keterkaitan[$i] == "fail") {
                $keterkaitan_fail++;
            }
        }

        if ($keterkaitan_fail === count($kriteria)) { // jika jumlah kriteria yg fail sama dengan jumlah kriteria keseluruhan,
            for ($i = 1; $i <= count($keterkaitan); $i++) {
                $bobot_normal[] = $bobot_parsial[$i - 1]; // maka bobot normal diisi dengan bobot parsial
            }
        } else {
            for ($i = 1; $i <= count($keterkaitan); $i++) {
                $bobot_normal[] = floatval($bobot_raw[$i - 1]) / $total_bobot_raw; // jika tidak, maka diisi dengan perhitungan bobot normal

            }
        }

        // dd($bobot_normal);

        $total = array_sum($bobot_normal);

        // dd($total);


        // dd($bobot_parsial, $bobot_normal, $total);

        // code sebelum dirubah
        // for ($i = 0; $i < count($bobot_raw); $i++) {
        //     $bobot_normal[] = floatval($bobot_raw[$i]) / $total_bobot_raw;
        // }

        $total_bobot_normal = floatval(array_sum($bobot_normal));
        $max_bobot_normal = floatval(max($bobot_normal));


        // bobot ideal - 9.3
        for ($i = 0; $i < count($bobot_normal); $i++) {
            $bobot_ideal[] = floatval($bobot_normal[$i] / $max_bobot_normal);
        }

        $total_bobot_ideal = floatval(array_sum($bobot_ideal));

        // dd($bobot_normal);

        // cek dengan kondisi mau diapakan

        if ($cr < 0.1) {
            return view('pages.penguji.kriteria-confirm', [
                'cr' => 'konsisten',
                'kriteria' => $kriteria,
                'loop' => $loop,
                'jurusan_id' => $jurusan_id,
                'id_x' => $id_x,
                'id_y' => $id_y,
                'kriteria_x' => $kriteria_x,
                'kriteria_y' => $kriteria_y,
                'kepentingan' => $kepentingan,
                'unweight' => $unweight,
                'weight' => $weight,
                // 'limit' => $limit,
                'normalisasi_limit' => $normalisasi_limit,
                'bobot_raw' => $bobot_raw,
                'bobot_normal' => $bobot_normal,
                'bobot_ideal' => $bobot_ideal
            ]);
        } else {

            // dd($bobot_normal);
            return view('pages.penguji.kriteria-confirm', [
                'cr' => '!konsisten',
                'kriteria' => $kriteria,
                'loop' => $loop,
                'jurusan_id' => $jurusan_id,
                'id_x' => $id_x,
                'id_y' => $id_y,
                'kriteria_x' => $kriteria_x,
                'kriteria_y' => $kriteria_y,
                'kepentingan' => $kepentingan,
                'unweight' => $unweight,
                'weight' => $weight,
                'limit' => $limit,
                'normalisasi_limit' => $normalisasi_limit,
                'bobot_raw' => $bobot_raw,
                'bobot_normal' => $bobot_normal,
                'bobot_ideal' => $bobot_ideal
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // dd(request()->all());

        // menyimpan nilai xykriteria
        $id_penguji = Auth::user()->id;

        $cek_data_xykriteria = xyKriteria::where('user_id', $id_penguji)->first();
        $cek_bobot_normal = BobotNormal::where('user_id', $id_penguji)->first();

        // dd($cek_data);

        if (isset($cek_data_xykriteria)) {
            xyKriteria::select('user_id', $id_penguji)->where('jurusan_id', request('jurusan_id'))->delete();
        }

        if (isset($cek_bobot_normal)) {
            BobotNormal::select('user_id', $id_penguji)->where('jurusan_id', request('jurusan_id'))->delete();
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

        for ($i = 0; $i < request('jumlah_bobot_normal'); $i++) {
            BobotNormal::create([
                'bobot' => request('bobot_normal_' . $i),
                // 'created_at' => now(),
                // 'updated_at' => now(),
                'user_id' => $id_penguji,
                'kriteria_id' => request('kriteria_id_' . $i),
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
