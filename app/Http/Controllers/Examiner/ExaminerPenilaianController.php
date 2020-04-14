<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExaminerPenilaianController extends Controller
{
    public function penilaian()
    {
        return view('pages.penguji.penilaian');
    }
}
