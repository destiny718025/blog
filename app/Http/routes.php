<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
    Route::get('/', 'Home\IndexController@index');
    Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
    Route::get('/a/{art_id}', 'Home\IndexController@article');
    
    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
    
    Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
        Route::get('/', 'IndexController@index');
        Route::get('info', 'IndexController@info');
        Route::get('quit', 'IndexController@quit');
        Route::post('cate/changeorder', 'CategoryController@changeOrder');
        Route::resource('category', 'CategoryController');
        Route::resource('article', 'ArticleController');
        Route::any('upload', 'CommonController@upload');
        Route::resource('links', 'LinksController');
        Route::post('links/changeorder', 'LinksController@changeOrder');
        Route::resource('navs', 'NavsController');
        Route::post('navs/changeorder', 'NavsController@changeOrder');
        Route::get('config/putfile', 'ConfigController@putFile');
        Route::resource('config', 'ConfigController');
        Route::post('config/changecontent', 'ConfigController@changeContent');
        Route::post('config/changeorder', 'ConfigController@changeOrder');
    });
    
