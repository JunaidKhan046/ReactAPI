<?php

namespace App\Http\Controllers\APIAuth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Create a new RegisterController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @bodyParam name string required The name of the user. Example: user
     * @bodyParam email string required unique The email of the user. Example: user@test.com
     * @bodyParam password alphanumeric required min:8 The password of the user. Example: 9657Ex@!1
     * @bodyParam password_confirmation alphanumeric required min:8 The confirm password of the user. Example: 9657Ex@!1.
     * @response 200 { 
     *  "data": {
     *   "statusCode": "200",
     *   "status": "OK Request",
     *   "message" : "Login Successfully.",
     *   "auth": {
     *     "access_token": "{token}",
     *     "token_type": "bearer",
     *     "expires_in": 3600,
     *     "user": {
     *           "id": 3,
     *           "name": "Junaid Khan",
     *           "email": "khanjunaid046@gmail.com",
     *           "email_verified_at": "null"
     *       }
     *   }
     * }
     *}
     * @response 400 { 
     * "data": {
     *  "statusCode": "400",
     *   "status": "Bad Request",
     *   "message": "The email has already been taken."
     *}
     *}
     
      
     * @param  Request  $request
     * @return \App\User
     */
    public function registerUser(Request $request)
    {
        try{
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%.]).*$/|confirmed',
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()->first()
                ]], __('statusCode.statusCode400'));
            }
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            DB::commit();
            if (!$token = auth()->attempt(request(['email', 'password']))) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode401'),
                    'status' => __('statusCode.status401'),
                    'message' => __('auth.failed')
                ]], __('statusCode.statusCode401'));
            }
            return $this->respondWithToken($token);
        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => $e->getMessage()
            ]], __('statusCode.statusCode500'));
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.registerSuccess'),
            'auth' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => [
                    "id" => auth()->user()->id,
                    "name" => auth()->user()->name,
                    "email" => auth()->user()->email,
                    "email_verified_at" => auth()->user()->email_verified_at,
                ]
            ],
        ]], __('statusCode.statusCode200'));
    }
}
