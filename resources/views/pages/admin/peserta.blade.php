@extends('layouts.admin')

@section('title', 'Menu Daftar Peserta')

@section('content')

@push('style-date-picker')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css"
    integrity="sha256-BqW0zYSKgIYEpELUf5irBCGGR7wQd5VZ/N6OaBEsz5U=" crossorigin="anonymous" />
@endpush

{{-- {{dd($peserta[0]->created_at)}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-peserta">
            <i class="fas fa-download fa-sm text-white-50"></i> Tambah peserta
        </button>
    </div>

    @if (session('massage'))
    <div class="alert alert-success col-6">
        {{ session('massage') }}
    </div>
    @endif

    @include('includes.admin.modal.tambah-peserta')


    <div class="col-xl-3 col-md-6 mb-4 px-0">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Peserta
                            Tahun: </div>
                        <form action="/admin/peserta/" method="POST">
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

    @if (!isset($peserta))
    <div class="alert alert-primary col-3">
        Pilih tahun terlebih dahulu
    </div>
    @else
    <div class="card shadow mb-4 col">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar kriteria tahun
                {{ date('Y', strtotime($peserta[0]->created_at))}}</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Siswa</th>
                        <th scope="col">Nomor Pendaftaran</th>
                        <th scope="col">NPSN Sekolah</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($peserta as $siswa)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $siswa->nama_siswa }}</td>
                        <td>{{ $siswa->nomor_pendaftaran }}</td>
                        <td>{{ $siswa->npsn_sekolah }}</td>
                        <td>{{ $siswa->jenis_kelamin }}</td>
                        <td>{{ $siswa->tanggal_lahir }}</td>
                        <td>{{ $siswa->jurusan }}</td>
                        <td class="row">
                            <div class="mx-2">
                                <form action="/admin/peserta/{{ $siswa->id }}" method="GET">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </div>

                            <div class="mx-2">
                                <form action="/admin/peserta/{{ $siswa->id }}" method="POST">
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
        $('#tambah-peserta').modal('show');
    });
</script>
@endif
@endpush

@push('script-date-picker')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
    integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js"
    integrity="sha256-NNMNW7d0OGoiO4RqoKSdLCcr+0E6rgu1hqzpYkh5BIM=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#date').datepicker({
            // todayBtn: "linked",
            language: "id",
            format:'yyyy/mm/dd',
            keyboardNavigation: false,
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
@endpush