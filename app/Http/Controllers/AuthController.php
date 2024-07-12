<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
     
       // dd($request->all());

        try{
            $user = User::create([
                'firstName'=> $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'password'=>Hash::make($request->password),
                'phone_number'=>$request->phone_number
              ]);
         
        if($user){

            return ResponseHelper::success(message:'user register successfully',data:$user);
           }
           return ResponseHelper::errors(message:'unable to register user');
        }
        catch(\Exception $e){
            return ResponseHelper::errors(message:"unable to register user"  .$e->getMessage());
            }
       
        }

        public function login(LoginRequest $request){
            try {
                $credentials = $request->only('email', 'password');
    
                if (!$token = JWTAuth::attempt($credentials)) {
                    return ResponseHelper::errors(message: 'Unable to login user due to invalid credentials');
                }
                $user = Auth::user();
    
                return ResponseHelper::success(  message: 'User logged in successfully',
                    data: [
                        'user' => $user,
                        'token' => $token
                    ]
                );
    
            } catch (\Exception $e) {
                return ResponseHelper::errors(message: 'Unable to login user: ' . $e->getMessage());
            }

        }


        public function profile(){
            $user = Auth::user();
            return ResponseHelper::success(message:'user profile',data:$user);

        }

        public function forgotpassword(){
        
        }
}