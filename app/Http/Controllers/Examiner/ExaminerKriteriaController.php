<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExaminerKriteriaController extends Controller
{
    public function kriteria() 
    {
        return view('pages.penguji.kriteria');
    }
}
