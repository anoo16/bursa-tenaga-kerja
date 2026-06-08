<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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
use Illuminate\Support\Facades\Log; 

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

        $user =
            Auth::guard('web')->user()
            ??
            Auth::guard('api')->user();

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

         $user =
            Auth::guard('web')->user()
            ??
            Auth::guard('api')->user();

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

    public function edit(Request $request)
    {
        $user =
            Auth::guard('web')->user()
            ??
            Auth::guard('api')->user();


        $template = $request->get('template');

        if($template){

            session([
                'selected_cv_template' => $template
            ]);

        }

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

        $templates = CvTemplate::where(
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

    public function update(Request $request)
    {
        $user = auth()->user();

        if(!$user){
            abort(404);
        }

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

        DB::transaction(function() use ($request, $user){

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

                'summary' =>
                    $request->summary .
                    "\n\nOrganisasi:\n" .
                    ($request->organization ?? ''),

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

            $profile->experiences()->delete();

            foreach($request->experiences ?? [] as $i => $exp){

                if(empty($exp['company'])){
                    continue;
                }

                CvExperience::create([

                    'cv_profile_id' => $profile->id,

                    'company' => $exp['company'],

                    'position' => $exp['position'] ?? null,

                    'start_date' => $exp['start_date'] ?? null,

                    'end_date' => $exp['end_date'] ?? null,

                    'description' => $exp['description'] ?? null,

                    'sort_order' => $i

                ]);
            }

            // ===================
            // Education
            // ===================

            $profile
                ->educations()
                ->delete();

            foreach($request->educations ?? [] as $i => $education){

                if(empty($education['school'])){
                    continue;
                }

                CvEducation::create([

                    'cv_profile_id' => $profile->id,

                    'institution' => $education['school'],

                    'degree' => $education['major'] ?? null,

                    'start_year' => $education['start_year'] ?? null,

                    'end_year' => $education['end_year'] ?? null,

                    'gpa' => $education['gpa'] ?? null,

                    'sort_order' => $i

                ]);
            }

            // ===================
            // Skills
            // ===================

            $profile->skills()->delete();

                foreach($request->skills ?? [] as $i => $skill){

                    if(empty($skill['name'])){
                        continue;
                    }

                    CvSkill::create([

                        'cv_profile_id' => $profile->id,

                        'name' => $skill['name'],

                        'level' => 80,

                        'category' => 'General',

                        'sort_order' => $i

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


        $profile = CvProfile::with([
            'educations',
            'skills',
            'experiences',
            'certifications'
        ])->where('user_id', $user->id)->first();

        return redirect()
            ->route('cv.preview')
            ->with(
                'success',
                'CV berhasil disimpan'
            );
    }

    // ===============================
    // Preview CV yang SUDAH tersimpan
    // ===============================
    public function preview()
    {
        $user = auth()->user();

        $profile = CvProfile::with([
            'experiences',
            'educations',
            'skills',
            'certifications'
        ])
        ->where('user_id', $user->id)
        ->firstOrFail();

        $templateView = match ($profile->template_id) {

            'modern-blue'
                => 'cv.templates.modern-blue',

            'professional-white'
                => 'cv.templates.professional-white',

            'corporate-elegant'
                => 'cv.templates.corporate-elegant',

            default
                => 'cv.templates.modern-blue'
        };

        return view(
            'cv.preview',
            compact(
                'profile',
                'templateView'
            )
        );
    }


    // ===============================
    // Preview CV SEBELUM disimpan
    // ===============================
    public function previewDraft(Request $request)
    {
        session([
            'cv_preview_data' => $request->all()
        ]);

        return redirect()
            ->route('cv.preview.show');
    }


    // ===============================
    // Tampilkan preview draft
    // ===============================
   public function showPreview()
{
    $data = session('cv_preview_data');

    if (!$data) {
        return redirect()->route('cv.edit')
            ->with('error', 'Data CV tidak ditemukan.');
    }

    $templateView = match ($data['template_id'] ?? 'modern-blue') {
        'modern-blue'        => 'cv.templates.modern-blue',
        'professional-white' => 'cv.templates.professional-white',
        'corporate-elegant'  => 'cv.templates.corporate-elegant',
        default              => 'cv.templates.modern-blue',
    };

    // Pastikan semua bagian adalah array murni
    $profile = [
        'full_name'     => $data['full_name']     ?? '',
        'email'         => $data['email']          ?? '',
        'phone'         => $data['phone']          ?? '',
        'location'      => $data['location']       ?? '',
        'job_title'     => $data['job_title']      ?? '',
        'website'       => $data['website']        ?? '',
        'linkedin'      => $data['linkedin']       ?? '',
        'summary'       => $data['summary']        ?? '',
        'photo'         => $data['photo']          ?? null,
        'template_id'   => $data['template_id']    ?? 'modern-blue',
        'primary_color' => $data['primary_color']  ?? '#1a3c8f',
        'experiences'   => array_values(array_filter(
                               $data['experiences'] ?? [],
                               fn($e) => !empty($e['company'])
                           )),
        'educations'    => array_values(array_filter(
                               $data['educations'] ?? [],
                               fn($e) => !empty($e['school'])
                           )),
        'skills'        => array_values(array_filter(
                               $data['skills'] ?? [],
                               fn($s) => !empty($s['name'])
                           )),
        'certifications' => array_values($data['certifications'] ?? []),
    ];

    return view('cv.preview-cv', [
        'profile'      => $profile,
        'templateView' => $templateView,
        'cvRawData'    => $profile, // kirim yang sudah bersih
    ]);
  }
  public function downloadDraftPDF(Request $request)
{
    $user = Auth::guard('api')->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Silakan login terlebih dahulu',
        ], 401);
    }

    $data = $request->input('cv_data');

    if (!$data) {
        return response()->json([
            'success' => false,
            'message' => 'Data CV tidak ditemukan.',
        ], 404);
    }

    // Sama persis dengan format yang dipakai template (array)
    $profile = [
        'full_name'     => $data['full_name']     ?? $user->name,
        'email'         => $data['email']          ?? $user->email,
        'phone'         => $data['phone']          ?? '',
        'location'      => $data['location']       ?? '',
        'job_title'     => $data['job_title']      ?? '',
        'website'       => $data['website']        ?? '',
        'linkedin'      => $data['linkedin']       ?? '',
        'summary'       => $data['summary']        ?? '',
        'photo'         => $data['photo']          ?? null,
        'template_id'   => $data['template_id']    ?? 'modern-blue',
        'primary_color' => $data['primary_color']  ?? '#1a3c8f',
        'experiences'   => array_values(array_filter(
                               $data['experiences'] ?? [],
                               fn($e) => !empty($e['company'])
                           )),
        'educations'    => array_values(array_filter(
                               $data['educations'] ?? [],
                               fn($e) => !empty($e['school'])
                           )),
        'skills'        => array_values(array_filter(
                               $data['skills'] ?? [],
                               fn($s) => !empty($s['name'])
                           )),
        'certifications' => array_values($data['certifications'] ?? []),
    ];

    $templateView = match ($profile['template_id']) {
        'professional-white' => 'cv.templates.professional-white',
        'corporate-elegant'  => 'cv.templates.corporate-elegant',
        default              => 'cv.templates.modern-blue',
    };

    if (!view()->exists($templateView)) {
        $templateView = 'cv.templates.modern-blue';
    }

    $pdf = Pdf::loadView($templateView, [
        'profile' => $profile,  // kirim sebagai array
    ]);

    $pdf->setPaper('a4', 'portrait');

    $filename = 'CV_' . str_replace(' ', '_', $profile['full_name']) . '.pdf';

    return $pdf->download($filename);
 }
}