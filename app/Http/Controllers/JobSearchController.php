<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSearchController extends Controller
{
    public function index(Request $request)
    {
        $company = Company::first();

        Job::where('status', 'buka')
            ->whereNotNull('deadline')
            ->where('deadline', '<', now()->toDateString())
            ->update(['status' => 'tutup']);

        $query = Job::where('status', 'buka');

        // Filter pencarian posisi
        if ($request->filled('search')) {
            $query->where('posisi', 'like', '%' . $request->search . '%');
        }

        // Filter lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        // Filter kategori / bidang industri
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter tipe pekerjaan
        if ($request->filled('jenis')) {
            $query->where('kategori', $request->jenis);
        }

        // Filter gaji (string match — sesuai kolom 'gaji' milikmu)
        if ($request->filled('gaji_min') || $request->filled('gaji_max')) {
            if ($request->filled('gaji_min')) {
                $query->where('gaji', 'like', '%' . $request->gaji_min . '%');
            }
        }

        // Urutkan
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $jobs = $query->withCount('applications')->paginate(6)->withQueryString();

        // Kategori unik untuk dropdown
        $kategoris = Job::where('status', 'buka')->distinct()->pluck('kategori');

        // user_id dari JWT atau query string
        $appliedJobIds = collect();
        $savedJobIds   = collect();

        $user = Auth::guard('api')->user();
        if ($user) {
            $appliedJobIds = JobApplication::where('user_id', $user->id)->pluck('job_id');
            $savedJobIds   = SavedJob::where('user_id', $user->id)->pluck('job_id');
        }

        // Fallback: ambil dari query string (pola JWT proyek ini)
        if ($appliedJobIds->isEmpty() && request('user_id')) {
            $uid = (int) request('user_id');
            $appliedJobIds = JobApplication::where('user_id', $uid)->pluck('job_id');
            $savedJobIds   = SavedJob::where('user_id', $uid)->pluck('job_id');
        }

        $totalJobs = $jobs->total();

        return view('jobseeker.cari-lowongan', compact(
            'jobs',
            'kategoris',
            'appliedJobIds',
            'savedJobIds',
            'totalJobs',
            'company',
            'sort'
        ));
    }

    public function show(Job $job)
    {
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