<?php 

namespace App\Traits;
use App\Models\Coupon;

trait HelperTrait  
{	

  	public function sendSms($phone,$msg)
  	{
  		return true;
  	}

  	public function rendomNumber($count = 4)
  	{
  	 	$min = pow(10, $count - 1);
  	    $max = pow(10, $count) - 1;
  	    return mt_rand($min, $max);
  	}

	

    // get the price and check code then apply the code 
    public function apply_code($coupon,$totalPrice = null,$false_response = true)
    {
      // search if code exsist 
      $coupon = Coupon::where('code',$coupon)->first();

      if($false_response)
      {
        if(!$coupon)
       {
          return $this->response([
            'message_ar' => 'الكود غير صحيح',
            'messge_en' => 'wrong code',
          ],false);
        }
      }


      if($coupon->type == 'percentage')
      {
        $totalPrice = $totalPrice * ((100-$coupon->discount) / 100);
      }else{
        $totalPrice = $totalPrice - $coupon->discount;
      }


      return $totalPrice;

    }
}