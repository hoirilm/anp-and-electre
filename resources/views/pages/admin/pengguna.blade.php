@extends('layouts.admin')

@section('title', 'Menu Penguji')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>

        @if (request()->is('admin/pengguna/admin'))
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Admin</a>

        @elseif (request()->is('admin/pengguna/penguji'))
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Penguji</a>
        @endif
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Penguji</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Opsi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        @if (request()->is('admin/pengguna/admin'))
                        <td> Update | Delete </td>
                        @elseif (request()->is('admin/pengguna/penguji'))
                        <td> Update | Delete </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection