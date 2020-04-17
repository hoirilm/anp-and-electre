<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillable = [
        'nama_siswa', 
        'nomor_pendaftaran', 
        'npsn_sekolah', 
        'jenis_kelamin', 
        'tanggal_lahir', 
        'jurusan_id'
    ];
}
