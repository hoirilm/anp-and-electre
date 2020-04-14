<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminKeputusanController extends Controller
{
    public function keputusan () 
    {
        return view('pages.admin.keputusan');
    }
}
