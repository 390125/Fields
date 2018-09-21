<?php
use Illuminate\Support\Facades\Auth;

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

//　これに入れとけば認証制御できる
Route::group(['middleware' =>['auth']], function(){

});

// ここから実用
// Auth
Auth::routes();

Route::get('/', function () {
    return view('home');
});

// Go to Home View
Route::get('/home', 'HomeController@index')->name('home');

// CRUD controller for contents
Route::resource('contents', 'Talk\ContentController', ['only' => ['show', 'store']]);

// Go to Rooms View
Route::resource('rooms', 'Talk\RoomController', ['only' => ['index', 'create', 'store']]);

// Go to Find View
Route::get('/find', 'Talk\RoomController@find')->name('find');

// Post to Find View
Route::post('/find', 'Talk\RoomController@findRoom')->name('findRoom');

// entryNewRoom
Route::get('entryRoom/{id}', 'Talk\RoomController@entryRoom')->name('entryRoom');

// exitRoom
Route::get('exitRoom/{id}', 'Talk\RoomController@exitRoom')->name('exitRoom');

// Get to settingpage
Route::get('setting/{id}', 'Auth\UserController@setUser')->name('setUser')->middleware('auth');

// Get to settingpage
Route::post('setting/{id}', 'Auth\UserController@update')->name('updateUser')->middleware('auth');
