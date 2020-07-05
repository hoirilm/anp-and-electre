@extends('layouts.admin')

@section('title', 'Edit Nilai')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    @if (session('massage'))
    <div class="alert alert-success col-4">
        {{ session('massage') }}
    </div>
    @endif

    @if (!isset($nilai) or count($nilai) < 1) <div class="card shadow mb-4 col-md-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Nilai {{$peserta->nama_siswa}}</h6>
        </div>
        <div class="card-body">
            <form action="/admin/peserta/nilai" method="POST">
                <div class="modal-body">
                    @csrf
                    {{-- @method('PUT') --}}
                    <input type="hidden" name="peserta_id" value="{{$peserta->id}}">
                    <input type="hidden" name="jurusan" value="{{$peserta->jurusan_id}}">
                    @foreach ($kriteria as $value)
                    <input type="hidden" name="loop" value="{{$loop->iteration}}">
                    <div class="form-group">
                        <label for="exampleFormControlInput{{$loop->iteration}}">{{ $value->kriteria }} </label>
                        <input type="hidden" name="kriteria_id_{{$loop->iteration}}" value="{{$value->id}}">
                        <input type="text"
                            class="form-control @error('nilai_kriteria_'.$loop->iteration) is-invalid @enderror"
                            id="exampleFormControlInput{{$loop->iteration}}" placeholder="Masukkan nilai"
                            name="nilai_kriteria_{{$loop->iteration}}"
                            value="{{ old('nilai_kriteria_'.$loop->iteration) }}">
                        @error('nilai_kriteria_'. $loop->iteration)
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        @else
        {{-- {{dd($kriteria[1]->id)}} --}}
        <div class="card shadow mb-4 col-md-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Nilai {{$peserta->nama_siswa}}</h6>
            </div>
            <div class="card-body">
                <form action="/admin/peserta/nilai" method="POST">
                    <div class="modal-body">
                        @csrf
                        {{-- @method('PUT') --}}
                        <input type="hidden" name="peserta_id" value="{{$peserta->id}}">
                        @foreach ($kriteria as $value)
                        <input type="hidden" name="loop" value="{{$loop->iteration}}">
                        <div class="form-group">
                            <label for="exampleFormControlInput{{$loop->iteration}}">{{ $value->kriteria }} </label>
                            <input type="hidden" name="kriteria_id_{{$loop->iteration}}" value="{{$value->id}}">
                            <input type="text"
                                class="form-control @error('nilai_kriteria_'.$loop->iteration) is-invalid @enderror"
                                id="exampleFormControlInput{{$loop->iteration}}" placeholder="Masukkan nilai"
                                name="nilai_kriteria_{{$loop->iteration}}" value="@if(isset($nilai[$loop->iteration -
                        1]->nilai)){{$nilai[$loop->iteration - 1]->nilai}}@else 0 @endif">

                            @error('nilai_kriteria_'.$loop->iteration)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
</div>
<!-- /.container-fluid -->
@endsection
