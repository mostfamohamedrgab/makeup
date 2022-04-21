<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class BookingController extends Controller
{
    
	public function bookService(Request $request)
	{
		$rows = [
            'services' => 'required|array',
            'beauty_id' => 'required|exists:users,id',
	      ];

	     $messages = $this->validateReq($rows); // if it fail it will hundel the response 

	     if($messages !== true)
	     {
	        return $messages;
	     }

	     $buty = User::where('id',$request->beauty_id)->where('account_type','beauty_expert')->first();

	     if(!$buty)
	     {
	     	return $this->response([
	     		'message' => __('site.something getting wrong')
	     	]);
	     }

	     $buty_service = $buty->services;

	     $user = auth()->user();
	     $selected_services = $request->services;

	     foreach($selected_services as $service)
	     {
	     	if($buty_service AND !in_array($service,$buty_service->pluck('id')->toArray()))
	     	{
	     		return $this->response([
	     		'message' => __('site.the center doesnt have this service')
	     	]);
	     	}
	     }



	     
	}

}
