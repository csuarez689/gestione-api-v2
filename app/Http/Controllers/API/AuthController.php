<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'refresh']);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!$token =  JWTAuth::attempt($request->validated())) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(JWTAuth::user()->loadMissing('school'));
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
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            throw new BadRequestHttpException('Token not provided');
        }
        try {
            $newToken = JWTAuth::refresh($token);
        } catch (TokenBlacklistedException | TokenInvalidException $e) {
            throw new AccessDeniedHttpException('The token is invalid');
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
            'user' => $user
        ]);
    }
}
