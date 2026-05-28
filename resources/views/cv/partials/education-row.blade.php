{{-- ── resources/views/cv/partials/education-row.blade.php ── --}}
<div class="item-header">
    <span class="item-label"><i class="fas fa-graduation-cap"></i> {{ $edu->institution }}</span>
    <button type="button" class="btn-remove" onclick="this.closest('.section-item').remove()">
        <i class="fas fa-trash"></i>
    </button>
</div>
<div class="form-grid-2">
    <div class="form-group">
        <label>Nama Institusi *</label>
        <input type="text" name="educations[{{ $i }}][institution]" class="form-input"
               value="{{ old("educations.$i.institution", $edu->institution) }}" required>
    </div>
    <div class="form-group">
        <label>Jenjang / Gelar *</label>
        <select name="educations[{{ $i }}][degree]" class="form-input">
            @foreach(['Sarjana (S1)','Diploma (D3)','Magister (S2)','SMA/SMK/MA','Doktor (S3)'] as $deg)
            <option {{ $edu->degree === $deg ? 'selected' : '' }}>{{ $deg }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Jurusan / Prodi</label>
        <input type="text" name="educations[{{ $i }}][field_of_study]" class="form-input"
               value="{{ old("educations.$i.field_of_study", $edu->field_of_study) }}">
    </div>
    <div class="form-group">
        <label>IPK / GPA</label>
        <input type="text" name="educations[{{ $i }}][gpa]" class="form-input"
               value="{{ old("educations.$i.gpa", $edu->gpa) }}">
    </div>
    <div class="form-group">
        <label>Tahun Masuk</label>
        <input type="text" name="educations[{{ $i }}][start_year]" class="form-input"
               value="{{ old("educations.$i.start_year", $edu->start_year) }}">
    </div>
    <div class="form-group">
        <label>Tahun Lulus</label>
        <input type="text" name="educations[{{ $i }}][end_year]" class="form-input"
               value="{{ old("educations.$i.end_year", $edu->end_year) }}">
    </div>
</div>
