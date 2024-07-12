<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName'=>'required|min:3|max:20',
            'lastName'=>'required|min:3|max:20',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:20|confirmed',
            'password_confirmation'=>'required',
            'phone_number'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'firstName.required' => 'please enter your name',
            'firstName.min' => 'First name must be at least 3 characters',
            'firstName.max' => 'First name must be at most 20 characters',
            'lastName.required' => 'Last name is required ',
            'lastName.min' => 'Last name must be at least 3 characters',
            'lastName.max' => 'Last name must be at most 20 characters',
            'email.required' => 'please enter your email',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is already taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 5 characters',
            'password.max' => 'Password must be at most 20 characters',
            'password_confirmation.required' => 'Password confirmation is required',
            'phone_number.required' => 'Phone number is required',
            ];
    }
}
