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

// Dashboard Routes
Route::group(['middlware' => 'admin'], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard/{id}', 'DashboardController@dashboard')->name('dashboard');
    Route::get('/dashboard/logs/{id}', 'DashboardController@logs')->name('logs');
    Route::get('/dashboard/settings/{id}', 'DashboardController@settings')->name('settings');
    Route::post('/dashboard/settings/{id}', 'DashboardController@postSettings')->name('settings.post');
    Route::get('/dashboard/setup/{id}', 'DashboardController@setup')->name('setup');
    Route::get('/dashboard/setup/save/{id}', 'DashboardController@setupSave')->name('setup.save');
});

// No Auth Routes
Route::get('/', function () {
    return view('index');
});
Route::get('/darkmode', 'UserController@darkmode')->name('darkmode');
Route::get('/logout', 'UserController@logout')->name('logout');

// Player Routes
Route::group(['middleware' => ['oauth']], function() {
    Route::get('/OAuth', 'GoodBotController@OAuth')->name('OAuth');
    Route::get('/characters', 'CharacterController@index')->name('character.servers');
    Route::get('/characters/{serverID}', 'CharacterController@server')->name('character.list');
    Route::get('/characters/save/{serverID}/{characterID}', 'CharacterController@save')->name('character.save');
    Route::get('/s/{id}', 'GoodBotController@signups')->name('s');
    Route::get('/signups/{id}', 'GoodBotController@signups')->name('signups');
    Route::get('/r/{id}', 'GoodBotController@reserves')->name('r');
    Route::get('/reserves/{id}', 'GoodBotController@reserves')->name('reserves');
    Route::get('/reserve/{signupID}/{itemID}', 'GoodBotController@reserve');
    Route::get('{raid}', 'GoodBotController@index');
});

