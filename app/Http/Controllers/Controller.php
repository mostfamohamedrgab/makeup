<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



     public function validateReq($rows)
    {
      $validator = \Validator::make(request()->all(), $rows);

      if($validator->fails())
      {
           $messages = $validator->getMessageBag();
           return $this->response($messages,false);
      }
      return true;
    }


    public function response($data,$status = true)
    {
      $code = 200;
    	if($status == false)
    	{
    		http_response_code(400);
        $code = 400;
    	}

    	return response()->json($data,$code);
    }	
      

    public function notAllowed()
    {
      return $this->response([
        'message_ar' => "ليس لديك صلاحية لاتخاذ الاجراء ",
        'message_en'  => 'you are not allowed to make this action'
      ],false);
    }


}
