<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Notifications\PasswordResetSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'refresh', 'forgotPassword', 'resetPassword']);
    }

    //------------JWT RELATED---------------------

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!$token =  JWTAuth::attempt($request->validated())) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);

        return response()->json(['message' => 'Se ha deslogueado con exito.']);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            throw new BadRequestHttpException('Token invalido');
        }
        try {
            $newToken = JWTAuth::refresh($token);
        } catch (TokenBlacklistedException | TokenInvalidException $e) {
            throw new AccessDeniedHttpException('Token invalido');
        }
        return response()->json([
            'access_token' => $newToken,
            'token_type' => 'bearer',
            'expires_in' =>  JWTAuth::factory()->getTTL() * 60, //response in secs
        ]);
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
        $user =  JWTAuth::user();
        $user['school_id'] = $user->school ? $user->school->id : null;
        unset($user->school);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  JWTAuth::factory()->getTTL() * 60, //response in secs
            'user' => $user,
        ]);
    }

    //------------PROFILE RELATED---------------------

    /**
     * Get the authenticated user profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $user = JWTAuth::user();
        $user['school_id'] = $user->school ? $user->school->id : null;
        unset($user->school);
        return $this->toResource($user);
    }

    /**
     * Update user profile data
     * @param  \App\Http\Requests\UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = JWTAuth::user();
        $user->update($request->validated());
        return $this->toResource($user);
    }



    //------------PASSWORD RELATED---------------------


    /**
     * Change user password
     *
     * @param  \App\Http\Requests\ChangePasswordRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = JWTAuth::user();
        $user->update(['password' => Hash::make($request->new_password)]);
        $user->notify(new PasswordResetSuccess);
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);
        return response()->json(['message' => 'Contraseña actualizada. Debe iniciar sesion.']);
    }

    /**
     * Create password reset token
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email:rfc,dns',]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Se ha enviado el correo para configurar su contraseña.'])
            : response()->json(['message' => __($status)], 400);
    }

    /**
     * Reset password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill(['password' => Hash::make($password)])->save();

                $user->notify(new PasswordResetSuccess);
            }
        );

        return $status == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Se ha configurado su nueva contraseña.'])
            : response()->json(['message' => __($status)], 400);
    }
}
