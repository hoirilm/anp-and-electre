<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\KeterkatitanKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminKeterkaitanKriteriaController extends Controller
{

    public function cariKeterkaitan()
    {

        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM kriteria"));

        // merubah hasil db:raw menjadi array agar bisa diakses ke dalam select tahun
        $tahun = array_map(function ($value) {
            return (array) $value;
        }, $tahun);

        $keterkaitan = DB::table('kriteria')->whereYear('created_at', request('tahun'))->get();

        // return $keterkaitan;

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

        // return $gabungan;

        return view('pages.admin.keterkaitan-kriteria', ['gabungan' => $gabungan, 'tahun' => $tahun]);
    }

    public function keterkaitan()
    {
        // return request()->all();

        $tanggal = date('Y', strtotime(request('tahun_kriteria_1')));
        $cek_data = KeterkatitanKriteria::whereYear('tahun_kriteria', $tanggal)->first();


        if (!isset($cek_data)) {
            for ($i = 1; $i <= request('loop'); $i++) {
                KeterkatitanKriteria::create([
                    'kriteria_x' => request('keterkaitan_x_' . $i),
                    'kriteria_y' => request('keterkaitan_y_' . $i),
                    'terkait' => request('keterkaitan' . $i),
                    'tahun_kriteria' => request('tahun_kriteria_' . $i),
                ]);
            }
        } else {
            for ($i = 1; $i <= request('loop'); $i++) {
                KeterkatitanKriteria::select('keterkaitan_kriteria')
                ->where('kriteria_x', request('keterkaitan_x_' . $i))
                ->where('kriteria_y', request('keterkaitan_y_' . $i))
                ->whereYear('tahun_kriteria', $tanggal)->update([
                    'terkait' => request('keterkaitan' . $i)
                ]);
            }
        }

        return redirect()->route('admin.keterkaitan-kriteria')->with('massage', 'Keterkaitan-kriteria berhasil disimpan');
    }
}
