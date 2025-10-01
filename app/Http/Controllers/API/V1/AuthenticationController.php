<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthenticationController extends BaseController
{
    public function login(Request $request)
    {
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];
  
        if (Auth::attempt($credentials)) 
        {
            $token = Auth::user()->createToken('passportToken')->accessToken;
             
            return response()->json([
                'user' => Auth::user(), 
                'token' => $token
            ], 200);
        }
  
        return response()->json([
            'error' => 'Unauthorised'
        ], 401);
  
    }

    public function show(Request $request){
        $user =  User::find($request->user()->id);
        if($user){
            return $this->sendResponse($user, 'User login successfully.');
        }else{
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function me(Request $request)

    {

        return $this->sendResponse($request->user(), 'Current user');
    }



    public function update(Request $request)

    {

        $user = User::find($request->user()->id);


        if ($request->has('image')) {

            $image = $request->file('image');

            $imageName = Str::random(24) . '.' . $image->getClientOriginalExtension();

            $imagePath = '/images/users/' . $request->user()->id . '/' . $imageName;

            if (is_file($image)) {
              Storage::disk('public')->put($imagePath, file_get_contents($image));
            }



            $user->photo = $imagePath;
        }



        if ($request->has('name')) {

            $user->name = $request->name;

            /*$user->phone = $request->phone;

            $user->username = $request->username;

            $user->gender = $request->gender;*/
        }



        if ($request->has("firebase_token")) {

            $user->firebase_token = $request->firebase_token;
        }



        $user->save();

        return $this->sendResponse($user, 'Current user');
    }
    public function logout(Request $request)

    {

        DB::table('users')->where('id', $request->user()->id)->update(["firebase_token" => NULL]);

        $request->user()->token()->revoke();

        if ($request->query("deleted")) {

            $user = User::find($request->user()->id);

            $user->active = false;

            $user->save();
        }

        return $this->sendResponse($request->user(), 'Successfully logged out');
    }

    public function firebaseRegister(Request $request)
    {
        $request->validate([
            'firebase_web_token' => 'required|string|max:255',
        ]);

        $user = User::find($request->user()->id);
        if ($user) {
            $user->firebase_web_token = $request->firebase_web_token;
            $user->save();
            return $this->sendResponse($user, 'Firebase token registered successfully.');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorised'], 401);
        }
    }
}
