<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthController extends Controller
{
    /**
     * Membuat dan mengirim OTP kepada user.
     */
    private function generateOtpForUser(User $user, string $purpose = 'verifikasi'): array
    {
        DB::table('otp_tokens')
            ->where('user_id', $user->id)
            ->delete();

        $otp = random_int(100000, 999999);

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
            'expired_at' => $expiredAt,
        ];
    }

    /**
     * Register User.
     *
     * Role publik:
     * 2 = Recruiter / Company
     * 3 = Jobseeker
     */
    public function register(Request $request)
    {
        $isRecruiter = (int) $request->input('role_id') === 2;

        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'role_id' => 'required|integer|in:2,3',

                'phone' => 'nullable|regex:/^[0-9]+$/|min:10|max:15',
                'birth_date' => 'nullable|date',
                'education' => 'nullable|string|max:255',

                'company_name' => $isRecruiter
                    ? 'required|string|max:255'
                    : 'nullable|string|max:255',

                'npwp' => $isRecruiter
                    ? 'required|string|regex:/^\d{2}\.\d{3}\.\d{3}\.\d-\d{3}\.\d{3}$/'
                    : 'nullable|string|regex:/^\d{2}\.\d{3}\.\d{3}\.\d-\d{3}\.\d{3}$/',

                'npwp_file' => $isRecruiter
                    ? 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
                    : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

                'business_license_file' => $isRecruiter
                    ? 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
                    : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

                'pic_authorization_file' => $isRecruiter
                    ? 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
                    : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

                'terms' => 'accepted',

            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama tidak valid.',
                'name.max' => 'Nama maksimal 255 karakter.',

                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',

                'password.required' => 'Kata sandi wajib diisi.',
                'password.min' => 'Kata sandi minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',

                'role_id.required' => 'Tipe akun wajib dipilih.',
                'role_id.integer' => 'Tipe akun tidak valid.',
                'role_id.in' => 'Tipe akun tidak valid.',

                'phone.regex' => 'Nomor telepon hanya boleh berisi angka.',
                'phone.min' => 'Nomor telepon minimal 10 karakter.',
                'phone.max' => 'Nomor telepon maksimal 15 karakter.',

                'birth_date.date' => 'Format tanggal lahir tidak valid.',

                'education.string' => 'Pendidikan tidak valid.',
                'education.max' => 'Pendidikan maksimal 255 karakter.',

                'company_name.required' => 'Nama perusahaan wajib diisi.',
                'company_name.string' => 'Nama perusahaan tidak valid.',
                'company_name.max' => 'Nama perusahaan maksimal 255 karakter.',

                'npwp.regex' => 'Format NPWP harus lengkap, contoh: 00.000.000.0-000.000.',

                'npwp_file.required' => 'Dokumen NPWP wajib diunggah.',
                'npwp_file.file' => 'Dokumen NPWP tidak valid.',
                'npwp_file.mimes' => 'Dokumen NPWP harus berupa PDF, JPG, JPEG, atau PNG.',
                'npwp_file.max' => 'Ukuran dokumen NPWP maksimal 2 MB.',

                'business_license_file.required' => 'Dokumen izin usaha wajib diunggah.',
                'business_license_file.file' => 'Dokumen izin usaha tidak valid.',
                'business_license_file.mimes' => 'Dokumen izin usaha harus berupa PDF, JPG, JPEG, atau PNG.',
                'business_license_file.max' => 'Ukuran dokumen izin usaha maksimal 2 MB.',

                'pic_authorization_file.required' => 'Surat kuasa PIC wajib diunggah.',
                'pic_authorization_file.file' => 'Surat kuasa PIC tidak valid.',
                'pic_authorization_file.mimes' => 'Surat kuasa PIC harus berupa PDF, JPG, JPEG, atau PNG.',
                'pic_authorization_file.max' => 'Ukuran surat kuasa PIC maksimal 2 MB.',

                'terms.accepted' => 'Anda wajib menyetujui Syarat & Ketentuan serta Kebijakan Privasi.',
            ]
        );

        $storedFiles = [];

        try {
            DB::beginTransaction();

            if ($isRecruiter) {
                $storedFiles['npwp_file'] = $request
                    ->file('npwp_file')
                    ->store('recruiter-documents/npwp', 'local');

                $storedFiles['business_license_file'] = $request
                    ->file('business_license_file')
                    ->store('recruiter-documents/business-license', 'local');

                $storedFiles['pic_authorization_file'] = $request
                    ->file('pic_authorization_file')
                    ->store('recruiter-documents/pic-authorization', 'local');
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role_id' => $validated['role_id'],

                'is_verified' => false,
                'approval_status' => $isRecruiter ? 'pending' : 'approved',
                'rejected_reason' => null,

                'phone' => $validated['phone'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'education' => $validated['education'] ?? null,

                'company_name' => $validated['company_name'] ?? null,
                'npwp' => $validated['npwp'] ?? null,
                'npwp_file' => $storedFiles['npwp_file'] ?? null,
                'business_license_file' => $storedFiles['business_license_file'] ?? null,
                'pic_authorization_file' => $storedFiles['pic_authorization_file'] ?? null,
            ]);

            $otpData = $this->generateOtpForUser(
                $user,
                $isRecruiter ? 'verifikasi pendaftaran recruiter' : 'verifikasi pendaftaran'
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil. Kode OTP telah dikirim ke email Anda.',
                'data' => [
                    'email' => $user->email,
                    'expired_at' => $otpData['expired_at'],
                ]
            ], 201);

        } catch (Throwable $exception) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            foreach ($storedFiles as $filePath) {
                Storage::disk('local')->delete($filePath);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran gagal diproses. Pastikan email dapat menerima kode OTP, lalu coba kembali.'
            ], 500);
        }
    }

    /**
     * Verify OTP Register.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'otp_code' => 'required|digits:6',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'otp_code.required' => 'Kode OTP wajib diisi.',
                'otp_code.digits' => 'Kode OTP harus terdiri dari 6 digit.',
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

        if (Carbon::parse($otp->expired_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode OTP.'
            ], 400);
        }

        $user->update([
            'is_verified' => true,
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
     * Resend OTP Register.
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

        try {
            $otpData = $this->generateOtpForUser($user, 'verifikasi pendaftaran');

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP baru telah dikirim ke email Anda.',
                'data' => [
                    'expired_at' => $otpData['expired_at'],
                ]
            ], 200);

        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Kode OTP gagal dikirim. Silakan coba kembali.'
            ], 500);
        }
    }

    /**
     * Login User.
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

        $userCheck = User::where('email', $request->email)->first();

        if (!$userCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Akun belum terdaftar. Silakan buat akun terlebih dahulu.'
            ], 404);
        }

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi salah.'
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
     * Get Authenticated User.
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
     * Logout User.
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
     * Refresh JWT Token.
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
     * Forgot Password - Generate and Send OTP.
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

        try {
            $otpData = $this->generateOtpForUser($user, 'reset kata sandi');

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP telah dikirim ke email Anda.',
                'data' => [
                    'expired_at' => $otpData['expired_at']
                ]
            ], 200);

        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Kode OTP gagal dikirim. Silakan coba kembali.'
            ], 500);
        }
    }

    /**
     * Verify OTP For Reset Password.
     */
    public function verifyResetOtp(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'otp_code' => 'required|digits:6',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'otp_code.required' => 'Kode OTP wajib diisi.',
                'otp_code.digits' => 'Kode OTP harus terdiri dari 6 digit.',
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

        if (Carbon::parse($otp->expired_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode OTP.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP berhasil diverifikasi.'
        ], 200);
    }

    /**
     * Reset Password Using OTP.
     */
    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'otp_code' => 'required|digits:6',
                'password' => 'required|min:6|confirmed'
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'otp_code.required' => 'Kode OTP wajib diisi.',
                'otp_code.digits' => 'Kode OTP harus terdiri dari 6 digit.',
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

        if (Carbon::parse($otp->expired_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode OTP.'
            ], 400);
        }

        $user->update([
            'password' => $request->password
        ]);

        DB::table('otp_tokens')
            ->where('user_id', $user->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil direset. Silakan login menggunakan kata sandi baru.'
        ], 200);
    }

    /**
     * Pending Recruiters.
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
     * Detail Recruiter / Company untuk admin.
     */
    public function showRecruiter($id)
    {
        $user = User::where('role_id', 2)->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Recruiter tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail recruiter berhasil diambil.',
            'data' => [
                'id' => $user->id,
                'user_code' => '#CPY-' . str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
                'name' => $user->name,
                'company_name' => $user->company_name,
                'email' => $user->email,
                'npwp' => $user->npwp,
                'role_id' => $user->role_id,
                'role_name' => 'Recruiter / Company',
                'is_verified' => (bool) $user->is_verified,
                'approval_status' => $user->approval_status,
                'rejected_reason' => $user->rejected_reason,
                'created_at' => $user->created_at,
                'documents' => [
                    'npwp' => !empty($user->npwp_file),
                    'business_license' => !empty($user->business_license_file),
                    'pic_authorization' => !empty($user->pic_authorization_file),
                ],
            ]
        ], 200);
    }

    /**
     * Membuka dokumen recruiter secara aman untuk admin.
     */
    public function viewRecruiterDocument($id, $type)
    { 
        $documentTypes = [
            'npwp' => [
                'column' => 'npwp_file',
                'label' => 'Dokumen NPWP',
            ],
            'business-license' => [
                'column' => 'business_license_file',
                'label' => 'Dokumen Izin Usaha',
            ],
            'pic-authorization' => [
                'column' => 'pic_authorization_file',
                'label' => 'Surat Kuasa PIC',
            ],
        ];

        if (!array_key_exists($type, $documentTypes)) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis dokumen tidak valid.'
            ], 404);
        }

        $user = User::where('role_id', 2)->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Recruiter tidak ditemukan.'
            ], 404);
        }

        $column = $documentTypes[$type]['column'];
        $documentLabel = $documentTypes[$type]['label'];
        $filePath = $user->{$column};

        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => $documentLabel . ' tidak ditemukan.'
            ], 404);
        }

        $absolutePath = Storage::disk('local')->path($filePath);
        $mimeType = Storage::disk('local')->mimeType($filePath)
            ?? 'application/octet-stream';

        return response()->file($absolutePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
        ]);
    }

    /**
     * Approve Recruiter.
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
     * Reject Recruiter.
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
            'rejected_reason' => $request->rejected_reason
                ?? 'Pendaftaran recruiter ditolak oleh admin.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recruiter berhasil ditolak.',
            'data' => $user
        ], 200);
    }

    /**
     * Redirect User To Google.
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
     * Handle Google Callback.
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
                    'password' => 'google-login',
                    'role_id' => 3,
                    'is_verified' => true,
                    'approval_status' => 'approved',
                    'rejected_reason' => null,
                ]);
            }

            if (!$user->is_verified) {
                $user->update([
                    'is_verified' => true,
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

        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('google.failed', [
                'message' => 'Login dengan Google gagal.'
            ]);
        }
    }
}