<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $fillable = ['nilai', 'peserta_id', 'kriteria_id','jurusan_id'];
}
