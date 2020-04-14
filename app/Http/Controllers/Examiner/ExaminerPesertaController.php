<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExaminerPesertaController extends Controller
{
    public function peserta()
    {
        return view('pages.penguji.peserta');
    }
}
