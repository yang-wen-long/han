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

//测试扩展名称
Route::get('/info', function () {
    phpinfo();
});

//后台管理方法
Route::get("/Login","Admin\IndexController@index");    //后台登录方法
Route::post("/desc/login","Admin\IndexController@login");    //后台登录方法
Route::get("/user/reg","Admin\IndexController@add");   //后台注册方法
Route::any("/user/registered","Admin\IndexController@registered");//后台注册方法
Route::any("/user/center","Admin\IndexController@center");   //后台成功登录的方法

//前台管理方法
Route::post("/Api/user/reg","Api\UserController@reg");   //前台注册的方法
Route::post("/Api/user/login","Api\UserController@login");   //前台登录的方法
Route::get("/Api/user/center","Api\UserController@center");   //前台登录成功



///usr/local/php/lib/php/extensions/no-debug-non-zts-20180731







//验签方法
Route::any("/redis","Admin\IndexController@redis");






Route::any("/time","Admin\IndexController@time");   //练习方法
