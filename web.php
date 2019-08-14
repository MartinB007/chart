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

Route::get('config_cache', function() {
$exitCode = Artisan::call('config:cache');
return 'Config Clear';
});
Route::get('/clear_cache', function() {
Artisan::call('cache:clear');
// return what you want
});

Route::get('/clear_view', function() {
Artisan::call('view:clear');
// return what you want
});

Route::get('/clear_config', function() {
Artisan::call('config:clear');
// return what you want
});
Route::group(['prefix' => 'admin'], function(){
Auth::routes();
Route::get('/', function(){
return redirect('admin/login');
});
});
//Route::get('/test', 'HomeController@test');
Route::group(['middleware' => 'auth','prefix' => 'admin'], function(){
Route::resource('setting','SettingController');
Route::get('settings/formedit','SettingController@editform');
Route::get('setting/update','SettingController@update');
Route::get('/', 'HomeController@check');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('category', 'CategoryController');
Route::post('category/getall', 'CategoryController@getall');
Route::resource('subcategory', 'SubcategoryController');
Route::post('subcategory/getall', 'SubcategoryController@getall');
Route::resource('question', 'QuestionController');
Route::post('question/getall', 'QuestionController@getall');
Route::resource('client', 'ClientController');
Route::get('application/{type}', 'ClientController@index');
Route::get('application/client/{type}', 'ClientController@show');
Route::post('client/getall', 'ClientController@getall');
Route::get('downloadpdf/{id}', 'ClientController@downloadpdf');
Route::get('application/downloadpdf/{id}', 'ClientController@downloadpdf');
Route::resource('email', 'EmailController');
Route::match(['get', 'post'], 'chart_details', 'HomeController@chartdetails');
Route::get('emailsetting', 'EmailController@index');
Route::post('question/update_status', 'QuestionController@update_status');
});

include_once 'front.php';
