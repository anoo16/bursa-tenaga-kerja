<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /*
     * Menampilkan halaman kelola lowongan
     */

    public function index(Request $request)
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

        // Query builder dengan filter
        $query = Job::withCount('applications');

        // Filter: Status Pekerjaan
        if ($request->filled('status')) {
            $statusMap = [
                'aktif'   => 'buka',
                'draft'   => 'draft',
                'ditutup' => 'tutup',
            ];
            $statusVal = $statusMap[$request->status] ?? $request->status;
            $query->where('status', $statusVal);
        }

        // Filter: Kata Kunci
        if ($request->filled('kata_kunci')) {
            $kw = $request->kata_kunci;
            $query->where(function ($q) use ($kw) {
                $q->where('posisi', 'like', "%{$kw}%")
                ->orWhere('kategori', 'like', "%{$kw}%");
            });
        }

        // Filter: Kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        // Filter: Rentang Gaji
        if ($request->filled('gaji_minimum')) {
            $gMin = preg_replace('/\D/', '', $request->gaji_minimum);
            if ($gMin) {
                $query->whereRaw("CAST(REGEXP_REPLACE(gaji_minimum, '[^0-9]', '') AS UNSIGNED) >= ?", [$gMin]);
            }
        }
        if ($request->filled('gaji_maksimum')) {
            $gMax = preg_replace('/\D/', '', $request->gaji_maksimum);
            if ($gMax) {
                $query->whereRaw("CAST(REGEXP_REPLACE(gaji_maksimum, '[^0-9]', '') AS UNSIGNED) <= ?", [$gMax]);
            }
        }

        // Filter: Tanggal Posting
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        // Urutan
        $urut = $request->input('urut', 'terbaru');
        if ($urut === 'a-z') {
            $query->orderBy('posisi', 'asc');
        } elseif ($urut === 'z-a') {
            $query->orderBy('posisi', 'desc');
        } elseif ($urut === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $jobs = $query->paginate(5)->withQueryString();
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

        //hitung filter aktif
        $filterAktif = 0;
        if ($request->filled('status')) $filterAktif++;
        if ($request->filled('kata_kunci')) $filterAktif++;
        if ($request->filled('kategori') && $request->kategori !== 'semua') $filterAktif++;
        if ($request->filled('gaji_minimum')) $filterAktif++;
        if ($request->filled('gaji_maksimum')) $filterAktif++;
        if ($request->filled('dari')) $filterAktif++;
        if ($request->filled('sampai')) $filterAktif++;

        return view(
            'lowongan.kelola-lowongan',
            compact(
                'jobs',
                'stats',
                'filterAktif'
            )
        );
    }

    // Tambahkan helper parsing gaji di atas method store() dan update()
    private function parseGaji(?string $val): ?int
    {
        if (!$val) return null;
        $clean = preg_replace('/[^0-9]/', '', $val);
        if (!$clean) return null;
        $num = (int) $clean;
        // Jika angka kecil (<= 999), anggap dalam juta
        return $num <= 999 ? $num * 1000000 : $num;
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
