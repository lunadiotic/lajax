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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'], function (){
    Route::get('user', 'UserController@index')->name('user.index');
    Route::resource('product', 'ProductController');
    Route::resource('category', 'CategoryController');



    Route::group(['prefix' => 'api'], function() {
        Route::get('user/data', 'UserController@getUserData')->name('api.user.data');
        Route::get('product/data', 'ProductController@getProductData')->name('api.product.data');
        Route::get('category/data', 'CategoryController@apiData')->name('api.category.data');
    });

    Route::group(['prefix' => 'print'], function() {
        Route::get('product', 'ProductController@makePDF')->name('product.print');
        Route::get('product/barcode', 'ProductController@makeBarcode')->name('product.print.barcode');
    });

    Route::group(['prefix' => 'db'], function(){
        Route::get('product/', 'ProductController@imexport')->name('product.imexport');
        Route::post('product/import', 'ProductController@importProduct')->name('product.import');
        Route::get('product/export', 'ProductController@exportProduct')->name('product.export');
    });


});

Route::get('date', function() {
   echo indoDate(date('Y-m-d'));
});
