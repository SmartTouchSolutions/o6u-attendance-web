<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthStudentController extends Controller
{

    public function loginGet() {
        return view('loginStudent');
    }


    public function loginPost(Request $request) {
        $validator = \Validator::make($request->all() , [
           'studentCode' => 'required|integer',
           'password' 	 => 'required'

        ])->validate();


        if(\Auth::guard('student')->attempt(['student_code' => $request->studentCode , 'password' => $request->password])) {
        	// return 'test';
        	return redirect('student/attendance');

        } else {
            \Session::flash('error', 'Code Or Password Is Invalid' );
            return back()->withInput();
        }

    }

    public function logoutStudent () {

        if(\Auth::guard('student')->check()) {

            \Auth::guard('student')->logout();
            return redirect(route('loginStudentGet'));

        } else {
            return redirect(route('loginStudentGet'));
        }

    }

}
