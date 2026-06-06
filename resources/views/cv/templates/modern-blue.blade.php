@section('title', 'Template CV')

@vite([
    'resources/css/template-cv.css',
    'resources/js/template-cv.js'
])

<div class="cv-preview-paper cv-real-modern-blue">

    <aside class="cv-real-sidebar">

        <h3>Kontak</h3>

        <p>{{ $profile['email'] ?? '' }}</p>
        <p>{{ $profile['phone'] ?? '' }}</p>
        <p>{{ $profile['location'] ?? '' }}</p>

        <h3>Keahlian</h3>

        <div class="cv-real-skill-list">

           <p>
                @foreach(($profile['skills'] ?? []) as $skill)

                    {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}

                    @if(!$loop->last), @endif

                @endforeach
            </p>

        </div>

    </aside>

    <main class="cv-real-main">

        <h1>{{ $profile['full_name'] ?? '' }}</h1>

        <section>
            <h3>Ringkasan</h3>
            <p>{{ $profile['summary'] ?? '' }}</p>
        </section>

        <section>
            <h3>Pengalaman</h3>

            @foreach(($profile['experiences'] ?? []) as $exp)

                <div class="cv-real-item">

                    <h4>{{ $exp['position'] ?? '' }}</h4>

                    <span>
                        {{ $exp['company'] ?? '' }}
                    </span>

                </div>

            @endforeach

        </section>

        <section>

            <h3>Pendidikan</h3>

            @foreach(($profile['educations'] ?? []) as $edu)

                <div class="cv-real-item">

                    <h4>{{ $edu['major'] ?? '' }}</h4>

                    <span>
                        {{ $edu['school'] ?? '' }}
                    </span>

                </div>

            @endforeach

        </section>

    </main>

</div>