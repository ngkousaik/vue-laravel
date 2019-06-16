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
    return view('home');
});


Route::get('/gettasks',[
    'uses'=>'TaskController@getTasks',
    'as'=>'getTasks'
]);

Route::post('/addtask',[
    'uses'=>'TaskController@addTask',
   'as'=>'addTask'
]);
Route::post('/edittask',[
    'uses'=>'TaskController@editTask',
   'as'=>'addTask'
]);

Route::post('/deletetask',[
    'uses'=>'TaskController@deleteTask',
    'as'=>'deleteTask'
]);

Route::post('/loadtask',[
    'uses'=>'TaskController@fetchTaskData',
    'as'=>'fetchTaskData'
]);