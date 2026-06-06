<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /*
     * Menampilkan halaman kelola lowongan
     */

    public function index()
    {
        // Auto-close expired jobs first (Hybrid Option)
        Job::where('status', 'buka')
            ->whereNotNull('deadline')
            ->where('deadline', '<', now()->toDateString())
            ->update(['status' => 'tutup']);

        // mengambil data terbaru beserta jumlah pelamar
        $jobs = Job::withCount('applications')->latest()->paginate(5);

        // Jika halaman saat ini kosong dan bukan halaman pertama, redirect ke halaman terakhir yang valid
        if ($jobs->isEmpty() && $jobs->currentPage() > 1) {
            return redirect()->to($jobs->url($jobs->lastPage()));
        }

        // Ambil ID semua lowongan
        $jobIds = Job::pluck('id');

        // Total pelamar real
        $totalPelamar = \App\Models\JobApplication::whereIn('job_id', $jobIds)->count();

        // Jumlah perekrutan berhasil (status DITERIMA)
        $perekrutanDiterima = \App\Models\JobApplication::whereIn('job_id', $jobIds)
            ->where('status', 'DITERIMA')
            ->count();

        // Persentase perekrutan berhasil
        $persentaseSukses = $totalPelamar > 0
            ? round(($perekrutanDiterima / $totalPelamar) * 100)
            : 0;

        $stats = [
            'aktif' => Job::where('status', 'buka')->count(),
            'pelamar' => $totalPelamar,
            'sukses' => $persentaseSukses
        ];

        return view(
            'lowongan.kelola-lowongan',
            compact(
                'jobs',
                'stats'
            )
        );
    }

    /*
     * Menyimpan lowongan baru
     */

    public function store(Request $request)
    {
        // validasi form

        $request->validate([
            'posisi' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_bidang' => 'required|string',
            'gaji_minimum' => 'required|numeric|min:0',
            'gaji_maksimum' => 'required|numeric|min:0',
            'deadline' => 'nullable|date',
            'tanggung_jawab' => 'required|array|min:1',
            'tanggung_jawab.*' => 'required|string',
            'kualifikasi' => 'required|array|min:1',
            'kualifikasi.*' => 'required|string',
        ]);

        Job::create([
            'company_id' => 1, // Pastikan company_id disertakan
            'posisi' => $request->posisi,
            'kategori' => $request->kategori,
            'jenis_bidang' => $request->jenis_bidang,
            'gaji_minimum' => $request->gaji_minimum,
            'gaji_maksimum' => $request->gaji_maksimum,
            // Batas waktu lowongan (opsional)
            'deadline' => $request->deadline ?: null,
            // Mengambil array tanggung jawab
            'tanggung_jawab' => $request->tanggung_jawab,
            // Mengambil array kualifikasi
            'kualifikasi' => $request->kualifikasi,
            // Default status saat dibuat
            'status' => 'buka',
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Lowongan berhasil ditambahkan'
            );
    }

    public function update(
        Request $request,
        Job $job
    ) {
        // Validasi form
        $request->validate([
            'posisi' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_bidang' => 'required|string',
            'gaji_minimum' => 'required|numeric|min:0',
            'gaji_maksimum' => 'required|numeric|min:0',
            'deadline' => 'nullable|date',
            'tanggung_jawab' => 'nullable|array|min:1',
            'tanggung_jawab.*' => 'required|string',
            'kualifikasi' => 'nullable|array|min:1',
            'kualifikasi.*' => 'required|string',
        ]);

        // Update data lowongan
        $job->update([
            'posisi' => $request->posisi,
            'kategori' => $request->kategori,
            'jenis_bidang' => $request->jenis_bidang,
            'gaji_minimum' => $request->gaji_minimum,
            'gaji_maksimum' => $request->gaji_maksimum,
            'deadline' => $request->deadline ?: null,
            'tanggung_jawab' => $request->tanggung_jawab,
            'kualifikasi' => $request->kualifikasi,
        ]);

        // Kembali dengan notifikasi sukses
        return back()
            ->with('success', 'Lowongan berhasil diperbarui');
    }

    /*
     * Mengubah status lowongan
     */

    public function toggleStatus(Job $job)
    {
        if ($job->status == 'buka') {
            $job->status = 'tutup';
        } else {
            // Cek jika deadline sudah lewat
            if ($job->deadline && $job->deadline < now()->toDateString()) {
                return back()->with('error', 'Silakan edit lowongan ini terlebih dahulu untuk memperbarui tanggal deadline.');
            }
            $job->status = 'buka';
        }

        $job->save();

        return back()
            ->with('success', 'Status lowongan berhasil diperbarui');
    }

    /*
     * Menghapus lowongan
     */

    public function destroy(Job $job)
    {
        $job->delete();

        return back()
            ->with(
                'success',
                'Lowongan berhasil dihapus'
            );
    }
}
