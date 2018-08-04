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

Route::get('/', function () {
    return view('welcome');
});

//　これに入れとけば認証制御できる
Route::group(['middleware' =>['auth']], function(){

});
/* ->name()�Ń��[�g�ɖ��O���Ă�  */
Route::get('/chatroom', 'ChatController@index')->name('chatroom');

// ここから実用
// Auth
Auth::routes();

// Go to Home View
Route::get('/home', 'HomeController@index')->name('home');

// CRUD controller for contents
Route::resource('contents', 'Talk\ContentController', ['only' => ['show', 'store']]);

// Go to Rooms View
Route::resource('rooms', 'Talk\RoomController', ['only' => ['index', 'create', 'store']]);

// Go to Find View
Route::get('/find', 'Talk\RoomController@find')->name('find');

// entryNewRoom
Route::get('entryRoom/{id}', 'Talk\RoomController@entryRoom')->name('entryRoom');

// entryNewRoom
Route::get('exitRoom/{id}', 'Talk\RoomController@exitRoom')->name('exitRoom');
