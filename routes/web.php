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

// 使用者
Route::group(['prefix' => 'user'], function(){
    // 使用者驗證相關
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
Route::get('/', 'HomepageController@listHomepage')->name('homepage');

// 商品頁面
Route::group(['prefix' => 'merchandise'], function(){
    //商品清單檢視
    Route::get('/', 'MerchandiseController@merchandiseListPage')->name('listMerchandise');
    //商品資料新增
    Route::get('/create', 'MerchandiseController@merchandiseCreateProcess')->name('createMerchandise');
    //商品管理清單檢視
    Route::get('/manage', 'MerchandiseController@merchandiseManageListPage')->name('manageMerchandise');
    //指定商品
    Route::group(['prefix' => '{merchandise_id}'], function(){
        //商品單品檢視
        Route::get('/', 'MerchandiseController@merchandiseItemPage');
        //商品單品編輯頁面檢視
        Route::get('/edit', 'MerchandiseController@merchandiseItemEditPage');
        //商品單品資料修改
        Route::put('/', 'MerchandiseController@merchandiseItemUpdateProcess');
        //購買商品
        Route::post('/buy', 'MerchandiseController@merchandiseItemBuyProcess');
    });
});

//交易
Route::get('/transaction', 'TransactionController@transactionListPage');



