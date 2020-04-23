@extends('layouts.admin')

@section('title', 'Menu Daftar Kriteria')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kriteria</h1>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-kriteria">
            <i class="fas fa-download fa-sm text-white-50"></i> Tambah kriteria
        </button>
    </div>

    @include('includes.admin.modal.tambah-kriteria')

    <div class="col-xl-3 col-md-6 mb-4 px-0">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        {{-- <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pilih tahun daftar: </div> --}}
                        <div class="dropdown row px-2">
                            <select class="form-control col-md-6">
                                <option>-Pilih tahun-</option>
                                <option value="">2019</option>
                                <option value="">2018</option>
                                <option value="">2017</option>
                            </select>
                            <button class="btn btn-primary btn-sm mx-2">Lihat</button>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('massage'))
    <div class="alert alert-success">
        {{ session('massage') }}
    </div>
    @endif

    <div class="card shadow mb-4 col-md-7">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar kriteria tahun 2020</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama kriteria</th>
                        <th scope="col">Tahun kriteria</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($kriteria as $krit)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $krit->kriteria }}</td>
                        <td>{{ date('Y', strtotime($krit->created_at)) }}</td>
                        <td>
                            Update | Delete
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $kriteria->links() }}
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@push('script-modal')
@if (count($errors) > 0)
<script>
    $( document ).ready(function() {
                $('#tambah-kriteria').modal('show');
            });
</script>
@endif
@endpush