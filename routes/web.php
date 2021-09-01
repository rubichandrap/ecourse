<?php

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

Auth::routes();

Route::get('/', function(){
    return view('welcome');
})->name('welcome');

Route::get('/tentang', 'TentangController@index')->name('tentang');

Route::get('/kontak', 'KontakController@index')->name('kontak');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/retrieve', 'HomeController@retrieve')->name('retrieve');

    /*password*/
    Route::name('password.')->group(function() {
        Route::get('/password/{id}/edit', 'PasswordController@edit')->name('edit');
        Route::patch('/password/{id}', 'PasswordController@update')->name('update');
    });

    /*profil*/
    Route::name('profile.')->group(function() {
        Route::get('/profile', 'ProfileController@index')->name('index');
        Route::patch('/profile/{id}', 'ProfileController@update')->name('update');
    });

    /*mahasiswa*/
    Route::name('mahasiswa.')->group(function() {
        Route::get('/mahasiswa', 'MahasiswaController@index')->name('index');
        Route::get('/mahasiswa/create', 'MahasiswaController@create')->name('create');
        Route::post('/mahasiswa', 'MahasiswaController@store')->name('store');
        Route::get('/mahasiswa/{id}', 'MahasiswaController@show')->name('show');
        Route::get('/mahasiswa/{id}/edit', 'MahasiswaController@edit')->name('edit');
        Route::patch('/mahasiswa/{id}', 'MahasiswaController@update')->name('update');
        Route::delete('/mahasiswa/{id}', 'MahasiswaController@destroy')->name('destroy');  
    });

    /*dosen*/
    Route::name('dosen.')->group(function() {
        Route::get('/dosen', 'DosenController@index')->name('index');
        Route::get('/dosen/create', 'DosenController@create')->name('create');
        Route::post('/dosen', 'DosenController@store')->name('store');
        Route::get('/dosen/{id}', 'DosenController@show')->name('show');
        Route::get('/dosen/{id}/edit', 'DosenController@edit')->name('edit');
        Route::patch('/dosen/{id}', 'DosenController@update')->name('update');
        Route::delete('/dosen/{id}', 'DosenController@destroy')->name('destroy');
    });

    /*kelas*/
    Route::name('kelas.')->group(function() {
        Route::get('/kelas', 'KelasController@index')->name('index');
        Route::get('/kelas/list', 'KelasController@kelas_list')->name('list');
        Route::get('/kelas/list/ajax', 'KelasController@ajax_kelas_list')->name('ajax_list');
        Route::get('/kelas/join', 'KelasController@kelas_join')->name('join');
        Route::get('/kelas/join/ajax', 'KelasController@ajax_kelas_join')->name('ajax_join');
        Route::post('/kelas/join', 'KelasController@token_handler')->name('token_handler');
        Route::get('/kelas/{id}/desc', 'KelasController@desc')->name('desc');
        Route::get('/kelas/{id}/desc/ajax', 'KelasController@ajax_desc')->name('ajax_desc');
        Route::get('/kelas/{id}/peserta', 'KelasController@peserta')->name('peserta');
        Route::get('/kelas/{id}/peserta/ajax', 'KelasController@ajax_peserta')->name('ajax_peserta');
        Route::patch('/kelas/{kelas_id}/peserta/{user_id}', 'KelasController@kick_peserta')->name('kick_peserta');
        Route::get('/kelas/create', 'KelasController@create')->name('create');
        Route::post('/kelas', 'KelasController@store')->name('store');
        Route::get('/kelas/{id}', 'KelasController@show')->name('show');
        Route::get('/kelas/{id}/edit', 'KelasController@edit')->name('edit');
        Route::patch('/kelas/{id}', 'KelasController@update')->name('update');
        Route::delete('/kelas/{id}', 'KelasController@destroy')->name('destroy');
        Route::post('/kelas/status', 'KelasController@status')->name('status');
    });

    Route::name('session.')->group(function() {
        Route::get('/kelas/{id}/session', 'SessionController@index')->name('index');
        Route::get('/kelas/{id}/session/ajax', 'SessionController@ajax_session')->name('ajax_session');
        Route::get('/kelas/{id}/session/create', 'SessionController@create')->name('create');
        Route::post('/kelas/{id}/session', 'SessionController@store')->name('store');
        Route::get('/kelas/{id}/session/{session_of}', 'SessionController@show')->name('show');
        Route::get('/kelas/{id}/session/{session_of}/edit', 'SessionController@edit')->name('edit');
        Route::patch('/kelas/{id}/session/{session_of}', 'SessionController@update')->name('update');
        Route::delete('/kelas/{id}/session/{session_of}', 'SessionController@destroy')->name('destroy');
        Route::post('/kelas/session/status', 'SessionController@status')->name('status');
    });

    Route::name('posting.')->group(function() {
        Route::post('/kelas/{id}/session/{session_of}/posting', 'PostingController@store')->name('store');
        Route::delete('/kelas/session/posting/{id}', 'PostingController@destroy')->name('destroy');
    });
    
    Route::name('comment.')->group(function() {
        Route::post('/kelas/session/posting/{posting_id}/comment', 'CommentController@store')->name('store');
        Route::delete('/kelas/session/posting/comment/{comment_id}', 'CommentController@destroy')->name('destroy');
    });

    Route::name('tugas_comment.')->group(function() {
        Route::post('/kelas/session/tugas/{tugas_id}/comment', 'TugasCommentController@store')->name('store');
        Route::delete('/kelas/session/tugas/comment/{comment_id}', 'TugasCommentController@destroy')->name('destroy');
    });

    Route::name('absent.')->group(function() {
        Route::get('/kelas/{kelas_id}/session/{session_of}/absent', 'AbsentController@index')->name('index');
        Route::post('/kelas/{kelas_id}/session/{session_of}/absent', 'AbsentController@store')->name('store');
    });

    Route::name('tugas.')->group(function() {
        Route::get('/kelas/{kelas_id}/session/{session_of}/tugas', 'TugasController@index')->name('index');
        Route::post('/kelas/{kelas_id}/session/{session_of}/tugas', 'TugasController@store')->name('store');
        Route::delete('/kelas/session/tugas/{id}', 'TugasController@destroy')->name('destroy');
    });

    /*modul*/
    Route::name('modul.')->group(function() {
        Route::get('/modul', 'ModulController@index')->name('index');
        Route::get('/modul/{slug}/desc', 'ModulController@desc')->name('desc');
        Route::get('/modul/{slug}/desc/ajax', 'ModulController@ajax_desc')->name('ajax_desc');
        Route::get('/modul/create', 'ModulController@create')->name('create');
        Route::post('/modul', 'ModulController@store')->name('store');
        Route::get('/modul/{slug}', 'ModulController@show')->name('show');
        Route::get('/modul/{slug}/edit', 'ModulController@edit')->name('edit');
        Route::patch('/modul/{id}', 'ModulController@update')->name('update');
        Route::delete('/modul/{id}', 'ModulController@destroy')->name('destroy');
        Route::post('/modul/status', 'ModulController@status')->name('status');
    });

    /*lecture*/
    Route::name('lecture.')->group(function() {
        Route::get('/modul/{slug}/lecture', 'LectureController@index')->name('index');
        Route::get('/modul/{slug}/lecture/ajax', 'LectureController@ajax_lecture')->name('ajax_lecture');
        Route::get('/modul/{slug}/lecture/create', 'LectureController@create')->name('create');
        Route::post('/modul/{slug}/lecture', 'LectureController@store')->name('store');
        Route::get('/modul/{slug}/lecture/{urutan}', 'LectureController@show')->name('show');
        Route::get('/modul/{slug}/lecture/{urutan}/edit', 'LectureController@edit')->name('edit');
        Route::patch('/modul/{slug}/lecture/{urutan}', 'LectureController@update')->name('update');
        Route::delete('/modul/{slug}/lecture/{urutan}', 'LectureController@destroy')->name('destroy');
        Route::post('/modul/lecture/status', 'LectureController@status')->name('status');
    });

    /*pencarian*/
    Route::get('/pencarian', 'PencarianController@index')->name('pencarian');
});

Route::get('/clear-cache', function () {
    $exitCode =
        Artisan::call('config:clear');
    $exitCode =
        Artisan::call('cache:clear');
    $exitCode =
        Artisan::call('config:cache');
    return 'Cache cleared!';
});
