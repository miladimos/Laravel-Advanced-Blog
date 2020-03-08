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
//
//Route::get('/tredis', function () {
////    $key = \Illuminate\Support\Facades\Cache::get('testkey');
//    if(\Illuminate\Support\Facades\Redis::has('testkey')) {
//        return "has ";
//    }
//    return "no";
//});
Route::redirect("/", '/en');

Route::group(['prefix'=>'{language}'], function() {
    Auth::routes();
    Route::group(['namespace'=>'Home'], function(){
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/tredis', 'HomeController@tredis');
        Route::get('/article/{article}', 'HomeController@articleSingle')->name('article.single');
    });
});



Route::group(['namespace'=>'Admin', 'prefix'=>'dashboard', 'middleware'=>'is.admin'], function(){
    Route::get('/', 'AdminController@index')->name('dashboard.index');

    Route::get('/article/trashed', 'ArticleController@trashed')->name('article.trashed');
    Route::delete('/article/trashed/{id}', 'ArticleController@restore')->name('article.restore');
    Route::delete('/article/trashed/{id}/fdelete', 'ArticleController@fdestroy')->name('article.fdestroy');
    Route::resource('article', 'ArticleController');

    Route::resource('category', 'CategoryController');
    Route::resource('tag', 'TagController');

    Route::get('/user/role', 'UserController@role')->name('user.role');
    Route::post('/user/role', 'UserController@storerole')->name('user.role.store');
    Route::get('/user/admins', 'UserController@admins')->name('user.admins');
    Route::resource('user', 'UserController');

    Route::resource('permission', 'PermissionController');
    Route::resource('role', 'RoleController');
});