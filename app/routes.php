<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/test','GeneralTestController@test');
Route::group(['prefix' => '/admin', 'before' => 'mediaIpChk|adminAuth'], function ($route) {
    // login
    $route->get('/', 'AdminTopController@getIndex');
    
    // xyz
    //$router->controller('/xyz', 'XYZController', ['only' => ['index', 'up-edit', 'new-edit', 'update']]);
    
});

// 管理画面ログイン(セッションチェック無)
Route::get('/admin', ['as' => 'admin', 'before' => 'mediaIpChk', 'uses' => 'AdminLoginController@getIndex']);
Route::post('/admin/login', ['before' => 'mediaIpChk', 'uses' => 'AdminLoginController@postLogin']);