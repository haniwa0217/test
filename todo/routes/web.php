<!--
 Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');
/folders/{id}/tasks にリクエストが来たら TaskController コントローラーの index メソッドを呼びだす


-->
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

//ページに認証を求める処理はミドルウェアを用いて実現します。
//ミドルウェアとは、ルートごとの処理に移る前に実行されるプログラムでした。
//認証状態の確認はさまざまなルートに共通して実行したい処理なのでミドルウェアで実現するのに適しています。
//ルートグループはいくつかのルートに対して一括で機能を追加したい場合に使用します。
//今回は認証ミドルウェアを複数のルートに一括して適用するために使う。

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');

Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index'); //todoリスト一覧画面のURL

Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create'); //フォルダの新規作成用画面のURL
Route::post('/folders/create', 'FolderController@create'); //フォルダ登録処理画面のURL


Route::get('/folders/{id}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create'); //タスクの新規作成用画面のURL
Route::post('/folders/{id}/tasks/create', 'TaskController@create'); //タスク登録処理画面のURL

Route::get('/folders/{id}/tasks/{task_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');//タスク編集画面のURL
Route::post('/folders/{id}/tasks/{task_id}/edit', 'TaskController@edit');//タスク編集画面のURL

Route::delete('/folders/{id}/tasks', 'FolderController@delete');
});

Auth::routes(); //このメソッドが、会員登録・ログイン・ログアウト・パスワード再設定の各機能で必要なルーティング設定をすべて定義します。