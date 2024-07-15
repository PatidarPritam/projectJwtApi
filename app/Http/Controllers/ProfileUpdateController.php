<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileUpdateController extends Controller
{
    
    public function update(Request $request)
    {
        
      
        $user = Auth::user();


       
        $validator = Validator::make($request->all(), [
            'firstName' => 'sometimes|string|max:255',
            'lastName' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);


       
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('profile_images', 'public');

            $user->image = $imagePath;
        }


        $user->update($request->only('firstName','lastName', 'email'));
       


       
        return ResponseHelper::success(message:'Profile updated successfully.',data:$user);

    }
        
}
