@extends('layouts.admin')

@section('title', 'Menu Rankin')

@section('content')

{{-- {{dd($peserta[0]->created_at)}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    @if (session('massage'))
    <div class="alert alert-success col-6">
        {{ session('massage') }}
    </div>
    @endif

        {{-- penguji --}}
        <div class="col-md-12 col-sm-12 mb-4 px-0">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 mx-3">Pilih Penguji:
                            </div>
                            <form action="/admin/ranking" method="POST">
                                @csrf
                                {{-- @method('put') --}}
                                <div class="dropdown row px-2">
                                    <select class="form-control col mx-3" name="penguji">
                                        <option>Pilih penguji</option>
                                        @foreach ($penguji as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control col mx-3" name="jurusan">
                                        <option>Pilih jurusan</option>

                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->id }}">{{ $item->jurusan }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control col mx-3" name="tahun">
                                        <option>Pilih tahun</option>
                                        @foreach ($tahun as $item)
                                            <option value="{{ $item->tahun }}">{{ $item->tahun }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm mx-3 col">Lihat</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @if ($isSuccess == false)
        <div class="alert alert-primary col-xl-3 col-md-12 col-sm-12">
            Isi data terlebih dahulu
        </div>
    @else
        {{-- {{$jumlah_peserta}} --}}
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Ranking</h6>
            </div>

            {{-- {{dd($ranking[0]["skor"])}} --}}

            <div class="card-body">
                <ul class="list-group">
                    @for ($i = 0; $i < count($ranking); $i++)
                        <li class="list-group-item">{{$i + 1}}  # <strong>{{ $ranking[$i]['nama_siswa'] }}</strong> dengan skor <strong> {{ $ranking[$i]['skor'] }} </strong></li>
                    @endfor
                </ul>
            </div>
        </div>


        {{-- {{dd($normalisasi_matriks_keputusan)}} --}}
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Perankingan</h6>
            </div>
            <div class="card-body">
                <div class="accordion" id="accordionExample">

                    {{-- Nilai --}}
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    Nilai
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            {{-- @if (count($input_terakhir) == 0)
                                <div class="card-body">
                                    <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                </div>
                            @else --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <th>Alternatif</th>
                                            @for ($i = 0; $i < count($kriteria); $i++)
                                                <th> {{$kriteria[$i]->kriteria}} </th>
                                            @endfor
                                        </thead>
                                        {{-- {{dd(count($nilai_peserta))}} --}}
                                        <tbody>
                                            @php $no = 0; @endphp
                                            @for ($i = 0; $i < $jumlah_peserta; $i++)
                                            <tr>
                                                <td> {{$peserta[$no]->nama_siswa}} </td>
                                                @for ($j = 0; $j < count($kriteria); $j++)
                                                    <td>  {{$nilai_peserta[$i][$j]->nilai}} </td>
                                                @endfor
                                            </tr>
                                            @php $no++; @endphp
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>


                    {{-- Langkah 1 Normalisasi Matrik Keputusan --}}
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="true" aria-controls="collapseTwo">
                                    Normalisasi Matrik Keputusan
                                </button>
                            </h2>
                        </div>

                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            {{-- @if (count($input_terakhir) == 0)
                                <div class="card-body">
                                    <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                </div>
                            @else --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <th>Alternatif</th>
                                            @for ($i = 0; $i < count($kriteria); $i++)
                                                <th> {{$kriteria[$i]->kriteria}} </th>
                                            @endfor
                                        </thead>
                                        <tbody>
                                            @php $no = 0; @endphp
                                            @for ($i = 0; $i < count($normalisasi_matriks_keputusan); $i++)
                                            <tr>
                                                <td> {{$peserta[$no]->nama_siswa}} </td>
                                                @for ($j = 0; $j < count($kriteria); $j++)
                                                    <td>  {{$normalisasi_matriks_keputusan[$i][$j]}} </td>
                                                @endfor
                                            </tr>
                                            @php $no++; @endphp
                                            @endfor
                                            <tr>
                                                <td>Rata-rata</td>
                                                @for ($i = 0; $i < count($rata_rata); $i++)
                                                    <td> {{$rata_rata[$i]}} </td>
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>

                    {{-- Langkah 2 Pembobotan Pada Matriks Yang Telah Dinormalisasi --}}
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseThree"
                                    aria-expanded="true" aria-controls="collapseThree">
                                    Pembobotan Pada Matriks Yang Telah Dinormalisasi
                                </button>
                            </h2>
                        </div>

                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            {{-- @if (count($input_terakhir) == 0)
                                <div class="card-body">
                                    <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                </div>
                            @else --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Bobot Normal</th>
                                                @for ($i = 0; $i < count($bobot_normal); $i++)
                                                    <td> {{$bobot_normal[$i]->bobot}} </td>
                                                @endfor
                                            </tr>

                                            <tr>
                                                <th>Alternatif</th>
                                                @for ($i = 0; $i < count($kriteria); $i++)
                                                    <th> {{$kriteria[$i]->kriteria}} </th>
                                                @endfor
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @php $no = 0; @endphp
                                            @for ($i = 0; $i < count($normalisasi_matriks_keputusan); $i++)
                                            <tr>
                                                <td> {{$peserta[$no]->nama_siswa}} </td>
                                                @for ($j = 0; $j < count($kriteria); $j++)
                                                    <td>  {{$normalisasi_matriks_keputusan[$i][$j]}} </td>
                                                @endfor
                                            </tr>
                                            @php $no++; @endphp
                                            @endfor
                                            <tr>
                                                <td>Rata-rata</td>
                                                @for ($i = 0; $i < count($rata_rata); $i++)
                                                    <td> {{$rata_rata[$i]}} </td>
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>

                    {{-- Langkah 3 Menentukan Himpunan Concordance dan Discordance pada Index --}}
                    {{-- dan Langkah 4 Menghitung Matrik Concordance dan Discordance --}}

                    {{-- Concordance --}}
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseThree"
                                    aria-expanded="true" aria-controls="collapseThree">
                                    Matrik Concordance
                                </button>
                            </h2>
                        </div>

                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            {{-- @if (count($input_terakhir) == 0)
                                <div class="card-body">
                                    <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                </div>
                            @else --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                @php
                                                    $cek = 0;
                                                @endphp
                                                @for ($i = 0; $i < count($concordance); $i++)

                                                    @if ($concordance[$i] === null)
                                                        <td style="background-color: orange"> 0 </td>
                                                        @php $cek++; @endphp
                                                    @elseif ($cek == $jumlah_peserta - 1)
                                                        <td> {{$concordance[$i]}} </td>
                                                        <tr></tr>
                                                        @php $cek = 0; @endphp
                                                    @else
                                                        <td> {{$concordance[$i]}} </td>
                                                        @php $cek++; @endphp
                                                    @endif
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>

                    {{-- Discordance --}}
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFour"
                                    aria-expanded="true" aria-controls="collapseFour">
                                    Matrik Discordance
                                </button>
                            </h2>
                        </div>

                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                            {{-- @if (count($input_terakhir) == 0)
                                <div class="card-body">
                                    <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                </div>
                            @else --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                @php
                                                    $cek = 0;
                                                @endphp
                                                @for ($i = 0; $i < count($gabung_discordance); $i++)
                                                    @if ($gabung_discordance[$i] === null)
                                                        <td style="background-color: orange"> 0 </td>
                                                        @php $cek++; @endphp
                                                    @elseif ($cek == $jumlah_peserta - 1)
                                                        <td> {{$gabung_discordance[$i]}} </td>
                                                        <tr></tr>
                                                        @php $cek = 0; @endphp
                                                    @else
                                                        <td> {{$gabung_discordance[$i]}} </td>
                                                        @php $cek++; @endphp
                                                    @endif
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>

                    {{-- Langkah 5 Menghitung Matriks Dominan Concordance dan Discordance --}}

                    {{-- Matrik Dominan Concordance --}}
                    <div class="card">
                        <div class="card-header" id="headingFive">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFive"
                                    aria-expanded="true" aria-controls="collapseFive">
                                    Matrik Domain Concordance
                                </button>
                            </h2>
                        </div>

                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                            {{-- @if (count($input_terakhir) == 0)
                                <div class="card-body">
                                    <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                </div>
                            @else --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <p>Nilai C: {{$nilai_c}}</p>
                                            <tr>
                                                @php
                                                    $cek = 0;
                                                @endphp
                                                @for ($i = 0; $i < count($matriks_domain_concordance); $i++)

                                                    @if ($matriks_domain_concordance[$i] === null)
                                                        <td style="background-color: orange"> 0</td>
                                                        @php $cek++; @endphp
                                                    @elseif ($cek == $jumlah_peserta - 1)
                                                        <td> {{$matriks_domain_concordance[$i]}} </td>
                                                        <tr></tr>
                                                        @php $cek = 0; @endphp
                                                    @else
                                                        <td> {{$matriks_domain_concordance[$i]}} </td>
                                                        @php $cek++; @endphp
                                                    @endif
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>

                    {{-- Matrik Dominan Discordance --}}
                    <div class="card">
                        <div class="card-header" id="headingSix">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseSix"
                                    aria-expanded="true" aria-controls="collapseSix">
                                    Matrik Domain Discordance
                                </button>
                            </h2>
                        </div>

                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                            {{-- @if (count($input_terakhir) == 0)
                                <div class="card-body">
                                    <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                </div>
                            @else --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <p>Nilai D: {{$nilai_d}}</p>
                                            <tr>
                                                @php
                                                    $cek = 0;
                                                @endphp
                                                @for ($i = 0; $i < count($matriks_domain_discordance); $i++)

                                                    @if ($matriks_domain_discordance[$i] === null)
                                                        <td style="background-color: orange"> 0 </td>
                                                        @php $cek++; @endphp
                                                    @elseif ($cek == $jumlah_peserta - 1)
                                                        <td> {{$matriks_domain_discordance[$i]}} </td>
                                                        <tr></tr>
                                                        @php $cek = 0; @endphp
                                                    @else
                                                        <td> {{$matriks_domain_discordance[$i]}} </td>
                                                        @php $cek++; @endphp
                                                    @endif
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>


                    {{-- Langkah 6 Menetukan Agregate Dominance Matrix --}}
                    <div class="card">
                        <div class="card-header" id="headingSeven">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseSeven"
                                    aria-expanded="true" aria-controls="collapseSeven">
                                    Agregate Dominance Matrix
                                </button>
                            </h2>
                        </div>

                        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                            {{-- @if (count($input_terakhir) == 0)
                                <div class="card-body">
                                    <p class="alert alert-warning m-0">Tidak ada input sebelumnya</p>
                                </div>
                            @else --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            {{-- {{dd($agregate_view)}} --}}
                                            <tr>
                                                @php
                                                    $cek = 0;
                                                @endphp
                                                @for ($i = 0; $i < count($agregate_view); $i++)
                                                    @if ($cek == $jumlah_peserta - 1)
                                                        @if ($agregate_view[$i] == 0 or $agregate_view[$i] == null)
                                                            <td> 0 </td>
                                                        @else
                                                            <td> {{$agregate_view[$i]}} </td>
                                                        @endif
                                                        <tr></tr>
                                                        @php $cek = 0; @endphp
                                                    @elseif ($agregate_view[$i] == 0 or $agregate_view[$i] == null)
                                                        <td> 0 </td>
                                                        @php $cek++; @endphp
                                                    @else
                                                        <td> {{$agregate_view[$i]}} </td>
                                                        @php $cek++; @endphp
                                                    @endif
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>



                </div>
        </div>
    @endif

</div>
<!-- /.container-fluid -->
@endsection
