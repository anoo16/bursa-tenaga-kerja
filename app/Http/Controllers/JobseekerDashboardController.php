<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\SavedJob;
use Illuminate\Support\Facades\Auth;

class JobseekerDashboardController extends Controller
{
    public function index()
    {
        // Ambil user_id: prioritaskan Auth session, fallback ke query string (pola JWT project ini)
        $user   = Auth::guard('api')->user();
        $userId = optional($user)->id ?? (int) request('user_id') ?: null;

        // ── STATISTIK ──────────────────────────────────────────────────
        if ($userId) {
            $allApplications = JobApplication::where('user_id', $userId)->get();

            $totalLamaran = $allApplications->count();
            $diproses     = $allApplications->whereIn('status', ['REVIEW', 'INTERVIEW'])->count();
            $diterima     = $allApplications->where('status', 'DITERIMA')->count();
            $ditolak      = $allApplications->where('status', 'DITOLAK')->count();
        } else {
            $totalLamaran = $diproses = $diterima = $ditolak = 0;
        }

        // ── LAMARAN TERBARU (5 terbaru) ────────────────────────────────
        $lamaranTerbaru = collect();
        if ($userId) {
            $lamaranTerbaru = JobApplication::with(['job.company'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // ── REKOMENDASI LOWONGAN ────────────────────────────────────────
        // Ambil 3 lowongan aktif yang belum dilamar user, terbaru
        $appliedJobIds = $userId
            ? JobApplication::where('user_id', $userId)->pluck('job_id')
            : collect();

        $rekomendasiLowongan = Job::with('company')
            ->where('status', 'buka')
            ->whereNotIn('id', $appliedJobIds)
            ->latest()
            ->limit(3)
            ->get();

        return view('dashboard.jobseeker', compact(
            'user',
            'totalLamaran',
            'diproses',
            'diterima',
            'ditolak',
            'lamaranTerbaru',
            'rekomendasiLowongan'
        ));
    }
}