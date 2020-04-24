@extends('layouts.admin')

@section('title', 'Edit Kriteria')

@section('content')

{{-- {{dd($kriteria['id'])}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4 col-md-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit kriteria</h6>
        </div>
        <div class="card-body">
            <form action="/admin/kriteria/{{ $kriteria->id }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama kriteria: </label>
                        <input type="text" class="form-control @error('kriteria') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan nama kriteria" name="kriteria"
                            value="{{ $kriteria->kriteria }}">

                        @error('kriteria')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection