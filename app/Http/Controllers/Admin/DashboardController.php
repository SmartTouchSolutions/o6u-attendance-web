<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('SuperAdmin');
//    }

    public function soon() { // if Not SuperAdmin
        return view('admin.soon');
    }

    public function dashboard() { // if SuperAdmin
        return view('admin.dashboard');
    }

}
