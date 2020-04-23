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
    
    Route::get('/admin/pengguna', 'PagesController@pengguna')->name('admin.pengguna');
    Route::post('/admin/pengguna', 'Admin\AdminPenggunaController@tambahPengguna');

    Route::get('/admin/peserta', 'PagesController@peserta')->name('admin.peserta');
    Route::post('/admin/peserta', 'Admin\AdminPesertaController@tambahPeserta');

    Route::get('/admin/kriteria/daftar-kriteria', 'PagesController@kriteria')->name('admin.daftar-kriteria');
    Route::put('/admin/kriteria/daftar-kriteria', 'Admin\AdminKriteriaController@cariKriteria');
    Route::put('/admin/kriteria/daftar-kriteria/{id}', 'Admin\AdminKriteriaController@updateKriteria');
    Route::post('/admin/kriteria/daftar-kriteria', 'Admin\AdminKriteriaController@tambahKriteria');
    Route::delete('/admin/kriteria/daftar-kriteria/{id}', 'Admin\AdminKriteriaController@hapusKriteria');
    

    Route::get('/admin/kriteria/keterkaitan-kriteria', 'PagesController@keterkaitanKriteria')->name('admin.keterkaitan-kriteria');
    Route::put('/admin/kriteria/keterkaitan-kriteria', 'Admin\AdminKeterkaitanKriteriaController@cariKeterkaitan');
    Route::post('/admin/kriteria/keterkaitan-kriteria', 'Admin\AdminKeterkaitanKriteriaController@keterkaitan');
    
    Route::get('/admin/keputusan', 'Admin\AdminKeputusanController@keputusan')->name('admin.keputusan');
});

Route::middleware('is_examiner')->group(function () {
    Route::get('/examiner', 'HomeController@examinerHome')->name('examiner.home');
    Route::get('/examiner/kriteria', 'Examiner\ExaminerKriteriaController@kriteria')->name('examiner.kriteria');
    Route::get('/examiner/peserta', 'Examiner\ExaminerPesertaController@peserta')->name('examiner.peserta');
    Route::get('/examiner/penilaian', 'Examiner\ExaminerPenilaianController@penilaian')->name('examiner.penilaian');
});
