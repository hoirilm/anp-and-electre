@extends('layouts.admin')

@section('title', 'Menu Daftar Pengguna')

@section('content')

{{-- {{ dd($errors) }} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-pengguna">
            <i class="fas fa-download fa-sm text-white-50"></i> Tambah Pengguna
        </button>

    </div>

    @if (session('massage'))
    <div class="alert alert-success">
        {{ session('massage') }}
    </div>
    @endif

    @include('includes.admin.modal.tambah-pengguna')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            {{ ($user->is_admin === 1) ? 'Admin' : 'Penguji' }}
                        </td>
                        <td class="row">
                            <div class="mx-2">
                                <form action="/admin/pengguna/{{ $user->id }}" method="GET">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </div>
                        
                            <div class="mx-2">
                                <form action="/admin/pengguna/{{ $user->id }}" method="POST">
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
            {{ $users->links() }}
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@push('script-modal')
@if (count($errors) > 0)
<script>
    $( document ).ready(function() {
                $('#tambah-pengguna').modal('show');
            });
</script>
@endif
@endpush