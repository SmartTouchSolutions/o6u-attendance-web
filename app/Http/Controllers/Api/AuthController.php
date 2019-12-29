<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){


        $validator = \Validator::make($request->all() , [

            'username' => 'required|string',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            $response['success'] = false;
            $response['error'] = 'Please Enter Username And Password';
            return response()->json(['response' => $response], 200);
        }

        if(\Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = \Auth::user();

            $api_token = openssl_random_pseudo_bytes(150);
            $api_token = bin2hex($api_token);

            User::where('id' , $user->id)->update(['api_token' => $api_token]);
            $userID = $user->id;
            $username = $user->username;
            $email = $user->email;
            $type = $user->type;
            $token = $api_token;
            $user = ['id' =>$userID , 'username' => $username , 'email' =>$email , 'type' =>$type , 'Authorization' => $token];
            $response['success']              = true;
            $response['userDetails'] 		  = $user;
            return response()->json(['response' => $response], 200);

        } else{
            $response['success'] = false;
            $response['error'] = 'Username or password is incorrect';
            return response()->json(['response' => $response], 200);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('api_token',$token)->first();
        if($user) {
          $postArray = ['api_token' => null];
          $logout = $user->update($postArray);
          if($logout) {

              $response['success'] = true;
              $response['message'] = 'User Logged Out';
              return response()->json(['response' => $response], 200);

          } else {
              $response['success'] = false;
              $response['message'] = 'Please Try Again Later';
              return response()->json(['response' => $response], 200);

          }
        } else {
            return response()->json([
                'message' => 'Not a valid API Token',
            ]);
        }
      }

      public function resetPassword(Request $request) {
          $validator = \Validator::make($request->all() , [
              'oldPassword' => 'required',
              'newPassword' => 'required'
          ]);

          if($validator->fails()) {
              $response['success'] = false;
              $response['error'] = 'Please Enter Password';
              return response()->json(['response' => $response], 200);
          }

          $token = $request->header('Authorization');
          $user = User::where('api_token',$token)->first();
          if($user) {
              if(Hash::check($request->oldPassword, $user->password)){
                  $user->update(['password' => bcrypt($request->newPassword)]);
                  $response['success'] = true;
                  $response['error'] = 'password updated';
                  return response()->json(['response' => $response], 200);
              } else {
                  $response['success'] = false;
                  $response['error'] = 'password Is Not Correct';
                  return response()->json(['response' => $response], 200);

              }
          } else {
              return response()->json([
                  'message' => 'Not a valid API Token',
              ]);
          }

      }


}
