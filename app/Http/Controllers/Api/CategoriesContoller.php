<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesContoller extends Controller
{
 
    public function index($search = null)
    {
        
        $sections = Category::where(function ($qurey) use($search){
            $q = '';

            if($search)
            {
                $q .=  $qurey->where('name_ar','LIKE','%'.$search.'%')
                        ->orWhere('name_en','LIKE','%'.$search.'%')->get();    
            }

            if(Request()->has('parent_id'))
            {
                $q .= $qurey->where('parent_id',Request()->get('parent_id'))->get();
            }
            
        })->get();


        foreach($sections as $section)
        {
            $section->image = files_path($section->image);
        }   
        
        $sections = ['sections' => $sections];

        return $this->response($sections);
    }

}
