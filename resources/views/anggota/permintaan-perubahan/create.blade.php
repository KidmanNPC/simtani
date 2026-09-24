@extends('layouts.backend')
@section('title', 'Buat Permintaan Perubahan')
@section('content')

<h2>Buat Permintaan Perubahan</h2>

<form method="post" action="{{ route('anggota.permintaan-perubahan.store') }}" class="form-page">
    @csrf

    <div class="field">
        <label for="penugasan_id">Penugasan</label>
        <select id="penugasan_id" name="penugasan_id" required>
            @foreach($penugasan as $item)
                <option value="{{ $item->id }}" data-jadwal="{{ $item->jadwal_id }}" @selected(old('penugasan_id') == $item->id)>
                    {{ $item->jadwal->nama_kegiatan ?? $item->id }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="jenis_permintaan">Jenis</label>
        <select id="jenis_permintaan" name="jenis_permintaan">
            <option value="tukar" @selected(old('jenis_permintaan', 'tukar') == 'tukar')>Tukar</option>
            <option value="sanggah" @selected(old('jenis_permintaan') == 'sanggah')>Sanggah</option>
        </select>
    </div>

    <div class="field" id="target-field">
        <label for="target_penugasan_id">Tukar dengan</label>
        <select id="target_penugasan_id" name="target_penugasan_id">
            <option value="">Pilih penugasan anggota lain</option>
            @foreach($targetPenugasan as $item)
                <option value="{{ $item->id }}" data-jadwal="{{ $item->jadwal_id }}" @selected(old('target_penugasan_id') == $item->id)>
                    {{ $item->anggota->nama_lengkap ?? 'Anggota' }} — {{ $item->jadwal->nama_kegiatan ?? $item->id }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="alasan">Alasan</label>
        <textarea id="alasan" name="alasan" required>{{ old('alasan') }}</textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary" style="width:auto;padding:10px 24px;">Kirim</button>
    </div>
</form>

<script>
(function () {
    var jenisSelect = document.getElementById('jenis_permintaan');
    var targetField = document.getElementById('target-field');
    var penugasanSelect = document.getElementById('penugasan_id');
    var targetSelect = document.getElementById('target_penugasan_id');

    function toggleTargetField() {
        var isTukar = jenisSelect.value === 'tukar';
        targetField.style.display = isTukar ? '' : 'none';
        targetSelect.required = isTukar;
    }

    function filterTargetOptions() {
        var selected = penugasanSelect.options[penugasanSelect.selectedIndex];
        var jadwalId = selected ? selected.dataset.jadwal : null;
        Array.from(targetSelect.options).forEach(function (opt) {
            if (!opt.value) return;
            opt.hidden = opt.dataset.jadwal !== jadwalId;
        });
        if (targetSelect.selectedOptions[0] && targetSelect.selectedOptions[0].hidden) {
            targetSelect.value = '';
        }
    }

    jenisSelect.addEventListener('change', toggleTargetField);
    penugasanSelect.addEventListener('change', filterTargetOptions);

    toggleTargetField();
    filterTargetOptions();
})();
</script>

@endsection