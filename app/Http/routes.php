<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('sale', 'SaleController@sale')->name('sale');
    Route::post('sale', 'SaleController@saveSale')->name('sale');
    Route::get('my-sell', 'SaleController@mySell')->name('my-sell');
    Route::delete('remove/{id}', 'SaleController@remove');
    Route::get('update/{id}', 'SaleController@update');
    Route::get('buy/{id}', 'SaleController@buy')->name('buy');
    Route::get('buy/confirm/{id}', 'SaleController@buyConfirm')->name('buy-confirm');
    Route::get('purchases', 'SaleController@purchases')->name('purchases');
    Route::get('sold', 'SaleController@sold')->name('sold');
    Route::get('order/remove/{id}', 'SaleController@removeOrder')->name('remove-order');
    Route::get('price/{appid}', 'SaleController@price')->name('price');

    Route::get('consent', 'HomeController@consent');
    Route::get('json/{phrase}', 'HomeController@json');
    Route::get('show/{id}', 'HomeController@showDeal')->name('show');
    Route::get('i-see-what-you-did-there', 'HomeController@ICU')->name('ICU');
    Route::get('search/{appid}/{slug}', 'HomeController@search')->name('search');
    Route::post('user/save', 'HomeController@save')->name('user-save');
    Route::get('regulamin', 'HomeController@regulamin')->name('regulamin');

    Route::get('profil', 'ProfilController@profil')->name('profil');
    Route::get('show/profil/{id}', 'ProfilController@showProfil')->name('show-profil');

    Route::get('steam', 'AuthController@login')->name('steam');
    Route::get('logout', 'AuthController@logout')->name('logout');

    Route::get('admin', 'AdminController@index')->name('admin');
    Route::get('admin/games', 'AdminController@games')->name('games');
    Route::delete('admin/games/remove/{appid}', 'AdminController@remove');
    Route::post('admin/add', 'AdminController@add')->name('add');
    Route::get('admin/users', 'AdminController@users')->name('users');
    Route::get('admin/user/{steamid}', 'AdminController@user')->name('user');
    Route::post('user/update/{steamid}', 'AdminController@userUpdate')->name('user-update');

    Route::get('message', 'MessageController@message')->name('message');
    Route::post('message/save', 'MessageController@save')->name('message-send');
    Route::get('message/{key}', 'MessageController@showMessage')->name('show-message');

    Route::get('my-opinions', 'OpinionController@myOpinions')->name('my-opinions');
    Route::get('opinions/{id}', 'OpinionController@opinions')->name('opinions');
    Route::get('opinion/add/{userID}/{saleID}', 'OpinionController@add')->name('add-opinion');
    Route::post('opinions/save', 'OpinionController@save')->name('save-opinions');

    Route::post('report/save', 'ReportController@save')->name('save-report');

});
