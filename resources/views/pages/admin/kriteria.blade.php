@extends('layouts.admin')

@section('title', 'Menu Daftar Kriteria')

@section('content')

{{-- {{dd($kriteria[0])}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4" style="display: none">
        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#tambah-kriteria">
            <i class="fas fa-download fa-sm text-white-50"></i> Tambah kriteria
        </button>
    </div> --}}

    @if (session('success-massage'))
    <div class="alert alert-success">
        {{ session('success-massage') }}
    </div>
    @endif

    @if (session('fail-massage'))
    <div class="alert alert-danger">
        {{ session('fail-massage') }}
    </div>
    @endif

    @include('includes.admin.modal.tambah-kriteria')

    @if (!isset($kriteria))
    <div class="alert alert-primary col-3">
        Tidak ada kriteria
    </div>
    @else
    <div class="card shadow mb-4 col">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar kriteria</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama kriteria</th>
                        {{-- <th scope="col">Tahun kriteria</th> --}}
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($kriteria as $krit)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $krit->kriteria }}</td>
                        {{-- <td>{{ date('Y', strtotime($krit->created_at)) }}</td> --}}
                        <td class="row">
                            <div class="mx-2">
                                <form action="/admin/kriteria/list/{{ $krit->id }}" method="GET">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </div>

                            {{-- <div class="mx-2">
                                <form action="/admin/kriteria/list/{{ $krit->id }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin untuk hapus data?')">Delete</button>
                                </form>
                            </div> --}}
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
    $(document).ready(function () {
        $('#tambah-kriteria').modal('show');
    });

</script>
@endif
@endpush
