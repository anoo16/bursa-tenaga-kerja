<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Generate OTP untuk user.
     */
    private function generateOtpForUser(User $user, $purpose = 'verifikasi')
    {
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
            'updated_at' => now(),
        ]);

         Mail::to($user->email)->send(new OtpMail($otp, $purpose));

        return [
            'otp_code' => $otp,
            'expired_at' => $expiredAt,
        ];
    }

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

        $approvalStatus = $validated['role_id'] == 2 ? 'pending' : 'approved';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => $validated['role_id'],

            'is_verified' => 0,
            'approval_status' => $approvalStatus,
            'rejected_reason' => null,

            'phone' => $validated['phone'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'education' => $validated['education'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
        ]);

        $otpData = $this->generateOtpForUser($user, 'verifikasi pendaftaran');

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil. Silakan verifikasi akun menggunakan kode OTP.',
            'data' => [
                'user' => $user,
                'email' => $user->email,

                // Untuk testing lokal. Jika email sudah aktif, bagian ini bisa dihapus dari response.
                'otp_code' => $otpData['otp_code'],
                'expired_at' => $otpData['expired_at'],
            ]
        ], 201);
    }

    /**
     * Verify OTP Register
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'otp_code' => 'required',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'otp_code.required' => 'Kode OTP wajib diisi.',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.'
            ], 404);
        }

        if ($user->is_verified) {
            return response()->json([
                'success' => true,
                'message' => 'Akun sudah terverifikasi.'
            ], 200);
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
            'is_verified' => 1,
        ]);

        DB::table('otp_tokens')
            ->where('user_id', $user->id)
            ->delete();

        if ($user->role_id == 2) {
            return response()->json([
                'success' => true,
                'message' => 'Verifikasi akun berhasil. Akun recruiter Anda sedang menunggu persetujuan admin.'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi akun berhasil. Silakan login.'
        ], 200);
    }

    /**
     * Resend OTP Register
     */
    public function resendOtp(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
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
                'message' => 'Pengguna tidak ditemukan.'
            ], 404);
        }

        if ($user->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Akun sudah terverifikasi.'
            ], 400);
        }

        $otpData = $this->generateOtpForUser($user, 'verifikasi pendaftaran');

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP baru berhasil dibuat.',
            'data' => [
                'otp_code' => $otpData['otp_code'],
                'expired_at' => $otpData['expired_at'],
            ]
        ], 200);
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

        $user = Auth::guard('api')->user();

        if ($user->role_id != 1 && !$user->is_verified) {
            Auth::guard('api')->logout();

            return response()->json([
                'success' => false,
                'message' => 'Akun belum terverifikasi. Silakan verifikasi OTP terlebih dahulu.',
                'data' => [
                    'email' => $user->email
                ]
            ], 403);
        }

        if ($user->role_id == 2 && $user->approval_status === 'pending') {
            Auth::guard('api')->logout();

            return response()->json([
                'success' => false,
                'message' => 'Akun recruiter Anda sedang menunggu persetujuan admin.'
            ], 403);
        }

        if ($user->role_id == 2 && $user->approval_status === 'rejected') {
            Auth::guard('api')->logout();

            return response()->json([
                'success' => false,
                'message' => 'Akun recruiter Anda ditolak oleh admin.',
                'data' => [
                    'rejected_reason' => $user->rejected_reason
                ]
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => $user
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

        $otpData = $this->generateOtpForUser($user, 'reset kata sandi');

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP berhasil dibuat.',
            'data' => [
                'otp_code' => $otpData['otp_code'],
                'expired_at' => $otpData['expired_at']
            ]
        ], 200);
    }

    /**
     * Verify OTP For Reset Password
     */
    public function verifyResetOtp(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'otp_code' => 'required',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'otp_code.required' => 'Kode OTP wajib diisi.',
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

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP berhasil diverifikasi.'
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
     * Pending Recruiters
     */
    public function pendingRecruiters()
    {
        $recruiters = User::where('role_id', 2)
            ->where('approval_status', 'pending')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data recruiter pending berhasil diambil.',
            'data' => $recruiters
        ], 200);
    }

    /**
     * Approve Recruiter
     */
    public function approveRecruiter($id)
    {
        $user = User::where('role_id', 2)->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Recruiter tidak ditemukan.'
            ], 404);
        }

        $user->update([
            'approval_status' => 'approved',
            'rejected_reason' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recruiter berhasil diterima.',
            'data' => $user
        ], 200);
    }

    /**
     * Reject Recruiter
     */
    public function rejectRecruiter(Request $request, $id)
    {
        $request->validate(
            [
                'rejected_reason' => 'nullable|string|max:1000',
            ],
            [
                'rejected_reason.max' => 'Alasan penolakan maksimal 1000 karakter.',
            ]
        );

        $user = User::where('role_id', 2)->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Recruiter tidak ditemukan.'
            ], 404);
        }

        $user->update([
            'approval_status' => 'rejected',
            'rejected_reason' => $request->rejected_reason ?? 'Pendaftaran recruiter ditolak oleh admin.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recruiter berhasil ditolak.',
            'data' => $user
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
                    'is_verified' => 1,
                    'approval_status' => 'approved',
                    'rejected_reason' => null,
                ]);
            }

            if (!$user->is_verified) {
                $user->update([
                    'is_verified' => 1,
                ]);
            }

            if ($user->role_id == 2 && $user->approval_status !== 'approved') {
                return redirect()->route('google.failed', [
                    'message' => 'Akun recruiter Anda belum disetujui admin.'
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