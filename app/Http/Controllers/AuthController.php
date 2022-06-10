<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Login Success',
                'data' => $this->respondWithToken($token)
            ], 200);
        }
    }
    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
            ]);
            //code...
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed',
                'data' =>  isset($e->validator) ? [
                    'validator' => $e->validator->errors(),
                ] : $e->getMessage(),
            ], 400);
        }

        try {

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $plainPassword = $request->password;
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Register Success',
                'data' => ''
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Register Failed',
                'data' => $e->getMessage()
            ], 400);
        }
    }
    public function profile()
    {
        try {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'Get Profile Success',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Get Profile Failed',
                'data' => $e->getMessage()
            ], 400);
        }
    }
}
