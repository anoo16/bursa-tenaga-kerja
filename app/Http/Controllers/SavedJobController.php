<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\SavedJob;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    public function index(Request $request)
    {
        $userId  = $this->getUserId();
        $company = Company::first();

        if (!$userId) {
            return view('jobseeker.simpan-lowongan', [
                'savedJobs'      => collect(),
                'totalSimpan'    => 0,
                'segeraDeadline' => 0,
                'sudahDilamar'   => 0,
                'appliedJobIds'  => collect(),
                'company'        => $company,
            ]);
        }

        $allSaved       = SavedJob::where('user_id', $userId)->with(['job'])->get();
        $totalSimpan    = $allSaved->count();
        $segeraDeadline = $allSaved->filter(function ($s) {
            $dl = optional($s->job)->deadline;
            if (!$dl) return false;
            $sisa = now()->diffInDays($dl, false);
            return $sisa >= 0 && $sisa <= 7;
        })->count();

        $appliedJobIds = JobApplication::where('user_id', $userId)->pluck('job_id');
        $sudahDilamar  = $allSaved->filter(
            fn($s) => $appliedJobIds->contains(optional($s->job)->id)
        )->count();

        $query = SavedJob::where('user_id', $userId)->with(['job']);

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->whereHas('job', function ($q) use ($keyword) {
                $q->where('posisi', 'like', "%{$keyword}%")
                  ->orWhere('kategori', 'like', "%{$keyword}%");
            });
        }

        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'deadline') {
            $query->join('jobs', 'saved_jobs.job_id', '=', 'jobs.id')
                  ->whereNotNull('jobs.deadline')
                  ->orderBy('jobs.deadline', 'asc')
                  ->select('saved_jobs.*');
        } elseif ($sort === 'az') {
            $query->join('jobs', 'saved_jobs.job_id', '=', 'jobs.id')
                  ->orderBy('jobs.posisi', 'asc')
                  ->select('saved_jobs.*');
        } else {
            $query->orderBy('saved_jobs.created_at', 'desc');
        }

        $savedJobs = $query->paginate(9)->withQueryString();

        return view('jobseeker.simpan-lowongan', compact(
            'savedJobs', 'totalSimpan', 'segeraDeadline',
            'sudahDilamar', 'appliedJobIds', 'company'
        ));
    }

    public function toggle(Request $request, int $jobId)
    {
        $userId = $this->getUserId();

        if (!$userId) {
            return response()->json(['error' => 'Silakan login terlebih dahulu.'], 401);
        }

        $existing = SavedJob::where('user_id', $userId)->where('job_id', $jobId)->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['saved' => false, 'message' => 'Lowongan dihapus dari simpanan.']);
        }

        SavedJob::create(['user_id' => $userId, 'job_id' => $jobId]);
        return response()->json(['saved' => true, 'message' => 'Lowongan berhasil disimpan.']);
    }

    public function remove(int $savedId)
    {
        $userId = $this->getUserId();
        if ($userId) {
            SavedJob::where('id', $savedId)->where('user_id', $userId)->delete();
        }
        return redirect()->route('jobseeker.simpan')->with('success', 'Lowongan dihapus dari simpanan.');
    }

    public function clearAll()
    {
        $userId = $this->getUserId();
        if ($userId) {
            SavedJob::where('user_id', $userId)->delete();
        }
        return redirect()->route('jobseeker.simpan')->with('success', 'Semua lowongan tersimpan telah dihapus.');
    }

    private function getUserId(): ?int
    {
        if ($id = optional(Auth::user())->id) return $id;
        if ($uid = request('user_id')) return (int) $uid;
        return null;
    }
}