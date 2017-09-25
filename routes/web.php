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
    return view('welcome');
});

/**
 * www
 */
Route::group(['domain'=>'www.lakegouwu.cn','namespace'=>'Www'],function(){
	// 用户信息 ,userinfo
	Route::get('userinfo/{id}', ['uses'=>'User@info','as'=>'userinfo'])->where('id','[0-9]+');
});

/**
 * Wechat
 */
Route::group(['domain'=>'wx.lakegouwu.cn','namespace'=>'Wechat'],function(){
	// 用户信息 ,userinfo
	Route::get('userinfo', ['uses'=>'User@info','as'=>'userinfo']);

	// 用户注册
	Route::get('register', ['uses'=>'Wechat@register','as'=>'register']);

	// 用户注册
	Route::get('login', ['uses'=>'Wechat@login','as'=>'login']);

	// 用户注册
	Route::get('callback', ['uses'=>'Wechat@callback','as'=>'callback']);
});