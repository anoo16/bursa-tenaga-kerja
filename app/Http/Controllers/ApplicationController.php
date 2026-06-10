<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
        public function index()
{
    $userId = request('user_id');

    $stats = [
        'total'    => 0,
        'review'   => 0,
        'diterima' => 0,
        'menunggu' => 0,
    ];

    if ($userId) {
        $all = JobApplication::where('user_id', $userId)->get();

        $stats = [
            'total'    => $all->count(),
            'review'   => $all->whereIn('status', ['REVIEW', 'INTERVIEW'])->count(),
            'diterima' => $all->where('status', 'DITERIMA')->count(),
            'menunggu' => $all->where('status', 'BARU')->count(),
        ];
    }

    $query = JobApplication::with('job');

    if ($userId) {
        $query->where('user_id', $userId);
    } else {
        // Tidak ada user_id = tampilkan kosong
        $query->whereRaw('1=0');
    }

    if (request('status')) {
        $query->where('status', request('status'));
    }

    $sort = request('sort', 'terbaru');
    if ($sort === 'terlama') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $applications = $query->paginate(10);

    return view('applications.lamaran-saya', compact('applications', 'stats'));
}

    public function create($jobId)
    {
        return view(
            'applications.create',
            compact('jobId')
        );
    }

    public function store(Request $request)
{
    $request->validate([
        'job_id'         => 'required|exists:jobs,id',
        'cover_letter'   => 'nullable|string|max:2000',
        'cv_file'        => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        'portfolio_file' => 'nullable|file|mimes:pdf|max:5120',
        'portfolio_link' => 'nullable|url|max:500',
        'user_id'        => 'required|exists:users,id',
    ]);

    $user = \App\Models\User::find($request->user_id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User tidak ditemukan.'
        ], 401);
    }

    $exists = JobApplication::where('user_id', $user->id)
        ->where('job_id', $request->job_id)
        ->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Anda sudah melamar lowongan ini.'
        ], 422);
    }

    DB::transaction(function () use ($request, $user) {
        $cvPath        = null;
        $portfolioPath = null;

        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')
                ->store('applications/cv', 'public');
        }

        if ($request->hasFile('portfolio_file')) {
            $portfolioPath = $request->file('portfolio_file')
                ->store('applications/portfolio', 'public');
        }

        JobApplication::create([
            'user_id'        => $user->id,
            'job_id'         => $request->job_id,
            'cover_letter'   => $request->cover_letter,
            'cv_file'        => $cvPath,
            'portfolio_file' => $portfolioPath,
            'portfolio_link' => $request->portfolio_link,
            'status'         => 'BARU',
            'applied_at'     => now(),
        ]);
    });

    return response()->json([
        'success'  => true,
        'message'  => 'Lamaran berhasil dikirim!',
        'redirect' => route('applications.success', ['job_id' => $request->job_id]),
    ]);
}

    public function show($id)
{
    $application = JobApplication::with([
        'job',
        'user',
    ])->find($id);

    // Ambil data company (satu perusahaan di sistem ini)
    $company = \App\Models\Company::first();

    return view('applications.show', compact('application', 'company'));
}

public function success(Request $request)
{
    $job = \App\Models\Job::find($request->job_id);

    $company = \App\Models\Company::first();

    return view('applications.success', compact('job', 'company'));
}
public function withdraw($id)
{
    $application = JobApplication::findOrFail($id);

    $application->delete();

    return redirect()->route('applications.lamaran-saya')
        ->with('success', 'Lamaran berhasil dibatalkan.');
}
}