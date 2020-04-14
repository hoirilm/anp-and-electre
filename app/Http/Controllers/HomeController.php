<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
        // return redirect()->back();
    }

    public function adminHome()
    {
        return view('pages.admin.index');
    }

    public function examinerHome()
    {
        return view('pages.penguji.index');
    }
}
