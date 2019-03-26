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

// Route::get('/users/{id}-{name}', function ($id, $name) {
//     return "".$id." ".$name;
// });

// Auto routes for resource controller

Route::get('/', 'PagesController@index');

Route::get('/about', 'PagesController@about');

Route::get('/steam', 'SteamController@index');
Route::get('/steam/login', 'SteamController@login');
Route::get('/steam/logout', 'SteamController@logout');

Route::get('/payment', 'PagesController@payment');
Route::get('/payment2', 'PagesController@payment2');
Route::get('/payment2/pay', 'PagesController@pay');

// Can be used with php artisan make:controller PhotoController --resource
Route::resource('cms/posts', 'PostsController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');

Route::view('/cms/test', 'cms.test');