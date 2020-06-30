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




    @if (!isset($pilih_jurusan))
    <div class="alert alert-primary col-3">
        Pilih jurusan terlebih dahulu.
    </div>
    @else

    <div class="accordion shadow mb-4" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#panduan" aria-expanded="true" aria-controls="panduan">
                        Panduan pengisian nilai
                    </button>
                </h2>
            </div>

            <div id="panduan" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <p>Isilah perbandingan dibawah ini seperti contoh :</p>
                    <ul>
                        <li>Nilai kepentingan antara Bahasa Indonesia dan Bahasa Inggris </li>
                        <img style="width: 100%" src="{{ url("img/kriteria.png") }}" alt="">
                        <li>Lalu pilihlah nilai yang sesuai</li>
                        <img style="width: 30%" src="{{ url("img/opsi.png") }}" alt="">
                        <li>Jika kriteria Bahasa Indonesia Lebih Penting dari Bahasa Inggris maka nilai yang akan diberi ialah :</li>
                        <ul>
                            <li>Bahasa Indonesia (5) Lebih Penting dari Bahasa Inggris</li>
                        </ul>
                        <li>Atau jika Jika kriteria Bahasa Inggris Lebih Penting dari Bahasa Indonesia maka nilai yang akan diberi ialah :</li>
                        <ul>
                            <li>Bahasa Indonesia (0,2) Lebih Penting dari Bahasa Inggris</li>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kriteria - {{ $pilih_jurusan->jurusan }}</h6>
        </div>

        {{-- {{dd($gabungan)}} --}}

        <div class="card-body">
            <form action="/examiner/kriteria/create" method="POST">
                @csrf
                @for ($i = 0; $i < count($gabungan); $i++) <input type="hidden" name="loop" value="{{$i+1}}">
                    <input type="hidden" name="jurusan_id" value="{{ $pilih_jurusan->id }}">
                    <div class="row m-3">
                        <div class="col text-right">
                            <p>
                                <input type="hidden" value="{{ $gabungan[$i]['satu']['id'] }}" name="id_x_{{$i}}">
                                <input type="hidden" value="{{ $gabungan[$i]['satu']['nama'] }}"
                                    name="kriteria_x_{{$i}}">
                                {{ $gabungan[$i]['satu']['nama'] }}
                            </p>
                        </div>
                        <div class="col">
                            <select name="kepentingan_{{$i}}" class="form-control">
                                <option value="1">1 - Sama pentingnya </option>
                                {{-- <option value="0.5">0.5</option> --}}
                                <option value="2">2 - Nilai tengah</option>
                                <option value="0.33">0.33 - Kriteria kanan sedikit lebih penting</option>
                                <option value="3">3 - Sedikit lebih penting</option>
                                {{-- <option value="0.25">0.25</option> --}}
                                <option value="4">4 - Nilai tengah</option>
                                <option value="0.2">0.2 - Kriteria kanan lebih penting</option>
                                <option value="5">5 - Lebih penting</option>
                                {{-- <option value="0.16">0.16</option> --}}
                                <option value="6">6 - Nilai tengah</option>
                                <option value="0.14">0.14 - Kriteria kanan sangat penting</option>
                                <option value="7">7 - Sangat penting</option>
                                {{-- <option value="0.12">0.12</option> --}}
                                <option value="8">8 - Nilai tengah</option>
                                <option value="0.11">0.11 - Kriteria kanan mutlak lebih penting</option>
                                <option value="9">9 - Mutlak lebih penting</option>
                            </select>
                        </div>
                        <div class="col">
                            <p>
                                <input type="hidden" value="{{ $gabungan[$i]['dua']['id'] }}" name="id_y_{{$i}}">
                                <input type="hidden" value="{{ $gabungan[$i]['dua']['nama'] }}"
                                    name="kriteria_y_{{$i}}">
                                {{ $gabungan[$i]['dua']['nama'] }}
                            </p>
                        </div>
                    </div>
                    @endfor
                    <button type="submit" class="btn btn-primary" style="float:right">Simpan</button>
            </form>
        </div>
    </div>
    @endif

</div>
<!-- /.container-fluid -->
@endsection
