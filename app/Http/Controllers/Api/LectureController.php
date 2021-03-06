<?php

namespace App\Http\Controllers\Api;

use App\Lecture;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LectureController extends Controller
{
    public function createLecture(Request $request) {

        $token = $request->header('Authorization');
        $user = User::where('api_token',$token)->first();
        if($user) {
            $userID = strval($user->id);
            $validator = \Validator::make($request->all() , [
                'subject_user_id' => 'required|exists:subject_users,id',
            ]);

            if($validator->fails()) {
                $response['success'] = false;
                $response['error'] = 'Please Enter subject_user_id';
                return response()->json($response, 200);
            }

            // Start Check If User Has This SubjectIDS
            $getUsersIDOfThisSubject = \DB::table('subject_users')->where('id' , $request->subject_user_id)->value('users_id');
            if (strpos($getUsersIDOfThisSubject, $userID) !== false) {

                // Check If Lecture Already Exists In This Day
                $lastLectureOfThisSubject = Lecture::where('subject_user_id', $request->subject_user_id)->orderBy('id', 'DESC')->first();
                if($lastLectureOfThisSubject) {
                    $lastLectureOfThisSubjectDate = $lastLectureOfThisSubject->created_at->toDateString();

                    $today = Date('Y-m-d');

                    if ($lastLectureOfThisSubjectDate == $today) {

                        $response['success'] = false;
                        $response['error'] = 'You Already Created lecture Today';
                        return response()->json($response, 200);

                    } else {
                        // Start Create Lecture

                        $createLecture = Lecture::create([
                            'subject_user_id' => $request->subject_user_id,
                            'user_id' => $user->id
                        ]);

                        if ($createLecture) {
                            $response['success'] = true;
                            $response['data'] = 'Lecture Created Success';
                            return response()->json($response, 200);
                        } else {
                            $response['success'] = false;
                            $response['error'] = 'Please Try Again Later';
                            return response()->json($response, 200);
                        }
                    }
                } else {
                    // Start Create Lecture

                    $createLecture = Lecture::create([
                        'subject_user_id' => $request->subject_user_id,
                        'user_id' => $user->id
                    ]);

                    if ($createLecture) {
                        $response['success'] = true;
                        $response['data'] = 'Lecture Created Success';
                        return response()->json($response, 200);
                    } else {
                        $response['success'] = false;
                        $response['error'] = 'Please Try Again Later';
                        return response()->json($response, 200);
                    }

                }

            } else {
                $response['success'] = false;
                $response['error'] = 'This Subject Does Not Belongs To This User';
                return response()->json($response, 200);
            }//end if (strpos($getUsersIDOfThisSubject, $userID) !== false) {

        } else {

              $response['success'] = false;
              $response['error'] = 'Not a valid API Token';
              return response()->json($response, 200);
        }
    }

    public function getLecture(Request $request) {

        $token = $request->header('Authorization');
        $user = User::where('api_token',$token)->first();
        if($user) {
            $userID = strval($user->id);
            $validator = \Validator::make($request->all() , [
                'subject_user_id' => 'required|exists:subject_users,id',
            ]);

            if($validator->fails()) {
                $response['success'] = false;
                $response['error'] = 'Please Enter subject_user_id';
                return response()->json($response, 200);
            }
            // Start Check If User Has This SubjectIDS
            $getUsersIDOfThisSubject = \DB::table('subject_users')->where('id' , $request->subject_user_id)->value('users_id');
            if (strpos($getUsersIDOfThisSubject, $userID) !== false) {
                // Start Get All Lectures Of This Subject
                $allLectures = Lecture::where('subject_user_id' , $request->subject_user_id)->select('id' , 'count_all_students' , 'created_at')->get();

                if(count($allLectures) > 0) {
                    $response['success'] = true;
                    $response['data'] = $allLectures;
                    return response()->json($response, 200);
                } else {
                    $response['success'] = true;
                    $response['data'] = [];
                    return response()->json($response, 200);
                }

            } else {
                $response['success'] = false;
                $response['error'] = 'This Subject Does Not Belongs To This User';
                return response()->json($response, 200);
            }



        } else {

              $response['success'] = false;
              $response['error'] = 'Not a valid API Token';
              return response()->json($response, 200);
        }

    }

}
