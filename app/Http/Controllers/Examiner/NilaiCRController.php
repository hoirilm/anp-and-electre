<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NilaiCRController extends Controller
{
    public function store()
    {
        return request()->all();
    }
}
