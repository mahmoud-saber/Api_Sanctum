<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function regsister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:225'],
            'email' => ['required', 'email', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::default()],
            'brith_date' => ['required', 'string']
        ], [], [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'brith_date' => 'BrithDate'
        ]);

        if ($validator->fails()) {
            return ApiResponse::SendResponse(422, ' Register Validation Error', $validator->messages()->all());
        }
        if ($request->brith_date > 18) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'brith_date' => $request->brith_date,
            ]);
            $data['token'] = $user->createToken('sanctom')->plainTextToken;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['brith_date'] = $user->brith_date;
            return ApiResponse::SendResponse(201, 'User Account Created Successful', $data);
        }
        return ApiResponse::SendResponse(200, 'The brith_date of user less than 18 or Eqle', []);
    }
}