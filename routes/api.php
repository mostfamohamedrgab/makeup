<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//************** Accounts Area & user area 
Route::post('accounts/store','AccountsController@store');
Route::post('accounts/phone','AccountsController@phone');
Route::post('login','AuthController@login');
//********* End accounts area 
/********** Reset Password ***************/
Route::post('reset-password-request','AccountsController@request_reset_password');
Route::post('reset-password-code','AccountsController@reset_password_code');
Route::post('reset-password','AccountsController@reset_password_code');
/**************** END RESET PASSWORD ************/

/************** DATE *****/
Route::resource('services','ServicesController'); // services 
Route::get('home','PagesController@index'); // homepage 
Route::post('filter-beauty-expert','PagesController@filter_buty'); // filter buty exper [ search ]
Route::get('categories/{search?}','CategoriesContoller@index'); // categories with nullable search - filter 
Route::get('beauty/{user}','PagesController@beauty'); // categories with nullable search - filter 
/************** DATA *****/



Route::group([
    'middleware' => 'auth:api'
], function ($router) {
	/************* Profile Area *******************/
	    Route::post('logout', 'AuthController@logout');
	    Route::post('refresh', 'AuthController@refresh');
	    Route::post('me', 'AuthController@me');
	    Route::get('profile','ProfileController@index');
	    Route::post('update-profile','ProfileController@update');


	    /* can be in customar middleware */
	    Route::post('book-service','BookingController@bookService');

	    Route::group(['middleware' => 'beautyexpert'],function (){
	    	Route::post('beauty-expert/schedule/store','ProfileController@scheduleStore');
	    	Route::post('beauty-expert/services/store','ProfileController@servicesStore');
	    	Route::post('beauty-expert/gallery/store','ProfileController@galleryStore');
	    });

    /********** End Profile Area *******/

    /************** address *****/
    Route::resource('address','AdreesController');
    





    
});




Route::get('code', 'AccountsController@test');