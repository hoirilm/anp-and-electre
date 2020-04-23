<!-- Modal -->
<div class="modal fade" id="update-kriteria-{{$krit->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/kriteria/daftar-kriteria/{{ $krit->id }}" method="POST">
                <div class="modal-body">

                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama kriteria: </label>
                        <input type="text" class="form-control @error('kriteria') is-invalid @enderror"
                            id="exampleFormControlInput1" placeholder="Masukkan nama kriteria" name="kriteria"
                            value="{{ $krit->kriteria }}">

                        @error('kriteria')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>