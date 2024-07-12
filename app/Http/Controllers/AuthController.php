<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            try{
                $email = $request->input('email');
                $password = $request->input('password');
                if(Auth::attempt(['email'=> $email,'password'=> $password])){
                    $user = Auth::user();
                    return ResponseHelper::success(message:'user login successfully',data:$user);
                   
                }
                   return  ResponseHelper::errors(message:'unable to login user! due to invalid credentials ');
            }
            catch(\Exception $e){
                return ResponseHelper::errors(message:"unable to login user"  .$e->getMessage());
                }

        }

}