<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jurusan;
use App\KeterkaitanKriteria;
use App\Kriteria;
use App\User;
use App\xyKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupermatrikController extends Controller
{
    public function index(){
        // return "parameter: penguji, jurusan";

        $penguji = User::where('is_admin', 0)->get();
        $jurusan = Jurusan::all();

        return view('pages.admin.supermatrik', ['penguji' => $penguji, 'jurusan' => $jurusan]);
    }

    public function select(){
        // return request()->all();
        $penguji = User::where('is_admin', 0)->get();
        $jurusan = Jurusan::all();

        $penguji_id = request('penguji');
        $jurusan_id = request('jurusan');
        $kriteria = Kriteria::all();
        $cek_update_kriteria_di_keterkaitan = 'gagal';
        $cek_update_kriteria_di_xykriteria = 'gagal';

        $pilih_jurusan = Jurusan::where('id', $jurusan_id)->first();
        $input_terakhir = xyKriteria::where('user_id', $penguji_id)->where('jurusan_id', $jurusan_id)->get();
        $keterkaitan_kriteria = DB::select(DB::raw("SELECT kriteria_x.kriteria as kriteria_x, kriteria_x.id AS id_x,kriteria_y.id AS id_y,kriteria_y.kriteria as kriteria_y, terkait as terkait FROM keterkaitan_kriteria JOIN kriteria as kriteria_x ON keterkaitan_kriteria.kriteria_x = kriteria_x.id JOIN kriteria as kriteria_y ON keterkaitan_kriteria.kriteria_Y = kriteria_Y.id"));

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

        // kodingan untuk cek kondisi keterkaitan kriteria apakah ada yg tidak terkait
        $a = [];
        for ($i = 0; $i < count($keterkaitan_kriteria); $i++) {
            $a[] = [
                $keterkaitan_kriteria[$i]->id_x => $keterkaitan_kriteria[$i]->terkait,
                $keterkaitan_kriteria[$i]->id_y => $keterkaitan_kriteria[$i]->terkait
            ];
        }

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


        // jika kriteria tertentu tidak terkait dengan kriteria manapun
        for ($i = 1; $i <= count($keterkaitan); $i++) {
            if ($keterkaitan[$i] == (count($kriteria) - 1)) {
                $keterkaitan[$i] = "fail";
            }
        }


        return view('pages.admin.supermatrik', [
            'keterkaitan_kriteria' => $keterkaitan_kriteria,
            'cek_update_kriteria_di_keterkaitan' => $cek_update_kriteria_di_keterkaitan,
            'cek_update_kriteria_di_xykriteria' => $cek_update_kriteria_di_xykriteria,
            'input_terakhir' => $input_terakhir,
            'pilih_jurusan' => $pilih_jurusan,
            'kriteria' => $kriteria,
            'keterkaitan' => $keterkaitan,
            'penguji' => $penguji,
            'jurusan' => $jurusan,
            // 'eigen_vektor' => $eigen_vektor,
            // 'unweight' => $unweight,
            // 'weight' => $weight,
            // 'limit' => $limit,
            // 'normalisasi_limit' => $normalisasi_limit,
            // 'bobot_raw' => $bobot_raw,
            // 'bobot_normal' => $bobot_normal,
            // 'bobot_ideal' => $bobot_ideal,
            'sudah_pilih' => true  // parameter untuk kondisi sudah memilih penguji dan jurusan
        ]);
    }
}
