{{-- resources/views/cv/partials/experience-row.blade.php --}}
<div class="item-header">
    <span class="item-label"><i class="fas fa-briefcase"></i> {{ $exp->company }}</span>
    <button type="button" class="btn-remove" onclick="removeItem('exp_{{ $i }}'); this.closest('.section-item').id='exp_{{ $i }}'">
        <i class="fas fa-trash"></i>
    </button>
</div>
<div class="form-grid-2">
    <div class="form-group">
        <label>Nama Organisasi / Perusahaan *</label>
        <input type="text" name="experiences[{{ $i }}][company]" class="form-input"
               value="{{ old("experiences.$i.company", $exp->company) }}" required>
    </div>
    <div class="form-group">
        <label>Posisi / Jabatan *</label>
        <input type="text" name="experiences[{{ $i }}][position]" class="form-input"
               value="{{ old("experiences.$i.position", $exp->position) }}" required>
    </div>
    <div class="form-group">
        <label>Mulai</label>
        <input type="text" name="experiences[{{ $i }}][start_date]" class="form-input"
               value="{{ old("experiences.$i.start_date", $exp->start_date) }}">
    </div>
    <div class="form-group">
        <label>Selesai</label>
        <div class="end-date-wrap">
            <input type="text" name="experiences[{{ $i }}][end_date]" class="form-input"
                   id="end_{{ $i }}" value="{{ old("experiences.$i.end_date", $exp->end_date) }}"
                   {{ $exp->is_current ? 'disabled' : '' }}>
            <label class="check-label">
                <input type="checkbox" name="experiences[{{ $i }}][is_current]" value="1"
                       {{ $exp->is_current ? 'checked' : '' }}
                       onchange="toggleCurrent(this,'end_{{ $i }}')">
                Masih berlangsung
            </label>
        </div>
    </div>
</div>
<div class="form-group full-width">
    <label>Deskripsi</label>
    <textarea name="experiences[{{ $i }}][description]" class="form-textarea" rows="3">{{ old("experiences.$i.description", $exp->description) }}</textarea>
</div>
