<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Register User
     */
    public function register(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'role_id' => 'required|integer|in:1,2,3',

                'phone' => 'nullable|string|max:20',
                'birth_date' => 'nullable|date',
                'education' => 'nullable|string|max:255',
                'company_name' => 'nullable|string|max:255',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Kata sandi wajib diisi.',
                'password.min' => 'Kata sandi minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
                'role_id.required' => 'Tipe akun wajib dipilih.',
                'role_id.in' => 'Tipe akun tidak valid.',
                'birth_date.date' => 'Format tanggal lahir tidak valid.',
            ]
        );

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
            'message' => 'Pendaftaran berhasil.',
            'data' => $user
        ], 201);
    }

    /**
     * Login User
     */
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Kata sandi wajib diisi.',
            ]
        );

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau kata sandi salah.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
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
            'message' => 'Profil pengguna berhasil diambil.',
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
            'message' => 'Logout berhasil.'
        ], 200);
    }

    /**
     * Refresh JWT Token
     */
    public function refresh()
    {
        return response()->json([
            'success' => true,
            'message' => 'Token berhasil diperbarui.',
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
        $request->validate(
            [
                'email' => 'required|email'
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan.'
            ], 404);
        }

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
            'message' => 'Kode OTP berhasil dibuat.',
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
        $request->validate(
            [
                'email' => 'required|email',
                'otp_code' => 'required',
                'password' => 'required|min:6|confirmed'
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'otp_code.required' => 'Kode OTP wajib diisi.',
                'password.required' => 'Kata sandi baru wajib diisi.',
                'password.min' => 'Kata sandi minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.'
            ], 404);
        }

        $otp = DB::table('otp_tokens')
            ->where('user_id', $user->id)
            ->where('otp_code', $request->otp_code)
            ->first();

        if (!$otp) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP salah atau tidak valid.'
            ], 400);
        }

        if (Carbon::now()->gt($otp->expired_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kedaluwarsa.'
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
            'message' => 'Kata sandi berhasil direset.'
        ], 200);
    }

    /**
     * Redirect User To Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->with([
                'prompt' => 'select_account'
            ])
            ->redirect();
    }

    /**
     * Handle Google Callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt('google-login'),
                    'role_id' => 3,
                ]);
            }

            $token = Auth::guard('api')->login($user);

            return redirect()->route('google.success', [
                'token' => $token
            ]);

        } catch (\Exception $e) {
            return redirect()->route('google.failed', [
                'message' => 'Login dengan Google gagal.'
            ]);
        }
    }
}