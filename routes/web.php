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

use App\Helpers\Helpers;
use App\User;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// TODO
Route::resource('/todos','TodoController',['except'=> ['create','show']]);
Route::put('/todo/{todo}/addCo', 'TodoController@addCoAdmin');
// Task
Route::resource('/todo/{todo}/tasks', 'TaskController',['except'=> ['create','show','destroy']]);
Route::post('/todo/{todo}/tasksuser', 'TaskController@addParticipant')->name('add_participant');
Route::delete('/todo/{todo}/tasksuser', 'TaskController@deleteParticipant')->name('delete_participant');
Route::delete('task/{task}', 'TaskController@destroy')->name('task.destroy');
Route::post('todo/type/{todo}','TaskController@check_todo_type')->name('todo.type');
// Sub_Task
Route::resource('/todo/{todo}/task/{task}/subs', 'SubTaskController',['except'=>['destroy','show','create']]);
Route::delete('/sub/{subTask}', 'SubTaskController@destroy')->name('subs.destroy');
Route::put('usub/{subTask}', 'SubTaskController@updateStatus')->name('subs.ustatus');
Route::post('/todo/{todo}/task/{task}/addSubTaskUser', 'SubTaskController@addParticipant')->name('sub_add_participant');
Route::delete('/todo/{todo}/task/{task}/delSubTaskUser', 'SubTaskController@deleteParticipant')->name('sub_delete_participant');
//checklist
Route::resource('/subtask/{subtask}/chklist', 'ChecklistController',['except'=>['destroy','update','create','show','edit']]);
Route::delete('checklist/{checklist}', 'ChecklistController@destroy');
Route::put('checklist/{checklist}','ChecklistController@update');
// Comment
Route::resource('/comment', 'CommentController',['except'=>['edit','show']]);

// Home Page
Route::get('/home', 'HomeController@index')->name('home');
// User
Route::post('/user/profile','UserController@add_friend');
Route::delete('user/profile/{friend}','UserController@remove_friend')->name('remove_friend');
Route::patch('/user/profie/name','UserController@updateName')->name('update_user_name');
Route::get('/user/profile', 'UserController@index')->name('profile')->middleware('auth');
//--------------
Route::get('change-password', 'ChangePasswordController@index');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
