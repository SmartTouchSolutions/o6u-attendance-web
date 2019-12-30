<?php

namespace App\Http\Controllers\Api;

use App\Subject;
use App\User;
use App\Subject_User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function getsubjects(Request $request) {

        $token = $request->header('Authorization');
        $user = User::where('api_token',$token)->first();
        if($user) {
            // Start Get User Subjects
            $userID = strval($user->id);
            // $getUsers = \DB::table('subject_users')->select('users_id','subject_id')->get()->toArray();
            $allSubjectUser = Subject_User::where('users_id' , 'LIKE', '%' .$user->id. '%')->withCount('lectures')->with('subjects:id,name')->get();
            
            // dd($allSubjectUser);

            // $getSubjectsIDS = [];
            // foreach($getUsers as $user) {
            //     $usersIDS = $user->users_id;
            //     if (strpos($usersIDS, $userID) !== false) {
            //         $getSubjectsIDS[] = $user->subject_id;
            //     }
            // }

            // // Start Get Subjects Name
            if(count($allSubjectUser) > 0) {
            //     $subjectName = Subject::whereIn('id' , $getSubjectsIDS)->pluck('name')->toArray();
                $response['success'] = true;
                $response['data'] = $allSubjectUser;
                return response()->json($response, 200);
            } else {
                $response['success'] = false;
                $response['error'] = 'This User Has Not Any Subjects Yet';
                return response()->json($response, 200);
            }

        } else {

           $response['success'] = false;
           $response['error'] = 'Not a valid API Token';
           return response()->json($response, 200);
        }
    }
}
