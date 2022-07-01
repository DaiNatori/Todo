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

Route::get('/show-ip', 'BasicController@showClientIp');
//Route::get('/showname', 'BasicController@inputName');

Route::get('/articles/{id}', 'BasicController@showArticle');


Route::get('/showname', function () {
    return view('test-post');
});

//->name というのは、Routeの名前を付けているということ。

Route::post('/showname', 'BasicController@showName')->name('sendname');

Route::get('/showtaska', 'BasicController@showTaskA');
Route::get('/showtaskb', 'BasicController@showTaskB');
Route::get('/showtaskc', 'BasicController@showTaskC');
Route::post('/codepoint', 'BasicController@codePoint')->name('codepoint');
Route::get('/codepoint', function () {
    return view('codepoint');
});

Route::get('/','TaskController@index')->name('home');

Route::get('/tasks/create', function () {
    return 'タスク新規登録';
})->name('task.new');

Route::get('/tasks/create', 'TaskController@create')->name('task.new');
Route::post('/tasks', 'TaskController@store')->name('task.submit');

Route::get('/tasks/{id}', 'TaskController@edit')->where('id', '[0-9]+')->name('task.edit');
Route::put('/tasks/{id}', 'TaskController@update')->where('id', '[0-9]+')->name('task.update');

Route::get('/tasks/{id}/status/{afterstatus}', 'TaskController@updateStatus')->where(['id'=>'[0-9]+','afterstatus'=> '[1-4]'])->name('task.updateStatus');

Route::get('/tabindex/{tabindex}', 'TaskController@index')->where('tabindex', '[1-4]')->name('tasklist');

Route::delete('/tasks/{id}', 'TaskController@destroy')->where('id', '[0-9]+')->name('task.delete');
