<?php

namespace App\Http\Controllers\APIAuth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Login user instance after a valid registration.
     *
     * @bodyParam email string required unique The email of the user. Example: user@test.com
     * @bodyParam password alphanumeric required min:8 The password of the user. Example: 9657Ex@!1
     * 
     * @response 200 { 
     *  "data": {
     *   "statusCode": "200",
     *   "status": "OK Request",
     *   "auth": {
     *     "access_token": "{token}",
     *     "token_type": "bearer",
     *     "expires_in": "3600",
     *     "user": {
     *           "id": "3",
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
     *   "message": "The password format is invalid."
     * }
     *}
     * @response 401 { 
     * "data": {
     *  "statusCode": "401",
     *   "status": "Unauthorized",
     *   "message": "These credentials do not match our records."
     * }
     *}
     * @response 500 { 
     * "data": {
     *  "statusCode": "500",
     *   "status": "Server Error",
     *   "message": "Server exception."
     * }
     *}    
      
     * @param  Request  $request
     */
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email',
                    'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%.]).*$/',
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()->first()
                ]], __('statusCode.statusCode400'));
            }
            if (!$token = auth()->attempt(request(['email', 'password']))) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode401'),
                    'status' => __('statusCode.status401'),
                    'message' => __('auth.failed')
                ]], __('statusCode.statusCode401'));
            }
            return $this->respondWithToken($token);
        } catch(Exception $e) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => $e->getMessage()
            ]], __('statusCode.statusCode500'));
        }
    }

    /**
     * Get the authenticated User.
     *
     * @response 200 { 
     *  "data": {
     *   "statusCode": "200",
     *   "status": "OK Request",
     *     "user": {
     *           "id": 3,
     *           "name": "Junaid Khan",
     *           "email": "khanjunaid046@gmail.com",
     *           "email_verified_at": null
     *       }
     *   }
     * }
     * @response 401 { 
     *    "message": "Unauthenticated."
     *}
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
                'user' => [
                    "id" => auth()->user()->id,
                    "name" => auth()->user()->name,
                    "email" => auth()->user()->email,
                    "email_verified_at" => auth()->user()->email_verified_at,
                ]
        ]], __('statusCode.statusCode200'));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @bodyParam token string required The string of the user auth token. Example: token
     * 
     * @response 200 { 
     *  "data": {
     *   "statusCode": "200",
     *   "status": "OK Request",
     *   "message": "'Successfully logged out"
     *  }
     *}
     * @response 401 { 
     *    "message": "Unauthenticated."
     *}
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.logout')
        ]], __('statusCode.statusCode200'));
    }

    /**
     * Refresh a token.
     *
     * @response 200 { 
     *  "data": {
     *   "statusCode": "200",
     *   "status": "OK Request",
     *   "message" : "Login Successfully.",
     *   "auth": {
     *     "access_token": "token",
     *     "token_type": "bearer",
     *     "expires_in": 3600,
     *     "user": {
     *           "id": 3,
     *           "name": "Junaid Khan",
     *           "email": "khanjunaid046@gmail.com",
     *           "email_verified_at": null
     *       }
     *   }
     * }
     *}
     * @response 401 { 
     *    "message": "Unauthenticated."
     *}
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
            'message' => __('auth.loginSuccess'),
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
