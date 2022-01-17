<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\Http\Requests\ApiUpdateUserRequest;

class ApiAuthController extends Controller
{
    public function register(ApiRegisterRequest $request)
    {
        // get the validated data, hash the password and create the user
        $user = User::create(array_merge($request->validated(), ['password' => Hash::make($request->password)]));
        //user creation successful or not.
        return $user != null ? $this->successResponse('User created successfully.', 201, $user) : $this->errorResponse('There was a problem creating the user.', 500);
    }

    public function login(ApiLoginRequest $request)
    {
        // get validated data.
        $loginData =  $request->validated();
        // determine the identification key type.
        $fieldType = filter_var($loginData['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // check for user
        $user = User::where($fieldType, $loginData['email'])->first();

        // No user found
        if (!$user) {
            return $this->errorResponse('No user found', 404, ['No user is associated with these credentials']);
        }

        // attempt auth
        if (!Auth::attempt([$fieldType => $loginData['email'], 'password' => $loginData['password']])) {
            return $this->errorResponse('Invalid login details', 401, ['E-mail or username & passwords do not match.']);
        }

        // successful auth
        $token = $user->createToken('auth_token', ['type:user'])->plainTextToken;

        return $this->successResponse('Authentication successful.', 200, [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return $this->successResponse('User found', 200,  [
            'user' => $request->user(),
        ]);
    }



    public function update(ApiUpdateUserRequest $request)
    {
        // get the validated data, hash the password and create the user
        $user = $request->user()->update(array_merge($request->validated(), ['password' => Hash::make($request->password)]));
        
        //user update status.
        return $user == true ?
            $this->successResponse('User updated successfully.', 200) : $this->errorResponse('There was a problem updating the user.', 500);
    }

    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete() == true ?
            $this->successResponse('Logged out successfully.', 200) : $this->errorResponse('Invalid token.', 401);
    }
}
