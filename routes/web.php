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

Route::get('/', function () {
    return view('welcome', [
    ]);
});


Route::get('/upload', function () {
    return view('upload', [
        'id' => request()->query('id'),
        'path' => request()->query('path')
    ]);
});

Route::post('/upload', function () {
    $server = request()->server_id;
    request()->file->storeAs('uploads', $server . '-' . request()->file->getClientOriginalName());
    return view('upload', [
        'id' => request()->query('id'),
        'path' => request()->query('path')
    ]);
})->name('upload');
