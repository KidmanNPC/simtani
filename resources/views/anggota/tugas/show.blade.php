@extends('layouts.backend')
@section('title', 'Detail Tugas')

@section('content')
@php
    $jadwal   = $penugasan->jadwal;
    $presensi = $penugasan->presensi;

    $statusLabel = match ($penugasan->status) {
        'assigned'    => 'Ditugaskan',
        'in_progress' => 'Berlangsung',
        'completed'   => 'Selesai',
        default       => ucfirst($penugasan->status),
    };
    $statusClass = match ($penugasan->status) {
        'assigned'    => 'badge-warn',
        'in_progress' => 'badge-progress',
        'completed'   => 'badge',
        default       => 'badge-muted',
    };

    $presensiLabel = match ($presensi?->status) {
        'hadir'       => 'Hadir',
        'izin'        => 'Izin',
        'tidak_hadir' => 'Tidak hadir',
        default       => 'Belum ada',
    };
    $presensiClass = match ($presensi?->status) {
        'hadir'       => 'badge',
        'izin'        => 'badge-warn',
        'tidak_hadir' => 'badge-danger',
        default       => 'badge-muted',
    };

    $tanggal = $jadwal?->tanggal
        ? \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y')
        : '-';
@endphp

<div class="detail-page">
    <a href="{{ Route::has('anggota.tugas.index') ? route('anggota.tugas.index') : url()->previous() }}"
       class="back-link">← Kembali</a>

    <h2>{{ $jadwal->nama_kegiatan ?? 'Tugas' }}</h2>

    <section class="detail-card">
        <dl class="detail-grid">
            <div>
                <dt>Tanggal</dt>
                <dd>{{ $tanggal }}</dd>
            </div>
            <div>
                <dt>Status</dt>
                <dd><span class="{{ $statusClass }}">{{ $statusLabel }}</span></dd>
            </div>
            <div>
                <dt>Presensi</dt>
                <dd><span class="{{ $presensiClass }}">{{ $presensiLabel }}</span></dd>
            </div>
        </dl>
    </section>

    @if (!$presensi)
        <section class="detail-card">
            <h3>Isi presensi</h3>
            <form method="post" action="{{ route('anggota.presensi.status', $penugasan) }}" class="presensi-form">
                @csrf
                <div class="field">
                    <label for="presensi-status">Status presensi</label>
                    <select id="presensi-status" name="status">
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="tidak_hadir">Tidak hadir</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Simpan presensi</button>
            </form>
        </section>
    @endif

    @if ($rekanTugas->isNotEmpty())
        <section class="detail-card">
            <h3>Anggota satu kegiatan</h3>
            <ul class="member-list">
                @foreach ($rekanTugas as $rekan)
                    @php $nama = $rekan->anggota->nama_lengkap ?? '-'; @endphp
                    <li>
                        <span class="avatar">{{ mb_strtoupper(mb_substr($nama, 0, 1)) }}</span>
                        {{ $nama }}
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <div class="actions">
        @if ($penugasan->status === 'assigned')
            <form method="post" action="{{ route('anggota.tugas.mulai', $penugasan) }}">
                @csrf
                <button type="submit" class="btn-primary">Mulai tugas</button>
            </form>
        @endif

        @if (in_array($penugasan->status, ['in_progress', 'assigned']))
            <a href="{{ route('anggota.tugas.complete.form', $penugasan) }}"
               class="{{ $penugasan->status === 'in_progress' ? 'btn-primary' : 'btn-outline' }}">Laporkan selesai</a>
        @endif

        <a href="{{ route('anggota.hubungi-admin') }}" class="btn-outline">Hubungi admin</a>
    </div>
</div>
@endsection