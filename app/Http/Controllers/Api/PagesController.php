<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use App\Models\Slider;

class PagesController extends Controller
{
    public function index()
    {
    	$services = Service::all();

    	foreach($services as $service)
    	{
    		$service->image = files_path($service->image);
    	}


    	$beautyExperts  = User::where('account_type','beauty_expert')->get();  

    	foreach($beautyExperts as $user)
    	{
    		$user->image = files_path($user->image);
    	}

        $sliders = Slider::all();

        foreach($sliders as $slider)
        {
            $slider->image = files_path($slider->image);
        }

    	return $this->response([
    		'services' => $services,
    		'beautyExperts' => $beautyExperts,
            'sliders' => $sliders,
    	]);
    }

    public function filter_buty(Request $request)
    {


        $users = User::where(function ($q) use ($request) {

            $query = '';

            if($request->has('name'))
            {
                $query .= $q->where('name','LIKE','%'.$request->name.'%')->get();
            }

            if($request->has('location'))
            {
                $query .= $q->where('location',$request->location)->get();
            }    

            return $query;
        })->where('account_type','beauty_expert')->get();

        foreach($users as $user)
        {
            $user->image = files_path($user->image);
        }


        return $this->response([
            'users' => $users,
            'resultsCount' => count($users)
        ]);
    }

    // beauty
    public function beauty( $user)
    {   
        $user = User::where('id',$user)->first();

        if(!$user Or $user->account_type != 'beauty_expert')
        {
            return $this->response([
                'success' => false,
                'messge' => __('site.something getting wrong')
            ],false);
        }


        $user->image = files_path($user->image);
        $user->services = $user->services;
        $user->categories = $user->categories;
       

        foreach($user->gallerey as $image)
        {
            $image->image = files_path($image->image);
        }
    
        return $user;
    }

}
