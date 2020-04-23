@extends('layouts.admin')

@section('title', 'Menu Daftar Keterkaitan Kriteria')

@section('content')

{{-- {{dd($gabungan[0]['satu']['tahun_kriteria'])}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Keterkaitan kriteria</h1>
    </div>

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
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data keterkaitan-kriteria
                            tahun: </div>
                        <form action="/admin/kriteria/keterkaitan-kriteria/" method="POST">
                            @csrf
                            @method('put')
                            <div class="dropdown row px-2">
                                <select class="form-control col" name="tahun">
                                    <option>Pilih tahun</option>
                                    @foreach ($tahun as $item)
                                    <option value="{{ $item['tahun'] }}">{{ $item['tahun'] }}</option>
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
    <div class="alert alert-primary">
        Pilih tahun terlebih dahulu
    </div>
    @else
    <div class="card shadow mb-4 col">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Keterkaitan-kriteria tahun
                {{ date('Y', strtotime($gabungan[0]['satu']['tahun_kriteria'])) }}</h6>
        </div>
        <div class="card-body">
            <form action="/admin/kriteria/keterkaitan-kriteria" method="POST">
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