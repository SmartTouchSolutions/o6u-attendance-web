<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginGet() {
        return view('login');
    }

    public function loginPost(Request $request) {
        $validator = \Validator::make($request->all() , [
           'username' => 'required',
           'password' => 'required'

        ])->validate();

        if(Auth::attempt(['username' => $request->username , 'password' => $request->password])) {
            $type = Auth::user()->type;
//            dd($type);
            if($type == 'superAdmin') { // admin
                return redirect('dashboard');
            } elseif($type == 'doctor') { // doctor
                return redirect('/soon');
            } elseif($type == 'teachingAssistant') { // teacherAssistant
                return redirect('/soon');
            } else {
                return 'error Type';
            }
        } else {
            \Session::flash('error', 'Username Or Password Is Invalid' );
            return back()->withInput();
        }

    }

    public function logout () {

        if(\Auth::check()) {

            \Auth::logout();
            return redirect('/');

        } else {
            return redirect('/');

        }

    }
}
