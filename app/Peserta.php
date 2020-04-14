<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillabel = ['nama_siswa, nomor_pendaftaran, npsn_sekolah, jenis_kelamin, tanggal_lahir, created_at, updated_at, jurusan_id']; 
}
