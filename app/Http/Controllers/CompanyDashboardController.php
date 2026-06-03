<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;
use App\Models\JobApplication;

class CompanyDashboardController extends Controller
{
    /**
     * Display the company recruiter dashboard.
     */
    public function index()
    {
        // Fetch company from database
        $company = Company::first();

        // If no company exists, fallback to empty object
        if (!$company) {
            $company = new Company([
                'name' => '',
                'description' => '',
            ]);
        }

        // Auto-close expired jobs first (Hybrid Option)
        Job::where('status', 'buka')
            ->whereNotNull('deadline')
            ->where('deadline', '<', now()->toDateString())
            ->update(['status' => 'tutup']);

        // Fetch active jobs from database
        $realActiveJobs = Job::where('status', 'buka')->withCount('applications')->latest()->get();
        $lowonganAktifCount = $realActiveJobs->count();

        $allJobIds = Job::pluck('id');

        // Total pelamar real
        $totalPelamarReal = \App\Models\JobApplication::whereIn('job_id', $allJobIds)->count();

        // Perlu ditinjau real (status BARU or REVIEW)
        $perluDitinjauReal = \App\Models\JobApplication::whereIn('job_id', $allJobIds)
            ->whereIn('status', ['BARU', 'REVIEW'])
            ->count();

        // Diterima bulan ini real
        $diterimaBulanIniReal = \App\Models\JobApplication::whereIn('job_id', $allJobIds)
            ->where('status', 'DITERIMA')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // 2. Statistics Cards
        $stats = [
            'lowongan_aktif' => [
                'value' => $lowonganAktifCount,
                'note' => '+2 bulan ini'
            ],
            'total_pelamar' => [
                'value' => $totalPelamarReal,
                'note' => 'Live'
            ],
            'perlu_ditinjau' => [
                'value' => $perluDitinjauReal,
                'note' => $perluDitinjauReal > 5 ? 'MENDESAK' : 'OK'
            ],
            'diterima_bulan_ini' => [
                'value' => $diterimaBulanIniReal,
                'note' => ''
            ]
        ];

        // 3. Active Jobs Table Data
        $activeJobs = $realActiveJobs->map(function ($job) {
            return [
                'posisi' => $job->posisi,
                'team' => $job->kategori, // Use kategori as team
                'lokasi' => 'Jakarta', // dummy fallback
                'pelamar_count' => $job->applications_count,
                'status' => 'AKTIF',
                'deadline' => $job->deadline ? \Carbon\Carbon::parse($job->deadline)->translatedFormat('d M Y') : 'Tidak ada'
            ];
        })->toArray();

        // 4. Recent Applicants Data from Database
        $realRecentApplicants = \App\Models\JobApplication::with(['user', 'job'])
            ->whereIn('job_id', $allJobIds)
            ->latest()
            ->take(4)
            ->get();

        $recentApplicants = $realRecentApplicants->map(function ($app) {
            // Determine human-readable time diff
            $waktuDiff = $app->created_at ? $app->created_at->diffForHumans() : 'Baru saja';
            
            // Map status badges
            $badge = $app->status === 'BARU' ? 'BARU' : 'REVIEW';
            
            // Random bg color for initial avatar
            $bgColors = [
                'bg-emerald-100 text-emerald-800',
                'bg-blue-100 text-blue-800',
                'bg-indigo-100 text-indigo-800',
                'bg-amber-100 text-amber-800'
            ];
            $avatarBg = $bgColors[rand(0, 3)];

            return [
                'nama' => $app->user->name ?? 'Anonim',
                'posisi' => $app->job->posisi ?? 'Posisi Umum',
                'badge' => $badge,
                'waktu' => $waktuDiff,
                'avatar_bg' => $avatarBg
            ];
        })->toArray();

        return view('company.dashboard', compact('company', 'stats', 'activeJobs', 'recentApplicants'));
    }

    /**
     * Show the company profile page.
     */
    public function profile()
    {
        $company = Company::with(['perks', 'galleries'])->first();
        
        if (!$company) {
            abort(404, 'Company profile not found.');
        }

        return view('company.profile', compact('company'));
    }

    /**
     * Show the company profile edit page.
     */
    public function editProfile()
    {
        $company = Company::first();

        if (!$company) {
            abort(404, 'Company profile not found.');
        }
        
        return view('company.edit-profile', compact('company'));
    }

    /**
     * Update the company profile.
     */
    public function updateProfile(Request $request)
    {
        $company = Company::firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:50',
            'hq' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'mission' => 'nullable|string',
            'culture' => 'nullable|string',
            'perks' => 'nullable|array',
            'perks.*' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('company_images', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($company->banner_path) {
                Storage::disk('public')->delete($company->banner_path);
            }
            $validated['banner_path'] = $request->file('banner')->store('company_images', 'public');
        }

        $company->update($validated);

        // Keep logged-in user's company_name in users table synchronized
        try {
            $user = auth('api')->user();
            if (!$user && $request->has('user_email')) {
                $user = \App\Models\User::where('email', $request->input('user_email'))->first();
            }
            if ($user) {
                $user->update([
                    'company_name' => $request->input('name')
                ]);
            }
        } catch (\Exception $e) {
            // Log/ignore silently to not block profile updates if JWT error occurs
        }

        if ($request->has('perks')) {
            $company->perks()->delete();
            $perksToInsert = [];
            foreach ($request->perks as $perk) {
                if (!empty(trim($perk))) {
                    $perksToInsert[] = ['perk_name' => trim($perk)];
                }
            }
            if (count($perksToInsert) > 0) {
                $company->perks()->createMany($perksToInsert);
            }
        } else {
            $company->perks()->delete();
        }

        // Handle gallery photo deletions
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $gallery = $company->galleries()->find($photoId);
                if ($gallery) {
                    Storage::disk('public')->delete($gallery->image_path);
                    $gallery->delete();
                }
            }
        }

        // Handle gallery new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('company_galleries', 'public');
                $company->galleries()->create([
                    'image_path' => $path
                ]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profil perusahaan berhasil diperbarui.'
            ]);
        }

        return redirect()->route('company.profile')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    /**
     * Show the incoming applicants page.
     */
    public function applicants()
{
    $applications = JobApplication::with([
        'user',
        'job'
    ])
    ->latest()
    ->paginate(10);

    $newCount = JobApplication::where(
        'status',
        'BARU'
    )->count();

    $interviewCount = JobApplication::where(
        'status',
        'INTERVIEW'
    )->count();

    $acceptedCount = JobApplication::where(
        'status',
        'DITERIMA'
    )->count();

    $rejectedCount = JobApplication::where(
        'status',
        'DITOLAK'
    )->count();

    return view(
        'company.applicants',
        compact(
            'applications',
            'newCount',
            'interviewCount',
            'acceptedCount',
            'rejectedCount'
        )
    );
}

public function reviewApplicant($id)
{
    $application = JobApplication::with([
        'user',
        'user.experiences',
        'user.skills',
        'user.certifications',
        'user.educations',
        'job'
    ])->findOrFail($id);

    return view('company.review-applicant', compact('application'));
}

public function updateApplicantStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:BARU,REVIEW,INTERVIEW,DITERIMA,DITOLAK'
    ]);

    $application = JobApplication::findOrFail($id);
    $application->update(['status' => $request->status]);

    return back()->with('success', 'Status pelamar berhasil diperbarui.');
}
}
