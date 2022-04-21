<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Category;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $adminsCount = Admin::count();
        $usersCount = User::count();
        $categoriesCount = Category::count();

        return view('admin.index',[
            'adminsCount' => $adminsCount,
            'usersCount' => $usersCount,
            'categoriesCount' => $categoriesCount
        ]);
    }
}
