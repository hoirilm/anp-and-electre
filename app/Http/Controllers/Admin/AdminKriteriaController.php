<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminKriteriaController extends Controller
{
    public function daftarKriteria()
    {
        return view('pages.admin.daftar-kriteria');
    }

    public function keterkaitanKriteria()
    {
        return view('pages.admin.keterkaitan-kriteria');
    }
}
