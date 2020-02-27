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

//使用者
Route::group(['prefix' => 'user'], function(){
    //使用者驗證
    Route::group(['prefix' => 'auth'], function(){
        // 註冊頁面
        Route::get('/register', 'Auth\RegisterController@registerPage')->name('registerPage');
        Route::post('/register', 'Auth\RegisterController@registerProcess')->name('doRegister');        
        // 登入頁面
        Route::get('/login', 'Auth\LoginController@loginPage')->name('loginPage');
        Route::post('/login', 'Auth\LoginController@loginProcess')->name('doLogin');
        Route::get('/sign-out', 'Auth\LoginController@signOut')->name('sign-out');
    });
});

// 首頁
Route::get('/', function () {
    return view('frontend.index');
})->name('homepage');

// 暫放頁
Route::get('about', function(){
    return view('frontend.about');
})->name('about');

Route::get('products', function(){
    return view('frontend.products');
})->name('products');

Route::get('store', function(){
    return view('frontend.store');
})->name('store');

