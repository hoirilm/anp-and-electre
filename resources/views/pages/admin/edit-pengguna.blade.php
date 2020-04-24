@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

{{-- {{dd($kriteria['id'])}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4 col-md-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit kriteria</h6>
        </div>
        <div class="card-body">
            <form action="/admin/pengguna/{{ $user->id }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama pengguna: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1"
                            placeholder="Masukkan nama admin" name="name" value="{{ $user->name }}">
            
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
            
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Username: </label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan username" name="username"
                            value="{{ $user->username }}">
            
                        @error('username')
                        <span class=" invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
            
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Password: </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan password" name="password">
            
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
            
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Konfirmasi password: </label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Konfirmasi password" name="password_confirmation">
            
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection