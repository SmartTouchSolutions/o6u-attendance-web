<?php

namespace App\Http\Controllers\Admin;

use App\Subject;
use App\Subject_User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class TeacherAssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        {
            $allTeacherAssistants = User::where('type' , 'TeachingAssistant')->when($request->search , function($que) use ($request) {
                $que->where('username' , 'LIKE' , '%'.$request->search.'%');
            })->select('id' , 'username' , 'email' , 'created_at')->orderBy('id','desc')->paginate(3);

            return view('admin.teacher.index' , ['allTeacherAssistants' => $allTeacherAssistants]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allSubjects = Subject::get(['id','name']);
        return view('admin.teacher.create' ,['allSubjects' => $allSubjects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all() ,[

            'username'      => 'required',
            'email'         => 'required',
            'password'      => 'required|min:4',
            'subjects'       => 'required |array'

        ])->validate();

            $insertData = new User;
            $insertData->username     = $request->username;
            $insertData->email        = $request->email;
            $insertData->password     = bcrypt($request->password);
            $insertData->type         = 'teachingAssistant';
            $insertData->save();

        foreach($request->subjects as $subject) {
            $theSubject = \DB::table('subject_users')->where('subject_id',$subject)->first();
            $usersIDS = $theSubject->users_id.','.strval($insertData->id);
            \DB::table('subject_users')->where('subject_id',$subject)->update(['users_id' => $usersIDS]);
        }





        return redirect('/TeacherAssistant');
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

//        $teacherDetails = User::find($id);
//        return view('admin.teacher.edit', compact('teacherDetails'));

        $teacherDetails = User::find($id);
        $teacherSubjects = \DB::table('subject_users')->where('users_id' , 'LIKE' , '%'.$id.'%')->pluck('subject_id')->toArray();
        $allSubjects = Subject::get(['id','name']);
        return view('admin.teacher.edit' , ['allSubjects' => $allSubjects , 'teacherDetails' => $teacherDetails , 'teacherSubjects' => $teacherSubjects]);


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
        $startUpdate = $user->update(['username' => $request->username , 'email' => $request->email , 'password' =>$password]);
        $idsOfSubjectsOfteacher = \DB::table('subject_users')->where('users_id' , 'LIKE' , '%'.$user->id.'%')->pluck('id')->toArray();
        // Start Delete User From users ids
        foreach($idsOfSubjectsOfteacher as $subjectID) {
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
            if($theSubject){
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
        return redirect('TeacherAssistant');


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

            return redirect('TeacherAssistant')->with('error' , 'teacher Deleted Success');

    }


}
