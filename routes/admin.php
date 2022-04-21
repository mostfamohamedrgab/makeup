<?php

use Illuminate\Support\Facades\Route;




//** Must Be Not Login As A Admin *****//
Route::group(['middleware' => 'guest:admin'], function (){
    Route::get('dashboard','AuthController@showLogin')->name('admin.showlogin');
    Route::post('dashboard/login','AuthController@login')->name('admin.login');
  });



// auth 
Route::group(['prefix' => 'dashboard','as' => 'admin.','middleware' => 'auth:admin'], function (){
  
  Route::get('admin','HomeController@index');
  
  Route::resources([
    'admins' => 'AdminsController',
    'categories' => 'CategoriesController',
    'users' => 'UsersController',
    'coupons' => 'CouponsController',
    'services' => 'ServicesController',
    'sliders' => 'SliderController',
  ]);

  // switch user status 
  Route::get('users/{user}/swith','UsersController@swith')->name('users.swith');


  

  Route::post('logout','AuthController@logout')->name('logout');

});