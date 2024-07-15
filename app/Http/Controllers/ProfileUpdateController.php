<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileUpdateController extends Controller
{
    
    public function update(Request $request)
    {
        
        // Get the authenticated user
        $user = Auth::user();


        // Validate the request
        $validator = Validator::make($request->all(), [
            'firstName' => 'sometimes|string|max:255',
            'lastName' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);


        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('profile_images', 'public');

            // Update user profile with the new image path
            $user->image = $imagePath;
        }


        $user->update($request->only('firstName','lastName', 'email'));
       


        // Return a success response
        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ]);
    }
        
}
