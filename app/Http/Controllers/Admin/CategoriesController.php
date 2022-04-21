<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        $rows = Category::all();
        $categories = Category::all();

        return view('admin.categories.index',[
          'rows' => $rows,
          'categories' => $categories
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
          'name_ar' => 'required',
          'name_en' => 'required',
          'parent_id' => 'nullable',
          'image' => 'required|image'
        ]);

        $data['image'] = uplode_file($request->image);

        Category::create($data);
        return back()->withSuccess('created');
    }


    public function update(Request $request,  $id)
    {
      $Category = Category::findOrFail($id);

      $data = $request->validate([
        'name_ar' => 'required',
        'name_en' => 'required',
        'parent_id' => 'nullable',
        'image' => 'nullable|nullable'
      ]);

      if($request->hasFile('image'))
      {
        delete_file($Category->image);
        $data['image'] = uplode_file($request->image);
      }

      $Category->update($data);
      return back()->withSuccess('updated');
    }


    public function destroy( $id)
    {
        $Category = Category::findOrFail($id);
        delete_file($Category->image);
        $Category->delete();
        return back()->withSuccess('deleted');
    }
}
