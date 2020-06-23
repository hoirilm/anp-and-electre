@extends('layouts.admin')

@section('title', 'Menu Daftar Keterkaitan Kriteria')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    @if (session('massage'))
    <div class="alert alert-success">
        {{ session('massage') }}
    </div>
    @endif


    @if (!isset($gabungan))
    <div class="alert alert-primary col-3">
        Tidak ada keterkaitan kriteria
    </div>
    @else


    <div class="accordion shadow mb-4" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#panduan" aria-expanded="true" aria-controls="panduan">
                        Panduan keterkaitan kriteria
                    </button>
                </h2>
            </div>

            <div id="panduan" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <p>Ada 5 kriteria yaitu IND, ING, MAT, BIO, KIM, FIS</p>
                    <ul>
                        <li>Semua mempunyai keterkaitan maka penggambarannya: </li>
                        <img style="width: 50%" src="{{ url("img/keterkaitan.png") }}" alt="">
                        <li>Semua tidak mempunyai keterkaitan maka penggambarannya: </li>
                        <img style="width: 50%" src="{{ url("img/tidak_terkait.png") }}" alt="">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 col">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Keterkaitan-kriteria tahun
                {{ date('Y', strtotime($gabungan[0]['satu']['tahun_kriteria'])) }}</h6>
        </div>
        <div class="card-body">
            <form action="/admin/kriteria/keterkaitan/store" method="POST">
                @csrf
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Kriteria</th>
                            <th scope="col">Terkait</th>
                            <th scope="col">Tidak</th>
                            <th scope="col">Kriteria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gabungan as $gab)
                        <tr>
                            <th scope="row"> <input type="hidden" name="loop" value="{{$loop->iteration}}">
                                {{$loop->iteration}}</th>
                            <td>
                                <input type="hidden" name="keterkaitan_x_{{$loop->iteration}}"
                                    value="{{ $gab['satu']['id'] }}">
                                <input type="hidden" name="tahun_kriteria_{{$loop->iteration}}"
                                    value="{{ $gab['satu']['tahun_kriteria'] }}">
                                {{ $gab['satu']['nama'] }}</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="terkait"
                                        name="keterkaitan{{$loop->iteration}}" value="1" checked>
                                    <label class="form-check-label" for="terkait"></label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="tidak"
                                        name="keterkaitan{{$loop->iteration}}" value="0">
                                    <label class="form-check-label" for="tidak"></label>
                                </div>
                            </td>
                            <td>
                                <input type="hidden" name="keterkaitan_y_{{$loop->iteration}}"
                                    value="{{ $gab['dua']['id'] }}">
                                <input type="hidden" name="tahun_kriteria_{{$loop->iteration}}"
                                    value="{{ $gab['dua']['tahun_kriteria'] }}">
                                {{ $gab['dua']['nama'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    @endif

</div>
<!-- /.container-fluid -->
@endsection
