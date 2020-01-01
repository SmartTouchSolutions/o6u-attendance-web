<?php

namespace App\Http\Controllers\Admin;

use App\Attendance;
use App\Student;
use App\Subject;
use App\Subject_Student;
use App\Subject_User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Lecture;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $allStudents = Student::when($request->search , function($que) use ($request) {
            $que->where('username' , 'LIKE' , '%'.$request->search.'%');
        })->select('id' , 'username' , 'student_code' , 'created_at')->orderBy('id','desc')->paginate(3);

        return view('admin.students.index' , ['allStudents' =>  $allStudents]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allStudents = Student::get(['id','username']);
        $allSubjects = Subject::get(['id','name']);
        return view('admin.students.create' ,['allStudents' =>  $allStudents , 'allSubjects' => $allSubjects]);
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
            'password'      => 'required|min:4',
            'student_code'       => 'required',
            'subjects'       => 'required |array'


        ])->validate();

        $insertData = new Student();
        $insertData->username     = $request->username;
        $insertData->password     = bcrypt($request->password);
        $insertData->student_code     =$request->student_code;

        $insertData->save();

        foreach($request->subjects as $subject) {
            $theSubjectUserID = \DB::table('subject_users')->where('subject_id',$subject)->first();
            if($theSubjectUserID) {
                // Start Insert theSubjectID With Student
                Subject_Student::create([
                    'subject_user_id' => $theSubjectUserID->id,
                    'student_id' => $insertData->id
                ]);
            } else {
                \Session::flash('error' , 'Please Add Doctor To Subjects');
                return redirect('/student');
            }


//            $usersIDS = $theSubject->subject_id.($insertData->id);
//            \DB::table('subject_students')->where('subject_id',$subject)->update(['subject_users_id' => $usersIDS]);
        }

        return redirect('/student');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Respo$studentDetailsnse
     */
    public function edit($id)
    {
        $studentDetails = Student::find($id);
        $studentSubjects = \DB::table('subject_students')->where('student_id',$studentDetails->id)->pluck('subject_user_id')->toArray();
        $subject_user = \DB::table('subject_users')->whereIn('id',$studentSubjects)->pluck('subject_id')->toArray();
        $allSubjectsOfStudent = Subject::whereIn('id',$subject_user)->pluck('id')->toArray();
        $allSubjects = Subject::get(['id','name']);
//                dd($allSubjects);

        return view('admin.students.edit' , [ 'studentDetails' => $studentDetails , 'allSubjectsOfStudent' => $allSubjectsOfStudent , 'allSubjects' => $allSubjects ]);

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
            'username'              => 'required|unique:students,username,'.$id,
            'student_code'          => 'required|unique:students,student_code,'.$id,
            'password'              => 'nullable',
            'subjects'              => 'required |array'
        ])->validate();
        $student = Student::find($id);
        $password = $request->password;
        if($password == null) {
            $password =  $student->password;
        } else {
            $password = bcrypt($password);
        }
        $sudentUpdate =  $student->update(['username' => $request->username , 'student_code' => $request->student_code, 'password' =>$password ]);

        //start delete subject
        \DB::table('subject_students')->where('student_id',$id)->delete();
        //start insert new subjects to user
        foreach($request->subjects as $subject) {
            $theSubject = \DB::table('subject_users')->where('subject_id', $subject)->value('id');
            if ($theSubject){
                \DB::table('subject_students')->insert([
                    'subject_user_id' =>$theSubject ,
                    'student_id'      =>$id,

                ]);
            }else{
                \Session::flash('error' , 'this subject does not have doctor yet ');
                return redirect('/student');
            }
        }


        \Session::flash('success' , 'Record Updated Success');
        return redirect('/student');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        \Session::flash('success' , 'student Deleted Success');
        return redirect('student');
    }



    public function showAttendance($id){

        $studentSubjects = Subject_Student::where('student_id' , $id)->pluck('subject_user_id')->toArray();
        $studentAttendance = [];
        $studentWithNoAttendance = [];
        foreach($studentSubjects as $studentSubject) {
            $checkStudentInAttendance = Attendance::where('student_id' , $id)->where('subject_user_id' , $studentSubject)->first();
            if($checkStudentInAttendance) {

                $studentAttendanceForOne = Attendance::where('student_id' , $id)->where('subject_user_id' , $studentSubject)->with('studentAttendance')->with('subjectUserAttendance')->with('subjectUserAttendance.subjects')->with('subjectUserAttendance.lectures:subject_user_id')->first()->toArray();

                // if(count($studentAttendanceForOne) > 0 ) {
                    $studentAttendance[] = $studentAttendanceForOne;
                // } else {
                //     // $studentWithNoAttendance[] = $studentSubject;
                // }
            } else {
                    $studentDetails = Student::find($id);
                    $studentWithNoAttendance[] = ['username' => $studentDetails->username , 'student_code' => $studentDetails->student_code ,'count_all_lectures' => 0,'subjectName' => Subject_User::where('id' , $studentSubject)->first()->subjects->name , 'countOfAllLecturesOFSubject' => Lecture::where('subject_user_id' , $studentSubject)->count()];
            }
            
        }

        // dd($studentAttendance , $studentWithNoAttendance);

       return  view('admin.students.attendance' , ['studentAttendance' => $studentAttendance , 'studentWithNoAttendance' => $studentWithNoAttendance]);

    }
}
