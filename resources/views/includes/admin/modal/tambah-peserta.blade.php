<!-- Modal TAMBAH ADMIN-->
<div class="modal fade" id="tambah-peserta" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/peserta" method="POST">
                <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama siswa: </label>
                        <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan nama siswa" name="nama_siswa"
                            value="{{ old('nama_siswa') }}">

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
                            name="nomor_pendaftaran" value="{{ old('nomor_pendaftaran') }}">

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
                            value="{{ old('nomor_pendaftaran') }}">

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
                            name="tanggal_lahir" id="tanggal_lahir" placeholder="Tanggal lahir">

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
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>