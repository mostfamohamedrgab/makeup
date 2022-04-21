<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Hash;

class AdminsController extends Controller
{
    
    public function index()
    {
        $admins = Admin::paginate(20);
        return view('admin.admins.index',[
            'admins' => $admins
        ]);
    }

  
    public function create()
    {
        return view('admin.admins.create');
    }

   
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:admins,email',
            'password' => 'required|max:20'
        ]);

        $data['password'] = Hash::make($data['password']);

        Admin::create($data);
        return back()->with('success','created');
    }

   
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {   
       return view('admin.admins.create',[
           'admin' => $admin
       ]);
    }

    
    public function update(Request $request, Admin $admin)
    {
        $date = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:admins,email,'.$admin->id,
            'password' => 'sometimes|required|max:20'
        ]);

         $data['password'] = $admin->password;  
        if($data['password'])
        {
            $data['password'] = Hash::make($data['password']);
        }


        $admin->update($data);
        return back()->with('success','updated');
    }

   
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return back()->with('success','deleted');
    }
}
