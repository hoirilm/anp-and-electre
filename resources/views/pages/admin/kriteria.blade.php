@extends('layouts.admin')

@section('title', 'Menu Daftar Kriteria')

@section('content')

{{-- {{dd($kriteria[0])}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kriteria</h1>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-kriteria">
            <i class="fas fa-download fa-sm text-white-50"></i> Tambah kriteria
        </button>
    </div>

    @if (session('massage'))
    <div class="alert alert-success">
        {{ session('massage') }}
    </div>
    @endif

    @include('includes.admin.modal.tambah-kriteria')


    <div class="col-xl-3 col-md-6 mb-4 px-0">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data kriteria
                            tahun: </div>
                        <form action="/admin/kriteria/list" method="POST">
                            @csrf
                            {{-- @method('put') --}}
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

    @if (!isset($kriteria))
    <div class="alert alert-primary">
        Pilih tahun terlebih dahulu
    </div>
    @else
    <div class="card shadow mb-4 col">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar kriteria tahun
                {{ date('Y', strtotime($kriteria[0]->created_at))}}</h6>
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
                        <td class="row">
                            <div class="mx-2">
                                <form action="/admin/kriteria/list/{{ $krit->id }}" method="GET">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </div>

                            <div class="mx-2">
                                <form action="/admin/kriteria/list/{{ $krit->id }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin untuk hapus data?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{-- {{ $kriteria->links() }} --}}
        </div>
    </div>
    @endif

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