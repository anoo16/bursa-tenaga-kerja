{{-- resources/views/cv/partials/certification-row.blade.php --}}
<div class="item-header">
    <span class="item-label"><i class="fas fa-certificate"></i> {{ $cert->name }}</span>
    <button type="button" class="btn-remove" onclick="this.closest('.section-item').remove()">
        <i class="fas fa-trash"></i>
    </button>
</div>
<div class="form-grid-2">
    <div class="form-group">
        <label>Nama Sertifikasi *</label>
        <input type="text" name="certifications[{{ $i }}][name]" class="form-input"
               value="{{ old("certifications.$i.name", $cert->name) }}" required>
    </div>
    <div class="form-group">
        <label>Penerbit</label>
        <input type="text" name="certifications[{{ $i }}][issuer]" class="form-input"
               value="{{ old("certifications.$i.issuer", $cert->issuer) }}">
    </div>
    <div class="form-group">
        <label>Tahun</label>
        <input type="text" name="certifications[{{ $i }}][year]" class="form-input"
               value="{{ old("certifications.$i.year", $cert->year) }}">
    </div>
    <div class="form-group">
        <label>Link Credential</label>
        <input type="url" name="certifications[{{ $i }}][credential_url]" class="form-input"
               value="{{ old("certifications.$i.credential_url", $cert->credential_url) }}">
    </div>
</div>
