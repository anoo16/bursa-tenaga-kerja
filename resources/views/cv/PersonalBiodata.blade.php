@extends('layouts.jobseeker')

@section('title', 'Personal Biodata - CV Builder')
@section('nav-profil', 'active')

@section('header-classes', 'bg-white border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-30')

@section('header-actions')
<div class="w-8 h-8 rounded-full bg-navy-500 text-white flex items-center justify-center text-sm font-bold">
    {{ substr($profile?->full_name ?? 'U',0,1) }}
</div>
@endsection

@section('content-classes', 'flex-1 p-6')

@section('header-content')
<p class="text-sm text-gray-500">
    CV Builder › Personal Biodata
</p>
@endsection


@section('content')

<h1 class="text-3xl font-bold text-gray-900 mb-2">
    Personal Biodata
</h1>

<p class="text-sm text-gray-500 mb-8">
    Lengkapi informasi dasar profil CV kamu
</p>


{{-- STEPPER --}}

@php
$stepperItems = [
['name'=>'Biodata','active'=>true],
['name'=>'Education','active'=>false],
['name'=>'Skill','active'=>false],
['name'=>'Summary','active'=>false],
['name'=>'Pengalaman','active'=>false],
];
@endphp

<div class="flex items-center gap-0 mb-10 overflow-x-auto">

@foreach($stepperItems as $i=>$si)

<div class="flex items-center {{ $i<count($stepperItems)-1 ? 'flex-1':'' }}">

<div class="flex items-center gap-2 flex-shrink-0">

<div class="
w-9 h-9 rounded-full
flex items-center justify-center
text-sm font-bold

{{ $si['active']
? 'bg-navy-500 text-white'
: 'bg-gray-200 text-gray-400'
}}
">

{{ $i+1 }}

</div>

<span class="
text-xs font-semibold whitespace-nowrap

{{ $si['active']
? 'text-navy-500'
:'text-gray-400'
}}
">

{{ $si['name'] }}

</span>

</div>


@if($i<count($stepperItems)-1)

<div class="
flex-1 h-[2px] mx-3

{{ $si['active']
? 'bg-navy-500'
:'bg-gray-200'
}}
"></div>

@endif

</div>

@endforeach

</div>



<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

<form
action="{{ route('cv.update') }}"
method="POST"
enctype="multipart/form-data"
>

@csrf
@method('PUT')


{{-- FOTO --}}

<div class="flex items-center gap-8 mb-8 pb-8 border-b">

<div class="flex flex-col items-center">

<div class="
w-32 h-32 rounded-2xl
border-2 border-dashed
border-gray-300
overflow-hidden
bg-gray-50
flex items-center justify-center
">

@if($profile?->photo)

<img
src="{{ Storage::url($profile->photo) }}"
class="w-full h-full object-cover"
id="previewImage"
>

@else

<div id="placeholder">

<svg
class="w-10 h-10 text-gray-400"
fill="none"
stroke="currentColor"
viewBox="0 0 24 24">

<path
stroke-linecap="round"
stroke-linejoin="round"
stroke-width="1.5"
d="M15 12a3 3 0 11-6 0
3 3 0 016 0zm6 8H3
a2 2 0 01-2-2V6
a2 2 0 012-2h1
l2-2h8l2 2h1
a2 2 0 012 2v12
a2 2 0 01-2 2z"/>

</svg>

</div>

<img
id="previewImage"
class="hidden w-full h-full object-cover"
>

@endif

</div>


<label class="
mt-4
px-4 py-2
bg-navy-500
text-white
rounded-xl
cursor-pointer
text-sm
hover:bg-navy-600
">

Pilih Foto

<input
type="file"
hidden
name="photo"
id="photoInput"
accept="image/*"
>

</label>

<p class="text-xs text-gray-400 mt-2">
JPG/PNG max 2MB
</p>

</div>



<div class="grid md:grid-cols-2 gap-5 flex-1">

<div>

<label class="text-sm font-medium">
Nama Lengkap
</label>

<input
type="text"
name="full_name"
value="{{ old('full_name',$profile?->full_name) }}"
class="w-full mt-2 px-4 py-3 border rounded-xl"
>

</div>


<div>

<label class="text-sm font-medium">
Email
</label>

<input
type="email"
name="email"
value="{{ old('email',$profile?->email) }}"
class="w-full mt-2 px-4 py-3 border rounded-xl"
>

</div>


<div>

<label class="text-sm font-medium">
Nomor Telepon
</label>

<input
type="text"
name="phone"
value="{{ old('phone',$profile?->phone) }}"
class="w-full mt-2 px-4 py-3 border rounded-xl"
>

</div>


<div>

<label class="text-sm font-medium">
Lokasi
</label>

<input
type="text"
name="location"
value="{{ old('location',$profile?->location) }}"
class="w-full mt-2 px-4 py-3 border rounded-xl"
>

</div>


<div class="md:col-span-2">

<label class="text-sm font-medium">
Jabatan
</label>

<input
type="text"
name="job_title"
value="{{ old('job_title',$profile?->job_title) }}"
class="w-full mt-2 px-4 py-3 border rounded-xl"
>

</div>


<div class="md:col-span-2">

<label class="text-sm font-medium">
Ringkasan Profil
</label>

<textarea
rows="4"
name="summary"
class="w-full mt-2 px-4 py-3 border rounded-xl"
>{{ old('summary',$profile?->summary) }}</textarea>

</div>

</div>

</div>



<div class="flex justify-end pt-6 border-t">

<a
href="{{ route('cv.education') }}"
class="
px-8 py-3
bg-navy-500
text-white
rounded-xl
hover:bg-navy-600
shadow-lg
"
>

Lanjut ke Education →

</a>

</div>

</form>

</div>


<script>

document
.getElementById('photoInput')
.addEventListener('change',function(e){

const file=e.target.files[0]

if(!file)return

const reader=new FileReader()

reader.onload=function(ev){

document
.getElementById('previewImage')
.src=ev.target.result

document
.getElementById('previewImage')
.classList.remove('hidden')

const p=
document.getElementById(
'placeholder'
)

if(p)p.style.display='none'

}

reader.readAsDataURL(file)

})

</script>

@endsection