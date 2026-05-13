<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register User
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register success',
            'data' => $user
        ], 201);
    }

    /**
     * Login User
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {

            return response()->json([

                'success' => false,

                'message' => 'Email atau password salah'

            ], 401);
        }

        return response()->json([

            'success' => true,

            'message' => 'Login success',

            'data' => [

                'token' => $token,

                'user' => Auth::guard('api')->user()

            ]

        ], 200);
    }

    /**
     * Get Authenticated User
     */
    public function me()
    {
        return response()->json([
            'success' => true,
            'message' => 'User profile',
            'data' => Auth::guard('api')->user()
        ], 200);
    }
    /**
     * Logout User
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout success'
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([

            'email' => 'required|email'

        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return response()->json([

                'success' => false,

                'message' => 'Email tidak ditemukan'

            ], 404);
        }

        $otp = rand(100000, 999999);

        DB::table('otp_tokens')->insert([

            'user_id' => $user->id,

            'otp_code' => $otp,

            'expired_at' => Carbon::now()->addMinutes(5),

            'created_at' => now(),

            'updated_at' => now()

        ]);

        return response()->json([

            'success' => true,

            'message' => 'OTP berhasil dibuat',

            'data' => [

                'otp_code' => $otp

            ]

        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([

            'email' => 'required|email',

            'otp_code' => 'required',

            'password' => 'required|min:6'

        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return response()->json([

                'success' => false,

                'message' => 'User tidak ditemukan'

            ], 404);
        }

        $otp = DB::table('otp_tokens')

            ->where('user_id', $user->id)

            ->where('otp_code', $request->otp_code)

            ->first();

        if (!$otp) {

            return response()->json([

                'success' => false,

                'message' => 'OTP salah'

            ], 400);
        }

        if (Carbon::now()->gt($otp->expired_at)) {

            return response()->json([

                'success' => false,

                'message' => 'OTP expired'

            ], 400);
        }

        $user->update([

            'password' => bcrypt($request->password)

        ]);

        DB::table('otp_tokens')

            ->where('user_id', $user->id)

            ->delete();

        return response()->json([

            'success' => true,

            'message' => 'Password berhasil direset'

        ], 200);
    }
}