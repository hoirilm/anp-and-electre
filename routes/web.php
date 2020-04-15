<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('is_admin')->group(function () {
    Route::get('/admin', 'HomeController@adminHome')->name('admin.home');
    Route::get('/admin/pengguna/admin', 'PagesController@daftarAdmin')->name('admin.daftar-admin');
    Route::get('/admin/pengguna/penguji', 'PagesController@daftarPenguji')->name('admin.daftar-penguji');
    Route::get('/admin/kriteria/daftar-kriteria', 'Admin\AdminKriteriaController@daftarKriteria')->name('admin.daftar-kriteria');
    Route::get('/admin/kriteria/keterkaitan-kriteria', 'Admin\AdminKriteriaController@keterkaitanKriteria')->name('admin.keterkaitan-kriteria');
    Route::get('/admin/peserta', 'PagesController@daftarPeserta')->name('admin.daftar-peserta');
    Route::get('/admin/keputusan', 'Admin\AdminKeputusanController@keputusan')->name('admin.keputusan');
});

Route::middleware('is_examiner')->group(function () {
    Route::get('/examiner', 'HomeController@examinerHome')->name('examiner.home');
    Route::get('/examiner/kriteria', 'Examiner\ExaminerKriteriaController@kriteria')->name('examiner.kriteria');
    Route::get('/examiner/peserta', 'Examiner\ExaminerPesertaController@peserta')->name('examiner.peserta');
    Route::get('/examiner/penilaian', 'Examiner\ExaminerPenilaianController@penilaian')->name('examiner.penilaian');
});
