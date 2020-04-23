<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\KeterkatitanKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminKeterkaitanKriteriaController extends Controller
{
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
