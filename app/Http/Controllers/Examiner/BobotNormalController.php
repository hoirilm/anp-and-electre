<?php

namespace App\Http\Controllers\Examiner;

use App\BobotNormal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BobotNormalController extends Controller
{
    public function store()
    {
        // return request()->all();

        $id_penguji = Auth::user()->id;

        $cek_data = BobotNormal::where('user_id', $id_penguji)->first();

        // dd($cek_data);

        if (isset($cek_data)) {
            BobotNormal::select('user_id', $id_penguji)->where('jurusan_id', request('jurusan_id'))->delete();
        }

        for ($i = 0; $i < request('loop'); $i++) {
            BobotNormal::create([
                'bobot' => request('bobot_normal_'.$i),
                'user_id' => $id_penguji,
                'kriteria_id' => request('kriteria_id_'. $i),
                'jurusan_id' => request('jurusan_id')
            ]);
        }

        return redirect()->route('examiner.kriteria')->with('bobot_normal', 'Bobot normal berhasil disimpan');
    }
}
