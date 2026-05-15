<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

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

            'password' => 'required|min:6|confirmed',

            'role_id' => 'required|integer|in:1,2,3',

            'phone' => 'nullable|string|max:20',

            'birth_date' => 'nullable|date',

            'education' => 'nullable|string|max:255',

            'company_name' => 'nullable|string|max:255',

        ]);

        $user = User::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => bcrypt($validated['password']),

            'role_id' => $validated['role_id'],

            'phone' => $validated['phone'] ?? null,

            'birth_date' => $validated['birth_date'] ?? null,

            'education' => $validated['education'] ?? null,

            'company_name' => $validated['company_name'] ?? null,

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

                'expires_in' => auth('api')->factory()->getTTL() * 60,

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

    /**
     * Refresh JWT Token
     */
    public function refresh()
    {
        return response()->json([

            'success' => true,

            'message' => 'Token refreshed',

            'data' => [

                'token' => Auth::guard('api')->refresh(),

                'expires_in' => auth('api')->factory()->getTTL() * 60

            ]

        ], 200);
    }

    /**
     * Forgot Password - Generate OTP
     */
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

        // Hapus OTP lama agar hanya ada 1 OTP aktif
        DB::table('otp_tokens')

            ->where('user_id', $user->id)

            ->delete();

        $otp = rand(100000, 999999);

        $expiredAt = Carbon::now()->addMinutes(5);

        DB::table('otp_tokens')->insert([

            'user_id' => $user->id,

            'otp_code' => $otp,

            'expired_at' => $expiredAt,

            'created_at' => now(),

            'updated_at' => now()

        ]);

        return response()->json([

            'success' => true,

            'message' => 'OTP berhasil dibuat',

            'data' => [

                'otp_code' => $otp,

                'expired_at' => $expiredAt

            ]

        ], 200);
    }

    /**
     * Reset Password Using OTP
     */
    public function resetPassword(Request $request)
    {
        $request->validate([

            'email' => 'required|email',

            'otp_code' => 'required',

            'password' => 'required|min:8|confirmed'

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

                'message' => 'OTP salah atau tidak valid'

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

    /**
    * Redirect User To Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
    * Handle Google Callback
    */
    public function handleGoogleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->email)->first();

            // Jika user belum ada
            if (!$user) {

                $user = User::create([

                    'name' => $googleUser->name,

                    'email' => $googleUser->email,

                    'password' => bcrypt('google-login'),

                    'role_id' => 3

                ]);
            }

            // Generate JWT token
            $token = Auth::guard('api')->login($user);

            return response()->json([

                'success' => true,

                'message' => 'Google login success',

                'data' => [

                    'token' => $token,

                    'user' => $user

                ]

            ], 200);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' => 'Google login failed',

                'error' => $e->getMessage()

            ], 500);
        }
    }
}