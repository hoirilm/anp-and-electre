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

    Route::get('/admin/kriteria/list/', 'Admin\KriteriaController@index')->name('admin.kriteria');
    // Route::post('/admin/kriteria/list/', 'Admin\KriteriaController@selectYear');
    Route::post('/admin/kriteria/list/store', 'Admin\KriteriaController@store');
    Route::get('/admin/kriteria/list/{id}/', 'Admin\KriteriaController@edit');
    Route::put('/admin/kriteria/list/{id}/', 'Admin\KriteriaController@update');
    Route::delete('/admin/kriteria/list/{id}/', 'Admin\KriteriaController@destroy');

    Route::get('/admin/kriteria/keterkaitan/', 'Admin\KeterkaitanKriteriaController@index')->name('admin.keterkaitan');
    // Route::post('/admin/kriteria/keterkaitan/', 'Admin\KeterkaitanKriteriaController@selectYear');
    Route::post('/admin/kriteria/keterkaitan/store', 'Admin\KeterkaitanKriteriaController@store');

    Route::get('/admin/kriteria/supermatrik', 'Admin\SupermatrikController@index')->name('admin.supermatrik');
    Route::post('/admin/kriteria/supermatrik', 'Admin\SupermatrikController@select');

    Route::get('/admin/pengguna', 'Admin\PenggunaController@index')->name('admin.pengguna');
    Route::post('/admin/pengguna/store', 'Admin\PenggunaController@store');
    Route::get('/admin/pengguna/{id}', 'Admin\PenggunaController@edit');
    Route::put('/admin/pengguna/{id}', 'Admin\PenggunaController@update');
    Route::delete('/admin/pengguna/{id}', 'Admin\PenggunaController@destroy');

    Route::get('/admin/peserta/', 'Admin\PesertaController@index')->name('admin.peserta');
    Route::post('/admin/peserta/', 'Admin\PesertaController@selectYear');
    Route::post('/admin/peserta/store', 'Admin\PesertaController@store');
    Route::get('/admin/peserta/{id}', 'Admin\PesertaController@edit');
    Route::put('/admin/peserta/{id}', 'Admin\PesertaController@update');
    Route::get('/admin/peserta/nilai/{id}', 'Admin\NilaiController@edit');
    Route::post('/admin/peserta/nilai', 'Admin\NilaiController@store');

    Route::get('/admin/ranking/', 'Admin\RankingController@index')->name('admin.ranking');
    Route::post('/admin/ranking/', 'Admin\RankingController@ranking');
    // Route::get('/admin/ranking/result', 'Admin\RankingController@result');

    Route::delete('/admin/peserta/{id}', 'Admin\PesertaController@destroy');

    // Route::get('')
});

Route::middleware('is_examiner')->group(function () {
    Route::get('/examiner', 'HomeController@examinerHome')->name('examiner.home');

    Route::get('/examiner/kriteria', 'Examiner\KriteriaController@index')->name('examiner.kriteria');
    Route::put('/examiner/kriteria', 'Examiner\KriteriaController@selectJurusan');

    // Route::post('/examiner/kriteria', 'Examiner\xyKriteriaController@create');

    Route::get('/examiner/kriteria/recent', 'Examiner\KriteriaController@recent')->name('examiner.recent');
    Route::put('/examiner/kriteria/recent', 'Examiner\KriteriaController@selectRecent');
    Route::post('/examiner/kriteria/create', 'Examiner\xyKriteriaController@create');

    Route::post('/examiner/kriteria/store', 'Examiner\xyKriteriaController@store');

    Route::post('/examiner/kriteria/bobot_normal', 'Examiner\BobotNormalController@store');


    // Route::get('/examiner/peserta', 'Examiner\ExaminerPesertaController@peserta')->name('examiner.peserta');
    // Route::get('/examiner/penilaian', 'Examiner\ExaminerPenilaianController@penilaian')->name('examiner.penilaian');
});
