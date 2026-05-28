{{-- resources/views/cv/partials/skill-row.blade.php --}}
<div class="form-grid-skill">
    <div class="form-group">
        <label>Nama Skill</label>
        <input type="text" name="skills[{{ $i }}][name]" class="form-input"
               value="{{ old("skills.$i.name", $skill->name) }}" placeholder="React.js">
    </div>
    <div class="form-group">
        <label>Kategori</label>
        <select name="skills[{{ $i }}][category]" class="form-input">
            @foreach(['Technical','Soft Skill','Language'] as $cat)
            <option {{ $skill->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group skill-level-group">
        <label>Level: <span id="lvlVal_{{ $i }}">{{ $skill->level }}</span>%</label>
        <input type="range" name="skills[{{ $i }}][level]" min="0" max="100"
               value="{{ old("skills.$i.level", $skill->level) }}"
               class="range-input"
               oninput="document.getElementById('lvlVal_{{ $i }}').textContent=this.value">
    </div>
    <button type="button" class="btn-remove align-self-end"
            onclick="this.closest('.section-item').remove()">
        <i class="fas fa-trash"></i>
    </button>
</div>
