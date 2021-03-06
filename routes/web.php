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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');

/**
 * 用户注册等
 */
Route::get('signup','UsersController@create')->name('signup');
Route::resource('users', 'UsersController');
/**
 * 上面RESTful 架构为用户资源生成路由，等同于下面七个路由
 */
//Route::get('/users', 'UsersController@index')->name('users.index');
//Route::get('/users/create', 'UsersController@create')->name('users.create');
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
//Route::post('/users', 'UsersController@store')->name('users.store');
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
//Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');

//登录页面，登录操作，退出操作
Route::get('login', 'SessionController@create')->name('login');
Route::post('login', 'SessionController@store')->name('login');
Route::delete('logout', 'SessionController@destroy')->name('logout');

//邮件发送路由
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

/**
 * 密码重置
 */
//显示重置密码的邮箱发送页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//给邮箱发送重设链接操作
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//显示密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


//微博相关操作-创建与删除
Route::resource('statuses','StatusesController',['only'=> ['store','destroy']]);

//显示用户关注人的列表页面
Route::get('/users/{user}/attentions', 'UsersController@attentions')->name('users.attentions');
//显示用户的粉丝列表页面
Route::get('/users/{user}/fans', 'UsersController@fans')->name('users.fans');

/**
 * 关注表单
 */
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');//关注用户
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');//取消关注
