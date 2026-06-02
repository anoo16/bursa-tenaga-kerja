<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function index()
    {
           

        $applications = Application::where(
            'user_id',
            Auth::id()
        )->paginate(10);

        return view(
            'applications.lamaran-saya',
            compact('applications')
        );
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
            'job_id' => 'required'
        ]);

        $user = Auth::user();

        $exists = Application::where(
            'user_id',
            $user->id
        )
        ->where(
            'job_id',
            $request->job_id
        )
        ->exists();

        if($exists)
        {
            return back()
                ->with(
                    'error',
                    'Anda sudah melamar lowongan ini'
                );
        }

        DB::transaction(function() use (
            $request,
            $user
        ){

            Application::create([
                'user_id' => $user->id,
                'job_id' => $request->job_id,
                'cover_letter' => $request->cover_letter,
                'status' => 'pending',
                'applied_at' => now()
            ]);

        });

        return redirect()
            ->route('applications.index')
            ->with(
                'success',
                'Lamaran berhasil dikirim'
            );
    }

    public function show($id)
    {
        $job = [
        'id' => $id,
        'title' => 'Senior UX Designer',
        'company' => 'Tokopedia',
        ];
        return view(
            'applications.show',
            compact('job')
        );
    }

    public function withdraw($id)
    {
        $application = Application::findOrFail($id);

        if($application->user_id != Auth::id())
        {
            abort(403);
        }

        $application->update([
            'status' => 'rejected'
        ]);

        return back()
            ->with(
                'success',
                'Lamaran dibatalkan'
            );
    }
}