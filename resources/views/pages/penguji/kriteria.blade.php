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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kriteria</h6>
        </div>

        {{-- nilai bobot kriteria --}}
        <div class="card-body">
            <form action="/examiner/kriteria/" method="POST">
                @csrf
                @if (count($gabungan) < 0) 
                    <p class="alert alert-warning m-0">Tidak ada kriteria</p>
                @else
                <table class="table table-bordered" style="text-align:center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Kriteria Prioritas</th>
                            <th scope="col">Equal</th>
                            <th scope="col">Tingkat Kepentingan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < count($gabungan); $i++)
                        <input type="hidden" name="loop" value="{{$i+1}}">
                        <tr>
                            <td>
                                <table class="table table-bordered" style="text-align:center">
                                    <thead class="thead-light">
                                    <th style="width: 50%"> <input type="hidden" name="id_x_{{$i}}" value="{{ $gabungan[$i]['satu']['id'] }}">  {{ $gabungan[$i]['satu']['nama'] }}</th>
                                    <th style="width: 50%"> <input type="hidden" name="id_y_{{$i}}" value="{{ $gabungan[$i]['dua']['id'] }}"> {{ $gabungan[$i]['dua']['nama'] }}</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td><input type="radio" name="prioritas_{{$i}}" value="{{$gabungan[$i]['satu']['nama']}}_>_{{$gabungan[$i]['dua']['nama']}}" checked></td>
                                        <td><input type="radio" name="prioritas_{{$i}}" value="{{$gabungan[$i]['dua']['nama']}}_>_{{$gabungan[$i]['satu']['nama']}}"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>

                            <td>
                                <table class="table table-bordered" style="text-align:center">
                                    <thead class="thead-light">
                                        <th>1</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td><input type="radio" name="kepentingan_{{$i}}" value="1" checked></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>

                            <td>
                                <table class="table table-bordered" style="text-align:center">
                                    <thead class="thead-light">
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>7</th>
                                        <th>8</th>
                                        <th>9</th>
                                    </thead>
                                    <tbody class="center">
                                        <tr>
                                            @for ($j = 1; $j <= 8; $j++)
                                        <td><input type="radio" name="kepentingan_{{$i}}" value="{{$j+1}}"></td>
                                            @endfor
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary" style="float:right">Simpan</button>
                @endif
            </form>
        </div>

    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
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
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <th>Perbandingan Kriteria</th>
                                    <th>Tingkat Kepentingan</th>
                                </thead>
                                <tbody>
                                    @foreach ($input_terakhir as $item)
                                        <tr>
                                            <td>{{ $item->prioritas }}</td>
                                            <td>{{ $item->nilai }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        @if ($cek_update_kriteria_di_keterkaitan === 'gagal' or count($keterkaitan_kriteria) < 0)
                        <div class="card-body">
                           <p class="alert alert-warning m-0">Keterkaitan kriteria belum diisi oleh admin</p>
                        </div>
                        @else
                        <div class="card-body">
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
                            @if ($cek_update_kriteria_di_xykriteria === 'gagal')
                            <p class="alert alert-warning m-0">kriteria baru ditambahkan oleh admin, segera lakukan penilaian ulang.</p>
                            @else
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th></th>
                                        @foreach ($kriteria as $mapel)
                                            <th>{{ $mapel->kriteria }}</th>
                                        @endforeach
                                    </tr>
                                
                                    @php
                                    $index = 0;
                                    @endphp

                                    @foreach ($kriteria as $mapel)
                                        <tr>
                                            <th>{{ $mapel->kriteria }}</th>
                                            @for ($i = 1; $i <= count($kriteria); $i++)
                                                @if($loop->iteration === $i)
                                                    <td style="color:red"> 1 </td>
                                                @elseif($loop->iteration > $i)
                                                    <td style="color:green"> kiri </td>
                                                @elseif($loop->iteration < $i && $i)
                                                    <td> {{$input_terakhir[$index]['nilai']}} </td>                                                    
                                                    @php $index++; @endphp
                                                @endif
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf
                            moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                            Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                            shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea
                            proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim
                            aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</div>
<!-- /.container-fluid -->
@endsection