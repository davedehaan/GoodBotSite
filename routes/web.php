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

// No Auth Routes
Route::get('/', function () {
    return view('index');
});
Route::get('/darkmode', 'UserController@darkmode')->name('darkmode');
Route::get('/logout', 'UserController@logout')->name('logout');

// Player Routes
Route::group(['middleware' => ['oauth']], function() {
    // Dashboard Routes
    Route::group(['middlware' => 'admin'], function() {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::get('/dashboard/{id}', 'DashboardController@dashboard')->name('dashboard');
        Route::get('/dashboard/logs/{id}', 'DashboardController@logs')->name('logs');
        Route::get('/dashboard/settings/{id}', 'DashboardController@settings')->name('settings');
        Route::post('/dashboard/settings/{id}', 'DashboardController@postSettings')->name('settings.post');
        Route::get('/dashboard/setup/{id}', 'DashboardController@setup')->name('setup');
        Route::get('/dashboard/setup/save/{id}', 'DashboardController@setupSave')->name('setup.save');
        Route::get('/dashboard/install/{id}', 'DashboardController@install')->name('install');
    });

    Route::get('/OAuth', 'GoodBotController@OAuth')->name('OAuth');
    // Characters 
    Route::get('/characters', 'CharacterController@index')->name('character.servers');
    Route::get('/characters/{serverID}', 'CharacterController@server')->name('character.list');
    Route::get('/characters/save/{serverID}/{characterID}', 'CharacterController@save')->name('character.save');

    // Signups
    Route::get('/s/{id}', 'GoodBotController@signups')->name('s');
    Route::get('/signups/{id}', 'GoodBotController@signups')->name('signups');
    
    // Raids
    Route::get('/raids', 'RaidController@index')->name('raids');
    Route::get('/raids/{id}/reserves', 'RaidController@reserves')->name('raids.reserves');
    Route::get('/raids/{id}/lineup', 'RaidController@lineup')->name('raids.lineup');
    Route::get('/raids/{id}/confirm/{signupID}', 'RaidController@confirm')->name('raids.confirm');
    Route::get('/raids/{id}/unconfirm/{signupID}', 'RaidController@unconfirm')->name('raids.unconfirm');
    Route::get('/raids/{id}/manage', 'RaidController@manage')->name('raids.manage');
    Route::post('/raids/{id}/manage', 'RaidController@postManage')->name('raids.manage.post');
    Route::get('/raids/{id}/command/{type}', 'RaidController@command')->name('raids.command');

    // Reserves
    Route::get('/r/{id}', 'GoodBotController@reserves')->name('r');
    Route::get('/reserves/{id}', 'GoodBotController@reserves')->name('reserves');
    Route::get('/reserve/{signupID}/{itemID}', 'GoodBotController@reserve');
    Route::get('{raid}', 'GoodBotController@index');
});

