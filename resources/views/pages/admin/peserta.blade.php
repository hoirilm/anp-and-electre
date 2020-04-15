@extends('layouts.admin')

@section('title', 'Menu Daftar Peserta')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peserta</h1>

        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Peserta Baru</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peserta</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nomor Pendaftaran</th>
                        <th scope="col">NPSN Sekolah</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col">Terdaftar Pada</th>
                        <th scope="col">Opsi</th>
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
                        <td>{{ date('d-m-Y', strtotime($user->tanggal_lahir)) }}</td>
                        <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                        <td> Update | Delete </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $peserta->links() }}
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4 px-0">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pilih Tahun Daftar: </div>
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                2020
                            </button>
                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">2019</a>
                                <a class="dropdown-item" href="#">2018</a>
                                <a class="dropdown-item" href="#">2017</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa    s fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection