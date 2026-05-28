<?php

namespace App\Http\Controllers;

use App\Models\CvProfile;
use App\Models\CvExperience;
use App\Models\CvEducation;
use App\Models\CvSkill;
use App\Models\CvCertification;
use App\Models\CvTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    // ===============================
    // STEP 1 : Pilih Template
    // ===============================

    public function templates()
    {
        $templates = CvTemplate::where(
            'is_active',
            true
        )->get();

        $user = Auth::user();

        $profile = $user
            ? $user->cvProfile
            : null;

        return view(
            'cv.templates-cv',
            compact(
                'templates',
                'profile'
            )
        );
    }

    public function selectTemplate(
        Request $request
    )
    {
        $request->validate([
            'template_id' => 'required'
        ]);

        $user = Auth::user();

        if(!$user){
            return back()
                ->with(
                    'error',
                    'User belum tersedia'
                );
        }

        $profile = CvProfile::firstOrCreate(

            [
                'user_id' => $user->id
            ],

            [
                'full_name' => $user->name,
                'email' => $user->email,
                'template_id' => 'modern',
                'primary_color' => '#1a3c8f'
            ]

        );

        $profile->update([
            'template_id' =>
            $request->template_id
        ]);

        return redirect()
            ->route('cv.edit')
            ->with(
                'success',
                'Template berhasil dipilih'
            );
    }

    // ===============================
    // STEP 2 : Form Edit CV
    // ===============================

    public function edit()
    {
        $user = Auth::user();

        if(!$user){

            return view(
                'cv.edit-cv',
                [
                    'profile'=>null,
                    'templates'=>[]
                ]
            );
        }

        $profile = CvProfile::with([

            'experiences',
            'educations',
            'skills',
            'certifications'

        ])->firstOrCreate(

            [
                'user_id'=>$user->id
            ],

            [
                'full_name'=>$user->name,
                'email'=>$user->email,
                'template_id'=>'modern',
                'primary_color'=>'#1a3c8f'
            ]

        );

        $templates =
            CvTemplate::where(
                'is_active',
                true
            )->get();

        return view(
            'cv.edit',
            compact(
                'profile',
                'templates'
            )
        );
    }


    // ===============================
    // STEP 3 : Simpan CV
    // ===============================

    public function update(
        Request $request
    )
    {

        $request->validate([

            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',

            'job_title'=>'nullable|string|max:255',
            'phone'=>'nullable|string|max:30',
            'location'=>'nullable|string|max:255',

            'website'=>'nullable|url|max:255',

            'linkedin'=>'nullable|string|max:255',

            'summary'=>'nullable|string|max:3000',

            'photo'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'experiences'=>'nullable|array',
            'educations'=>'nullable|array',
            'skills'=>'nullable|array',
            'certifications'=>'nullable|array',

        ]);


        DB::transaction(function()
        use($request){

            $user = Auth::user();

            $profile=
                CvProfile::firstOrCreate(

                    [
                        'user_id'=>$user->id
                    ],

                    [
                        'full_name'=>$user->name,
                        'email'=>$user->email,
                        'template_id'=>'modern',
                        'primary_color'=>'#1a3c8f'
                    ]
                );


            // upload foto

            $photoPath =
                $profile->photo;

            if(
                $request
                ->hasFile('photo')
            ){

                if(
                    $photoPath
                ){

                    Storage::disk(
                        'public'
                    )->delete(
                        $photoPath
                    );
                }

                $photoPath=
                    $request
                    ->file(
                        'photo'
                    )
                    ->store(
                        'cv-photos',
                        'public'
                    );
            }


            // update profile utama

            $profile->update([

                'full_name'=>
                    $request->full_name,

                'job_title'=>
                    $request->job_title,

                'email'=>
                    $request->email,

                'phone'=>
                    $request->phone,

                'location'=>
                    $request->location,

                'website'=>
                    $request->website,

                'linkedin'=>
                    $request->linkedin,

                'summary'=>
                    $request->summary,

                'template_id'=>
                    $request->template_id
                    ??
                    $profile->template_id,

                'primary_color'=>
                    $request->primary_color
                    ??
                    $profile->primary_color,

                'photo'=>
                    $photoPath

            ]);


            // ===================
            // Experience
            // ===================

            $profile
                ->experiences()
                ->delete();

            foreach(
                ($request->experiences ?? [])
                as $i=>$exp
            ){

                CvExperience::create([

                    'cv_profile_id'=>
                        $profile->id,

                    'company'=>
                        $exp['company'],

                    'position'=>
                        $exp['position'],

                    'start_date'=>
                        $exp['start_date'],

                    'end_date'=>
                        $exp['end_date']
                        ?? null,

                    'is_current'=>
                        $exp['is_current']
                        ?? false,

                    'description'=>
                        $exp['description']
                        ?? null,

                    'sort_order'=>$i
                ]);
            }


            // ===================
            // Education
            // ===================

            $profile
                ->educations()
                ->delete();

            foreach(
                ($request->educations ?? [])
                as $i=>$edu
            ){

                CvEducation::create([

                    'cv_profile_id'=>
                        $profile->id,

                    'institution'=>
                        $edu['institution'],

                    'degree'=>
                        $edu['degree'],

                    'field_of_study'=>
                        $edu['field_of_study']
                        ?? null,

                    'start_year'=>
                        $edu['start_year'],

                    'end_year'=>
                        $edu['end_year']
                        ?? null,

                    'gpa'=>
                        $edu['gpa']
                        ?? null,

                    'description'=>
                        $edu['description']
                        ?? null,

                    'sort_order'=>$i
                ]);
            }



            // ===================
            // Skills
            // ===================

            $profile
                ->skills()
                ->delete();

            foreach(
                ($request->skills ?? [])
                as $i=>$skill
            ){

                CvSkill::create([

                    'cv_profile_id'=>
                        $profile->id,

                    'name'=>
                        $skill['name'],

                    'level'=>
                        $skill['level']
                        ?? 80,

                    'category'=>
                        $skill['category']
                        ?? 'Technical',

                    'sort_order'=>$i
                ]);
            }



            // ===================
            // Certification
            // ===================

            $profile
                ->certifications()
                ->delete();

            foreach(
                ($request->certifications ?? [])
                as $i=>$cert
            ){

                CvCertification::create([

                    'cv_profile_id'=>
                        $profile->id,

                    'name'=>
                        $cert['name'],

                    'issuer'=>
                        $cert['issuer']
                        ?? null,

                    'year'=>
                        $cert['year']
                        ?? null,

                    'credential_url'=>
                        $cert['credential_url']
                        ?? null,

                    'sort_order'=>$i
                ]);
            }

        });

        return redirect()
            ->route(
                'cv.preview'
            )
            ->with(
                'success',
                'CV berhasil disimpan'
            );
    }



    // ===============================
    // Preview CV
    // ===============================

    public function preview()
    {
        $user = Auth::user();

        if(!$user){

            abort(404);
        }

        $profile=
            CvProfile::with([

                'experiences',
                'educations',
                'skills',
                'certifications'

            ])
            ->where(
                'user_id',
                $user->id
            )
            ->firstOrFail();


        $templateView=
            'templates.'.
            $profile->template_id;


        if(
            !view()
            ->exists(
                $templateView
            )
        ){

            $templateView=
            'templates.modern';
        }


        return view(
            'cv.preview',
            compact(
                'profile',
                'templateView'
            )
        );
    }



    // ===============================
    // Hapus item section
    // ===============================

    public function deleteSection(
        string $section,
        int $id
    )
    {

        $map=[

            'experience'=>
                CvExperience::class,

            'education'=>
                CvEducation::class,

            'skill'=>
                CvSkill::class,

            'certification'=>
                CvCertification::class
        ];


        abort_unless(
            isset(
                $map[$section]
            ),
            404
        );


        $record = $map[$section]::findOrFail($id);

        abort_unless(
            $record->profile->user_id === Auth::id(),
            403
        );

        $record->delete();

        return response()->json([
            'success'=>true
        ]);
    }

}