<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subject_Student;
use App\Student;
use App\Attendance;
use App\Subject_User;
use App\Lecture;
class AttendanceController extends Controller
{
    public function attendance() {
    	$id = auth()->guard('student')->user()->id;
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

    	return view('student.attendance' , ['studentAttendance' => $studentAttendance , 'studentWithNoAttendance' => $studentWithNoAttendance]);

	}
}
