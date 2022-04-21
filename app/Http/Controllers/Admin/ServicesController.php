<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $rows = Service::all();
        $services = Service::all();

        return view('admin.services.index',[
          'rows' => $rows,
          'services' => $services
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
          'name_ar' => 'required',
          'name_en' => 'required',
          'parent_id' => 'nullable',
          'image' => 'required'
        ]);

        $data['image'] = uplode_file($request->image);

        Service::create($data);
        return back()->withSuccess('created');
    }


    public function update(Request $request,  $id)
    {
      $service = Service::findOrFail($id);

      $data = $request->validate([
        'name_ar' => 'required',
        'name_en' => 'required',
        'parent_id' => 'nullable',
        'image' => 'required'
      ]);

      if($request->hasFile('image'))
      {
        delete_file($service->image);
        $data['image'] = uplode_file($request->image);
      }

      $service->update($data);
      return back()->withSuccess('updated');
    }


    public function destroy( $id)
    {
        $service = Service::findOrFail($id);
        delete_file($service->image);
        $service->delete();
        return back()->withSuccess('deleted');
    }
}
