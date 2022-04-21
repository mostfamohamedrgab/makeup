<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BeautyGallery;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Hash;

class ProfileController extends Controller
{
  
    public function index()
    {
        return $this->response(auth()->user());
    }

  
    public function update(Request $request)
    {      
          $user = User::findOrFail(auth()->id());
          $password =  $user->getAuthPassword();

          $rows = [
            'name' => 'required',
            'password' => 'nullable|min:8|max:20',
          ];

         $messages = $this->validateReq($rows); // if it fail it will hundel the response 

         if($messages !== true)
         {
            return $messages;
         }

         $password = $request->has('password') ? Hash::make($request->password) : $password;

        
       $user->update([
            'password' => $password,
            'name' => $request->name
         ]);
       return $user;
    }

  
  /**************** add schedule to Buty *********/

   public function scheduleStore(Request $request)
   {

      $rows = [
            'days' => 'required|array',
            'times' => 'required|array',
      ];

     $messages = $this->validateReq($rows); // if it fail it will hundel the response 

     if($messages !== true)
     {
        return $messages;
     }

     $days = $request->days;
     $times = $request->times;


     if(count($days) != count($times))
     {
      return $this->response([
        'messge' => __('site.somting geeting worng ')
      ]);
     }


     foreach($days as $index => $day)
     {
        $day_times = $times[$index];

    
        foreach($day_times as $time)
        { 
          $checkDay = Schedule::where('day',$day)
                                ->where('time',$time)
                                ->where('user_id',auth()->id())
                                ->count();

          if(!$checkDay)
          {
              Schedule::create([
                'day' => $day,
                'time' => $time,
                'user_id' => auth()->id()
              ]); 
          }
           
        }
      }  
       

       return $this->response([
        'messge' => __('site.success operation')
       ]);
   }  



   /****************** Add service to buty ***************/

   public function servicesStore(Request $request)
   {
       
        $rows = [
            'services' => 'required|array',
        ];

       $messages = $this->validateReq($rows); // if it fail it will hundel the response 

       if($messages !== true)
       {
          return $messages;
       }

       auth()->user()->services()->detach();
       
       foreach($request->services as $service)
       {
          auth()->user()->services()->attach($service['service_id'],[
            'price' => $service['price'],
            'time' => $service['time']
          ]);
       }

       return response()->json([
        'messge' => __('site.success operation')
       ]);
   }


    public function galleryStore(Request $request)
    {
        $rows = [
           'images' => 'required|array|file|image',
        ];

       $messages = $this->validateReq($rows); // if it fail it will hundel the response 

       if($messages !== true)
       {
          return $messages;
       }


      foreach($request->file('images') as $image)
      {
          $data['image'] = uplode_file($image);
          $data['user_id'] = auth()->id();
          BeautyGallery::create($data);
      }


      return $this->response([
        'messge' => __('site.success operation')
      ]); 
    }

}
