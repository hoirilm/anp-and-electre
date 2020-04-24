@extends('layouts.admin')

@section('title', 'Edit Peseerta')

@section('content')

@push('style-date-picker')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css"
    integrity="sha256-BqW0zYSKgIYEpELUf5irBCGGR7wQd5VZ/N6OaBEsz5U=" crossorigin="anonymous" />
@endpush

{{-- {{dd($kriteria['id'])}} --}}

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4 col-md-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit peserta</h6>
        </div>
        <div class="card-body">
            <form action="/admin/peserta/{{$peserta->id}}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama siswa: </label>
                        <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan nama siswa" name="nama_siswa"
                            value="{{ $peserta->nama_siswa }}">

                        @error('nama_siswa')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nomor pendaftaran: </label>
                        <input type="text" class="form-control @error('nomor_pendaftaran') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan nomor pendaftaran"
                            name="nomor_pendaftaran" value="{{ $peserta->nomor_pendaftaran }}">

                        @error('nomor_pendaftaran')
                        <span class=" invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">NPSN sekolah: </label>
                        <input type="text" class="form-control @error('npsn_sekolah') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan npsn sekolah" name="npsn_sekolah"
                            value="{{ $peserta->npsn_sekolah }}">

                        @error('npsn_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Jenis kelamin: </label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tgl. lahir: </label>
                        <input type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            name="tanggal_lahir" id="date" placeholder="Tanggal lahir"
                            value="{{ $peserta->tanggal_lahir }}" autocomplete="off">

                        @error('tanggal_lahir')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Jurusan: </label>
                        <select name="jurusan" class="form-control">
                            @foreach ($list_jurusan as $jurusan)
                            <option value="{{ $jurusan->id }}">{{ $jurusan->jurusan }}</option>
                            @endforeach
                        </select>

                        @error('jurusan')
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