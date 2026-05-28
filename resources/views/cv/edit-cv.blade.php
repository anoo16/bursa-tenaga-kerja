@extends('layouts.jobseeker')

@section('title','Edit CV')

@vite([
'resources/css/cv-wizard.css'
])

@section('content')

<div class="cv-wizard">

    {{-- SIDEBAR --}}
    <div class="wizard-sidebar">

        <h4>Application Status</h4>

                <div class="progress-text">

                <div class="progress-bar">
                <div
                id="progressFill"
                style="width:20%"
                ></div>
                </div>

                <span id="progressText">
                20%
                </span>

                COMPLETED

            </div>

        <ul class="wizard-menu">

            <li class="wizard-item active">
                <i class='bx bx-user'></i>
                <span>Profile</span>
            </li>

            <li class="wizard-item">
                <i class='bx bx-book'></i>
                <span>Education</span>
            </li>

            <li class="wizard-item">
                <i class='bx bx-brain'></i>
                <span>Skill</span>
            </li>

            <li class="wizard-item">
                <i class='bx bx-group'></i>
                <span>Summary</span>
            </li>

            <li class="wizard-item">
                <i class='bx bx-briefcase'></i>
                <span>Experience</span>
            </li>

        </ul>

    </div>



    {{-- CONTENT --}}
    <div class="wizard-content">

        <small>
            STEP
            <span id="stepCounter">
                01 / 05
            </span>
        </small>

        <h1 id="stepTitle">
            Personal Biodata
        </h1>

        <p>
            Lengkapi informasi CV
        </p>


<form
action="{{ route('cv.update') }}"
method="POST"
id="cvForm"
enctype="multipart/form-data"
>

@csrf
@method('PUT')


{{-- STEP 1 PROFILE --}}
<div class="step-content active">

<div class="form-grid-2">

<input
type="text"
name="full_name"
class="form-input"
placeholder="Nama lengkap"
value="{{ old('full_name',$profile?->full_name) }}"
>


<input
type="email"
name="email"
class="form-input"
placeholder="Email"
value="{{ old('email',$profile?->email) }}"
>


<input
type="text"
name="phone"
class="form-input"
placeholder="Nomor HP"
value="{{ old('phone',$profile?->phone) }}"
>


<input
type="text"
name="location"
class="form-input"
placeholder="Alamat"
value="{{ old('location',$profile?->location) }}"
>

</div>

</div>



{{-- STEP 2 EDUCATION --}}
<div class="step-content">

<h3>Riwayat Pendidikan</h3>

<div id="educationList">

@forelse($profile?->educations ?? [] as $i=>$edu)

@include(
'cv.partials.education-row',
['edu'=>$edu,'i'=>$i]
)

@empty

<div>Belum ada pendidikan</div>

@endforelse

</div>

</div>



{{-- STEP 3 SKILL --}}
<div class="step-content">

<h3>Keahlian</h3>

<div id="skillList">

@forelse($profile?->skills ?? [] as $i=>$skill)

@include(
'cv.partials.skill-row',
['skill'=>$skill,'i'=>$i]
)

@empty

Belum ada skill

@endforelse

</div>

</div>



{{-- STEP 4 SUMMARY + ORGANISASI --}}
<div class="step-content">

<h3>Summary</h3>

<textarea
class="form-textarea"
name="summary"
rows="6"
placeholder="Ceritakan tentang dirimu..."
>{{ old('summary',$profile?->summary) }}</textarea>


<br><br>

<h3>Pengalaman Organisasi</h3>

<div id="organizationList">

<textarea
name="organization"
class="form-textarea"
rows="5"
placeholder="Masukkan pengalaman organisasi"
></textarea>

</div>

</div>




{{-- STEP 5 EXPERIENCE --}}
<div class="step-content">

<h3>Pengalaman Kerja</h3>

<div id="experienceList">

@forelse($profile?->experiences ?? [] as $i=>$exp)

@include(
'cv.partials.experience-row',
['exp'=>$exp,'i'=>$i]
)

@empty

Belum ada pengalaman kerja

@endforelse

</div>

</div>



<div class="wizard-footer">

<button
type="button"
id="prevBtn"
class="btn-outline">

← Kembali

</button>


<button
type="button"
id="nextBtn"
class="btn-primary">

Lanjut →

</button>


<button
type="submit"
id="submitBtn"
style="display:none"
class="btn-primary">

Simpan CV

</button>

</div>


</form>

</div>

</div>


@endsection


@push('scripts')

<script>

let currentStep = 0;

const steps =
document.querySelectorAll(
'.step-content'
);

const menu =
document.querySelectorAll(
'.wizard-item'
);

const nextBtn =
document.getElementById(
'nextBtn'
);

const prevBtn =
document.getElementById(
'prevBtn'
);

const submitBtn =
document.getElementById(
'submitBtn'
);


const titles=[

"Personal Biodata",

"Riwayat Pendidikan",

"Keahlian",

"Summary & Organisasi",

"Pengalaman Kerja"

];


showStep();



function showStep(){


steps.forEach(
(step,index)=>{

step.classList.remove(
'active'
)

if(index===currentStep){

step.classList.add(
'active'
)

}

})


menu.forEach(
(item,index)=>{

item.classList.remove(
'active'
)

if(index===currentStep){

item.classList.add(
'active'
)

}

}
)



document
.getElementById(
'stepTitle'
)
.innerText=
titles[currentStep]



document
.getElementById(
'stepCounter'
)
.innerText=

String(
currentStep+1
).padStart(2,'0')

+' / 05'



let percent=
((currentStep+1)*20);

document
.getElementById(
'progressText'
)
.innerText=
percent+'%'


document
.getElementById(
'progressFill'
)
.style.width=
percent+'%'



prevBtn.style.display=

currentStep===0
?'none'
:'inline-flex'



nextBtn.style.display=

currentStep===steps.length-1
?'none'
:'inline-flex'



submitBtn.style.display=

currentStep===steps.length-1
?'inline-flex'
:'none'

}



nextBtn.addEventListener(
'click',
()=>{

if(
currentStep<
steps.length-1
){

currentStep++

showStep()

}

}
)



prevBtn.addEventListener(
'click',
()=>{

if(
currentStep>0
){

currentStep--

showStep()

}

}
)



menu.forEach(
(item,index)=>{

item.addEventListener(
'click',
()=>{

currentStep=index

showStep()

})

})



</script>

@endpush