<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public function index()
    {
        $rows = Slider::all();
        return view('admin.sliders.index',[
          'rows' => $rows
        ]);
    }

  
    public function store(Request $request)
    {
      $data = $request->validate([
        'image' => 'required|image'
      ]);

      $data['image'] = uplode_file($request->image);

      Slider::create($data);
      return back()->withSuccess('تم الاضافه بنجاح');
    }

  
    public function update(Request $request,  $slider)
    {
      $slider = Slider::findOrFail($slider);
      $data = $request->validate([
        'image' => 'required|image'
      ]);

      if($request->hasFile('image'))
      {
        delete_file($slider->image);
        $data['image'] = uplode_file($request->image);
      }


      $slider->update($data);
      return back()->withSuccess('success operation');
    }

    public function destroy( $id)
    {
      $slider = Slider::findOrFail($id);
      delete_file($slider->image);
      $slider->delete();
      return back()->withSuccess('success operation');
    }
}
