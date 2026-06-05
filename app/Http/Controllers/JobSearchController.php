<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSearchController extends Controller
{
    public function index(Request $request)
    {
        $company = Company::first();

        // Auto-close expired jobs
        Job::where('status', 'buka')
            ->whereNotNull('deadline')
            ->where('deadline', '<', now()->toDateString())
            ->update(['status' => 'tutup']);

        $query = Job::where('status', 'buka');

        // Filter pencarian posisi
        if ($request->filled('search')) {
            $query->where(
                'posisi', 'like', '%' . $request->search . '%'
            );
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter gaji (sederhana: cari string)
        if ($request->filled('gaji')) {
            $query->where('gaji', 'like', '%' . $request->gaji . '%');
        }

        // Urutkan
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $jobs = $query->withCount('applications')->paginate(6)->withQueryString();

        // Ambil semua kategori unik untuk filter
        $kategoris = Job::where('status', 'buka')
            ->distinct()
            ->pluck('kategori');

        // Ambil ID job yang sudah dilamar user ini
        $appliedJobIds = collect();
        $user = Auth::guard('api')->user();
        if ($user) {
            $appliedJobIds = JobApplication::where('user_id', $user->id)
                ->pluck('job_id');
        }

        $totalJobs = Job::where('status', 'buka')->count();

        return view('jobseeker.cari-lowongan', compact(
            'jobs',
            'kategoris',
            'appliedJobIds',
            'totalJobs',
            'company',
            'sort'
        ));
    }
    public function show(Job $job)
{
    // Auto-close jika deadline lewat
    if ($job->status === 'buka' && $job->deadline && $job->deadline < now()->toDateString()) {
        $job->update(['status' => 'tutup']);
    }

    $company    = Company::first();
    $user       = Auth::guard('api')->user();
    $sudahLamar = false;

    if ($user) {
        $sudahLamar = JobApplication::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->exists();
    }

    return view('jobseeker.detail-lowongan', compact('job', 'company', 'sudahLamar'));
}
}