@section('title', 'Template CV')

@vite([
    'resources/css/template-cv.css',
    'resources/js/template-cv.js'
])

<div class="cv-preview-paper cv-real-corporate-elegant">

    <div class="corp-header">

        <h1>{{ $profile['full_name'] ?? '' }}</h1>

        <p>{{ $profile['email'] ?? '' }}</p>

    </div>

    <div class="corp-grid">

        <main>

            <section>

                <h3>Professional Profile</h3>

                <p>
                    {{ $profile['summary'] ?? '' }}
                </p>

            </section>

        </main>

        <aside>

            <section>

                <h3>Skills</h3>

                 <p>
                    @foreach(($profile['skills'] ?? []) as $skill)

                        {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}

                        @if(!$loop->last), @endif

                    @endforeach
                </p>

            </section>

        </aside>

    </div>

</div>