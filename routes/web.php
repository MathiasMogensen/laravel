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

Route::get('/', 'PagesController@index');

Route::get('/about', 'PagesController@about');
Route::get('/steam', 'PagesController@steamShow');
Route::get('/steam/login', 'PagesController@steam');
Route::get('/steam/logout', 'PagesController@steamLogout');

Route::get('/payment', 'PagesController@payment');
Route::get('/payment2', 'PagesController@payment2');
Route::get('/payment2/pay', 'PagesController@pay');

// Route::get('/users/{id}-{name}', function ($id, $name) {
//     return "".$id." ".$name;
// });

// Auto routes for resource controller
Route::resource('posts', 'PostsController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');