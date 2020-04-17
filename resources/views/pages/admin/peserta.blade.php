@extends('layouts.admin')

@section('title', 'Menu Daftar Peserta')

@push('style-date-picker')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css"
    integrity="sha256-BqW0zYSKgIYEpELUf5irBCGGR7wQd5VZ/N6OaBEsz5U=" crossorigin="anonymous" />
@endpush

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peserta</h1>

        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-peserta">
            <i class="fas fa-download fa-sm text-white-50"></i> Tambah Peserta
        </button>
    </div>

    @if (session('massage'))
    <div class="alert alert-success">
        {{ session('massage') }}
    </div>
    @endif

    @include('includes.admin.modal.tambah-peserta')

    <div class="col-xl-3 col-md-6 mb-4 px-0">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
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
                        <i class="fa    s fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar peserta</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nomor pendaftaran</th>
                        <th scope="col">NPSN sekolah</th>
                        <th scope="col">Jenis kelamin</th>
                        <th scope="col">Tanggal lahir</th>
                        <th scope="col">Terdaftar pada</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($peserta as $user)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $user->nama_siswa }}</td>
                        <td>{{ $user->nomor_pendaftaran }}</td>
                        <td>{{ $user->npsn_sekolah }}</td>
                        <td>{{ $user->jenis_kelamin }}</td>
                        <td>{{ date('d-M-Y', strtotime($user->tanggal_lahir)) }}</td>
                        <td>{{ date('d-M-Y', strtotime($user->created_at)) }}</td>
                        <td> Update | Delete </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $peserta->links() }}
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@push('script-date-picker')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
    integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js"
    integrity="sha256-NNMNW7d0OGoiO4RqoKSdLCcr+0E6rgu1hqzpYkh5BIM=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#tanggal_lahir').datepicker({
            // todayBtn: "linked",
            language: "id",
            keyboardNavigation: false,
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        });
    });
</script>
@endpush

@push('script-modal')
@if (count($errors) > 0)
<script>
    $( document ).ready(function() {
                $('#tambah-peserta').modal('show');
            });
</script>
@endif
@endpush