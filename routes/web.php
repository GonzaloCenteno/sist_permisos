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

Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::get('$',function(){ echo 0;});

Route::group(['namespace' => 'general'], function() 
{
    Route::get('/', 'Inicio_Controller@index');
    Route::resource('roles', 'Roles_Controller');
    Route::resource('usuarios', 'Usuarios_Controller');
});