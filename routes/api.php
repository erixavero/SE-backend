<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group([

    'prefix' => 'auth'

], function () {
    Route::get('show', 'AuthController@show');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register','Auth\RegisterController@create');

});

// Gmopx\LaravelOWM\Http\Controllers
Route::group(['prefix' => 'owmapi', 'namespace' => '\Gmopx\LaravelOWM\Http\Controllers'], function() {
    Route::get('current-weather', ['uses' => 'LaravelOWMController@currentweather']);
    Route::get('forecast', ['uses' => 'LaravelOWMController@forecast']);
});

Route::group([

    'prefix' => 'device'

], function () {
    Route::get('stat', 'DeviceController@stat');
    Route::post('lighton', 'DeviceController@lightOn');
    Route::post('lightoff', 'DeviceController@lightOff');
    Route::post('tvon', 'DeviceController@tvOn');
    Route::post('tvoff', 'DeviceController@tvOff');

});

Route::group([
    'prefix' => 'schedule'
], function(){
   Route::get('all', 'CalendarController@showAll');
   Route::get('date/{date}', 'CalendarController@showByDate');
   Route::post('createNew', 'CalendarController@create');
});
<<<<<<< HEAD

Route::group([
    'prefix' => 'spotify'
], function(){
   Route::get('auth', 'SpotifyAPI@auth');
   Route::put('login', 'SpotifyAPI@login');
   Route::get('gettrack', 'SpotifyAPI@getTrackInformation');
   Route::get('next','SpotifyAPI@nextTrack');
   Route::get('previous','SpotifyAPI@previousTrack');
   Route::get('pause','SpotifyAPI@pauseTrack');
   Route::get('play','SpotifyAPI@playTrack');
   Route::put('trackShuffle','SpotifyAPI@trackShuffle');
   Route::put('trackRepeat','SpotifyAPI@trackRepeat');
   Route::put('trackVolume','SpotifyAPI@trackVolume');
   Route::put('trackSeek','SpotifyAPI@trackSeek');
});
=======
>>>>>>> 50d6eead5b6d1165f8e58b14f4fdb2e4e71e7980
