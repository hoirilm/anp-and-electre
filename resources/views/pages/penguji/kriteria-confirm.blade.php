@extends('layouts.penguji')

@section('title', 'Menu Kriteria')

@section('content')

{{-- {{dd($kepentingan)}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    @if ($cr == "konsisten")
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Konsisten</h4>
            <p>Karena nilai CR kurang dari 0.1, maka CR bernilai Konsisten. Tekan Simpan untuk lanjut.</p>
            <hr>
            <form action="/examiner/kriteria/store" method="POST">
                @csrf

                <input type="hidden" name="loop" value="{{$loop}}">
                <input type="hidden" name="jurusan_id" value="{{$jurusan_id}}">

                @for ($i=0; $i < count($id_x); $i++)
                    <input type="hidden" name="id_x_{{$i}}" value="{{$id_x[$i]}}">
                    <input type="hidden" name="id_y_{{$i}}" value="{{$id_y[$i]}}">
                @endfor

                @for ($i=0; $i < $loop; $i++)
                    <input type="hidden" name="kepentingan_{{$i}}" value="{{$kepentingan[$i]}}">
                @endfor

                @for ($i=0; $i < count($id_x); $i++)
                    <input type="hidden" name="kriteria_x_{{$i}}" value="{{$kriteria_x[$i]}}">
                    <input type="hidden" name="kriteria_y_{{$i}}" value="{{$kriteria_y[$i]}}">
                @endfor

                @for ($i=0; $i < count($bobot_normal); $i++)
                    <input type="hidden" name="kriteria_id_{{$i}}" value="{{$kriteria[$i]->id}}">
                    <input type="hidden" name="bobot_normal_{{$i}}" value="{{$bobot_normal[$i]}}">
                @endfor

                {{-- {{dd($unweight)}} --}}

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    @elseif($cr == "!konsisten")
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Tidak Konsisten</h4>
            <p>Karena nilai CR lebih dari 0.1, maka CR bernilai tidak konsisten. Inputkan kembali nilai kriteria perbandingan atau lanjutkan dengan nilai yang ada.</p>
            <hr>
            <form action="/examiner/kriteria/store" method="POST">
                @csrf

                <input type="hidden" name="loop" value="{{$loop}}">
                <input type="hidden" name="jurusan_id" value="{{$jurusan_id}}">

                @for ($i=0; $i < count($id_x); $i++)
                    <input type="hidden" name="id_x_{{$i}}" value="{{$id_x[$i]}}">
                    <input type="hidden" name="id_y_{{$i}}" value="{{$id_x[$i]}}">
                @endfor

                @for ($i=0; $i < $loop; $i++) <input type="hidden" name="kepentingan_{{$i}}"
                    value="{{$kepentingan[$i]}}">
                    @endfor

                @for ($i=0; $i < count($id_x); $i++)
                    <input type="hidden" name="kriteria_x_{{$i}}" value="{{$kriteria_x[$i]}}">
                    <input type="hidden" name="kriteria_y_{{$i}}" value="{{$kriteria_y[$i]}}">
                @endfor

                @for ($i=0; $i < count($bobot_normal); $i++)
                    <input type="hidden" name="kriteria_id_{{$i}}" value="{{$kriteria[$i]->id}}">
                    <input type="hidden" name="bobot_normal_{{$i}}" value="{{$bobot_normal[$i]}}">
                @endfor



                <button type="submit" class="btn btn-primary">Lanjutkan, dan simpan</button>
                <button type="button" class="btn btn-danger" onclick="window.location='{{ route('examiner.kriteria') }}'">Kembali mengisi nilai kriteria</button>
            </form>


        </div>
    @endif

</div>
<!-- /.container-fluid -->
@endsection
