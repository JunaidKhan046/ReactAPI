<?php

namespace App\Http\Controllers\APIAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Send the email verification notification.
     *
     * @bodyParam email string required The email of the user. Example: user@test.com
     * @response 200 { 
     *  "data": {
     *   "statusCode": "200",
     *   "status": "OK Request",
     *   "message": "Your email verification link has been successfully sent. or email already verified."
     * }
     *}
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.verified')
            ]], __('statusCode.statusCode200'));
        }
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.verify')
        ]], __('statusCode.statusCode200'));
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @bodyParam expires string required The expire of the user. Example: 1607095509
     * @bodyParam hash string required The has of the user. Example: 8331c2de507b8ac5bd9118e3962d20ad3e486bd7
     * @bodyParam id int required The id of the user. Example: 1
     * @bodyParam signature string required The signature of the user. Example: 06f3b646233bb92fabde010cf202564c84d1ed23cd7c8f97c1073fae59d9957b
     * @response 200 { 
     *  "data": {
     *   "statusCode": "200",
     *   "status": "OK Request",
     *   "message": "Email verify successfully or email already verified."
     * }
     *}
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (! hash_equals((string) $request->id, (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->hash, sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'verified' => true,
                'message' =>  __('auth.verified')
            ]], __('statusCode.statusCode200'));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'verified' => true,
            'message' =>  __('auth.verifySuccess')
        ]], __('statusCode.statusCode200'));
    }
}
