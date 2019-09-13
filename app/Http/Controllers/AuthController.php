<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoverPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\S3\S3Controller;
use App\Mail\PasswordReset;
use App\Mail\Welcome;
use App\User;
use App\Profile;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Validator;


/**
 * Class AuthController
 * @group Auth
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Current User
     * @authenticated
     * @return JsonResponse
     */
    public function getUser()
    {
        return response()->json(['data' => Auth::user()], 200);
    }

    /**
     * Login
     *
     * @bodyParam email string required The email
     * @bodyParam password string required The password
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json(['message' => trans('messages.login_failed')], 401);
        }

        return response()->json(['data' => ['user' => Auth::user(), 'token' => $token]], 200);
    }

    /**
     * Register
     *
     * @bodyParam email string required The email
     * @bodyParam password string required The password
     * @bodyParam name string required The name
     * @bodyParam lastname string required The lastname
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $name = $request->input('name');
        $lastname = $request->input('lastname');

        $user = User::createFromValues($name, $lastname, $email, $password);
        
        if ($request->input('image'))
        {
            $s3 = new S3Controller;
            $s3 = $s3->store_64($request);
            $image = $s3->getData()->data;

            $profile = new Profile;
            $profile->user_id = $user->id;        
            $profile->image = $image->url;
            $profile->save();
        }
        
        Mail::to($user)->send(new Welcome($user));

        return response()->json(['data' => ['message' => 'Account created. Please verify via email.']], 200);
    }

    /**
     * Verify User
     *
     * @queryParam token required The token
     *
     * @param String $token
     * @return JsonResponse
     * @throws Exception
     */
    public function verify($token)
    {
        $user = User::verifyByToken($token);

        if (!$user) {
            return response()->json(['data' => ['message' => 'Invalid verification token']], 400);
        }

        return response()->json(['data' => ['message' => 'Account has been verified']], 200);
    }

    /**
     * Send new Password Request
     *
     * @bodyParam email string required The email
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email'
        ]);

        if ($validator->passes()) {
            $user = User::byEmail($request->input('email'));

            Mail::to($user)->send(new PasswordReset($user));
        }

        return response()->json(['data' => ['message' => 'Please check your email to reset your password.']], 200);
    }

    /**
     * Create new Password
     *
     * @bodyParam password string required The new password
     *
     * @param Request $request
     * @param $token
     * @return JsonResponse
     * @throws ValidationException
     */
    public function recoverPassword(Request $request, $token)
    {
        $this->validate($request, [
            'password' => 'required|min:8',
        ]);

        $user = User::newPasswordByResetToken($token, $request->input('password'));

        if ($user) {
            return response()->json(['data' => ['message' => 'Password has been changed.']], 200);
        } else {
            return response()->json(['data' => ['message' => 'Invalid password reset token']], 400);
        }
    }
}
