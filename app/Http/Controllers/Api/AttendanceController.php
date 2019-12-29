<?php

namespace App\Http\Controllers\Api;

use App\Attendance;
use App\Lecture;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function addAttendance(Request $request) {
        $token = $request->header('Authorization');
        $user = User::where('api_token',$token)->first();
        if($user) {
            $userID = strval($user->id);

            $validator = \Validator::make($request->all() , [
                'subject_user_id' => 'required|exists:subject_users,id',
                'student_id'      => 'required|exists:students,id',
                'lecture_id'      => 'required|exists:lectures,id'
            ]);

            if($validator->fails()) {
                $response['success'] = false;
                $response['error'] = 'Please Enter A valid Data';
                return response()->json(['response' => $response], 200);
            }

            // Start Check If User Has This SubjectIDS
            $getUsersIDOfThisSubject = \DB::table('subject_users')->where('id' , $request->subject_user_id)->value('users_id');
            $getStudentsIDOfThisSubject = \DB::table('subject_students')->where('subject_user_id' , $request->subject_user_id)->pluck('student_id')->toArray();
            if (strpos($getUsersIDOfThisSubject, $userID) !== false && in_array($request->student_id , $getStudentsIDOfThisSubject)) {
                // Check This Student Already Exists With This Subject Or Not
                $getStudentAttendanceOfSubject = Attendance::where(['subject_user_id' => $request->subject_user_id , 'student_id' => $request->student_id])->first();
                if($getStudentAttendanceOfSubject) {
                    // Check If $request->lecture_id Is Already Exists Means This Student Already Got His Attendance
                    $currentStudentLectures = $getStudentAttendanceOfSubject->lectures_id;
                    $requestLectureWithString = strval($request->lecture_id);
//                    dd($requestLectureWithString);
                    if (strpos($currentStudentLectures, $requestLectureWithString) !== false) {


                        $response['success'] = false;
                        $response['error'] = 'This Student Has Logged In This Lecture Before';
                        return response()->json(['response' => $response], 200);


                    } else {

                        $allLecturesWhichStudentssigned = $getStudentAttendanceOfSubject->lectures_id;
                        $addTheNewLectureOfThisUserToOld = $allLecturesWhichStudentssigned.','.$request->lecture_id;

                        $theNewCountOfAllLecturesOfStudent = intval($getStudentAttendanceOfSubject->count_all_lectures)+1;

                        $getStudentAttendanceOfSubject->update(['lectures_id' => $addTheNewLectureOfThisUserToOld , 'count_all_lectures' => $theNewCountOfAllLecturesOfStudent]);
                        // Start Update Table Lectures
                        $currentAllCountOfAllStudentsInThisLecture = Lecture::find($request->lecture_id);
                        $getCurrentAllCountOfAllStudentsInThisLctureValue = $currentAllCountOfAllStudentsInThisLecture->count_all_students;
//                        dd($currentAllCountOfAllStudentsInThisLecture);
                        $addCurrentPlusOne = $currentAllCountOfAllStudentsInThisLecture->update(['count_all_students' => $getCurrentAllCountOfAllStudentsInThisLctureValue+1]);

                        if($addCurrentPlusOne) {

                            $response['success'] = true;
                            $response['message'] = 'Attendance has been successfully switched';
                            return response()->json(['response' => $response], 200);

                        }


                    }

                } else {
                    $startInsertNewStudentInAttendance = Attendance::create([
                       'subject_user_id'        => $request->subject_user_id,
                       'student_id'             => $request->student_id,
                       'lectures_id'            => $request->lecture_id,
                        'count_all_lectures'    => 1

                    ]);

                    $currentAllCountOfAllStudentsInThisLecture = Lecture::find($request->lecture_id);
                    $getCurrentAllCountOfAllStudentsInThisLctureValue = $currentAllCountOfAllStudentsInThisLecture->count_all_students;
                    $addCurrentPlusOne = $currentAllCountOfAllStudentsInThisLecture->update(['count_all_students' => $getCurrentAllCountOfAllStudentsInThisLctureValue+1]);



                    if($startInsertNewStudentInAttendance && $addCurrentPlusOne) {
                        $response['success'] = true;
                        $response['message'] = 'Attendance has been successfully switched';
                        return response()->json(['response' => $response], 200);
                    } else {
                        $response['success'] = false;
                        $response['error'] = 'Please Try Again Later';
                        return response()->json(['response' => $response], 200);
                    }
                }
            }  else {
            $response['success'] = false;
            $response['error'] = 'This Subject Does Not Belongs To This User Or This Student Is Not Belongs To This Subject';
            return response()->json(['response' => $response], 200);
            }

        } else {

            return response()->json([
                'message' => 'Not a valid API Token',
            ]);
        }

    }

    function getAttendance(Request $request) {
        $token = $request->header('Authorization');
        $user = User::where('api_token',$token)->first();
        if($user) {
            $userID = strval($user->id);
            $validator = \Validator::make($request->all() , [
                'subject_user_id' => 'required|exists:subject_users,id',
            ]);

            if($validator->fails()) {
                $response['success'] = false;
                $response['error'] = 'Please Enter A valid Data';
                return response()->json(['response' => $response], 200);
            }

            // Start Check If User Has This SubjectIDS
            $getUsersIDOfThisSubject = \DB::table('subject_users')->where('id' , $request->subject_user_id)->value('users_id');
            if (strpos($getUsersIDOfThisSubject, $userID) !== false) {
                $countOfLecturesOfThisSubject = Lecture::where('subject_user_id' , $request->subject_user_id)->count();
                $getAllStudentsOfThisSubject = \DB::table('subject_students')->where('subject_user_id' , $request->subject_user_id)->pluck('student_id')->toArray();

                $getAttendanceOfThisSubject = Attendance::where('subject_user_id' , $request->subject_user_id)->select('student_id','count_all_lectures')->with('studentAttendance:id,username')->get();
                if(count($getAttendanceOfThisSubject) > 0) {
                    $allStudentsInAttendance= [];
                    foreach($getAttendanceOfThisSubject as $getStudentId) {
                        $allStudentsInAttendance[] = $getStudentId->student_id;
                    }
                    $studentsWhoDidntSetAnyAttendance = array_diff($getAllStudentsOfThisSubject , $allStudentsInAttendance);
                    if(count($studentsWhoDidntSetAnyAttendance) > 0) {
                        $getStudentsNamesWhoDidnotInAttendance = Student::whereIn('id' , $studentsWhoDidntSetAnyAttendance)->select('id' , 'username')->get();

                    } else {
                        $getStudentsNamesWhoDidnotInAttendance = null;
                    }

                    $response['success'] = true;
                    $response['count_all_lectures_of_subject'] = $countOfLecturesOfThisSubject;
                    $response['attendance'] = $getAttendanceOfThisSubject;
                    $response['studentsWithNoAttendance'] = $getStudentsNamesWhoDidnotInAttendance;
                    return response()->json(['response' => $response], 200);
                } else {
                    $response['success'] = false;
                    $response['error'] = 'This Subject Does Not Have Any Attendances Yet';
                    return response()->json(['response' => $response], 200);
                }


            } else {
                    $response['success'] = false;
                    $response['error'] = 'This Subject Does Not Belongs To This User';
                    return response()->json(['response' => $response], 200);
            }



            } else {

            return response()->json([
                'message' => 'Not a valid API Token',
            ]);
        }
    }


}
