@section('title', 'Template CV')

@vite([
    'resources/css/template-cv.css',
    'resources/js/template-cv.js'
])

<div class="cv-preview-paper cv-real-professional-white">

    <div class="cv-pro-header">

        <h1>{{ $profile['full_name'] ?? '' }}</h1>

        <p>{{ $profile['headline'] ?? '' }}</p>

        <span>
            {{ $profile['email'] ?? '' }}
            •
            {{ $profile['phone'] ?? '' }}
            •
            {{ $profile['location'] ?? '' }}
        </span>

    </div>

    <section>
        <h3>Professional Summary</h3>
        <p>{{ $profile['summary'] ?? '' }}</p>
    </section>

    <section>
        <h3>Work Experience</h3>

        @foreach(($profile['experiences'] ?? []) as $exp)

            <div class="cv-pro-row">
                <div>
                    <h4>{{ $exp['position'] ?? '' }}</h4>
                    <p>{{ $exp['company'] ?? '' }}</p>
                </div>

                <span>
                    {{ $exp['period'] ?? '' }}
                </span>
            </div>

        @endforeach

    </section>

    <section>
        <h3>Education</h3>

        @foreach(($profile['educations'] ?? []) as $edu)

            <div class="cv-pro-row">
                <div>
                    <h4>{{ $edu['major'] ?? '' }}</h4>
                    <p>{{ $edu['school'] ?? '' }}</p>
                </div>

                <span>
                    {{ $edu['graduation_year'] ?? '' }}
                </span>
            </div>

        @endforeach

    </section>

    <section>
        <h3>Skills</h3>

        <p>
            @foreach(($profile['skills'] ?? []) as $skill)

                {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}

                @if(!$loop->last), @endif

            @endforeach
        </p>

    </section>

</div>