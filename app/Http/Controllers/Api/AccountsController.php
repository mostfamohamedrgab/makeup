<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\HelperTrait;
use App\Models\ConfirmPhone;
use Hash;
use DB;
use Carbon\Carbon;

class AccountsController extends Controller
{
    use HelperTrait;

    // 1 - reseve phone -> send otp_number 
    // 2 - reseve phone & otp_to_confirm is it true 
    public function phone()
    {
          $request = request();
          $rows = [
            'phone' => 'required',
            'otp_number' => 'nullable',
            'account_type' => 'required|in:user,beauty_expert'
          ];

         $messages = $this->validateReq($rows); // if it fail it will hundel the response 

         if($messages !== true)
         {
            return $messages;
         }

         $phone = $request->phone;

         // check if phone not exsist in the user and he is not active 
         $user = User::where('phone',$request->phone)->where('is_active','1')->count();


         if($user)
         {
            return $this->response([
                    'messge' => 'account exsist and active'
                ],false);
         }

         /********** START CHECK OTP_NUMBER *****************/
         if($phone && $request->otp_number)
         {  
            $check = ConfirmPhone::where('phone',$phone)
                                ->where('otp_number',$request->otp_number)->first();

            if($check)
            {   
                // delete confirm opt
                $check->delete();
                // create account and be ready to reseve the rest of user information 
                User::create([
                    'phone' => $request->phone,
                    'account_type' => $request->account_type
                ]);

                return $this->response([
                    'messge' => 'otp number is correct'
                ]);
            }else{
                return $this->response([
                    'messages' => 'wrong otp number'
                ],false);
            }
         }
         /********** END CHECK OTP_NUMBER *****************/

         // create new request to confrim mobile 
         $otpNumber = $this->rendomNumber();
         // send sms 
         $smsMsg = 'hi you can confirm your number by enter the number '.$otpNumber;
         $this->sendSms($phone,$smsMsg);

         ConfirmPhone::create([
            'phone' => $phone,
            'otp_number' => $otpNumber
         ]);

         return $this->response([
            'messge' => 'messge sent',
            'otp_number' => $otpNumber
         ]);
    }   

    /************* CREATE NEW ACCOUNT ***********/
   public function store()
   {    
    
      $request = request();

      $rows = [
        'phone' => 'required',
        'account_type' => 'required|in:user,beauty_expert',
        'name' => 'required',
        'password' => 'required|min:8|max:20',
        'location' => 'required_if:account_type,==,beauty_expert',
        'categories' => 'required_if:account_type,==,beauty_expert',
      ];

     $messages = $this->validateReq($rows); // if it fail it will hundel the response 

     if($messages !== true)
     {
        return $messages;
     }
        


     // check if user phone exsist 
     $user = User::where('phone',$request->phone)
                        ->first();

     if($user AND $user->is_active)
     {
        return $this->response([
            'messge' => 'something went wrong , account activated before or phone not found'
        ],false);
     }  

     if($request->hasFile('licenses'))
     {
       $data['licenses'] = uplode_file($request->licenses);
     }

      $user->update([
        'name' => $request->name,
        'password' => Hash::make($request->password),
        'is_active' => '1',
        'location' => $request->location,
     ]);

     if($user->account_type == 'beauty_expert' && $request->categories)
     {      
        $user->categories()->detach();

        foreach($request->categories as $categoreyID)
        {
            $categoreyCount = Category::where('id',$categoreyID)->count();
            if($categoreyCount){
                 $user->categories()->attach($categoreyID);
            }
        }
     }

        
     return response([
        'messge' => 'account created',
        'user' => $user
     ]);
   }
   /***** END CREATE NEW ACCOUNT **************/


   /*** [1] reset password ********/
   public function request_reset_password()
  {
    $rows = [
      'phone' => 'required|exists:users,phone',
    ];

    $messages = $this->validateReq($rows);

    if($messages !== true)
    {
      return $messages;
    }

    $user = User::where('phone',request()->phone)->first();

    if(!$user) // check if user not exist !
    {
      return $this->response(false,[
        'message_ar' => 'الحساب غير موجود',
        'message_en' => 'account not found',
      ],400);
    }


    
    $code = $this->rendomNumber();
    $phone = $user->phone;

    // delete old requests
    DB::table('password_resets')->where('email',$phone)->delete();
    // create new password_reset


    DB::table('password_resets')->insert([
        'email' => $phone,
        'token' => $code,
        'created_at' => Carbon::now()
    ]);

    
    $msg = 'your code to change password is '.$code;
    
    if(!$this->sendSms($phone,$msg))
    {
         return $this->response([
          'message_ar' => 'خطأ في ارسال الرساله',
          'message_en' => 'feild to send sms messge',
        ],false); 
    }   

    return $this->response([
      'message_ar' => 'تم إرسال كود تغيير كلمة السر بنجاح',
      'message_en' => 'Password change code has been sent successfully',
      'code' => $code
    ]);
  }
  /********** END STEP_ONE REQUEST RESET_PASSWORD *******************/

  /******** 2 - check reset password code ****************/
    /************ 3- if there is password mean he checked the code alread *********/ 
  public function reset_password_code ()
  {
    $rows = [
      'phone' => 'required|exists:users,phone',
      'code' => 'required',
      'password' => 'nullable|min:8|max:20'
    ];

    $messages = $this->validateReq($rows);

    if($messages !== true)
    {
      return $messages;
    }

    $phone = request()->phone;

    $user = User::where('phone',$phone)->first();
    $user_password_reset = DB::table('password_resets')->where('email',$phone)->first();
    // check if user doesnt ask to chage password
    if(!$user_password_reset)
    {
      return $this->response([
        'message_ar' => 'لايوجد طلب لتغيير كلمة السر',
        'message_en' => 'There is no request to change the password',
      ],false);
    }

    // check code send and password_resets code
    if($user_password_reset->token != request()->code)
    {
      return $this->response([
        'message_ar' => 'الكود غير صحيح',
        'message_en' => 'The code is incorrect',
      ],false);
    }



    // #step 3
    if(request()->has('password'))
    {

      $user->update([
        'password' => Hash::make(request()->password),
      ]);

      DB::table('password_resets')->where('email',request()->phone)->delete();

      return $this->response([
        'message_ar' => 'تم تغيير كلمة السر بنجاح',
        'message_en' => 'Password changed successfully',
      ]);

    }else{
      return $this->response([
        'message_ar' => 'أدخل كلمة السر الجديدة',
        'message_en' => 'Enter the new password',
      ]);
    }
  }


  public function test()
  {
    return $this->apply_code('free_20',100);
  }


}
