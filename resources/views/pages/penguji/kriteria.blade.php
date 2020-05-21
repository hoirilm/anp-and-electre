@extends('layouts.penguji')

@section('title', 'Menu Kriteria')

@section('content')

{{-- {{ dd($gabungan) }} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    @if (session('massage'))
    <div class="alert alert-success">
        {{ session('massage') }}
    </div>
    @endif

    @if (session('bobot_normal'))
    <div class="alert alert-success">
        {{ session('bobot_normal') }}
    </div>
    @endif

    <div class="col-xl-3 col-md-6 mb-4 px-0">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pilih Jurusan: </div>
                        <form action="/examiner/kriteria" method="POST">
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kriteria</h6>
        </div>

        <div class="card-body">
            <form action="/examiner/kriteria/" method="POST">
                @csrf
                @for ($i = 0; $i < count($gabungan); $i++)
                <input type="hidden" name="loop" value="{{$i+1}}">
                <input type="hidden" name="jurusan_id" value="{{ $pilih_jurusan->id }}">
                <div class="row m-3">
                    <div class="col text-right">
                        <p> 
                            <input type="hidden" value="{{ $gabungan[$i]['satu']['id'] }}" name="id_x_{{$i}}">
                            <input type="hidden" value="{{ $gabungan[$i]['satu']['nama'] }}" name="kriteria_x_{{$i}}">
                            {{ $gabungan[$i]['satu']['nama'] }} 
                        </p>
                    </div>
                    <div class="col">
                        <select name="kepentingan_{{$i}}" class="form-control">
                            <option value="1">1</option>
                            <option value="0.5">0.5</option>
                            <option value="2">2</option>
                            <option value="0.33">0.33</option>
                            <option value="3">3</option>
                            <option value="0.25">0.25</option>
                            <option value="4">4</option>
                            <option value="0.2">0.2</option>
                            <option value="5">5</option>
                            <option value="0.16">0.16</option>
                            <option value="6">6</option>
                            <option value="0.14">0.14</option>
                            <option value="7">7</option>
                            <option value="0.12">0.12</option>
                            <option value="8">8</option>
                            <option value="0.11">0.11</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col">
                        <p> 
                            <input type="hidden" value="{{ $gabungan[$i]['dua']['id'] }}" name="id_y_{{$i}}">
                            <input type="hidden" value="{{ $gabungan[$i]['dua']['nama'] }}" name="kriteria_y_{{$i}}">
                            {{ $gabungan[$i]['dua']['nama'] }} 
                        </p>
                    </div>
                </div>
                @endfor
                <button type="submit" class="btn btn-primary" style="float:right">Simpan</button>
            </form>
        </div>
    </div>

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
                                        @endphp

                                        @foreach ($kriteria as $mapel)
                                            <tr>
                                                <th class="table-secondary">{{ $mapel->kriteria }}</th>
                                                @for ($i = 1; $i <= count($kriteria); $i++)
                                                    <td> 
                                                        @if ($loop->iteration === $i)
                                                        {{ $total_perbandingan[$i][] = number_format($nilai1,4) }}
                                                        @elseif ($loop->iteration > $i)
                                                        {{ $total_perbandingan[$i][] = number_format(1/$input_terakhir[$index1]['nilai'],4) }}
                                                        @php $index1++; @endphp
                                                        @elseif ($loop->iteration < $i && $i)
                                                        {{ $total_perbandingan[$i][] = number_format($input_terakhir[$index2]['nilai'],4) }}
                                                        @php $index2++; @endphp
                                                        @endif
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endforeach
                                        {{-- {{ dd($total) }} --}}
                                        <tr>
                                            <th class="table-success">
                                                Total
                                            </th>
                                            @for ($i = 1; $i <= count($total_perbandingan); $i++)
                                                <td class="table-success"> {{ number_format(array_sum($total_perbandingan[$i]),4) }}</td>
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
                                                        {{ $total_normalisasi[$j][] = number_format($total_perbandingan[$j][$loop->iteration - 1]/array_sum($total_perbandingan[$j]),4) }}
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th class="table-success"> Total </th>
                                            @for ($i = 1; $i <= count($total_normalisasi); $i++) 
                                                <td class="table-success">
                                                    {{ number_format(array_sum($total_normalisasi[$i]),4) }}
                                                </td>
                                            @endfor
                                        </tr>

                                        <tr>
                                            <th class="table-secondary"> Eigen </th>
                                            @for ($i = 1; $i <= count($total_normalisasi); $i++)
                                                <td>
                                                    {{ $total_eigen[] = number_format(pow(array_product($total_normalisasi[$i]), 1/count($total_normalisasi)),4)  }}
                                                </td>
                                            @endfor
                                            <td class="table-success"> Jumlah: {{ number_format(array_sum($total_eigen),4) }} </td>
                                        </tr>

                                        <tr>
                                            <th class="table-secondary"> Bobot Prioritas </th>
                                            @for ($i = 0; $i < count($total_eigen); $i++) 
                                                <td>
                                                    {{ $bobot_prioritas[] = number_format($total_eigen[$i]/array_sum($total_eigen),4) }}
                                                </td>
                                            @endfor
                                            <td class="table-success"> Jumlah: {{ number_format(array_sum($bobot_prioritas),4) }} </td>
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
                            @if (!isset($total_normalisasi) or count($total_normalisasi) < 1) 
                                <p class="alert alert-warning m-0">Tidak ada nilai bobot prioritas pada normalisasi.</p>
                            @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                <thead>
                                    <th class="table-primary">Kriteria</th>
                                    <th class="table-primary">Bobot Sintesa / Bobot Prioritas</th>
                                </thead>
                                <tbody>

                                    {{-- menghitung eigen max --}}
                                    {{-- {{ dd(array_sum($total_normalisasi[1]) / $bobot_prioritas[0]) }} --}}
                                    @foreach ($kriteria as $mapel)
                                    <tr>
                                        <th class="table-secondary" style="width: 20%">{{ $mapel->kriteria }}</th>
                                        <td>{{ $nilai_eigen_max[] = number_format(array_sum($total_normalisasi[$loop->iteration]) / $bobot_prioritas[$loop->iteration - 1],4) }}
                                        </td>
                                    </tr>
                                    @endforeach
                            
                                    <tr>
                                        <th class="table-success" style="width: 20%"> Total </th>
                                        <td class="table-success">
                                            {{ $total_eigen_max = number_format(array_sum($nilai_eigen_max),4) }}</td>
                                    </tr>
                                </tbody>
                                
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="table-secondary" style="width: 20%"> Eigen Maximum </th>
                                        <td> {{ $eigen_maximum = number_format($total_eigen_max/count($kriteria),4) }} </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" style="width: 20%"> CI </th>
                                        <td> {{ $ci = number_format(($eigen_maximum - count($kriteria)) / (count($kriteria) - 1),4) }} </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" style="width: 20%"> CR </th>
                                        @php
                                            if (count($kriteria) == 1 or count($kriteria) == 2) {
                                                $ri = 0;
                                            } elseif (count($kriteria) == 3) {
                                                $ri = 0.53;
                                            } elseif (count($kriteria) == 4) {
                                                $ri = 0.89;
                                            } elseif (count($kriteria) == 5) {
                                                $ri = 1.11;
                                            } elseif (count($kriteria) == 6) {
                                                $ri = 1.25;
                                            } elseif (count($kriteria) == 7) {
                                                $ri = 1.35;
                                            } elseif (count($kriteria) == 8) {
                                                $ri = 1.4;
                                            } elseif (count($kriteria) == 9) {
                                                $ri = 1.45;
                                            } elseif (count($kriteria0 == 10)) {
                                                $ri = 1.49;
                                            } else {
                                                $ri = null;
                                            }
                                        @endphp
                                        <td> {{ number_format($cr = $ci/$ri,4) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" style="width: 20%"> CR < 0.1</th>
                                        <td> 
                                            @if ($cr < 0.1)
                                                @php
                                                    $nilai_cr = true;    
                                                @endphp
                                                <span class="text-success"> Konsisten </span> 
                                            @else 
                                                @php
                                                    $nilai_cr = false;
                                                @endphp
                                                <span class="text-danger"> Tidak Konsisten </span> 
                                            @endif 
                                        </td>
                                    </tr>
                                </table>
                            </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>




                {{-- Unweight --}}
                <div class="card">
                    <div class="card-header" id="headingSix">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix"
                                aria-expanded="false" aria-controls="collapseSix">
                                Unweight
                            </button>
                        </h2>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                        <div class="card-body">
                            @if (!isset($nilai_eigen_max) or count($nilai_eigen_max) < 1) 
                                <p class="alert alert-warning m-0">Tidak ada nilai eigen pada normalisasi.</p>
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
                                        @for($i = 0; $i < count($total_eigen); $i++)
                                            <td> {{ $unweight[] = number_format($total_eigen[$loop->iteration - 1] * $total_eigen[$i],4) }} </td>
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
                            @if (!isset($nilai_eigen_max) or count($nilai_eigen_max) < 1 or count($keterkaitan_kriteria) < 1) 
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
                                                    {{ $weight[] = number_format($total_perbandingan[$i][$index1] * $unweight[$index2],4) }}
                                                    @php $index2++; @endphp

                                                @elseif ($loop->iteration > $i)
                                                    @if ($keterkaitan_kriteria[$index3]->terkait == 0)
                                                        {{ $weight[] = number_format(0,4) }}
                                                        @php $index2++; $index3++; @endphp
                                                    @else
                                                        {{ $weight[] = number_format($total_perbandingan[$i][$index1] * $unweight[$index2],4) }}
                                                        @php $index2++; $index3++; @endphp
                                                    @endif
                                                    
                                                @elseif ($loop->iteration < $i && $i)
                                                    @if ($keterkaitan_kriteria[$index4]->terkait == 0)
                                                        {{ $weight[] = number_format(0,4) }}
                                                        @php $index2++; $index4++; @endphp

                                                    @else
                                                        {{ $weight[] = number_format($total_perbandingan[$i][$index1] * $unweight[$index2],4) }}
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

                {{-- Limit --}}
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
                                                    {{ $limit[$i][] = number_format(pow($weight[$index1], $weight[$index1]),4)}}
                                                    @php $index1++; @endphp

                                                @elseif ($loop->iteration > $i)
                                                    @if ($keterkaitan_kriteria[$index2]->terkait == 0)
                                                        {{ $limit[$i][] = number_format(1,4) }}
                                                        @php $index1++; $index2++; @endphp
                                                    @else
                                                        {{ $limit[$i][] = number_format(pow($weight[$index1], $weight[$index1]),4)}}
                                                        @php $index1++; $index2++; @endphp
                                                    @endif
                                                    
                                                @elseif ($loop->iteration < $i && $i)
                                                    @if ($keterkaitan_kriteria[$index3]->terkait == 0)
                                                        {{ $limit[$i][] = number_format(1,4) }}
                                                        @php $index1++; $index3++; @endphp

                                                    @else
                                                        {{ $limit[$i][] = number_format(pow($weight[$index1], $weight[$index1]),4)}}
                                                        @php $index1++; $index3++; @endphp
                                                    @endif
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th class="table-success">Total</th>
                                        @for($j=1; $j <= count($limit); $j++)
                                            <td class="table-success"> {{ $total_limit[] = number_format(array_sum($limit[$j]),4) }} </td>
                                        @endfor
                                    </tr>
                                    {{-- {{dd($total_limit)}} --}}
                                </tbody>
                            </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

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
                            @if (!isset($weight) or count($weight) < 1) 
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
                                        @for($i = 1; $i <= count($limit); $i++)
                                            <td>
                                                {{ $normalisasi_limit[$i][] = number_format($limit[$i][$loop->iteration - 1] / $total_limit[$i - 1],4) }}
                                            </td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th class="table-success">Total</th>
                                        @for($j=1; $j <= count($normalisasi_limit); $j++)
                                            <td class="table-success">
                                                {{ $total_normalisasi_limit[] = number_format(array_sum($normalisasi_limit[$j]),4) }}
                                            </td>
                                        @endfor
                                    </tr>
                                </tbody>
                            </table>
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
                                            <td> {{ $bobot_raw[] = number_format(array_product($normalisasi_limit[$i])/(1/count($total_normalisasi_limit)),4) }} </td>
                                        @endfor
                                        <td class="font-weight-bold table-success"> Total : {{ number_format(array_sum($bobot_raw),4) }} </td>
                                    </tr>
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
                                                        value="{{ number_format($bobot_raw[$i]/array_sum($bobot_raw),4) }}"
                                                        name="bobot_normal_{{$i}}">
                                                    {{ $bobot_normal[] = number_format($bobot_raw[$i]/array_sum($bobot_raw),4) }}
                                                </td>
                                            @endfor
                                            <td class="font-weight-bold table-success"> Total:
                                                {{ number_format(array_sum($bobot_normal),4) }} | (Max:
                                                {{ number_format(max($bobot_normal),4) }}) 
                                                <button type="submit" class="btn btn-primary btn-sm mx-2">Simpan Bobot Normal</button>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary">Bobot Ideal</th>
                                        @for($i=0; $i < count($bobot_normal); $i++)
                                            <td> {{ $bobot_ideal[] = number_format($bobot_normal[$i]/max($bobot_normal),4) }}
                                            </td>
                                        @endfor
                                        <td class="font-weight-bold table-success"> Total: {{ number_format(array_sum($bobot_ideal),4) }} </td>
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

        @if ($nilai_cr === true)
            <div class="alert alert-success text-center" role="alert">
                <h4 class="alert-heading"><i class="fas fa-check"></i> Sukses</h4>
                <p>Nilai <strong>CR</strong> kurang dari 0.1 dengan hasil <strong>Konsisten</strong>. Tekan "Update" untuk update data.
                </p>
                <hr>
                <input type="submit" value="Update" class="btn btn-primary">
            </div>
        @elseif($nilai_cr === false)
        <div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Peringatan</h4>
            <p>Nilai <strong>CR</strong> lebih dari 0.1 dengan hasil <strong>Tidak Konsisten</strong>. Disarankan untuk
                mengisi bobot nilai kembali.
            </p>
            <hr>
            <input type="submit" value="Simpan dan lanjutkan" class="btn btn-primary">
        </div>
        @endif
    @endif

</div>
<!-- /.container-fluid -->
@endsection