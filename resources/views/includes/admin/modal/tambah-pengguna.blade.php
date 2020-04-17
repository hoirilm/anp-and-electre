<!-- Modal TAMBAH ADMIN-->
<div class="modal fade" id="tambah-pengguna" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/pengguna" method="POST">
                <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama pengguna: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan nama admin" name="name"
                            value="{{ old('name') }}">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Username: </label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan username" name="username"
                            value="{{ old('username') }}">

                        @error('username')
                        <span class=" invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Sebagai: </label>
                        <select name="status" class="form-control">
                            <option value="1">Admin</option>
                            <option value="0">Penguji</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Password: </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan password" name="password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Konfirmasi password: </label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Konfirmasu password"
                            name="password_confirmation">

                        @error('password_confirmation')
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