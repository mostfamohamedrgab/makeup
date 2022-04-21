<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HelperTrait;
use App\Models\Category;
use Hash;

class UsersController extends Controller
{
    
    use HelperTrait;

    public function index()
    {
       $users = User::where(function ($qurey){

        $q = '';

        if(request()->has('search'))
        {
            $request = request()->except(['search']);
            
            foreach($request as $key => $val)
            {
                $q .= $qurey->orWhere($key,$val)->get();
            }

            return $q;
        }

       })->paginate(20);

       $usersCount = User::count();
       return view('admin.users.index',[
        'users' => $users,
        'usersCount' => $usersCount
       ]);
    }

    
    
    public function create()
    {
        
        return view('admin.users.create');
    }

  
    public function store(Request $request)
    {
      
        $data = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|max:20',
            'account_type' => 'required|in:user,beauty_expert',
            'image' => 'nullable|file',
            'is_active' => 'nullable'
        ]);


        if($request->hasFile('image'))
        {
            $data['image'] = uplode_user_image($request->image);
        }

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->is_active ? '1' : '0';

        User::create($data);
        return back()->with('success','created');
    }

    
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
            
        return view('admin.users.create',[
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
         $data = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|unique:users,phone,'.$user->id,
            'password' => 'nullable|max:20',
            'account_type' => 'required|in:user,beauty_expert',
            'image' => 'nullable|file',
            'is_active' => 'nullable'
        ]);




        if($request->hasFile('image'))
        {
            $data['image'] = uplode_user_image($request->image);
        }

        $data['password'] = $user->password;

        if($request->password)
        {
            $data['password'] = Hash::make($data['password']);
        }

        $data['is_active'] = $request->is_active ? '1' : '0';

        $user->update($data);
        return back()->with('success','created');
    }


    public function destroy(User $user)
    {
        // need to preapre logic frist
    }

    public function swith (User $user)
    {   
       
        $user->update([
            'is_active' =>  $user->is_active ? '0' : '1'
        ]);

        return back()->withSuccess('status changed');
    }
}
