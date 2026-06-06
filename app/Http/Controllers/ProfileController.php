<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Certification;

class ProfileController extends Controller
{

    public function index()
    {
        $user =
            Auth::guard('web')->user()
            ??
            Auth::guard('api')->user();

        return view('jobseeker.profile', compact('user'));
    }

    public function edit()
    {
        $user =
            Auth::guard('web')->user()
            ??
            Auth::guard('api')->user();

        return view('jobseeker.profile-edit', compact('user'));
    }
    
    public function update(Request $request)
    {

        dd($request->all());   

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 401);
        }

        // photo
        if ($request->hasFile('photo')) {

            $path = $request->file('photo')
                ->store('profiles', 'public');

            $user->photo = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->summary = $request->summary;
        $user->location = $request->location;
        $user->headline = $request->headline;

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | EDUCATION
        |--------------------------------------------------------------------------
        */
        if ($request->filled('educations')) {

            Education::where(
                'user_id',
                $user->id
            )->delete();

            $educations = json_decode(
                $request->educations,
                true
            );

            foreach ($educations as $edu) {

                Education::create([
                    'user_id' => $user->id,
                    'level' => $edu['level'] ?? null,
                    'major' => $edu['major'] ?? null,
                    'school' => $edu['school'] ?? null,
                    'graduation_year' => $edu['graduation_year'] ?? null,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EXPERIENCE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('experiences')) {

            Experience::where(
                'user_id',
                $user->id
            )->delete();

            $experiences = json_decode(
                $request->experiences,
                true
            );

            foreach ($experiences as $exp) {

                Experience::create([
                    'user_id' => $user->id,
                    'company' => $exp['company'] ?? null,
                    'position' => $exp['position'] ?? null,
                    'period' => $exp['period'] ?? null,
                    'description' => $exp['description'] ?? null,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SKILLS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('skills')) {

            Skill::where(
                'user_id',
                $user->id
            )->delete();

            $skills = json_decode(
                $request->skills,
                true
            );

            foreach ($skills as $skill) {

                Skill::create([
                    'user_id' => $user->id,
                    'name' => $skill['name'] ?? $skill,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CERTIFICATIONS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('certifications')) {

            Certification::where(
                'user_id',
                $user->id
            )->delete();

            $certifications = json_decode(
                $request->certifications,
                true
            );

            foreach ($certifications as $cert) {

                Certification::create([
                    'user_id' => $user->id,
                    'title' => $cert['title'] ?? null,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui',
            'user' => $user->load([
                'educations',
                'experiences',
                'skills',
                'certifications'
            ])
        ]);
    }
}