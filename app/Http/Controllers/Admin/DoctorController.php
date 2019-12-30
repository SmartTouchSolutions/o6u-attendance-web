<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Subject;
use App\Subject_User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allDoctors = User::where('type' , 'doctor')->when($request->search , function($que) use ($request) {
            $que->where('username' , 'LIKE' , '%'.$request->search.'%');
        })->select('id','name' , 'username' , 'email' , 'created_at')->orderBy('id' , 'DESC')->paginate(3);

        return view('admin.doctor.index' , ['allDoctors' => $allDoctors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allSubjects = Subject::get(['id','name']);
        return view('admin.doctor.create' , ['allSubjects' => $allSubjects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all() , [

            'username'              => 'required|unique:users,username',
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'nullable',            
            'subjects'              => 'required|array',


        ])->validate();

        $insertDoctor = User::create([
            'username'  => $request->username,
            'name'      => $request->name,
            'email'     => $request->email,
            'type'      => 'doctor',
            'password'  => $request->password
        ]);

        // Start Add User To Subject 
        foreach($request->subjects as $subject) {
            $theSubject = \DB::table('subject_users')->where('subject_id',$subject)->first();
            if($theSubject) {
                $usersIDS = $theSubject->users_id.','.$insertDoctor->id;
                \DB::table('subject_users')->where('subject_id',$subject)->update(['users_id' => $usersIDS]);
            } else {
                Subject_User::create([
                    'users_id' => $insertDoctor->id,
                    'subject_id' => $subject

                ]);
            }
        }
        \Session::flash('success' , 'Record Created Success');
        return redirect('doctor');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $doctorDetails = User::find($id);
        $doctorSubjects = \DB::table('subject_users')->where('users_id' , 'LIKE' , '%'.$id.'%')->pluck('subject_id')->toArray();
        $allSubjects = Subject::get(['id','name']);
        return view('admin.doctor.edit' , ['allSubjects' => $allSubjects , 'doctorDetails' => $doctorDetails , 'doctorSubjects' => $doctorSubjects]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all() , [

            'username'              => 'required|unique:users,username,'.$id,
            'name'                  => 'required',
            'email'                 => 'required|unique:users,email,'.$id,
            'password'              => 'nullable',            
            'subjects'              => 'required|array',


        ])->validate();


        $user = User::find($id);
        $password = $request->password;
        if($password == null) {
            $password = $user->password;
        } else {
            $password = bcrypt($password);
        }
        $startUpdate = $user->update(['username' => $request->username,'name' => $request->name , 'email' => $request->email , 'password' =>$password]);

        $idsOfSubjectsOfDoctor = \DB::table('subject_users')->where('users_id' , 'LIKE' , '%'.$user->id.'%')->pluck('id')->toArray();
        // Start Delete User From users ids
        foreach($idsOfSubjectsOfDoctor as $subjectID) {
            $getusersIDS = \DB::table('subject_users')->where('id' , $subjectID)->value('users_id');
            $explodegetusersIDS = explode(',' , $getusersIDS);
            $removeUserIDFromArray = array_filter($explodegetusersIDS , function($que) use ($user) {
                return $que != intval($user->id);
            });
            $implodeArray = implode(',', $removeUserIDFromArray);

            $startUpdate = \DB::table('subject_users')->where('id' , $subjectID)->update(['users_id' => $implodeArray]);
        }

        // Start Add User To Subject 

        foreach($request->subjects as $subject) {
            $theSubject = \DB::table('subject_users')->where('subject_id',$subject)->first();
            if($theSubject) {
                $usersIDS = $theSubject->users_id.','.$user->id;
                \DB::table('subject_users')->where('subject_id',$subject)->update(['users_id' => $usersIDS]);
            } else {
                Subject_User::create([
                    'users_id' => $user->id,
                    'subject_id' => $subject

                ]);
            }


        }

        \Session::flash('success' , 'Record Updated Success');
        return redirect('doctor');
        
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        \Session::flash('success' , 'Doctor Deleted Success');
        return redirect('doctor');
    }
}
