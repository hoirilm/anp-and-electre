<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jurusan;
use App\Kriteria;
use App\Nilai;
use App\Peserta;
use App\User;
use App\xyKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        $penguji = User::where('is_admin', 0)->get();
        $jurusan = Jurusan::all();
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM peserta"));
        $isSuccess = false;

        return view('pages.admin.ranking', [
            'penguji' => $penguji,
            'jurusan' => $jurusan,
            'tahun' => $tahun,
            'isSuccess' => $isSuccess
        ]);
    }

    public function ranking()
    {
        // return request()->all();

        // untuk dipanggil dalam dropdwon
        $penguji = User::where('is_admin', 0)->get();
        $jurusan = Jurusan::all();
        $tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(created_at) AS tahun FROM peserta"));
        // ==================================

        $kriteria = Kriteria::all(); // kriteria untuk menghitung banyaknya kriteria yang ada.

        $selectPenguji = request('penguji');
        $selectJurusan = request('jurusan');
        $selectTahun = request('tahun');
        $isSuccess = false;

        // $banyak_peserta = DB::select(DB::raw("SELECT COUNT(DISTINCT(peserta_id)) as jumlah_peserta  FROM nilai"));
        $banyak_peserta = DB::select(DB::raw("SELECT COUNT(id) AS jumlah_peserta FROM peserta WHERE jurusan_id = $selectJurusan"));

        $peserta = Peserta::where('jurusan_id', "=", $selectJurusan)->get();

        $jumlah_peserta = $banyak_peserta[0]->jumlah_peserta;

        // $bobot_normal = DB::table('bobot_normal')->select('bobot')->whereYear('created_at', '=', $selectTahun)->where('user_id', '=', $selectPenguji)->where('jurusan_id', '=', $selectJurusan)->get();
        $bobot_normal = DB::table('bobot_normal')->select('bobot')->where('user_id', '=', $selectPenguji)->where('jurusan_id', '=', $selectJurusan)->get();

        $nilai = DB::table('nilai')->select('nilai')->whereYear('created_at', '=', $selectTahun)->get();

        // dd($nilai);

        // dd($bobot_normal, $peserta, $nilai);

        if (count($bobot_normal) < 1 or count($peserta) < 1 or count($nilai) < 1) {
            return view('pages.admin.ranking', [
                'isSuccess' => $isSuccess,
                'penguji' => $penguji,
                'jurusan' => $jurusan,
                'tahun' => $tahun
            ]);
        } else {
            // menampung semua nilai peserta
            $index = 0;
            for ($i = 0; $i < $banyak_peserta[0]->jumlah_peserta; $i++) {
                for ($j = 0; $j < count($kriteria); $j++) {
                    $nilai_peserta[$i][] = $nilai[$index];
                    $index++;
                }
                $pembanding = 1;
            }

            // menjumlahkan nilai ditiap kriteria
            for ($i = 0; $i < count($kriteria); $i++) {
                for ($j = 0; $j < $banyak_peserta[0]->jumlah_peserta; $j++) {
                    $a[$i][] = $nilai_peserta[$j][$i];
                }
            }

            for ($i = 0; $i < count($kriteria); $i++) {
                for ($j = 0; $j < $banyak_peserta[0]->jumlah_peserta; $j++) {
                    $b[$i][] = $a[$i][$j]->nilai;
                }
            }

            for ($i = 0; $i < count($b); $i++) {
                for ($j = 0; $j < $banyak_peserta[0]->jumlah_peserta; $j++) {
                    $c[$i][] = pow($b[$i][$j], 2);
                }
            }

            for ($i = 0; $i < count($b); $i++) {
                $rata_rata[] = sqrt(array_sum($c[$i]));
            }

            // ==============================================================

            // Langkah 1 Normalisasi Matriks Keputusan
            for ($i = 0; $i < $banyak_peserta[0]->jumlah_peserta; $i++) {
                for ($j = 0; $j < count($kriteria); $j++) {
                    $normalisasi_matriks_keputusan[$i][] = $nilai_peserta[$i][$j]->nilai / $rata_rata[$j];
                }
            }

            // dd($normalisasi_matriks_keputusan);

            // Langkah 2 Pembobotan Pada Matriks Yang Telah Dinormalisasi
            for ($i = 0; $i < $banyak_peserta[0]->jumlah_peserta; $i++) {
                for ($j = 0; $j < count($kriteria); $j++) {
                    $pembobotan_matriks[$i][] = $normalisasi_matriks_keputusan[$i][$j] * $bobot_normal[$j]->bobot;
                }
            }

            // dd($pembobotan_matriks);

            // Langkah 3 Menentukan Himpunan Concordance dan Discordance pada Index
            for ($i = 0; $i < $jumlah_peserta; $i++) {
                for ($j = 0; $j < $jumlah_peserta; $j++) {
                    if ($i === $j) {
                        $concordance[] = null;
                    } else {
                        for ($k = 0; $k < count($kriteria); $k++) {
                            if ($pembobotan_matriks[$i][$k] >= $pembobotan_matriks[$j][$k]) {
                                $tampung[] = $bobot_normal[$k]->bobot;
                            } else {
                                $tampung[] = 0;
                            }
                        }

                        $concordance[] = array_sum($tampung);
                        $tampung = [];
                    }
                }
            }


            // Langkah 4 Menghitung Matrik Concordance dan Discordance

            // discordance a
            for ($i = 0; $i < $jumlah_peserta; $i++) {
                for ($j = 0; $j < $jumlah_peserta; $j++) {
                    if ($i == $j) {
                        $discordance_a[] = null;
                    } else {
                        for ($k = 0; $k < count($kriteria); $k++) {
                            if ($pembobotan_matriks[$i][$k] < $pembobotan_matriks[$j][$k]) {
                                $tampung[] = abs($pembobotan_matriks[$i][$k] - $pembobotan_matriks[$j][$k]);
                            } else {
                                $tampung[] = 0;
                            }
                        }

                        $discordance_a[] = max($tampung);
                        $tampung = [];
                    }
                }
            }

            // dd($discordance_a);

            // discordance b
            for ($i = 0; $i < $jumlah_peserta; $i++) {
                for ($j = 0; $j < $jumlah_peserta; $j++) {
                    if ($i == $j) {
                        $discordance_b[] = null;
                    } else {
                        for ($k = 0; $k < count($kriteria); $k++) {
                            $tampung[] = abs($pembobotan_matriks[$i][$k] - $pembobotan_matriks[$j][$k]);
                        }

                        $discordance_b[] = max($tampung);
                        $tampung = [];
                    }
                }
            }

            // dd($discordance_b);

            for ($i = 0; $i < count($discordance_a); $i++) {
                if ($discordance_a[$i] === null and $discordance_b[$i] === null) {
                    $gabung_discordance[] = null;
                } elseif ($discordance_a[$i] == null and $discordance_b[$i] == null) {
                    $gabung_discordance[] = 0;
                } else {
                    $gabung_discordance[] = $discordance_a[$i] / $discordance_b[$i];
                }
            }

            // dd($concordance);

            // Langkah 5 Menghitung Matriks Dominan Concordance dan Discordance
            $nilai_c = (array_sum($concordance) / ($jumlah_peserta * ($jumlah_peserta - 1)));
            for ($i = 0; $i < count($concordance); $i++) {
                if ($concordance[$i] === null) {
                    $matriks_domain_concordance[] = null;
                } else if ($concordance[$i] >= $nilai_c) {
                    $matriks_domain_concordance[] = 1;
                } else {
                    $matriks_domain_concordance[] = 0;
                }
            }

            $nilai_d = (array_sum($gabung_discordance) / ($jumlah_peserta * ($jumlah_peserta - 1)));
            for ($i = 0; $i < count($gabung_discordance); $i++) {
                // print_r(array_keys($gabung_discordance));
                if ($gabung_discordance[$i] === null) {
                    $matriks_domain_discordance[] = null;
                } else if ($gabung_discordance[$i] >= $nilai_d) {
                    $matriks_domain_discordance[] = 0;
                } else {
                    $matriks_domain_discordance[] = 1;
                }
            }


            // dd($matriks_domain_discordance);

            // Langkah 6 Menetukan Agregate Dominance Matrix
            for ($i = 0; $i < count($matriks_domain_discordance); $i++) {
                if ($matriks_domain_concordance[$i] == null) {
                    $agregate[] = null;
                    $agregate_view[] = null; // untuk ditampilkan dihalaman view
                } else {
                    $agregate[] = $matriks_domain_concordance[$i] * $matriks_domain_discordance[$i];
                    $agregate_view[] = $matriks_domain_concordance[$i] * $matriks_domain_discordance[$i]; // untuk ditampilkan dihalaman view
                }

                if (count($agregate) === $jumlah_peserta) {
                    $tampung2[] = array_sum($agregate);
                    $agregate = [];
                }
            }


            for ($i = 1; $i <= count($peserta); $i++) {
                $ranking[$i] = ['skor' => $tampung2[$i - 1], 'nama_siswa' => $peserta[$i - 1]->nama_siswa];
            }

            foreach ($ranking as $key => $row) {
                $ranking_siswa[$key] = ['skor' => $row['skor'], 'nama_siswa' => $row['nama_siswa']];
            }
            array_multisort($ranking_siswa, SORT_DESC, $ranking);

            $isSuccess = true;

            return view('pages.admin.ranking', [
                'isSuccess' => $isSuccess,
                'bobot_normal' => $bobot_normal,
                'nilai_c' => $nilai_c,
                'nilai_d' => $nilai_d,
                'peserta' => $peserta,
                'jumlah_peserta' => $jumlah_peserta,
                'penguji' => $penguji,
                'jurusan' => $jurusan,
                'tahun' => $tahun,
                'kriteria' => $kriteria,
                'ranking' => $ranking,
                'nilai_peserta' => $nilai_peserta,
                'rata_rata' => $rata_rata,
                'normalisasi_matriks_keputusan' => $normalisasi_matriks_keputusan,
                'pembobotan_matriks' => $pembobotan_matriks,
                'concordance' => $concordance,
                'gabung_discordance' => $gabung_discordance,
                'matriks_domain_concordance' => $matriks_domain_concordance,
                'matriks_domain_discordance' => $matriks_domain_discordance,
                'agregate_view' => $agregate_view
            ]);
        }

    }
}
