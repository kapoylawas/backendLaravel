<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password2' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors());
        }

        $checkEmail = User::where("email", $input['email'])->first();

        if($checkEmail){
            return $this->errorResponse('Email Already Existed');
        }

        $input['password'] = bcrypt($input['password']);
        
        $user = User::create($input);

        $response = [
            'token' => $user->createToken('kapoylawas')->plainTextToken,
            'name' => $user->name,
            'email' => $user->email
        ];

        return $this->successResponse($response, "User Successfully Registered");
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors());
        }

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = Auth::user();
            $response = [
                'token' => $user->createToken('kapoylawas')->plainTextToken,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at
            ];

            return $this->successResponse($response, "User Successfully Login");
        }else {
            return $this->errorResponse('Your Email or Password is not Valid');
        }
    }
}