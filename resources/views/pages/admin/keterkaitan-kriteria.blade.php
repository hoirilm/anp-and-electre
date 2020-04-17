@extends('layouts.admin')

@section('title', 'Menu Daftar Keterkaitan Kriteria')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Keterkaitan kriteria</h1>
    </div>

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

    <div class="card shadow mb-4 col-md-7">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar kriteria tahun 2020</h6>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kriteria</th>
                        <th scope="col">Terkait</th>
                        <th scope="col">Tidak</th>
                        <th scope="col">Kriteria</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>1</td>
                        <td>Bahasa Indonesia</td>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="terkait" name="keterkaitan" checked>
                                <label class="form-check-label" for="terkait"></label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="tidak" name="keterkaitan">
                                <label class="form-check-label" for="tidak"></label>
                            </div>
                        </td>
                        <td>
                            Bahasa Inggris
                        </td>
                    </tr>
                </tbody>
            </table>
            {{-- {{ $peserta->links() }} --}}
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection