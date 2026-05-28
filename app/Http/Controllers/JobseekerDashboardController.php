<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class JobseekerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();

        $totalLamaran = 0;
        $diproses = 0;
        $diterima = 0;
        $ditolak = 0;

        return view(
            'dashboard.jobseeker',
            compact(
                'user',
                'totalLamaran',
                'diproses',
                'diterima',
                'ditolak'
            )
        );
    }
}