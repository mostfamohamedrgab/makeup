<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
   
    public function index()
    {
        $coupons = Coupon::paginate(20);

        return view('admin.coupons.index',[
            'coupons' => $coupons
        ]); 
    }

   
    public function store(Request $request)
    {   
        $data = $request->validate([
          "code" => "required|max:100",
          "type" => "required|in:fixed,percentage",
          "price_discount" => "required_if:type,==,price",
          "percentage_discount" => "required_if:type,==,percentage|integer|between:1,100",
          "start_at" => "required",
          "end_at" => "required",
        ]);

        if($request->price_discount)
        {
            $data['discount'] = $request->price_discount;
        }else {
            $data['discount'] = $request->percentage_discount;
        }
         unset($data['price_discount']);
         unset($data['percentage_discount']);


   
        Coupon::create($data);
        return back()->withSuccess('succsufly created ..');
    }

    public function show(Coupon $coupon)
    {
        //
    }

    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->withSuccess('deleted succsufly');   
    }
}
