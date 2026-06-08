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

        // Filter lokasi (dari tabel companies)
        if ($request->filled('lokasi')) {
        $query->whereHas('company', function($q) use ($request) {
        $q->where('hq', 'like', '%' . $request->lokasi . '%');
        });
        }

        // Filter kategori / bidang industri
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter tipe pekerjaan
        if ($request->filled('jenis_bidang')) {
            $query->where('jenis_bidang', $request->jenis_bidang);
        }

        // Filter gaji
        if ($request->filled('gaji_min') || $request->filled('gaji_max')) {
            if ($request->filled('gaji_min')) {
                $min = (int) $request->gaji_min * 1000000;
                $query->where('gaji_minimum', '>=', $min);
        }
        if ($request->filled('gaji_max')) {
            $max = (int) $request->gaji_max * 1000000;
            $query->where('gaji_maksimum', '<=', $max);
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
        $jenis_bidangs = [
            'IT & Software',
            'Data Science & AI',
            'Cyber Security',
            'Business & Management',
            'Finance & Accounting',
            'Human Resources',
            'Education',
            'Healthcare',
            'Engineering'
        ];

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
            'jenis_bidangs',
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