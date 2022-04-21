<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adress;
use Illuminate\Http\Request;

class AdreesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response([
            'address' => auth()->user()->address
        ]);
    }

   
    public function store(Request $request)
    {
        $request = request();
          $rows = [
            'location' => 'required',
            'street_number' => 'required',
            'building_number' => 'required',
            'floor_number' => 'required',
            'apartment_number' => 'required',
            'phone_number' => 'required',
          ];

         $messages = $this->validateReq($rows); // if it fail it will hundel the response 

         if($messages !== true)
         {
            return $messages;
         }

         $rows['user_id'] = auth()->id();

         Adress::create([
            'location' => $request->location,
            'street_number' => $request->street_number,
            'building_number' => $request->building_number,
            'floor_number' => $request->floor_number,
            'apartment_number' => $request->apartment_number,
            'phone_number' => $request->phone_number,
          ]);

         return response([
            'message_ar' => 'تم أنشاء العنوان بنجاح',
            'message_en' => 'address created successfully',
         ]);
    }

    
    public function update(Request $request,  $adress)
    {
        $adress = Adress::find($adress);

        if(auth()->id() != $adress->user_id)
        {
            return $this->notAllowed();
        }

        $request = request();
          $rows = [
            'location' => 'required',
            'street_number' => 'required',
            'building_number' => 'required',
            'floor_number' => 'required',
            'apartment_number' => 'required',
            'phone_number' => 'required',
          ];

         $messages = $this->validateReq($rows); // if it fail it will hundel the response 

         if($messages !== true)
         {
            return $messages;
         }



         $adress->update([
            'location' => $request->location,
            'street_number' => $request->street_number,
            'building_number' => $request->building_number,
            'floor_number' => $request->floor_number,
            'apartment_number' => $request->apartment_number,
            'phone_number' => $request->phone_number,
          ]);

         return response([
            'message_ar' => 'تم تعديل العنوان بنجاح',
            'message_en' => 'address updated successfully',
         ]);
    }

   
    public function destroy( $adress)
    {
        $adress = Adress::find($adress);
        if(auth()->id() != $adress->user_id)
        {
            return $this->notAllowed();
        }
        $adress->delete();
         return response([
            'message_ar' => "تم الحذف بنجاح",
            'message_en' => 'address deleted',
         ]);
    }
}
