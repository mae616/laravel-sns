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

// 認証関連のルーティングの追加
Auth::routes();

Route::prefix('login')->name('login.')->group(function () {
  Route::get('/{provider}', 'Auth\LoginController@redirectToProvider')->name('{provider}');
});

// ArticleControllerコントローラでindexメソッドを実行する
Route::get('/', 'ArticleController@index')->name('articles.index');

Route::resource('/articles', 'ArticleController')->except(['index', 'show'])->middleware('auth');
Route::resource('/articles', 'ArticleController')->only(['show']);

Route::prefix('articles')->name('articles.')->group(function () {
  Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
  Route::delete('{article}/like', 'ArticleController@unlike')->name('unlike')->middleware('auth');
});
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');
Route::prefix('users')->name('users.')->group(function () {
  Route::get('/{name}', 'UserController@show')->name('show');
  Route::get('/{name}/likes', 'UserController@likes')->name('likes');
  Route::get('/{name}/followings', 'UserController@followings')->name('followings');
  Route::get('/{name}/followers', 'UserController@followers')->name('followers');
  Route::middleware('auth')->group(function () {
    Route::put('/{name}/follow', 'UserController@follow')->name('follow');
    Route::delete('/{name}/follow', 'UserController@unfollow')->name('unfollow');
  });
});
