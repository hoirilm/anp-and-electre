@extends('layouts.penguji')

@section('title', 'Menu Kriteria')

@section('content')

<div class="container-fluid">

{{-- {{dd($pilih_jurusan)}} --}}
    <div class="col-xl-3 col-md-6 mb-4 px-0">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pilih Jurusan: </div>
                        <form action="/examiner/kriteria/recent" method="POST">
                            @csrf
                            @method('put')
                            <div class="dropdown row px-2">
                                <select class="form-control col" name="jurusan">
                                    <option>Pilih Jurusan</option>
                                    @foreach ($jurusan as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['jurusan'] }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm mx-2">Lihat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (!isset($gabungan))
    <div class="alert alert-primary col-3">
        Pilih jurusan terlebih dahulu
    </div>

    @else
        {{-- {{dd($cek_update_kriteria_di_xykriteria ,$input_terakhir)}} --}}
        @php
            $keterkaitan_fail = 0;
            for ($i = 1; $i <= count($keterkaitan); $i++) {
                if ($keterkaitan[$i] == "fail") {
                    $keterkaitan_fail++;
                }
            }
        @endphp

        {{-- {{dd($keterkaitan_kriteria)}} --}}

        @if ($keterkaitan_fail == count($kriteria)) {{-- jika semua kriteria tidak berkaitan --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail nilai dari jurusan {{ $pilih_jurusan->jurusan }}</h6>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionExample">

                        {{-- detail proses sebelumnya --}}
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Proses Sebelumnya
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                @if (count($input_terakhir) == 0)
                                    <div class="card-body">
                                        <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                    </div>
                                @else
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <th>Perbandingan Kriteria</th>
                                                <th>Tingkat Kepentingan</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($input_terakhir as $item)
                                                    <tr>
                                                        <td>{{ $item->prioritas }}</td>
                                                        <td>{{ number_format($item->nilai,2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- detail keterkaitan kriteria --}}
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">
                                        Keterkaitan Kriteria
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                @if ($cek_update_kriteria_di_keterkaitan === 'gagal' or count($keterkaitan_kriteria) < 1)
                                <div class="card-body">
                                <p class="alert alert-warning m-0">Keterkaitan kriteria belum diisi oleh admin</p>
                                </div>
                                @else
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <th>Kriteria</th>
                                                <th>Status</th>
                                                <th>Kriteria</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($keterkaitan_kriteria as $item)
                                                <tr>
                                                    <td>{{ $item->kriteria_x }}</td>
                                                    <td>
                                                        @if($item->terkait === 0)
                                                            <span class="badge badge-danger">Tidak terkait</span>
                                                        @else
                                                            <span class="badge badge-success">Terkait</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->kriteria_y }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- detail nilai perbandingan --}}
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        Nilai Perbandingan
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if ($cek_update_kriteria_di_xykriteria === 'gagal' or count($input_terakhir) < 1)
                                        <p class="alert alert-warning m-0">Kriteria baru ditambahkan oleh admin, segera lakukan penilaian ulang.</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody class="text-center">
                                                <tr>
                                                    <th></th>
                                                    @foreach ($kriteria as $mapel)
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                    @endforeach
                                                </tr>

                                                @php
                                                $nilai1 = 1.0;
                                                $index1 = 0;
                                                $index2 = 0;

                                                $array = array(0,1,5,2,6,9,3,7,10,12,4,8,11,13,14);
                                                @endphp
                                                {{-- {{ dd($input_terakhir[$array[7]]) }} --}}
                                                {{-- {{dd($input_terakhir[7])}} --}}

                                                @foreach ($kriteria as $mapel)
                                                    <tr>
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                        @for ($i = 1; $i <= count($kriteria); $i++)

                                                            <td>
                                                                @if ($loop->iteration === $i)
                                                                {{ $total_perbandingan[$i][] = floatval($nilai1) }}
                                                                @elseif ($loop->iteration > $i)
                                                                {{ $total_perbandingan[$i][] = floatval(1/$input_terakhir[$array[$index1]]['nilai']) }}
                                                                @php $index1++; @endphp
                                                                @elseif ($loop->iteration < $i && $i)
                                                                {{ $total_perbandingan[$i][] = floatval($input_terakhir[$index2]['nilai']) }}
                                                                @php $index2++; @endphp
                                                                @endif
                                                            </td>
                                                        @endfor

                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th class="table-success">
                                                        Total
                                                    </th>
                                                    @for ($i = 1; $i <= count($total_perbandingan); $i++)
                                                        <td class="table-success"> {{ floatval(array_sum($total_perbandingan[$i])) }}</td>
                                                    @endfor
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    @endif
                                </div>
                            </div>
                        </div>


                        {{-- detail normalisasi --}}
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Normalisasi
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if (!isset($total_perbandingan) or count($total_perbandingan) < 1)
                                        <p class="alert alert-warning m-0">Tidak ada nilai yang diinputkan.</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    @foreach ($kriteria as $mapel)
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                    @endforeach
                                                </tr>

                                                @foreach ($kriteria as $mapel)
                                                    <tr>
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                        @for ($j = 1; $j <= count($total_perbandingan); $j++)
                                                            <td>
                                                                {{ $total_normalisasi[$j][] = floatval($total_perbandingan[$j][$loop->iteration - 1]/array_sum($total_perbandingan[$j])) }}
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <th class="table-success"> Total </th>
                                                    @for ($i = 1; $i <= count($total_normalisasi); $i++)
                                                        <td class="table-success">
                                                            {{ floatval(array_sum($total_normalisasi[$i])) }}
                                                        </td>
                                                    @endfor
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    @php
                                                        for ($i=0; $i < count($total_normalisasi); $i++) {
                                                            for ($j=1; $j <= count($total_normalisasi); $j++) {
                                                                $tampung_bobot_parsial[$i][] = $total_normalisasi[$j][$i];
                                                            }
                                                        }
                                                    @endphp

                                                    <th class="table-secondary" style="width: 20%"> Bobot Parsial </th>
                                                    @for ($i = 0; $i < count($total_normalisasi); $i++)
                                                        <td>
                                                            {{-- {{ $total_eigen[] = number_format(pow(array_product($total_normalisasi[$i]), 1/count($total_normalisasi)),4)  }} --}}
                                                            {{ $bobot_parsial[] = floatval(array_sum($tampung_bobot_parsial[$i]) / count($kriteria)) }}
                                                        </td>
                                                    @endfor
                                                    <td class="table-success"> Jumlah:
                                                        {{ floatval(array_sum($bobot_parsial)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    @php
                                                        for ($i=0; $i < count($bobot_parsial); $i++) {
                                                            for ($j=1; $j <=count($total_perbandingan); $j++) {
                                                                $tampung_eigen_verktor[$i][] = $total_perbandingan[$j][$i] * $bobot_parsial[$j-1];
                                                            }
                                                        }
                                                    @endphp

                                                    <th class="table-secondary">Eigen Vektor</th>
                                                    @for ($i=0; $i < count($tampung_eigen_verktor); $i++)
                                                        <td> {{ $eigen_vektor[] = floatval(array_sum($tampung_eigen_verktor[$i])) }} </td>
                                                    @endfor
                                                    <td class="table-success"> Jumlah:
                                                        {{ floatval(array_sum($eigen_vektor)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="table-secondary">Ternormalisasi Terbobot</th>
                                                    @for ($i = 0; $i < count($kriteria); $i++)
                                                        <td> {{ $ternormalisasi_terbobot[] = floatval($eigen_vektor[$i] / $bobot_parsial[$i])}}
                                                        </td>
                                                    @endfor
                                                    <td class="table-success"> Jumlah:
                                                        {{ floatval(array_sum($ternormalisasi_terbobot)) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Eigen Max --}}
                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        Eigen Max
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if (!isset($ternormalisasi_terbobot) or count($ternormalisasi_terbobot) < 1)
                                        <p class="alert alert-warning m-0">Tidak ada nilai bobot ternormalisasi.</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>

                                                <tr>
                                                    <th class="table-secondary" style="width: 20%">Eigen Max</th>
                                                    <td>
                                                        {{ $eigen_maximum = floatval(array_sum($ternormalisasi_terbobot) / count($kriteria)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="table-secondary" style="width: 20%">CI</th>
                                                    <td>
                                                        {{ $ci = floatval(($eigen_maximum - count($kriteria)) / (count($kriteria) - 1)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="table-secondary" style="width: 20%">CI < 0.1</th>
                                                    @php
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
                                                    @endphp

                                                    <td>
                                                        {{ $cr = floatval($ci/$ri) }}

                                                        @if ($cr < 0.1)
                                                            <span class="text-success"> - Konsisten </span>
                                                        @else
                                                            <span class="text-danger"> - Tidak Konsisten </span>
                                                        @endif

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @else
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail nilai dari jurusan {{ $pilih_jurusan->jurusan }}</h6>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionExample">

                        {{-- detail proses sebelumnya --}}
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Proses Sebelumnya
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                @if (count($input_terakhir) == 0)
                                    <div class="card-body">
                                        <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                    </div>
                                @else
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <th>Perbandingan Kriteria</th>
                                                <th>Tingkat Kepentingan</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($input_terakhir as $item)
                                                    <tr>
                                                        <td>{{ $item->prioritas }}</td>
                                                        <td>{{ number_format($item->nilai,2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- detail keterkaitan kriteria --}}
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">
                                        Keterkaitan Kriteria
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                @if ($cek_update_kriteria_di_keterkaitan === 'gagal' or count($keterkaitan_kriteria) < 1)
                                <div class="card-body">
                                <p class="alert alert-warning m-0">Keterkaitan kriteria belum diisi oleh admin</p>
                                </div>
                                @else
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <th>Kriteria</th>
                                                <th>Status</th>
                                                <th>Kriteria</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($keterkaitan_kriteria as $item)
                                                <tr>
                                                    <td>{{ $item->kriteria_x }}</td>
                                                    <td>
                                                        @if($item->terkait === 0)
                                                            <span class="badge badge-danger">Tidak terkait</span>
                                                        @else
                                                            <span class="badge badge-success">Terkait</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->kriteria_y }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- @php
                            for($i = 0; $i < count($input_terakhir); $i++){
                                $data[] = $input_terakhir[$i]->nilai;
                            }
                        @endphp

                        {{dd($data)}} --}}

                        {{-- detail nilai perbandingan --}}
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        Nilai Perbandingan
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if ($cek_update_kriteria_di_xykriteria === 'gagal' or count($input_terakhir) < 1)
                                        <p class="alert alert-warning m-0">Kriteria baru ditambahkan oleh admin, segera lakukan penilaian ulang.</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody class="text-center">
                                                <tr>
                                                    <th></th>
                                                    @foreach ($kriteria as $mapel)
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                    @endforeach
                                                </tr>

                                                @php
                                                $nilai1 = 1.0;
                                                $index1 = 0;
                                                $index2 = 0;

                                                if (count($kriteria) == 5) {
                                                    // khusus 5 kriteria
                                                    $array = array(0,1,4,2,5,7,3,6,8,9);
                                                } else if (count($kriteria) == 6) {
                                                    // khusus 6 kriteria
                                                    $array = array(0,1,5,2,6,9,3,7,10,12,4,8,11,13,14);
                                                } else if (count($kriteria) == 7) {
                                                    // khusus 7 kriteria
                                                    $array = array(0,1,6,2,7,11,3,8,12,15,4,9,13,16,18,5,10,14,17,19,20);
                                                }

                                                @endphp
                                                {{-- {{ dd($input_terakhir[$array[7]]) }} --}}
                                                {{-- {{dd($input_terakhir[7])}} --}}

                                                @foreach ($kriteria as $mapel)
                                                    <tr>
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                        @for ($i = 1; $i <= count($kriteria); $i++)

                                                            <td>
                                                                @if ($loop->iteration === $i)
                                                                {{ $total_perbandingan[$i][] = floatval($nilai1) }}
                                                                @elseif ($loop->iteration > $i)
                                                                {{ $total_perbandingan[$i][] = floatval(1/$input_terakhir[$array[$index1]]['nilai']) }}
                                                                @php $index1++; @endphp
                                                                @elseif ($loop->iteration < $i && $i)
                                                                {{ $total_perbandingan[$i][] = floatval($input_terakhir[$index2]['nilai']) }}
                                                                @php $index2++; @endphp
                                                                @endif
                                                            </td>
                                                        @endfor

                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th class="table-success">
                                                        Total
                                                    </th>
                                                    @for ($i = 1; $i <= count($total_perbandingan); $i++)
                                                        <td class="table-success"> {{ floatval(array_sum($total_perbandingan[$i])) }}</td>
                                                    @endfor
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- {{dd($total_perbandingan)}} --}}

                        {{-- detail normalisasi --}}
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Normalisasi
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if (!isset($total_perbandingan) or count($total_perbandingan) < 1)
                                        <p class="alert alert-warning m-0">Tidak ada nilai yang diinputkan.</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    @foreach ($kriteria as $mapel)
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                    @endforeach
                                                </tr>

                                                @foreach ($kriteria as $mapel)
                                                    <tr>
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                        @for ($j = 1; $j <= count($total_perbandingan); $j++)
                                                            <td>
                                                                {{ $total_normalisasi[$j][] = floatval($total_perbandingan[$j][$loop->iteration - 1]/array_sum($total_perbandingan[$j])) }}
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <th class="table-success"> Total </th>
                                                    @for ($i = 1; $i <= count($total_normalisasi); $i++)
                                                        <td class="table-success">
                                                            {{ floatval(array_sum($total_normalisasi[$i])) }}
                                                        </td>
                                                    @endfor
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    @php
                                                        for ($i=0; $i < count($total_normalisasi); $i++) {
                                                            for ($j=1; $j <= count($total_normalisasi); $j++) {
                                                                $tampung_bobot_parsial[$i][] = $total_normalisasi[$j][$i];
                                                            }
                                                        }
                                                    @endphp

                                                    <th class="table-secondary" style="width: 20%"> Bobot Parsial </th>
                                                    @for ($i = 0; $i < count($total_normalisasi); $i++)
                                                        <td>
                                                            {{-- {{ $total_eigen[] = number_format(pow(array_product($total_normalisasi[$i]), 1/count($total_normalisasi)),4)  }} --}}
                                                            {{ $bobot_parsial[] = floatval(array_sum($tampung_bobot_parsial[$i]) / count($kriteria)) }}
                                                        </td>
                                                    @endfor
                                                    <td class="table-success"> Jumlah:
                                                        {{ floatval(array_sum($bobot_parsial)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    @php
                                                        for ($i=0; $i < count($bobot_parsial); $i++) {
                                                            for ($j=1; $j <=count($total_perbandingan); $j++) {
                                                                $tampung_eigen_verktor[$i][] = $total_perbandingan[$j][$i] * $bobot_parsial[$j-1];
                                                            }
                                                        }
                                                    @endphp

                                                    <th class="table-secondary">Eigen Vektor</th>
                                                    @for ($i=0; $i < count($tampung_eigen_verktor); $i++)
                                                        <td> {{ $eigen_vektor[] = floatval(array_sum($tampung_eigen_verktor[$i])) }} </td>
                                                    @endfor
                                                    <td class="table-success"> Jumlah:
                                                        {{ floatval(array_sum($eigen_vektor)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="table-secondary">Ternormalisasi Terbobot</th>
                                                    @for ($i = 0; $i < count($kriteria); $i++)
                                                        <td> {{ $ternormalisasi_terbobot[] = floatval($eigen_vektor[$i] / $bobot_parsial[$i])}}
                                                        </td>
                                                    @endfor
                                                    <td class="table-success"> Jumlah:
                                                        {{ floatval(array_sum($ternormalisasi_terbobot)) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- {{dd($total_normalisasi)}} --}}

                        {{-- Eigen Max --}}
                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        Eigen Max
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if (!isset($ternormalisasi_terbobot) or count($ternormalisasi_terbobot) < 1)
                                        <p class="alert alert-warning m-0">Tidak ada nilai bobot ternormalisasi.</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>

                                                <tr>
                                                    <th class="table-secondary" style="width: 20%">Eigen Max</th>
                                                    <td>
                                                        {{ $eigen_maximum = floatval(array_sum($ternormalisasi_terbobot) / count($kriteria)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="table-secondary" style="width: 20%">CI</th>
                                                    <td>
                                                        {{ $ci = floatval(($eigen_maximum - count($kriteria)) / (count($kriteria) - 1)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="table-secondary" style="width: 20%">CI < 0.1</th>
                                                    @php
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
                                                    @endphp

                                                    <td>
                                                        {{ $cr = floatval($ci/$ri) }}

                                                        @if ($cr < 0.1)
                                                            <span class="text-success"> - Konsisten </span>
                                                        @else
                                                            <span class="text-danger"> - Tidak Konsisten </span>
                                                        @endif

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- {{dd($eigen_maximum)}} --}}


                        {{-- Unweight --}}
                        <div class="card">
                            <div class="card-header" id="headingSix">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        Unweight
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if (!isset($eigen_vektor) or count($eigen_vektor) < 1) <p
                                        class="alert alert-warning m-0">Tidak ada nilai eigen pada normalisasi.</p>
                                        @else
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th class="table-primary">Kriteria</th>
                                                    @foreach ($kriteria as $mapel)
                                                    <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                    @endforeach
                                                </thead>
                                                <tbody>
                                                    @foreach ($kriteria as $mapel)
                                                    <tr>
                                                        <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                        @for($i = 0; $i < count($eigen_vektor); $i++)
                                                            <td>
                                                                {{ $unweight[] = floatval($eigen_vektor[$loop->iteration - 1] * $eigen_vektor[$i]) }}
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- {{dd($unweight)}} --}}

                        {{-- Weight --}}
                        <div class="card">
                            <div class="card-header" id="headingSeven">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven"
                                        aria-expanded="false" aria-controls="collapseSeven">
                                        Weight
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if (!isset($eigen_maximum) or count($keterkaitan_kriteria) < 1)
                                        <p class="alert alert-warning m-0">Tidak ada nilai unweight / keterkaitan kriteria belum diisi oleh admin</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        @php
                                            $weight = [];
                                            $index1 = 0;
                                            $index2 = 0;
                                            $index3 = 0;
                                            $index4 = 0;

                                            // dd(count($kriteria) == 7);

                                            if (count($kriteria) == 5) {
                                               // khusus 5 kriteria
                                                $array = array(1,2,7,3,8,13,4,9,14,19);
                                            } elseif (count($kriteria) == 6) {
                                                // khusus 6 kriteria
                                                $array = array(1,2,8,3,9,15,4,10,16,22,5,11,17,23,29);
                                            } elseif (count($kriteria) == 7) {
                                               // khusus 7 kriteria
                                                $array = array(1,2,9,3,10,17,4,11,18,25,5,12,19,26,33,6,13,20,27,34,41);
                                            }

                                            // dd($array);

                                        @endphp
                                        {{-- model
                                        [loop-iteration][index1] dan [index2]
                                        [1][0] dan [0]
                                        [2][0] dan [1]
                                        [3][0] dan [2]

                                        [1][1] dan [3]
                                        [2][1] dan [4]
                                        [3][1] dan [5]

                                        index3 untuk mencari keterkaitan kriteria bagian 'kiri'
                                        index4 untuk mencari keterkaitan kriteria bagian 'kanan'
                                        --}}
                                        <thead>
                                            <th class="table-primary">Kriteria</th>
                                            @foreach ($kriteria as $mapel)
                                                <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                            @foreach ($kriteria as $mapel)
                                            <tr>
                                                <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                @for($i = 1; $i <= count($kriteria); $i++)
                                                    <td>
                                                        @if($loop->iteration === $i)
                                                            {{ $weight[] = floatval($total_perbandingan[$i][$index1] * $unweight[$index2]) }}
                                                            @php $index2++; @endphp

                                                        {{-- kiri --}}
                                                        @elseif ($loop->iteration > $i)
                                                            @if ($weight[$array[$index3]] == 0)
                                                                {{ $weight[] = floatval(0) }}
                                                                @php $index2++; $index3++; @endphp
                                                            @else
                                                                {{ $weight[] = floatval($total_perbandingan[$i][$index1] * $unweight[$index2]) }}
                                                                @php $index2++; $index3++; @endphp
                                                            @endif

                                                        {{-- kanan --}}
                                                        @elseif ($loop->iteration < $i && $i)
                                                            @if ($keterkaitan_kriteria[$index4]->terkait == 0)
                                                                {{ $weight[] = floatval(0) }}
                                                                @php $index2++; $index4++; @endphp

                                                            @else
                                                                {{ $weight[] = floatval($total_perbandingan[$i][$index1] * $unweight[$index2]) }}
                                                                @php $index2++; $index4++; @endphp
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endfor
                                                @php $index1++; @endphp


                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- {{dd($weight)}} --}}

                        {{-- limit --}}
                        <div class="card">
                            <div class="card-header" id="headingEight">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseEight"
                                        aria-expanded="false" aria-controls="collapseEight">
                                        Limit
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if (!isset($weight) or count($weight) < 1)
                                        <p class="alert alert-warning m-0">Tidak ada nilai weight.</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">

                                        @php
                                            $limit = [];
                                            $index1 = 0;
                                            $index2 = 0;
                                            $index3 = 0;

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

                                            for ($i=1; $i <= count($limit); $i++) {
                                                for ($j=0; $j < count($limit); $j++) {
                                                    if ($limit[$i][$j] == INF){
                                                        $new_limit[$i][$j] = 0;
                                                    } else {
                                                        $new_limit[$i][$j] = $limit[$i][$j];
                                                    }
                                                }
                                            }
                                        @endphp

                                        {{-- {{dd($new_limit)}} --}}

                                        @php
                                            $a = 0;
                                            $b = 0;
                                            $c = 0;
                                        @endphp

                                        <thead>
                                            <th class="table-primary">Kriteria</th>
                                            @foreach ($kriteria as $mapel)
                                                <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                            @foreach ($kriteria as $mapel)
                                            <tr>
                                                <th class="table-secondary">{{ $mapel->kriteria }}</th>

                                                @for($i = 1; $i <= count($kriteria); $i++)
                                                    <td>


                                                        @if($loop->iteration === $i)
                                                            @if (floatval(pow($weight[$a], $weight[$a])) == INF)
                                                                {{ 0 }}
                                                            @else
                                                                {{floatval(pow($weight[$a], $weight[$a]))}}
                                                            @endif
                                                            @php $a++; @endphp
                                                        @elseif ($loop->iteration > $i)
                                                            @if (floatval(pow($weight[$a], $weight[$a])) == INF)
                                                                {{ 0 }}
                                                            @else
                                                                {{floatval(pow($weight[$a], $weight[$a]))}}
                                                            @endif
                                                            @php $a++; $b++; @endphp
                                                        @elseif ($loop->iteration < $i && $i)
                                                            @if (floatval(pow($weight[$a], $weight[$a])) == INF)
                                                                {{ 0 }}
                                                            @else
                                                                {{floatval(pow($weight[$a], $weight[$a]))}}
                                                            @endif
                                                            @php $a++; $c++; @endphp
                                                        @endif
                                                    </td>
                                                @endfor

                                            </tr>
                                            @endforeach

                                            <tr>
                                                <th class="table-success">Total</th>
                                                @for($j=1; $j <= count($new_limit); $j++)
                                                    <td class="table-success">
                                                        {{ $total_limit[] = floatval(array_sum($new_limit[$j])) }} </td>
                                                @endfor
                                            </tr>

                                        </tbody>
                                    </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- {{dd($total_limit)}} --}}

                        {{-- Normalisasi Limit --}}
                        <div class="card">
                            <div class="card-header" id="headingNine">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseNineNine" aria-expanded="false" aria-controls="collapseNineNine">
                                    Normalisasi Limit
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseNineNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if (!isset($new_limit) or count($new_limit) < 1)
                                        <p class="alert alert-warning m-0">Tidak ada nilai limit.</p>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        @php
                                            $normalisasi_limit = [];
                                            $index1 = 0;
                                            $index2 = 0;
                                            $index3 = 0;
                                        @endphp
                                        <thead>
                                            <th class="table-primary">Kriteria</th>
                                            @foreach ($kriteria as $mapel)
                                                <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                            {{-- {{dd($limit[1][0]/$total_limit[0])}} --}}
                                            {{-- {{dd($limit)}} --}}
                                            @foreach ($kriteria as $mapel)
                                            <tr>
                                                <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                @for($i = 1; $i <= count($new_limit); $i++)
                                                    <td>
                                                        {{ $normalisasi_limit[$i][] = floatval($new_limit[$i][$loop->iteration - 1] / $total_limit[$i - 1]) }}
                                                    </td>
                                                @endfor
                                            </tr>
                                            @endforeach

                                            <tr>
                                                <th class="table-success">Total</th>
                                                @for($j=1; $j <= count($normalisasi_limit); $j++)
                                                    <td class="table-success">
                                                        {{ $total_normalisasi_limit[] = floatval(array_sum($normalisasi_limit[$j])) }}
                                                    </td>
                                                @endfor
                                            </tr>

                                        </tbody>
                                    </table>

                                    {{-- {{dd($normalisasi_limit, $total_normalisasi_limit)}} --}}

                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th></th>
                                                @foreach ($kriteria as $mapel)
                                                    <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th class="table-secondary">Bobot RAW</th>
                                                @for($i=1; $i <= count($kriteria); $i++)
                                                    <td> {{ $bobot_raw[] = floatval(array_product($normalisasi_limit[$i])/(1/count($total_normalisasi_limit))) }}
                                                    </td>
                                                @endfor

                                                <td class="font-weight-bold table-success"> Total : {{ floatval(array_sum($bobot_raw)) }} </td>
                                            </tr>

                                            {{-- {{dd($bobot_raw)}} --}}

                                            <tr>
                                                <th class="table-secondary">Bobot Normal</th>
                                                <form action="/examiner/kriteria/bobot_normal" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $pilih_jurusan->id }}" name="jurusan_id">
                                                    @for($i=0; $i < count($bobot_raw); $i++)
                                                    <input type="hidden" name="loop" value="{{$i+1}}">
                                                        <td>
                                                            <input type="hidden" value="{{ $kriteria[$i]->id }}" name="kriteria_id_{{$i}}">
                                                            <input type="hidden"
                                                                value="{{ floatval($bobot_raw[$i]/floatval(array_sum($bobot_raw))) }}"
                                                                name="bobot_normal_{{$i}}">
                                                            {{ $bobot_normal[] = floatval($bobot_raw[$i]) / floatval(array_sum($bobot_raw)) }}
                                                        </td>
                                                    @endfor

                                                    <td class="font-weight-bold table-success"> Total:
                                                        {{ floatval(array_sum($bobot_normal)) }} | (Max:
                                                        {{ floatval(max($bobot_normal)) }})
                                                        {{-- <button type="submit" class="btn btn-primary btn-sm mx-2">Simpan Bobot Normal</button> --}}
                                                    </td>
                                                </form>
                                            </tr>

                                            {{-- {{dd($bobot_normal)}} --}}

                                            <tr>
                                                <th class="table-secondary">Bobot Ideal</th>
                                                @for($i=0; $i < count($bobot_normal); $i++)
                                                    <td> {{ $bobot_ideal[] = floatval($bobot_normal[$i]/max($bobot_normal)) }}
                                                    </td>
                                                @endfor
                                                <td class="font-weight-bold table-success"> Total: {{ floatval(array_sum($bobot_ideal)) }} </td>
                                            </tr>

                                            {{-- {{dd(floatval(array_sum($bobot_ideal)))}} --}}
                                        </tbody>
                                    </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endif

    @endif
</div>


@endsection
